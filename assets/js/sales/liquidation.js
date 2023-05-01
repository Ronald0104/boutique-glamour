$(function() {
    $.datepicker.formatDate('yy/mm/dd');

    $('#liqFechaDesde').datepicker({
        dateFormat: 'dd/mm/yy',
        maxDate: '+1D',
        showOtherMonths: true,
        selectOtherMonths: true
    });
    
    $('#liqFechaHasta').datepicker({
        dateFormat: 'dd/mm/yy',
        maxDate: '+1D',
        showOtherMonths: true,
        selectOtherMonths: true
    });

    $('#liqBuscar').click(function(evt) {
        evt.preventDefault();
        
        consultarLiquidacionTotal(function(ventas, compras, anulados) {
            mostrarDetalleIngresos(ventas);            
            mostrarDetalleEgresos(compras);
            mostrarDetalleAnulados(anulados);
            mostrarResumenAsesor(ventas);
            calcularTotalesLiquidacion(ventas, compras);
        });
        // consultarLiquidacion(function(data) {
        //     mostrarDetalleIngresos(data);            
        //     mostrarResumenAsesor(data);
        //     calcularTotalesLiquidacion(data);
        // });
    });         

    $(document).on('click', '.btn-sale-show', function (evt) {
        evt.preventDefault();
        let ventaId = $(this).data('ventaId');
        Call_Progress(true)
        setTimeout(function () {            
            Call_Progress(true);
            window.open('/ventas/editar/' + Number(ventaId), '_blank');
            Call_Progress(false);
        }, 1000)
    });

    $(document).on('click', '.btn-customer-show', function (evt) {
        evt.preventDefault();
        let clienteId = $(this).data('clienteId');
        let clienteNro = $(this).data('clienteNro');
        fn_ObtenerModalRegistrarCliente(function () {
            fn_LimpiarCliente();
            $('#customerId_Add').val(clienteId);
            $('#nroDocumento_Add').val(clienteNro);
            $('#nroDocumento_Add').data('valueOld', clienteNro);
            fn_ObtenerCliente(() => $('#modal-register-customer').modal('show'));
        })
    })

    $('#liqBuscarDetalleIngresos').keyup(function() {        
        var $that = $(this).val().trim().toUpperCase();       
        $('#tbl-detalle-ingresos>tbody>tr').each(function(i, e) {
            var numero = $(e).find('td:eq(0)').text().toUpperCase();
            var cliente = $(e).find('td:eq(1)').text().toUpperCase();
            var asesor = $(e).find('td:eq(3)').text().toUpperCase();
            if (numero.indexOf($that)>-1 || cliente.indexOf($that)>-1 || asesor.indexOf($that)>-1) {
                $(e).show();
            }else {
                $(e).hide();
            }
        })
    })
});

var data_liq; 
var tb_resumen_asesor = [];

function consultarLiquidacionTotal(Success, Error) {
    let fechaDesde = $('#liqFechaDesde').val();
    let fechaHasta = $('#liqFechaHasta').val();
    let tiendaId = $('#liqTiendaId').val();
    $.when(
        $.ajax({
            method: 'POST',
            url: '/ventas/consultarDetalleLiquidacion',
            data: {fechaDesde:fechaDesde, fechaHasta:fechaHasta, tiendaId:tiendaId}
        }), 
        $.ajax({
            method: 'POST',
            url: '/compras/listarCompras',
            data: {fechaDesde:fechaDesde, fechaHasta:fechaHasta, tienda:tiendaId, tipoGasto:''}
        }),
        $.ajax({
            method: 'POST',
            url: '/ventas/listarAnulados',
            data: {fechaDesde:fechaDesde, fechaHasta:fechaHasta, tiendaId:tiendaId}
        })
    )
    .done(function(r1, r2, r3) {
        let ventas = JSON.parse(r1[0]);
        let compras = JSON.parse(r2[0]).data;
        let anulados = JSON.parse(r3[0]);        
        if (Success != undefined && typeof Success == "function") Success(ventas, compras, anulados);
    })
}

