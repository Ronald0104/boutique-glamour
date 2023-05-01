$(document).ready(function () {
    // console.log('tienda');

    var opts = {
        url: '/tienda/loadFoto',
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
            /* ~~ THIS CODE IS NOT NECESSARY ~~ */
            /* ~~ IT'S ONLY HERE BECAUSE THE SERVER IS MOCKED ~~ */
            var oFReader = new FileReader();
            oFReader.readAsDataURL(uploaded_file);
            oFReader.onload = function (oFREvent) {
                _prev.attr('src', oFREvent.target.result);
            };
        }
    };
    $('#foto-drop').droparea(opts);

    var opts_edit = {
        url: '/tienda/loadFoto',
        fileHolder: '#foto_edit',
        filePreview: '#foto_preview_edit',
        notificationDelay: 120000,
        onSuccess: function (server_return, name, uploaded_file) {
            var _prev = $('#foto_preview_edit');
            var _drop = $('#foto-drop-edit');

            _drop.after($('<p />').html('File sent: <b>' + name + ' (' + server_return.file_name + ')</b>'));
            $('#fotoPath_edit').val(server_return.file_name);
            $('#token_edit').val(server_return.token);
            console.log($('#fotoPath_edit').val());
            console.log(name);
            console.log(server_return);
            /* ~~ THIS CODE IS NOT NECESSARY ~~ */
            /* ~~ IT'S ONLY HERE BECAUSE THE SERVER IS MOCKED ~~ */
            var oFReader = new FileReader();
            oFReader.readAsDataURL(uploaded_file);
            oFReader.onload = function (oFREvent) {
                _prev.attr('src', oFREvent.target.result);
            };
        }
    };
    $('#foto-drop-edit').droparea(opts_edit);

    $('#btn-shop-add').on('click', agregarTienda);
    $('#btn-shop-edit').on('click', editarTienda);
    $(document).on('click', '.btn-shop-edit', mostrarEditarTienda);

    $('#estado').on('change', function() {$(this).val(Number($(this).prop('checked')))});
    $('#estado_edit').on('change', function() {$(this).val(Number($(this).prop('checked')))});
    
    $.validator.setDefaults({
        submitHandler: function () {
            alert("submitted!");
        }
    });

    // reglas formularios
    $('#form-shop-add').validate({
        rules: {
            nombre: "required",
            direccion: "required"
        },
        messages: {
            nombre: "Por favor, ingrese un nombre a la tienda",
            direccion: 'Por favor, ingrese su dirección'
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-6").addClass("has-success").removeClass("has-error");
        }
    });
    $('#form-shop-edit').validate({
        rules: {
            nombre_edit: "required",
            direccion_edit: "required"
        },
        messages: {
            nombre_edit: "Por favor, ingrese un nombre a la tienda",
            direccion_edit: 'Por favor, ingrese su dirección'
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-6").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-6").addClass("has-success").removeClass("has-error");
        }
    });


    var tienda;
    // Guardar tienda
    function agregarTienda() {
        console.log('Agregar tienda');
        event.preventDefault();

        var shop = $('#form-shop-add').serializeFormJSON();
        var nombre = $("input[name='nombre']").val();
        var direccion = $("input[name='direccion']").val();
        var foto = $("input[name='fotoPath']").val();

        console.log(shop);
        // Validar el formulario antes de enviarlo formulario
        if (!$('#form-shop-add').valid()) {
            $('#form-shop-add #nombre').focus();
            return 0;
        }
        console.log("validado");
        var request = $.ajax({
            'type': 'POST',
            'url': '/tienda/add',
            'data': shop  // { nombre : nombre, direccion : direccion, foto : foto}
        })
            .done(function (data) {
                console.log(data);
                var data = JSON.parse(data);
                if (data.code == 0) {
                    mostrarError($('#form-shop-add-error'), data.message);
                } else {
                    // alert('Tienda registrado correctamente');
                    swal('', 'Tienda registrada correctamente', 'info');
                    limpiarFormulario($('#form-shop-add'));
                    $('#modal-shop-add').modal('hide')
                    // Recargar la lista de usuarios
                }
            })
            .fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            })
            .always(function () {
                console.log('completado');
            });
    }

    function mostrarEditarTienda() {
        var tiendaId = $(this).data('tienda');
        $.ajax({
            method: 'POST',
            url: '/tienda/obtener',
            data: { tiendaId: tiendaId },
            dataType: 'json',
            beforeSend: Call_Progress(true)
        })
            .done(function (data) {
                console.log(data);
                tienda = data[0];
                $('#tiendaId_edit').val(tienda.id);
                $('#nombre_edit').val(tienda.nombre);
                $('#sub_nombre_edit').val(tienda.sub_nombre);
                $('#direccion_edit').val(tienda.direccion);
                $('#referencia_edit').val(tienda.referencia);
                $('#telefono_edit').val(tienda.telefono);
                $('#estado_edit').prop('checked', Number(tienda.estado));
                $('#estado_edit').val(tienda.estado);
                if (tienda.foto != "")
                    $('#foto_preview_edit').prop('src', '/assets/img/shops/shop_' + tiendaId + '/' + tienda.foto);
                else
                    $('#foto_preview_edit').prop('src', '/assets/img/shops/store_256.png');
                $('#modal-shop-edit').modal('show');
            })
            .fail(function () {
                console.log('Error al obtener tienda');
            })
            .always(function () {
                Call_Progress(false)
            })
    }

    function editarTienda() {
        console.log('Editar tienda');
        event.preventDefault();

        var shop = $('#form-shop-edit').serializeFormJSON();
        var nombre = $("input[name='nombre_edit']").val();
        var direccion = $("input[name='direccion_edit']").val();
        var foto = $("input[name='fotoPath_edit']").val();

        console.log(shop);
        // Validar el formulario antes de enviarlo formulario
        if (!$('#form-shop-edit').valid()) {
            $('#form-shop-add #nombre_edit').focus();
            return 0;
        }
        console.log("validado");
        var request = $.ajax({
            method: 'POST',
            url: '/tienda/edit',
            data: shop,  // { nombre : nombre, direccion : direccion, foto : foto}
            beforeSend: Call_Progress(true)
        })
            .done(function (data) {
                console.log(data);
                var data = JSON.parse(data);
                if (data.code == 0) {
                    mostrarError($('#form-shop-edit-error'), data.message);
                } else {
                    // alert('Tienda actualizada correctamente');
                    swal('', 'Tienda actualizada correctamente');
                    limpiarFormulario($('#form-shop-edit'));
                    $('#modal-shop-edit').modal('hide')
                    // Recargar la lista de tiendas
                }
            })
            .fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            })
            .always(function () {
                // console.log('completado');
                Call_Progress(false)
            });
    }

    function cargarFoto() {

    }
})