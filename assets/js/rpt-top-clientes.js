$(function() {
    $('#fechaDesde').datepicker({ 
        dateFormat: 'dd/mm/yy', minDate: '-6M', maxDate: '+12M', 
        showButtonPanel: true, showOtherMonths: true, selectOtherMonths: true
    });
    $('#fechaHasta').datepicker({
        dateFormat: 'dd/mm/yy', minDate: '-6M', maxDate: '+12M',
        showButtonPanel: true, showOtherMonths: true, selectOtherMonths: true
    });
    
    $('#cantidadMostrar').select2({minimumResultsForSearch: Infinity});

    $('#btn-mostrar-reporte').click(function(evt) {
        evt.preventDefault();
        fn_ReporteTopClientes();    
    })

    $('#btn-exportar-reporte').click(function() {
        // console.log('Exportar Excel');
        if (!exportTable) return;
        // exportTable.getExportData()[''];

        var tableId = 'rptTopClientes';
        var XLS = exportTable.CONSTANTS.FORMAT.XLSX;
        console.log(XLS);

        var exportData = exportTable.getExportData()[tableId][XLS];
        // console.log(exportData);
        // console.log(exportData.data);
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
        fn_ObtenerModalRegistrarCliente(function () {
            fn_LimpiarCliente();
            $('#customerId_Add').val(clienteId);
            $('#nroDocumento_Add').val(nroDocumento);
            $('#nroDocumento_Add').data('valueOld', nroDocumento);
            fn_ObtenerCliente(() => $('#modal-register-customer').modal('show'));
        })
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

    $('#mostrarDetallado').change(function() {
        fn_ReporteTopClientes();
    })

    fn_ReporteTopClientes();
})

function fn_ReporteTopClientes() {
    let cantidadMostrar = $('#cantidadMostrar').val();
    let fechaDesde = $('#fechaDesde').val();
    let fechaHasta = $('#fechaHasta').val();

    $.ajax({
        method: 'POST',
        url: '/reporte/reporteTopClientes_Content',
        data: {cantidadMostrar: cantidadMostrar, fechaDesde: fechaDesde, fechaHasta: fechaHasta},
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
    exportTable = $("#rptTopClientes").tableExport({
        formats: ["xlsx","txt"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
        position: 'bottom',  // Posicion que se muestran los botones puedes ser: (top, bottom)
        bootstrap: true,//Usar lo estilos de css de bootstrap para los botones (true, false)
        fileName: "ReportePendientesDevolucion",    //Nombre del archivo 
        exportButtons: false    
    });
    
}

function fn_ContextMenu() {
    $('#rptTopClientes>tbody>tr').find('td').contextMenu({
        menuSelector: "#contextMenuReporte",
        menuSelected: function (invokedOn, selectedMenu) { fn_MostrarMenu(invokedOn, selectedMenu) },
        menuDisabled: []
    });
}