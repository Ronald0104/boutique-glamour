$(document).ready(function () {

    $.validator.setDefaults({
        submitHandler: function () {
            alert("submitted!");
        }
    });

    $('#form-article-add-error').css('display', 'none');
    $('#form-article-edit-error').css('display', 'none');
    $('.btn-article-edit-show').on('click', mostrarEditarArticulo);
    $('#btn-show-article-add').on('click', function(evt) {
        if($('#m-register-article').html().trim() == "") {
            $.ajax({
                method: 'POST',
                url: '/inventario/articuloAgregar',
                beforeSend: Call_Progress(true)
            })
            .done(function(data){
                $('#m-register-article').html(data);
                $('#modal-article-add').modal('show');
            })
            .fail(function() {})
            .always(function() {Call_Progress(false)})
        } 
        else {
            $('#modal-article-add').modal('show');
        }       
    });

    $('#tbl_articles thead tr').clone(true).appendTo('#tbl_articles thead');

    // Setup - add a text input to each footer cell
    $('#tbl_articles thead tr:eq(1) th').each(function (i) {
        var title = $(this).text();
        if(i>0){
            $(this).html('<input type="text" placeholder="' + title + '" />');

            $('input', this).on('keyup change', function () {
                if (table.column(i).search() !== this.value) {
                    table
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        }        
    });
    var table = $('#tbl_articles').DataTable({
        "scrollX": true,
        orderCellsTop: true,
        fixedHeader: true
    });


    /* Funciones para cargar las imagenes */
    $("#fileInput").fileinput({
        // theme: "fas", 
        showUpload: true,
        previewFileType: 'any',
        browseOnZoneClick: false,
        maxFileCount: 3,
        language: 'es',
        showRemove: true,
        // actionDelete: '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}>{removeIcon}</button>\n'
        allowedFileExtensions: ["png", "jpg"],
        uploadUrl: "upload",
        initialPreviewConfig: {},
        //"fileActionSettings":{"showDrag":false}
        uploadExtraData: { "PublicacionId": $("#PublicacionId").val() },
    });

    $("#fileInput_edit").fileinput({
        // theme: "fas", 
        showUpload: true,
        previewFileType: 'any',
        browseOnZoneClick: false,
        maxFileCount: 3,
        language: 'es',
        showRemove: true,
        // actionDelete: '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}>{removeIcon}</button>\n'
        allowedFileExtensions: ["png", "jpg"],
        uploadUrl: "upload",
        initialPreviewConfig: {},
        //"fileActionSettings":{"showDrag":false}
        uploadExtraData: { "PublicacionId": $("#PublicacionId").val() },
    });

    // reglas formulario
    $('#form-article-add').validate({
        rules: {
            articulo: "required",
            code: "required",
            nombre: "required"
        },
        messages: {
            articulo: "Por favor, seleccione una articulo",
            code: "Por favor, ingrese un código al artículo",
            nombre: "Por favor, ingrese un nombre al artículo"
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-8").addClass("has-error").removeClass("has-success");
            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-8").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
        }
    });

    // Obtener el codigo del articulo
    $('#categoria').on('change', obtenerCodigo);
    $('#categoria_edit').on('change', obtenerCodigo);

    function obtenerCodigo() {
        console.log('articulo');
        console.log($(this).val());
        var categoriaId = $(this).val();
        var request = $.ajax({
            'type': 'POST',
            'url': '/inventario/obtenerCorrelativo',
            'data': { categoriaId: categoriaId }
        })
            .done(function (data) {
                console.log(data);
                $("#code").val(data.trim());
                // addAEvent();
            })
            .fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            })
            .always(function () {
                console.log('completado');
            });
    }

    $('#btn-article-add').on('click', agregarArticulo);
    function agregarArticulo() {
        console.log('Agregar artículo');
        event.preventDefault();

        var article = $('#form-article-add').serializeFormJSON();
        var nombre = $("input[name='nombre']").val();
        var descripcion = $("input[name='descripcion']").val();

        console.log(article);
        // return 0;
        // Validar el formulario antes de enviarlo formulario
        if (!$('#form-article-add').valid()) {
            $('#form-article-add #nombre').focus();
            return 0;
        }
        console.log("validado");
        var request = $.ajax({
            'type': 'POST',
            'url': '/inventario/article_add',
            'data': article  // { nombre : nombre, descripcion : descripcion, foto : foto}
        })
            .done(function (data) {
                console.log(data);
                var data = JSON.parse(data);
                if (data.code == 0) {
                    mostrarError($('#form-article-add-error'), data.message);
                } else {
                    swal('', 'Artículo registrado correctamente', 'info');
                    limpiarFormulario($('#form-article-add'));
                    $('#foto_preview').attr('src', '/assets/img/default_256.png');
                    $('#form-article-add').find(".form-group .col-sm-8").removeClass('has-success');
                    $('#modal-article-add').modal('hide')
                    listarArticulos();
                }
            })
            .fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            })
            .always(function () {
                console.log('completado');
            });
    }
    var articulo;
    function listarArticulos() {
        var request = $.ajax({
            'type': 'POST',
            'url': '/inventario/article_list',
            'data': articulo  // {usuario_id : usuarioId, nombres : nombres}
        })
            .done(function (data) {
                // var data =JSON.parse(data);
                $('#articles-items').html('');
                $('#articles-items').html(data);
                addAEvent();
            })
            .fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            })
            .always(function () {
                console.log('completado');
            });
    }

    // reglas formulario edit
    $('#form-article-edit').validate({
        rules: {
            articulo_edit: "required",
            code_edit: "required",
            nombre_edit: "required"
        },
        messages: {
            articulo_edit: "Por favor, seleccione una articulo",
            code_edit: "Por favor, ingrese un código al artículo",
            nombre_edit: "Por favor, ingrese un nombre al artículo"
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-8").addClass("has-error").removeClass("has-success");
            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-8").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
        }
    });

    // Mostrar editar artículo
    var articulo;
    function mostrarEditarArticulo() {
        var articuloId = $(this).data('articulo');
        console.log($(this).data('articulo'));

        // Obtener los datos del usuario con ajax
        var request = $.ajax({
            'type': 'GET',
            'url': '/inventario/articuloById',
            'data': { articuloId: articuloId }
        })
            .done(function (data) {
                articulo = JSON.parse(data)[0];
                console.log(articulo);
                limpiarFormulario($("#form-article-edit"));
                // $('#foto_preview_edit').attr('src', '/assets/img/default_256.png');

                $('#articuloId_edit').val(articulo.articuloId);
                $('#categoria_edit').val(articulo.categoriaId);
                $('#code_edit').val(articulo.code);
                $('#nombre_edit').val(articulo.nombre);
                $('#descripcion_edit').val(articulo.descripcion);
                $('#unidadMedida_edit').val(articulo.unidadMedida);
                $('#marca_edit').val(articulo.marca);
                $('#modelo_edit').val(articulo.modelo);
                $('#talla_edit').val(articulo.talla);
                $('#color_edit').val(articulo.color);
                $('#tela_edit').val(articulo.tela);
                $('#caracteristicas_edit').val(articulo.caracteristicas);
                $('#estado_edit').attr('checked', true);
                // $('#foto_preview_edit').attr('src', '/assets/img/categorys/category_'+articulo.articuloId+'/'+articulo.imagen_path);
            })
            .fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            })
            .always(function () {
                console.log('completado');

            });
        $("#modal-article-edit").modal('show');
    }

    $('#modal-article-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    })


    $('#btn-article-edit').on('click', editarArticulo);

    function editarArticulo() {
        event.preventDefault();
        console.log('Editar articulo');
        var articulo = $('#form-article-edit').serializeFormJSON();

        var articuloId = $('#articuloId_edit').val();
        console.log(articuloId);

        // Validar el formulario antes de enviarlo formulario
        if (!$('#form-article-edit').valid()) {
            $('#nombre_edit').focus();
            return 0;
        }

        var request = $.ajax({
            'type': 'POST',
            'url': '/inventario/article_edit',
            'data': articulo  // {usuario_id : usuarioId, nombres : nombres}
        })
            .done(function (data) {
                var data = JSON.parse(data);
                if (data.code == 0) {
                    mostrarError($('#form-article-edit-error'), data.message);
                } else {
                    alert('artículo actualizada correctamente');
                    limpiarFormulario($('#form-article-edit'));
                    // $('#foto_preview_edit').attr('src', '/assets/img/default_256.png');              
                    $('#modal-category-edit').modal('hide')
                    listarArticulos();
                }
            })
            .fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            })
            .always(function () {
                console.log('completado');
            });
    }

    function addAEvent() {
        $('.btn-article-edit-show').unbind();
        $('.btn-article-edit-show').on('click', mostrarEditarArticulo);
    }
})