function consultarLiquidacion(Success, Error) {
    let fecha, tiendaId;
    fechaDesde = $('#liqFechaDesde').val();
    fechaHasta = $('#liqFechaHasta').val();
    tiendaId = $('#liqTiendaId').val();

    $.ajax({
        method: 'POST',
        url: '/ventas/consultarDetalleLiquidacion',
        data: {fechaDesde : fechaDesde, fechaHasta : fechaHasta, tiendaId : tiendaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        data_liq = data;
        if (Success != undefined && typeof Success == "function") Success(data);
    })
    .fail(function(jqXHR) {
        console.log('Error al cargar la liquidación');
        console.log(jqXHR.responseText);
    })
    .always(function() {
        Call_Progress(false)
    })
}

function mostrarDetalleIngresos(data) {
    if(data) {
        let detalle_ing;
        if (typeof data != "object" ) {
            detalle_ing = JSON.parse(data);
        } else {
            detalle_ing = data;
        }
        
        let tbl_ing = $('#tbl-detalle-ingresos>tbody');
        let tr, link; 
        tbl_ing.html('');

        detalle_ing.forEach(function(item) {
            tr = $('<tr>').prop('tabindex', 0).data('item', item);
            if (item.nroOperacion==""){
                link = $('<a>').attr('href', '#').addClass('btn btn-link btn-sale-show').attr('data-venta-id', item.ventaId).append(item.ventaId);                
            } else {
                link = $('<a>').attr('href', '#').addClass('btn btn-link btn-sale-show').attr('data-venta-id', item.ventaId).append(item.nroOperacion);  
            }
            tr.append($('<td>').append(link));
            link = $('<a>').attr('href', '#').addClass('btn btn-link btn-customer-show').attr('data-cliente-id', item.clienteId).attr('data-cliente-nro', item.clienteNro).append(item.cliente);
            tr.append($('<td>').append(link));
            tr.append($('<td>').text(item.fechaHora));
            tr.append($('<td>').text(item.usuario));
            tr.append($('<td>').text(Number(item.importeTotal)).addClass('text-right'));
            tr.append($('<td>').text(Number(item.efectivo)).addClass('text-right'));
            tr.append($('<td>').text(Number(item.tarjeta)).addClass('text-right'));
            tbl_ing.append(tr);
        })
    }
}

function mostrarDetalleEgresos(data) {
    if(data) {
        let detalle_egr;
        if (typeof data != "object" ) {
            detalle_egr = JSON.parse(data);
        } else {
            detalle_egr = data;
        }
        
        let tbl_egr = $('#tbl-detalle-egresos>tbody');
        let tr, link; 
        tbl_egr.html('');

        detalle_egr.forEach(function(item) {
            if (item.importeTienda>0) {
                tr = $('<tr>').prop('tabindex', 0).data('item', item);
  
                link = $('<a>').attr('href', '#').addClass('btn btn-link btn-purchase-show').attr('data-compra-id', item.compraId).append(item.codigo);  
                tr.append($('<td>').append(link));
                // link = $('<a>').attr('href', '#').addClass('btn btn-link btn-customer-show').attr('data-cliente-id', item.clienteId).attr('data-cliente-nro', item.clienteNro).append(item.cliente);
                // tr.append($('<td>').append(link));
                tr.append($('<td>').text(item.proveedor));
                tr.append($('<td>').text(item.fechaCompra));
                tr.append($('<td>').text(item.tipoGasto));
                tr.append($('<td>').text(item.descripcion));
                tr.append($('<td>').text(Number(item.importeTienda)).addClass('text-right'));
                tbl_egr.append(tr);
            }            
        })
    }
}

function mostrarDetalleAnulados(data) {
    if(data) {
        let det_anulados;
        det_anulados = (typeof data != "object") ? JSON.parse(data) : data;        
        // if (typeof det_anulados == "object") det_anulados = [det_anulados];
        let tbl_anulados = $('#tbl-detalle-anulados>tbody');
        let tr, link; 
        tbl_anulados.html('');

        det_anulados.forEach(function(item) {
            // console.log(item);
            tr = $('<tr>').prop('tabindex', 0).data('item', item);
            if (item.nroOperacion == "")
                link = $('<a>').attr('href', '#').addClass('btn btn-link btn-sale-show').attr('data-venta-id', item.ventaId).append(zfill(item.ventaId,6));  
            else
                link = $('<a>').attr('href', '#').addClass('btn btn-link btn-sale-show').attr('data-venta-id', item.ventaId).append(item.nroOperacion);  
            tr.append($('<td>').append(link));
            // link = $('<a>').attr('href', '#').addClass('btn btn-link btn-customer-show').attr('data-cliente-id', item.clienteId).attr('data-cliente-nro', item.clienteNro).append(item.cliente);
            // tr.append($('<td>').append(link));
            tr.append($('<td>').text(item.cliente).data('cliente-id', item.clienteId));
            tr.append($('<td>').text(item.fechaAnulacion));
            tr.append($('<td>').text(item.usuarioAnulacion));
            tr.append($('<td>').text(item.motivo));
            tr.append($('<td>').text(Number(item.importe)).addClass('text-right'));
            tbl_anulados.append(tr);         
        })
    }
}

function calcularResumenPorAsesor(data) {
    tb_resumen_asesor = [];
    if (data) {
        let resumen;
        if (typeof data != "object" ) {
            resumen = JSON.parse(data);
        } else {
            resumen = data;
        }

        let objRes = {};
        let i = 1;
        resumen.forEach((item) => {
            // Esta Vacio
            if (tb_resumen_asesor.length == 0) {
                objRes = {};
                objRes.usuarioId = item.usuarioId;
                objRes.usuario = item.usuario;
                objRes.cantidad = 1;
                objRes.efectivo = Number(item.efectivo);
                objRes.tarjeta = Number(item.tarjeta);
                tb_resumen_asesor.push(objRes);                
            } else {
                var idx = tb_resumen_asesor.findIndex(e => e.usuarioId == item.usuarioId);
                if(tb_resumen_asesor.findIndex(e => e.usuarioId == item.usuarioId) > -1){
                    objRes = tb_resumen_asesor.find(e => e.usuarioId == item.usuarioId);
                    objRes.cantidad += 1;
                    objRes.efectivo += Number(item.efectivo);
                    objRes.tarjeta += Number(item.tarjeta);                    
                } else {
                    objRes = {};
                    objRes.usuarioId = item.usuarioId;
                    objRes.usuario = item.usuario;
                    objRes.cantidad = 1;
                    objRes.efectivo = Number(item.efectivo);
                    objRes.tarjeta = Number(item.tarjeta);
                    tb_resumen_asesor.push(objRes);                    
                }
            }
            i++;
        });
        // console.log(tb_resumen_asesor);
        return tb_resumen_asesor;
    }
}

function mostrarResumenAsesor(data) {
    if (data) {
        let resumen = calcularResumenPorAsesor(data);
        // let resumen = JSON.parse(data);
        let tbl = $('#liq-resumen-usuario>tbody');
        let tbl_foot = $('#liq-resumen-usuario>tfoot>tr');
        let tr; 
        let cantTotal = 0, totalEfectivo = 0, totalTarjeta = 0, totalIngresos;
        tbl.html('');
        tbl_foot.html('');
        let totalItem;
        resumen.forEach(function(item) {
            tr = $('<tr>').prop('tabindex', 0).data('item', item);
            tr.append($('<td>').text(item.usuario));
            tr.append($('<td>').text(item.cantidad));
            tr.append($('<td>').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(item.efectivo)).addClass('text-right'));
            tr.append($('<td>').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(item.tarjeta)).addClass('text-right'));
            totalItem = Number(item.efectivo) + Number(item.tarjeta);
            tr.append($('<td>').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalItem)).addClass('text-right'));
            tr.append($('<td>').text(''));
            tbl.append(tr);

            cantTotal += Number(item.cantidad);
            totalEfectivo += Number(item.efectivo);
            totalTarjeta += Number(item.tarjeta);
        })
        totalIngresos = totalEfectivo + totalTarjeta;
        tbl_foot.append($('<th style="font-size:1.1rem">').text('TOTALES'));
        tbl_foot.append($('<th style="font-size:1rem">').text(cantTotal));
        tbl_foot.append($('<th style="font-size:1rem">').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalEfectivo)));
        tbl_foot.append($('<th style="font-size:1rem">').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalTarjeta)));
        tbl_foot.append($('<th style="font-size:1rem">').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalIngresos)));
        tbl_foot.append($('<th style="font-size:1rem">').text(''));
    }
}

function calcularTotalesLiquidacion(ventas, compras) {
    if(ventas){
        let resumen_ventas;
        resumen_ventas = (typeof ventas != "object") ? JSON.parse(ventas) : ventas;        
        let resumen_compras;
        resumen_compras = (typeof compras != "object") ? JSON.parse(compras) : compras;

        let totalIngresos=0;
        let totalEgresos=0;
        let totalEfectivo=0;
        let totalTarjeta=0;
        
        resumen_ventas.forEach(function(item) {
            totalEfectivo += Number(item.efectivo);
            totalTarjeta += Number(item.tarjeta);
        });
        totalIngresos = totalEfectivo+totalTarjeta;

        resumen_compras.forEach(function(item){
            totalEgresos += Number(item.importeTienda);
        });
        totalEfectivo = totalEfectivo-totalEgresos;

        $('#liqTotalIngresos').val(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalIngresos));
        $('#liqTotalTarjeta').val(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalTarjeta * -1));
        $('#liqTotalEgresos').val(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalEgresos * -1));
        $('#liqTotalEfectivo').val(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(totalEfectivo));      
    }
}
