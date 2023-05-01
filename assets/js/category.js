$(document).ready(function(){
    var category;

    $.validator.setDefaults({
        submitHandler: function (){
            alert( "submitted!");
        }
    });

    // reglas formulario
    $('#form-category-add').validate({
        rules: {
            nombre: "required",
            prefijo: "required"
        },
        messages: {
            nombre: "Por favor, ingrese un nombre a la categoria",
            prefijo: "Por favor, ingrese un prefijo a la categoria"
        },
        highlight: function (element, errorClass, validClass){
            $(element).parents(".col-sm-8").addClass("has-error").removeClass("has-success");
            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-8").addClass("has-success").removeClass("has-error");
            $(element).parents(".col-sm-4").addClass("has-error").removeClass("has-success");
        }
    });
    // reglas formulario
    $('#form-category-edit').validate({
        rules: {
            nombre: "required",
            prefijo: "required"
        },
        messages: {
            nombre: "Por favor, ingrese un nombre a la categoria",
            prefijo: "Por favor, ingrese un prefijo a la categoria"
        },
        highlight: function (element, errorClass, validClass){
            $(element).parents(".col-sm-8").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-8").addClass("has-success").removeClass("has-error");
        }
    });

    var opts = {
        url: '/admin/loadFotoTemp',
        data : {folderPath: 'category'},
        fileHolder: '#foto',
        filePreview: '#foto_preview',
        notificationDelay: 120000,
        onSuccess: function (server_return, name, uploaded_file) {
            var _prev = $('#foto_preview');
            var _drop = $('#foto-drop');

            _drop.after($('<p />').html('File sent: <b>' + name + ' (' + server_return.file_name + ')</b>'));
            $('#fotoPath').val(server_return.file_name);
            $('#token').val(server_return.token);
            console.log($('#fotoPath').val());
            console.log(name);
            console.log(server_return);

            var oFReader = new FileReader();
            oFReader.readAsDataURL(uploaded_file);
            oFReader.onload = function (oFREvent) {
                _prev.attr('src', oFREvent.target.result);
            };
        }
    };
    var opts2 = {
        url: '/admin/loadFotoTemp',
        // data : {folderPath: 'category'},
        fileHolder: '#foto_edit',
        filePreview: '#foto_preview_edit',
        notificationDelay: 120000,
        onSuccess: function (server_return, name, uploaded_file) {
            var _prev = $('#foto_preview_edit');
            var _drop = $('#foto-drop-edit');
            _drop.parent().find('p').remove();
            _drop.after($('<p />').html('File sent: <b>' + name + ' (' + server_return.file_name + ')</b>'));
            $('#fotoPath_edit').val(server_return.file_name);
            $('#token_edit').val(server_return.token);
            console.log($('#fotoPath_edit').val());
            console.log(name);
            console.log(server_return);

            var oFReader = new FileReader();
            oFReader.readAsDataURL(uploaded_file);
            oFReader.onload = function (oFREvent) {
                _prev.attr('src', oFREvent.target.result);
            };
        }
    };

    $('#foto-drop').droparea(opts);
    $('#foto-drop-edit').droparea(opts2);

    $('#btn-category-add').on('click', agregarCategoria);
    $('#btn-category-edit').on('click', editarCategoria);

    $('#form-category-add-error').css('display', 'none');
    $('#form-category-edit-error').css('display', 'none');

    $('.btn-category-edit-show').on('click', mostrarEditarCategoria);
 

    // Agregar categoria
    function agregarCategoria(){
        console.log('Agregar categoria');
        event.preventDefault();
        
        var category = $('#form-category-add').serializeFormJSON();
        var nombre = $("input[name='nombre']").val();
        var descripcion = $("input[name='descripcion']").val();
        var foto = $("input[name='fotoPath']").val();

        console.log(category);
        // Validar el formulario antes de enviarlo formulario
        if(!$('#form-category-add').valid()){
            $('#form-category-add #nombre').focus();
            return 0;
        }
        console.log("validado");
        var request = $.ajax({
            'type' : 'POST',
            'url' : '/inventario/category_add',
            'data' : category  // { nombre : nombre, descripcion : descripcion, foto : foto}
        })
        .done(function(data){
            console.log(data);
            var data =JSON.parse(data);
            if(data.code == 0){
                mostrarError($('#form-category-add-error'), data.message);
            }else {
                alert('Categoria registrado correctamente');
                limpiarFormulario($('#form-category-add'));   
                $('#foto_preview').attr('src', '/assets/img/default_256.png'); 
                $('#form-category-add').find(".form-group .col-sm-8").removeClass('has-success');          
                $('#modal-category-add').modal('hide')
                listarCategorias();
            }
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
        }); 
    }

    // Editar categoria
    var categoria;
    function mostrarEditarCategoria(){
        var categoriaId = $(this).data('categoria');
        console.log($(this).data('categoria'));

        // Obtener los datos del usuario con ajax
        var request = $.ajax({
            'type' : 'GET',            
            'url' : '/inventario/categoriaById',
            'data' :  {categoriaId : categoriaId}
        })
        .done(function(data){
            categoria = JSON.parse(data)[0];
            console.log(categoria);
            limpiarFormulario($("#form-category-edit"));
            $('#foto_preview_edit').attr('src', '/assets/img/default_256.png');

            $('#categoriaId_edit').val(categoria.categoriaId);
            $('#nombre_edit').val(categoria.nombre);
            $('#descripcion_edit').val(categoria.descripcion);
            $('#prefijo_edit').val(categoria.prefijo_code);
            $('#estado_edit').val(categoria.estado);
            $('#categoriaPadreId_edit').val(categoria.categoriaPadreId);
            $('#foto_preview_edit').attr('src', '/assets/img/categorys/category_'+categoria.categoriaId+'/'+categoria.imagen_path);
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
            
        });
        $("#modal-category-edit").modal('show');        
    }

    $('#modal-category-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    })

    function editarCategoria(){
        event.preventDefault();
        console.log('Editar categoria');
        var categoria = $('#form-category-edit').serializeFormJSON();

        var categoriaId = $('#categoriaId_edit').val();
        console.log(categoriaId);

        // Validar el formulario antes de enviarlo formulario
        if(!$('#form-category-edit').valid()){
            return 0;
        }

        var request = $.ajax({
            'type' : 'POST',
            'url' : '/inventario/category_edit',
            'data' : categoria  // {usuario_id : usuarioId, nombres : nombres}
        })
        .done(function(data){
            var data =JSON.parse(data);
            if(data.code == 0){
                mostrarError($('#form-category-edit-error'), data.message);
            }else {
                alert('categoria actualizada correctamente');
                limpiarFormulario($('#form-category-edit'));  
                $('#foto_preview_edit').attr('src', '/assets/img/default_256.png');              
                $('#modal-category-edit').modal('hide')
                listarCategorias();
            }
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
        });
    }

    function listarCategorias() {
        var request = $.ajax({
            'type' : 'POST',
            'url' : '/inventario/category_list',
            'data' : categoria  // {usuario_id : usuarioId, nombres : nombres}
        }) 
        .done(function(data){
            // var data =JSON.parse(data);
            // console.log(data);
            $('#categorys-items').html('');
            $('#categorys-items').html(data);
            addAEvent();
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
        });
    }

    function addAEvent(){
        $('.btn-category-edit-show').unbind();
        $('.btn-category-edit-show').on('click', mostrarEditarCategoria);    
    }
})