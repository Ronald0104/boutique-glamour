App.Compra.Estado = 1; // 1: NUEVO, 2: EDITAR
App.Compra = (function() {


    var fn_LimpiarModalCompra = function() {
        $('#form-purchase-add')[0].reset();
        valCompra.resetForm();
    
        var fecha = moment();
        $('#compraId').val('0');
        $('#fechaRegistroCompra').val(fecha.format('DD/MM/YYYY'));
        $('#tipoGasto').trigger('change');
        $('#tipoComprobante').trigger('change');
    
        // Limpiar distribucion
    
        // Obtener el siguiente correlativo
    }

    var fn_Prueba = function() {
        console.log('Prueba registro de compra');
    }

    return {
        fn_LimpiarModalCompra : fn_LimpiarModalCompra,
        fn_Prueba : fn_Prueba
    }
})();

App.Compra.fn_Prueba2 = function() {
    console.log('prueba de registro de compras 2');
}

App.Compra.fn_ObtenerCompra = function(compraId, success) {
    $.ajax({
        method: 'POST',
        url: '/compras/obtenerCompraById',
        data: {compraId : compraId}
    })
    .done(function(data) {
        if (success != undefined && typeof success == "function") success(data);
    })
    .fail(function(jqXHR) {
        console.log(jqXHR.responseText);
    })
    .always(function() {})
}

App.Compra.fn_CargarCompra = function(oCompra) {
    $('#compraId').val(oCompra.compraId);
    $('#codigoCompra').val(oCompra.codigo);
    $('#fechaRegistroCompra').val(oCompra.fechaCompra);
    $('#proveedor').val(oCompra.proveedor);
    $('#tipoGasto').val(oCompra.tipoGastoId).trigger('change');
    $('#tipoComprobante').val(oCompra.tipoDocumentoId).trigger('change');
    $('#numeroComprobante').val(oCompra.numeroDocumento);
    $('#descripcionCompra').val(oCompra.descripcion);
    $('#importeTotal').val(oCompra.importeTotal);

    // cargar distribución de tiendas
    let tbl_dist = $('#tbl-compras-distribucion>tbody');
    let tbl = $('#tbl-compras-distribucion>tbody');
    let tr;
    tbl.html('');
    oCompra.distribucion.forEach(function(e, i) {  
        fn_AgregarDistribucionTienda(e.tiendaId, e.tienda, e.monto, e.porcentaje);                                                                     
    });
}

var valCompra;
// function fn_InicializaModal() {
// }

