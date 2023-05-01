$(function () {
    $('#modal-register-customer').on('shown.bs.modal', function () {
        if(!$('#customerId_Add').val()) $('#tipoDocumento_Add').val('1'); // Unicamente si es nuevo
        $('#nroDocumento_Add').trigger('focus');
        // console.log(location.href);
        // console.log(window.location);
    })

    $('#nroDocumento_Add').on('keypress', function (evt) {
        if (evt.keyCode == 13) {
            var $this = $(this);
            if ($('#nroDocumento_Add').val().trim() == $this.data('valueOld')) return;
            // if ($('#customerId_Add').val() == "0") return;
            fn_ObtenerCliente(function () {
                $('#nroDocumento_Add').data('valueOld', $this.val().trim());
                $('#nombres_Add').focus();
            });
        }
    }).on('blur', function (evt) {
        if ($(this).val().length >= 8) {
            var $this = $(this);
            if ($('#nroDocumento_Add').val().trim() == $this.data('valueOld')) return;
            // if ($('#customerId_Add').val() == "0") return;
            fn_ObtenerCliente(function () {
                $('#nroDocumento_Add').data('valueOld', $this.val().trim());
                $('#nombres_Add').focus();
            });
        }
    });

    $('#fotoCliente_Add').on('change', function (evt) {
        // console.log(this);
        // var fn = $(this).val();
        // var filename = fn.match(/[^\\/]*$/)[0];
        var filename = URL.createObjectURL(evt.target.files[0]);
        $('#fotoCliente_Preview').attr('src', filename);
        console.log(filename);
    })

    $('#form-customer-add-full').submit(function (evt) {
        evt.preventDefault();
    });
    $('#btn-customer-add').on('click', function (evt) {
        evt.preventDefault();
        var isValid = $('#form-customer-add-full').valid();

        if (isValid) {
            // var cliente = $('#form-customer-add-full').serializeFormJSON();
            var cliente = new FormData($('#form-customer-add-full')[0]);
            var clienteJson = $('#form-customer-add-full').serializeFormJSON();
            // console.log(cliente);
            // return;
            $.ajax({
                method: 'POST',
                url: '/cliente/registrar',
                data: cliente,
                beforeSend: Call_Progress(true),
                contentType: false,
                cache: false,
                processData: false,
                // contentType: 'application/json; charset=utf-8'                       
            })
                .done(function (data, textStatus, jqXHR) {
                    console.log(data);
                    let action = jqXHR.getResponseHeader('Content-Type-Action');
                    if (data) {
                        $('#modal-register-customer').modal('hide');
                        validateCustomerFull.resetForm();
                        fn_LimpiarCliente();
                        if (action == "insert")
                            swal('', 'cliente registrado correctamente', 'info');
                        else if (action == "update")
                            swal('', 'cliente actualizado correctamente', 'info');
                        else
                            swal('', 'error al registrar al cliente', 'info');

                        let path = window.location.pathname;
                        if (path == "/cliente/listar") fn_CargaClientes();
                        if(action == "insert") clienteJson.customerId_Add = data;
                        $(document).trigger('customerAction', {action: action, cliente: clienteJson});
                    }
                })
                .fail(function () {
                    console.log("error al registrar cliente");
                })
                .always(function () {
                    Call_Progress(false);
                })
        }
    })

    $(document).on('click', '.link-venta', function (evt) {
        evt.preventDefault();
        let ventaId = $(this).data('venta');
        Call_Progress(true)
        setTimeout(function () {
            Call_Progress(true);
            window.open('/ventas/editar/' + ventaId, '_blank');
            Call_Progress(false);
        }, 1000)
    });
})

function fn_ObtenerCliente(func) {
    $.ajax({
        type: 'POST',
        url: '/cliente/obtenerClienteByNumero',
        data: { numero: $('#nroDocumento_Add').val() },
        beforeSend: Call_Progress(true),
        dataType: 'json'
    })
        .done(function (data) {   
            console.log(data.historial);      
            if (data.cliente.length > 0) {                
                let cliente = data.cliente[0];
                $('#customerId_Add').val(cliente.clienteId);
                $('#tipoDocumento_Add').val(cliente.tipo_documento);
                $('#nroDocumento_Add').val(cliente.nro_documento);
                $('#nombres_Add').val(cliente.nombres);
                $('#apellidos_Add').val(cliente.apellido_paterno);
                $('#telefono_Add').val(cliente.telefono);
                $('#celular_Add').val(cliente.celular);
                $('#celular_Add').val(cliente.celular);
                $('#direccion_Add').val(cliente.direccion);
                $('#email_Add').val(cliente.email);
                $('#observaciones_Add').val(cliente.observaciones);

                let path = cliente.path_foto;
                if (path) $('#fotoCliente_Preview').attr('src', '/assets/img/customers/' + cliente.clienteId + '/' + path)  
                fn_CargarHistorialCliente(data.historial);              
            }
            if (func != undefined && typeof func == "function") func();
        })
        .fail(function (jqXHR) {
            console.log('ERROR');
            console.log(jqXHR.reponseText);
        })
        .always(function () {
            Call_Progress(false);
        })
}

function fn_CargarHistorialCliente(historial) {
    $('#tb_historial_cliente').html('');
    if (historial.length > 0) {
        var tr;
        historial.forEach(function(e, i) {
            console.log(e);
            tr = $('<tr>');
            tr.append("<td>"+(i+1)+"</td>");
            tr.append("<td><a href='#' class='link-venta' data-venta='"+e.ventaId+"' ><u>"+e.codigo+"</u></td>");       
            tr.append("<td>"+e.fecha+"</td>");
            tr.append("<td>"+e.tienda+"</td>");
            tr.append("<td>"+e.operacion+"</td>");
            // tr.append("<td>"+e.estado+"</td>");
            tr.append("<td>"+e.totalVenta+"</td>");
            tr.append("<td>"+e.totalSaldo+"</td>");
            $('#tb_historial_cliente').append(tr);
        })
    }
}

function fn_LimpiarCliente() {
    $('#customerId_Add').val('0');
    $('#fotoCliente_Preview').attr('src', '/assets/img/img.svg');
    $('#form-customer-add-full')[0].reset();
}

function fn_CargaClientes() {
    $.ajax({
        method: 'POST',
        url: '/cliente/listarItems'
    })
        .done(function (data) {
            $('#customers-items').html(data);
        })
        .fail(function (xhr) {
            console.log('ERROR');
        })
        .always(function () {
            Call_Progress(false);
        })
}
var validateCustomerFull = $('#form-customer-add-full').validate({
    rules: {
        tipoDocumento_Add: 'required',
        nroDocumento_Add: {
            required: true,
            maxlength: 15
        },
        nombres_Add: 'required',
        apellidos_Add: 'required',
        // direccion_Add: 'required',
        email_Add: 'email'
    },
    messages: {
        tipoDocumento_Add: 'El tipo documento es obligatorio',
        nroDocumento_Add: {
            required: 'El DNI el obligatorio',
            maxlength: "El N° Documento debe tener como máximo de 15 caracteres",
            length: 'El DNI debe tener 8 dígitos'
            // function() {
            // 	if(('#tipoDocumento').val() == "1")
            // 		return 'El DNI debe tener 8 dígitos';
            // 	else 
            // 		return 'El N° de documento es inválido'	
            // }
        },
        nombres_Add: 'Los Nombres son obligatorios',
        apellidos_Add: 'Los Apellidos son obligatorios',
        // direccion_Add: 'La Dirección es obligatorio',
        email_Add: 'Email no válido'
    }
});