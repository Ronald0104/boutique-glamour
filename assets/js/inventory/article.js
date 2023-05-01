var tbl_articulos;

$(document).ready(function () {
    //fn_ListarArticulos_Json();
    fn_ListarArticulos();
    fn_CargarModalArticulos(null, false);
    // var table = $('#tbl_articles').DataTable({
    //     "scrollX": true,
    //     orderCellsTop: true,
    //     fixedHeader: true
    // });

    $('#categoria').select2({minimumResultsForSearch: Infinity});
    $('#estado').select2({minimumResultsForSearch: Infinity});
    $('#condicion').select2({minimumResultsForSearch: Infinity});
    $('#talla').select2();
    $('#color').select2();
    $('#diseno').select2();

    $('#categoria').change(function() {
        Call_Progress(true);
        tbl_articulos.ajax.reload(function() {Call_Progress(false);}, false);
        let categoriaId = $(this).val();
        fn_ListarTallasxCategoria2(categoriaId);
        fn_ListarColoresxCategoria2(categoriaId);
        fn_ListarDisenosxCategoria2(categoriaId);
    })

    $('#estado').change(function() {
        Call_Progress(true);
        tbl_articulos.ajax.reload(function() {Call_Progress(false);}, false);
    })
    $('#condicion').change(function() {
        Call_Progress(true);
        tbl_articulos.ajax.reload(function() {Call_Progress(false);}, false);
    })

    $('#tbl_articles thead tr').clone(true).appendTo('#tbl_articles thead');

    // Setup - add a text input to each footer cell
    $('#tbl_articles thead tr:eq(1) th').each(function (i) {
        var title = $(this).text();
        if(i>0){
            $(this).html('<input type="text" placeholder="' + title + '" />');
            $('input', this).on('keyup change', function () {
                if (tbl_articulos.column(i).search() !== this.value) {
                    tbl_articulos.column(i).search(this.value).draw();
                }
            });
        }        
    });

    $(document).on('dblclick', '#tbl_articles>tbody>tr', function() {
        var articuloId = $(this).data('articulo').articuloId;
        fn_CargarModalArticulos(function() {
            fn_ObtenerArticuloById(articuloId, function(data) {
                App.Producto.EsEdit = true;
                fn_LimpiarArticuloFull();
                fn_MostrarArticulo(data);
            })
        });
    });
    $.validator.setDefaults({
        submitHandler: function () {
            alert("submitted!");
        }
    });

    $('#form-article-add-error').css('display', 'none');
    $('#form-article-edit-error').css('display', 'none');
    
    $('#btn-search-article').on('click', function() {
        Call_Progress(true);
        tbl_articulos.ajax.reload(function() {Call_Progress(false)}, false);        
    })
    $('#btn-show-article-add').on('click', function(evt) {
        fn_CargarModalArticulos(function() {
            App.Producto.EsNuevo = true;
            App.Producto.Nuevo();
            App.Producto.EsNuevo = false;
        });
    });
    $(document).on('click', '.btn-article-edit-show', function() {
        //mostrarEditarArticulo();
        var articuloId = $(this).data('articulo');
        fn_CargarModalArticulos(function() {
            // console.log('cargar el articulo ' + articuloId);
            fn_ObtenerArticuloById(articuloId, function(data) {
                // console.log(data);
                fn_LimpiarArticuloFull();
                fn_MostrarArticulo(data);
                // console.log($('#articuloId').val());
            })
            // console.log($('#articuloId').val());
        });
        // console.log($('#articuloId').val());
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
    // $('#categoria').on('change', obtenerCodigo);

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
                console.log(data);
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
        // $('.btn-article-edit-show').unbind();
        // $('.btn-article-edit-show').on('click', mostrarEditarArticulo);
    }
})

function fn_ListarArticulos() {
    tbl_articulos = $('#tbl_articles').DataTable({
        language: language_espanol,
        pageLength: 50,
        scrollX: true,
        orderCellsTop: true,
        fixedHeader: true,
        ajax: {
            method: "POST",
            url: "/inventario/articulos_Json",
            data: function (d) {
                d.categoria = $('#categoria').val();             
                d.estado = $('#estado').val();
                d.condicion = $('#condicion').val();
                d.talla = $('#talla').val();
                d.color = $('#color').val();
                d.diseno = $('#diseno').val();
                // d.fechaDesde = $('#fechaDesde').val(); 
                // d.fechaHasta = $('#fechaHasta').val(); 
                // d.tienda = $('#tienda').val();
                // d.estado = $('#estado').val();
            }
            //$('#frmSaleSearch').serializeFormJSON()
        },
        // dom: 'Bfrtip',
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ],
        columns: [
            {
                data: "articuloId", render: function (data, display, row) {
                    //console.log(data);  
                    //console.log(row);  
                    var str = "<div class='center' style='min-width:76px'>";
                    str += "<button type='button' class='btn btn-success btn-xs btn-article-edit-show' data-toggle='modal' data-target='#modal-article-edit2' data-articulo=" + data + "><i class='glyphicon glyphicon-edit'></i></button>";                    
                    str += "&nbsp;"
                    str += "<button type='button' class='btn btn-warning btn-xs btn-article-delete' data-toggle='modal' data-target='#' data-articulo=" + data + "><i class='icon icon-trash'></i></button>";                    
                    str += "</div>";
                    return str;
                }
            },
            // { data: "articuloId"},
            { data: "code" },
            { data: "nombre" },
            { data: "categoria" },
            { data: "estado" },
            { data: "condicion" },
            { data: "color" },
            { data: "talla" },
            { data: "tela" }                    
        ],
        // footerCallback: function (row, data, start, end, display) {
            // var api = this.api(), data;

            // // Remove the formatting to get integer data for summation
            // var intVal = function (i) { return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; };
            // // Total over all pages
            // total = api.column(7).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // // A Cuenta Anterior
            // cuentaAnterior = api.column(8).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // // A Cuenta
            // cuenta = api.column(9).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // // Saldo
            // saldo = api.column(10).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // // Total over this page
            // pageTotal = api.column(6, { page: 'current' }).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // // Update footer
            // $(api.column(7).footer()).html('<h5><b>S/' + Number(total).toFixed(2) + '</b></h5>');
            // $(api.column(8).footer()).html('<h5><b>S/' + Number(cuentaAnterior).toFixed(2) + '</b></h5>');
            // $(api.column(9).footer()).html('<h5><b>S/' + Number(cuenta).toFixed(2) + '</b></h5>');
            // $(api.column(10).footer()).html('<h5><b>S/' + Number(saldo).toFixed(2) + '</b></h5>');
        // },
        createdRow: function (row, data, dataIndex, cells) {
            $(row).attr('tabindex', 0).data('articulo', data);
            // switch (data.estadoId) {
            //     case "1": $(row).css('background-color', 'rgb(14, 236, 83)'); break;
            //     case "2":
            //         var fechaDevolucion = new Date(data.fechaDevolucionProgramada);
            //         var fechaActual = new Date();
            //         if (fechaActual.getTime() > fechaDevolucion.getTime())
            //             $(row).css('background-color', 'rgb(220, 89, 0)');
            //         else
            //             $(row).css('background-color', 'rgb(228, 154, 20)');
            //         break;
            //     case "3": $(row).css('background-color', 'rgb(210, 135, 84)'); break; //rgb(122, 209, 243)
            //     case "4": $(row).css('background-color', 'rgb(72, 167, 204)'); break;
            //     default: break;
            // }
        }
    });
}

