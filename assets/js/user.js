$(document).ready(function(){

    $('#tblUsuarios').DataTable();
    $('#form-user-add-error').css('display', 'none'); // ocultando los mensajes
    $('.btn-user-edit-show').on('click', mostrarEditarUsuario);
    $('#btn-user-add').on('click', agregarUsuario);    
    $('#btn-user-edit').on('click', editarUsuario);
    $('.btn-user-delete').on('click', eliminarUsuario);

    $('#modal-user-add').on('show.bs.modal', function(evt) {
        limpiarFormulario($('#form-user-add'));   
        $('#form-user-add-error').hide();
    })

    $('#modal-user-edit').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        // limpiarFormulario($('#form-user-edit'));   
        $('#form-user-edit-error').hide();
        // modal.find('.modal-title').text('New message to ' + recipient)
        // modal.find('.modal-body input').val(recipient)
    })

    $('#tiendas').multiselect({
        buttonContainer: '<div class="btn-group btn-multiselect" />'
    });
    $('#tiendas_edit').multiselect({
        buttonContainer: '<div class="btn-group btn-multiselect" />',
        buttonWidth: '100%'
    });

    $.validator.setDefaults({
        submitHandler: function (){
            alert( "submitted!");
        }
    });

    // reglas formularios
    $('#form-user-add').validate({
        rules: {
            nombres: "required",
            apellidoPaterno: "required",
            apellidoMaterno: "required",
            email: {
                // required: true,
                email: true
            },
            usuario: {
                required: true,
                minlength: 3
            },
            clave: {
                required: true,
                minlength: 5
            },
            confirm_clave: {
                required: true,
                minlength: 5,
                equalTo: "#clave"
            },
            rol: {
                required : true,
                number: true
            }
        },
        messages: {
            nombres: "Por favor, ingrese su nombre",
            apellidoPaterno: "Por favor, ingrese su apellido paterno",
            apellidoMaterno: "Por favor, ingrese su apellido materno",
            email: "Por favor, ingrese un email valido",
            usuario: {
                required: "Por favor, ingrese un nombre de usuario",
                minlength: "Su nombre de usuario debera tener al menos 3 caracteres"
            },
            clave: {
                required: "Por favor, ingrese una contraseña",
                minlength: "Su contraseña debera tener al menos 5 caracteres"
            },
            confirm_clave: {
                required: "Por favor, ingrese nuevamente su contraseña",
                minlength: "Su contraseña debera tener al menos 5 caracteres",
                equalTo: "Las contraseñas no coinciden"
            },
            rol : "Por favor, seleccione un rol"
        },
        // errorElement: "em",
        // errorPlacement: function ( error, element ) {
        //     // Add the `help-block` class to the error element
        //     error.addClass( "help-block" );

        //     if ( element.prop( "type" ) === "checkbox" ) {
        //         error.insertAfter( element.parent( "label" ) );
        //     } else {
        //         error.insertAfter( element );
        //     }
        // },
        highlight: function (element, errorClass, validClass){
            $(element).parents(".col-sm-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-6").addClass("has-success").removeClass("has-error");
        }
    });

    $('#form-user-edit').validate({
        rules: {
            nombres_edit: "required",
            apellidoPaterno_edit: "required",
            apellidoMaterno_edit: "required",
            email_edit: {

                email: true
            },
            usuario_edit: {
                required: true,
                minlength: 3
            },
            clave_edit: {
                minlength: 5
            },
            confirm_clave_edit: {
                minlength: 5,
                equalTo: "#clave_edit"
            },
            rol_edit: {
                required : true,
                number: true
            }
        },
        messages: {
            nombres_edit: "Por favor, ingrese su nombre",
            apellidoPaterno_edit: "Por favor, ingrese su apellido paterno",
            apellidoMaterno_edit: "Por favor, ingrese su apellido materno",
            email_edit: "Por favor, ingrese un email valido",
            usuario_edit: {
                required: "Por favor, ingrese un nombre de usuario",
                minlength: "Su nombre de usuario debera tener al menos 3 caracteres"
            },
            clave_edit: {
                required: "Por favor, ingrese una contraseña",
                minlength: "Su contraseña debera tener al menos 5 caracteres"
            },
            confirm_clave_edit: {
                required: "Por favor, ingrese nuevamente su contraseña",
                minlength: "Su contraseña debera tener al menos 5 caracteres",
                equalTo: "Las contraseñas no coinciden"
            },
            rol_edit : "Por favor, seleccione un rol"
        },
        highlight: function (element, errorClass, validClass){
            $(element).parents(".col-sm-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-6").addClass("has-success").removeClass("has-error");
        }
    });


    // function mostrar editar usuario
    var usuario;
    function mostrarEditarUsuario(){
        var usuarioId = $(this).data('usuario');
        console.log($(this).data('usuario'));

        // Obtener los datos del usuario con ajax
        var request = $.ajax({
            'type' : 'GET',            
            'url' : '/usuario/show',
            'data' :  {usuario_id : usuarioId },
            beforeSend: Call_Progress(true)
        })
        .done(function(data){
            usuario = JSON.parse(data)[0];
            console.log(usuario);
            limpiarFormulario($("#form-user-edit"));

            $('#usuarioId_edit').val(usuario.usuario_id);
            $('#nombres_edit').val(usuario.nombre);
            $('#apellidoPaterno_edit').val(usuario.apellido_paterno);
            $('#apellidoMaterno_edit').val(usuario.apellido_materno);
            $('#direccion_edit').val(usuario.direccion);
            $('#celular_edit').val(usuario.celular);
            $('#telefono_edit').val(usuario.telefono);
            $('#email_edit').val(usuario.email);
            $('#usuario_edit').val(usuario.usuario);
            $('#estado_edit').prop('checked', Number(usuario.estado));            
            $('#rol_edit').val(usuario.rol_id);
            
            var tiendas = [];
            $.each(usuario.tiendas, function(index, value){
                // alert(value.tiendaId);
                tiendas[index] = value.tiendaId;
            })
            console.log(tiendas);
            $('#tiendas_edit').multiselect('select', tiendas);
            $("#modal-user-edit").modal('show');   
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');      
            beforeSend: Call_Progress(false);      
        });             
    }    
    function agregarUsuario(){
        event.preventDefault();
        console.log('Agregar usuario');
        // var user = $('#form-user-add').serialize(); //FormJSON();
        var user = $('#form-user-add').serializeFormJSON();

        var usuarioId = $('#usuarioId').val();
        var nombres = $("input[name='nombres']").val();
        // console.log(user);
        // return 0;

        // Validar el formulario antes de enviarlo formulario
        if(!$('#form-user-add').valid()){
            return 0;
        }
        console.log("validado");
        var request = $.ajax({
            'type' : 'POST',
            'url' : '/usuario/add',
            'data' : user,  // {usuario_id : usuarioId, nombres : nombres}
            beforeSend: Call_Progress(true)
        })
        .done(function(data){
            var data = JSON.parse(data);
            console.log(data);
            if(data.code == 0){
                mostrarError($('#form-user-add-error'), data.message);
            }else { 
                swal('', 'El usuario ha sido registrado correctamente', 'success');
                limpiarFormulario($('#form-user-add'));                
                $('#modal-user-add').modal('hide')
                listarUsuarios();
            }
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
            beforeSend: Call_Progress(false);
        });
    }
    function editarUsuario()
    {
        event.preventDefault();
        console.log('Editar usuario');
        var user = $('#form-user-edit').serializeFormJSON();

        var usuarioId = $('#usuarioId_edit').val();
        // console.log(usuarioId);

        // Validar el formulario antes de enviarlo formulario
        if(!$('#form-user-edit').valid()){
            return 0;
        }

        var request = $.ajax({
            method: 'POST',
            url: '/usuario/edit',
            data: user,  // {usuario_id : usuarioId, nombres : nombres}
            beforeSend: Call_Progress(true)
        })
        .done(function(data){
            // console.log(data);
            var data =JSON.parse(data);
            if(data.code == 0){
                mostrarError($('#form-user-edit-error'), data.message);
            }else {
                swal('', 'El usuario ha sido actualizado correctamente', 'success');
                limpiarFormulario($('#form-user-edit'));                
                $('#modal-user-edit').modal('hide');
                listarUsuarios();
            }
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){            
            beforeSend: Call_Progress(false)
        });
    }
    function eliminarUsuario() {
        swal('', 'Esta opción no se encuentra disponible temporalmente', 'warning');
    }
    function listarUsuarios() {
        var request = $.ajax({
            'type' : 'POST',
            'url' : '/usuario/list_items',
            'data' : usuario  // {usuario_id : usuarioId, nombres : nombres}
        }) 
        .done(function(data){
            $('#users-items').html('');
            $('#users-items').html(data);
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
        $('.btn-user-edit-show').unbind();
        $('.btn-user-edit-show').on('click', mostrarEditarUsuario); 
        $('.btn-user-delete').unbind();
        $('.btn-user-delete').on('click', eliminarUsuario);    
    }
})