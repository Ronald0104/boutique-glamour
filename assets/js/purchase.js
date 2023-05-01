$(function () {
    // 
    $('#fechaDesde').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-6M',
        maxDate: '+7D',
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $('#fechaHasta').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-6M',
        maxDate: '+2D',
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $('#LC_tipoGasto').select2({ minimumResultsForSearch: Infinity })
    $('#LC_tienda').select2({ minimumResultsForSearch: Infinity })    

    // console.log('módulo de compras');
    fn_ListarCompras();

    $('#btn-purchase-search').click(function(evt) {        
        evt.preventDefault();        
        tbl_compras.ajax.reload(null, false);
    })

    $('#btn-purchase-register-show').click(function (evt) {
        evt.preventDefault();
        fn_ObtenerModalRegistraCompra(function () {
            // Agregar distribucion de compras    
            let tbl = $('#tbl-compras-distribucion>tbody');
            tbl.html('');
            $('#tiendaCompra>option').each((i, e) => fn_AgregarDistribucionTienda($(e).val(), $(e).text()));            

            // fn_InicializaModal();
            fn_LimpiarModalCompra();
            fn_ObtenerCorrelativoCompra(function (correlativo) {
                $('#codigoCompra').val(correlativo);
                // console.log('mostrar modal');
                $('#modal-purchase-add').modal({ show: true });
            });

        });
    })

    $(document).on('click', '.btn-purchase-edit-show', function() {        
        // Obtener la compra por su ID
        var compraId = $(this).data('purchase');
        fn_ObtenerCompra(compraId, function(data) {
            var compra = JSON.parse(data);            
            
            fn_ObtenerModalRegistraCompra(function () { 
                // fn_InicializaModal();
                fn_CargarCompra(compra);
                $('#modal-purchase-add').modal({ show: true });
            });
        });
    })

    $(document).on('click', '.btn-purchase-delete', function() {
        var compraId = $(this).data('purchase');

        swal({
            title: "¿Anular Compra?",
            text: "Esta seguro de anular la compra " + compraId,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                console.log('anulando compra');
                return $.ajax({
                    method: 'POST',
                    url: '/compras/anularCompra',
                    data: { compraId: compraId }
                });
            }
        })
        .then((result) => {
            console.log(result);
            if (result) {
                // console.log('El registro ha sido anulado');
                swal('','El registro ha sido anulado', 'info');
                tbl_compras.ajax.reload(null, false);
            } else {
                swal('', 'Ocurrio un error al anular el registro', 'error');
            }
        });
    })

    $(document).on('dblclick', '#tbl_purchases>tbody>tr', function(evt) {
        var compraId = $(this).closest('tr').data('purchase');
        fn_ObtenerCompra(compraId, function(data) {
            var compra = JSON.parse(data);            
            fn_ObtenerModalRegistraCompra(function () { 
                fn_LimpiarModalCompra();
                fn_CargarCompra(compra);
                $('#modal-purchase-add').modal({ show: true });
            });
        });
    })

})


// Listar compras
var tbl_compras;
function fn_ListarCompras() {
    tbl_compras = $('#tbl_purchases').DataTable({
        language: language_espanol,
        order: [[1, 'desc']],
        pageLength: 25,
        ajax: {
            method: 'POST',
            url: '/compras/listarCompras',
            data: function(d) {
                d.tipoGasto = $('#LC_tipoGasto').val();
                d.tienda = $('#LC_tienda').val();
                d.fechaDesde = $('#fechaDesde').val();
                d.fechaHasta = $('#fechaHasta').val();
            }
        },
        columns: [
            { data: 'compraId', render: function(data) {
                var str = "<div class='center'>";
                str += "<button class='btn btn-dark btn-icon btn-purchase-edit-show' data-purchase='" + data +"'>";
                str += "<i class='icon icon-clipboard6'></i>";
                str += "</button>";
                str += "&nbsp;"
                str += "<button class='btn btn-danger btn-icon btn-purchase-delete' data-purchase='" + data +"'>";
                str += "<i class='icon icon-bin'></i>";
                str += "</button>";
                str += "</div>"
                return str;
            }},
            {data: 'codigo'},
            {data: 'tienda'},
            {data: 'fechaCompra'},
            {data: 'proveedor'},
            {data: 'descripcion'},
            {data: 'tipoGasto'},
            {data: 'importeTienda'}
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) { return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; };
            // Total over all pages
            total = api.column(7).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // Total over this page
            // pageTotal = api.column(8, { page: 'current' }).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);

            // Update footer
            $(api.column(7).footer()).html('<h5><b>S/' + Number(total).toFixed(2) + '</b></h5>');
        },
        createdRow: function(row, data, dataIndex, cells) {    
            $(row).attr('tabindex', 0).data('purchase', data.compraId);
        }
    })
}