$(function() {
    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $.datepicker.formatDate('yy/mm/dd');

    $('#fechaRegistroCompra').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-2M',
        maxDate: '+1D',
        showButtonPanel: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        // changeMonth: true,
        defaultDate: +1
    });
    $('#tipoGasto').select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $('#modal-purchase-add')
    });
    $('#tipoComprobante').select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $('#modal-purchase-add')
    });
    $('#tiendaCompra').select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $('#modal-purchase-add')
    });
    $('#proveedor').on('keypress', function(evt) {
        var that = this;
        setTimeout(() => {
            that.value = that.value.toUpperCase();
        }, 40);
    })
    $('#numeroComprobante').on('keypress', function() {
        var that = this;
        setTimeout(() => {
            that.value = that.value.toUpperCase();
        }, 40);
    })
    $('#descripcionCompra').on('keypress', function() {
        var that = this;
        setTimeout(() => {
            that.value = that.value.toUpperCase();
        }, 40);
    })
    $('#importeTotal').on('keypress', function(evt) {
        var keyCode = (evt.keyCode) ? evt.keyCode : evt.whicth;
        if ($(this).val().indexOf('.') > -1) {
            if (!/^[0-9]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        } else {
            if (!/^[0-9.]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        }
    })
    $('input.text-number').on('keypress', function(evt) {
        //$(document).on('keypress', 'input.text-number', function(evt){
        var keyCode = (evt.keyCode) ? evt.keyCode : evt.whicth;
        if ($(this).val().indexOf('.') > -1) {
            if (!/^[0-9]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        } else {
            if (!/^[0-9.]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        }
    })
    $('#importeTotal').change(function() {
        // Distribuir los montos entre las tiendas
        var compraId = Number($('#compraId').val());
        if (compraId == 0){
            var importeTotal = Number($(this).val());
            var importeTienda = 0;
            var cantidad = $('#tbl-compras-distribucion>tbody>tr').length;
            importeTienda = importeTotal / cantidad;
            $('#tbl-compras-distribucion>tbody>tr').each(function() {
                $(this).closest('tr').find('td').eq(1).find('input').val(importeTienda);
                $(this).closest('tr').find('td').eq(1).find('input').trigger('change');
            })
        }        
    })
    $(document).on('change', '#tbl-compras-distribucion input.text-number', function() {
        var importeTotal = Number($('#importeTotal').val());
        var valueOld = Number($(this).data('value-old'));
        var valueNew = Number($(this).val());
        // Validar que la suma de las distribuciones no superen el total de la compra
        if (Number($(this).val()) > importeTotal) {
            swal('', 'El monto de distribución no puede superar el importe total', 'warning');
            $(this).val(valueOld);
        } else {
            $(this).data('value-old', valueNew);
            // Calcular el porcentaje
            var porcentaje = (valueNew / importeTotal) * 100;
            $(this).closest('tr').find('td:eq(2)').find('input').val(porcentaje);
        }
    })
    $('#btn-purchase-add').click(function() {
        var isValid = $('#form-purchase-add').valid();
        if (!isValid) {
            swal('', 'No ha completado los datos de la compra.', 'warning');
            return;
        }
        // console.log('Registrar gastos');

        // Validar distribución los totales no pueden superar el importe total de la compra
        var importeTotal = Number($('#importeTotal').val());
        var importeDistribucion = 0;
        $('#tbl-compras-distribucion>tbody>tr').each(function() {
            // console.log(Number($(this).find('td').eq(1).find('input').val()));
            importeDistribucion += Number($(this).find('td').eq(1).find('input').val());
        })
        // console.log(importeDistribucion);

        // los importe de distribucion no puede ser mayor al importe total
        if (importeDistribucion > importeTotal) {
            swal('', 'El importe de distribución no puede ser mayor al importe total', 'warning');
            return false;
        }
        if (importeTotal > importeDistribucion) {
            swal('', 'El importe de distribución debe ser igual al importe total', 'warning');
            return false;
        }

        var compra = fn_GenerarCompra();
        // console.log(compra);
        // return;
        if (compra.id == 0) {
            fn_RegistrarCompra(compra, function(data) {
                var compra = JSON.parse(data);
                // console.log(compra);
                if (compra) {
                    swal('', 'Compra registrada correctamente', 'info');
                    if (document.location.pathname.toLowerCase() == "/compras/") 
                        tbl_compras.ajax.reload(null, false);
                    fn_LimpiarModalCompra();
                    fn_ObtenerCorrelativoCompra(function(correlativo) {
                        $('#codigoCompra').val(correlativo);
                    });
                } else {
                    swal('', 'Ocurrio un error al registrar la compra', 'error');
                }
            });
        }
        else {
            fn_ActualizarCompra(compra, function(data) {
                var compra = JSON.parse(data);
                console.log(compra);
                if (compra) {
                    swal('', 'Compra actualizada correctamente', 'info');
                    if (document.location.pathname.toLowerCase() == "/compras/") tbl_compras
                        .ajax.reload(null, false);
                    fn_LimpiarModalCompra();
                    fn_ObtenerCorrelativoCompra(function(correlativo) {
                        $('#codigoCompra').val(correlativo);
                    });
                } else {
                    swal('', 'Ocurrio un error al registrar la compra', 'error');
                }
            });
        }


    })
    $('#btn-purchase-new').click(function() {
        fn_LimpiarModalCompra();
        fn_ObtenerCorrelativoCompra(function(correlativo) {
            $('#codigoCompra').val(correlativo);
        })
    })
    $('#btn-compra-tienda-agregar').click(function(evt){
        evt.preventDefault();
        // Verificar que no este agregado
        let tbl = $('#tbl-compras-distribucion>tbody');
        let exists = false;
        tbl.find('tr').each((i, e) => { if ($(e).data('tienda-id') == $('#tiendaCompra').val()) exists = true; });
        if (exists) { 
            swal('', 'La tienda ya ha sido agregada', 'warning');
            return false; 
        }    
        fn_AgregarDistribucionTienda($('#tiendaCompra').val(), $('#tiendaCompra>option:selected').text());
    });
    $(document).on('click', '.btn-compra-tienda-quitar', function(evt) {
        evt.preventDefault();
        $(this).closest('tr').remove();
    })

  

})

valCompra = $('#form-purchase-add').validate({
        ignore: [],
        submitHandler: function() {
            console.log('formulario de compra validado');
        },
        rules: {
            codigoCompra: 'required',
            fechaRegistroCompra: 'required',
            tipoGasto: 'required',
            proveedor: 'required',
            tipoComprobante: 'required',
            numeroComprobante: 'required',
            descripcionCompra: 'required',
            importeTotal: {
                required: true,
                number: true
            }
        },
        messages: {
            codigoCompra: 'El código de compra es obligatorio',
            fechaRegistroCompra: 'La fecha de registro de compra el obligatorio',
            tipoGasto: 'El tipo de gasto es obligatorio',
            proveedor: 'El proveedor el obligatorio',
            tipoComprobante: 'El tipo de comprobante es obligatorio',
            numeroComprobante: 'El número de comprobante es obligatorio',
            descripcionCompra: 'La descripción de la compra es obligatorio',
            importeTotal: {
                required: 'El importe total de la compra es obligatorio',
                number: 'El importe de compra es númerico'
            }
        }
    })

function fn_AgregarDistribucionTienda(id, nombre, monto = 0, porcentaje = 0) {
    let tbl = $('#tbl-compras-distribucion>tbody');
    tr = $('<tr>').prop('tabindex', 0).data('tienda-id',id);
    tr.append($('<td>').append("<strong>"+nombre.toUpperCase()+"</strong>"));
    tr.append($('<td>').append("<input type='text' class='form-control text-number' value='"+monto+"' data-value-old='"+monto+"' />"));
    tr.append($('<td>').append("<input type='text' class='form-control' readonly value='"+porcentaje+"' />"));
    tr.append($('<td>').append("<button class='btn btn-danger btn-compra-tienda-quitar'><i class='fa fa-trash'></i></button>"));
    tbl.append(tr);
}