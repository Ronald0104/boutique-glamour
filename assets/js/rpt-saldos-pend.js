$(function() {
    $('#fechaDesde').datepicker({
        dateFormat: 'dd/mm/yy',
        // minDate: '-2M',
        maxDate: '+12M',
        showButtonPanel: true,
		showOtherMonths: true,
		selectOtherMonths: true
    });
    $('#fechaHasta').datepicker({
        dateFormat: 'dd/mm/yy',
        // minDate: '-2M',
        maxDate: '+12M',
        showButtonPanel: true,
		showOtherMonths: true,
		selectOtherMonths: true
    });    
    $('#tienda').select2({minimumResultsForSearch: Infinity});

    $('#btn-mostrar-reporte').click(function(evt) {
        evt.preventDefault();
        fn_ReporteSaldosPendientes();    
    })

    $('#buscador').keyup(function() {
        var $that = $(this).val().trim().toUpperCase();       
        $('#rptSaldosPendientes>tbody>tr').each(function(i, e) {
            var documento = $(e).find('td:eq(1)').text().toUpperCase();
            var nombres = $(e).find('td:eq(2)').text().toUpperCase();
            if (documento.indexOf($that)>-1 || nombres.indexOf($that)>-1) {
                $(e).show();
            }else {
                $(e).hide();
            }
        })
    })

    $('#btn-exportar-reporte').click(function() {
        console.log('Exportar Excel');
        if (!exportTable) return;
        // exportTable.getExportData()[''];

        var tableId = 'rptPendienteDevolucion';
        var XLS = exportTable.CONSTANTS.FORMAT.XLSX;
        console.log(XLS);

        var exportData = exportTable.getExportData()[tableId][XLS];
        console.log(exportData);
        console.log(exportData.data);
        exportTable.export2file(
            exportData.data,
            exportData.mimeType,
            exportData.filename,
            exportData.fileExtension
        );
    })
    $(document).on('click', '.link-cliente', function (evt) {
        evt.preventDefault();
        let clienteId = $(this).data('cliente');
        let nroDocumento = $(this).data('cliente-nro');
        fn_MostrarCliente(clienteId, nroDocumento);
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

    fn_ReporteSaldosPendientes();
})

function fn_ReporteSaldosPendientes() {
    let tienda = $('#tienda').val();
    let fechaDesde = $('#fechaDesde').val();
    let fechaHasta = $('#fechaHasta').val();

    $.ajax({
        method: 'POST',
        url: '/reporte/reporteSaldosPendientes_Content',
        data: {tienda: tienda, fechaDesde: fechaDesde, fechaHasta : fechaHasta},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#tbl_reporte').html('');
        $('#tbl_reporte').html(data);
        fn_ExportTable();
        fn_ContextMenu();
    })
    .fail(function(jqXHR, textStatus){
        console.log(jqXHR.responseText);
    })
    .always(function() {
        Call_Progress(false)
    })
}

var exportTable;
function fn_ExportTable() {
    exportTable = $("#rptPendienteDevolucion").tableExport({
        formats: ["xlsx","txt"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
        position: 'bottom',  // Posicion que se muestran los botones puedes ser: (top, bottom)
        bootstrap: true,//Usar lo estilos de css de bootstrap para los botones (true, false)
        fileName: "ReportePendientesDevolucion",    //Nombre del archivo 
        exportButtons: false    
    });
    
}

function fn_ContextMenu() {
    $('#rptSaldosPendientes>tbody>tr').find('td').contextMenu({
        menuSelector: "#contextMenuReporte",
        menuSelected: function (invokedOn, selectedMenu) { fn_MostrarMenu(invokedOn, selectedMenu) },
        menuDisabled: []
    });
}

function fn_MostrarMenu (invokedOn, selectedMenu) {
    var TipoDoc, SerieDoc, NumDoc;
    var FacturaId;
    var clienteId, nroDocumento;
    switch (selectedMenu.attr('id')) {
        case "mnIrAOperacion":            
            let ventaId = $(invokedOn).closest('tr').find('td').eq(3).find('a').data('venta');
            Call_Progress(true)
            setTimeout(function () {
                Call_Progress(true);
                window.open('/ventas/editar/' + ventaId, '_blank');
                Call_Progress(false);
            }, 1000)
            break;
        case "mnVerCliente":
            let clienteId = $(invokedOn).closest('tr').find('td').eq(1).find('a').data('cliente');
            let nroDocumento = $(invokedOn).closest('tr').find('td').eq(1).find('a').data('cliente-nro');
            fn_MostrarCliente(clienteId, nroDocumento);
            break;
        case "mnDevolver":
            // TipoDoc = $(invokedOn).closest('tr').find('td').eq(2).data('tipo');      
            // FacturaId = $(invokedOn).closest('tr').find('td').eq(2).data('idFactura'); 
            // fn_ImprimirComprobante(FacturaId, TipoDoc);

            fn_MostrarDevolucion();
            break;
        default:
    }
    // console.log(invokedOn[0]);
    // console.log(selectedMenu[0]);
    // var msg = "You selected the menu item '" + selectedMenu.text() + "' on the value '" + invokedOn.text() + "'";
    // console.log(msg);
}

function fn_MostrarCliente(clienteId, nroDocumento) {
    fn_ObtenerModalRegistrarCliente(function () {
        fn_LimpiarCliente();
        $('#customerId_Add').val(clienteId);
        $('#nroDocumento_Add').val(nroDocumento);
        $('#nroDocumento_Add').data('valueOld', nroDocumento);
        fn_ObtenerCliente(() => $('#modal-register-customer').modal('show'));
    })
}

function fn_MostrarDevolucion() {
    fn_ObtenerModalVentaDevolucion(function() {
        $('#modal-atender-devolucion').modal('show')
    });
}