function fn_ListarArticulos_Json() {
    $.ajax({
        method: 'POST',
        url: '/inventario/articulos_Json'
    })
    .done(function(data) {
        //console.log(data);
    })
    .fail(function(textStatus, jqXHR) {
        console.log(textStatus);
    })
    .always(function(){
        console.log('Articulos cargados');
    })
}

// Cargar Modal de articulos
function fn_CargarModalArticulos(success, showModal = true) {
    if($('#m-register-article').html().trim() == "") {
        $.ajax({
            method: 'POST',
            url: '/inventario/articuloAgregar',
            beforeSend: Call_Progress(true)
        })
        .done(function(data){
            $('#m-register-article').html(data);
            if (success != undefined && typeof success == "function") success();
            if (showModal) $('#modal-article-add').modal('show');
        })
        .fail(function(jqXHR) { console.log(jqXHR.responseText)})
        .always(function() {Call_Progress(false)})
    } 
    else {
        if (success != undefined && typeof success == "function") success();
        if (showModal) $('#modal-article-add').modal('show');
    }          
}

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

function fn_ListarTallasxCategoria2(categoriaId) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarTallasxCategoria',
        data: { categoriaId : categoriaId},
        // dataType: "json",
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#talla').html('');
        let tallas = JSON.parse(data); 
        $('#talla').select2("destroy");               
        $('#talla').append("<option value='0'>TODOS</option>");
        if (tallas.length > 0) {        
            tallas.forEach((e) => $('#talla').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))            
        };   
        $('#talla').select2(); 
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}

function fn_ListarColoresxCategoria2(categoriaId) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarColoresxCategoria',
        data: { categoriaId : categoriaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#color').html('');
        let colores = JSON.parse(data);
        $('#color').select2("destroy");
        $('#color').append("<option value='0'>TODOS</option>");        
        if (colores.length > 0) {
            colores.forEach((e) => $('#color').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))           
        };  
        $('#color').select2();
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}

function fn_ListarDisenosxCategoria2(categoriaId) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarDisenosxCategoria',
        data: { categoriaId : categoriaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#diseno').html('');
        let disenos = JSON.parse(data);  
        $('#diseno').select2("destroy");
        $('#diseno').append("<option value='0'>TODOS</option>");         
        if (disenos.length > 0) {
            disenos.forEach((e) => $('#diseno').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))
        }; 
        $('#diseno').select2();
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}