function fn_ObtenerCorrelativoCompra(Success) {
    $.ajax({
        method: 'POST',
        url: '/compras/obtenerCorrelativoCompra'
    }).done(function (data) {
        console.log(data);
        if (Success != undefined && typeof Success == "function") Success(data);
    })
        .fail(function (jqXHR) {
            console.log(jqXHR.responseText);            
        })
        .always()
} 

function fn_GenerarCompra() {
    // Obtener datos de la compra
    // let fechaCompra = fn_GetDate($('#fechaRegistroCompra').val());
    // fechaCompra = new Date(fechaCompra.getTime() - (fechaCompra.getTimezoneOffset() * 60000)).toISOString();
    // console.log(fechaCompra);
    var objCompra = new Object();
    objCompra.id = Number($('#compraId').val());
    objCompra.codigo = $('#codigoCompra').val();
    objCompra.fechaCompra = fn_GetDateLocal($('#fechaRegistroCompra').val()).toISOString();
    objCompra.tipoGasto = $('#tipoGasto').val();
    objCompra.estadoCompra = $('#estadoCompra').val();
    objCompra.proveedor = $('#proveedor').val();
    objCompra.tipoComprobante = $('#tipoComprobante').val();
    objCompra.numeroComprobante = $('#numeroComprobante').val();
    objCompra.descripcionCompra = $('#descripcionCompra').val();
    objCompra.importeTotal = Number($('#importeTotal').val());
    objCompra.distribucionTienda = [];

    // Obtener la distribución por tienda
    $('#tbl-compras-distribucion>tbody>tr').each(function() {
        var distribucion = new Object();
        distribucion.compraId = objCompra.id;
        distribucion.tiendaId = $(this).data('tiendaId');
        distribucion.montoTienda = Number($(this).closest('tr').find('td:eq(1)').find('input').val());
        distribucion.porcentajeTienda = Number($(this).closest('tr').find('td:eq(2)').find('input').val());
        objCompra.distribucionTienda.push(distribucion);
    })    
    return objCompra;
}

function fn_RegistrarCompra(compra, success) {
    $.ajax({
        method: 'POST', 
        url: '/compras/registrarCompra',
        data: { compra: compra}
    })
    .done(function(data) {
        if(success != undefined && typeof success == "function") success(data);
    })
    .fail(function(jqXHR) {
        console.log(jqXHR.responseText);
    })
}

function fn_ActualizarCompra(compra, success) {
    $.ajax({
        method: 'POST', 
        url: '/compras/actualizarCompra',
        data: { compra: compra}
    })
    .done(function(data) {
        if(success != undefined && typeof success == "function") success(data);
    })
    .fail(function(jqXHR) {
        console.log(jqXHR.responseText);
    })
}

function fn_LimpiarModalCompra() {
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

function fn_ObtenerCompra(compraId, success) {
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

function fn_CargarCompra(compra) {
    $('#compraId').val(compra.compraId);
    $('#codigoCompra').val(compra.codigo);
    $('#fechaRegistroCompra').val(compra.fechaCompra);
    $('#proveedor').val(compra.proveedor);
    $('#tipoGasto').val(compra.tipoGastoId).trigger('change');
    $('#tipoComprobante').val(compra.tipoDocumentoId).trigger('change');
    $('#numeroComprobante').val(compra.numeroDocumento);
    $('#descripcionCompra').val(compra.descripcion);
    $('#importeTotal').val(compra.importeTotal);

    // cargar distribución de tiendas
    var tbl_dist = $('#tbl-compras-distribucion>tbody');
    // tbl_dist.html("");

    // console.log(compra);
    let tbl = $('#tbl-compras-distribucion>tbody');
    var tr;
    tbl.html('');
    compra.distribucion.forEach(function(e, i) {  
        fn_AgregarDistribucionTienda(e.tiendaId, e.tienda, e.monto, e.porcentaje);
        // tbl_dist.find('tr').data('tienda-id', e.tiendaId);
        // tbl_dist.find('tr').eq(i).find('td').eq(0).find('strong').text(e.tienda.toUpperCase());
        // tbl_dist.find('tr').eq(i).find('td').eq(1).find('input').val(e.monto).data('value-old', e.monto);
        // tbl_dist.find('tr').eq(i).find('td').eq(2).find('input').val(e.porcentaje);

        // tr = $('<tr>');
        // tr.append($("<td>").html("<strong class='text-brown-800'>"+e.tienda.toUpperCase()+"</strong>"));
        // tr.append($("<td>").html("<input type='text' class='form-control text-number' data-value-old='0' />"));
        // tr.append($("<td>").html("<input type='text' class='form-control' readonly />"));
        // tbl_dist.append(tr);                                                                           
    });
}
