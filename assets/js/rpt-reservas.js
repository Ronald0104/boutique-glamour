$(function() {
    $('#fechaDesde').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-2M',
        maxDate: '+12M',
        showButtonPanel: true,
		showOtherMonths: true,
		selectOtherMonths: true
    });
    $('#fechaHasta').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-2M',
        maxDate: '+12M',
        showButtonPanel: true,
		showOtherMonths: true,
		selectOtherMonths: true
    });
    
    $('#tienda').select2({minimumResultsForSearch: Infinity})
    // $('#diasFaltantes').select2({minimumResultsForSearch: Infinity})

    $('#btn-mostrar-reporte').click(function(evt) {
        evt.preventDefault();
        fn_ReporteReservas();    
    })

    $('#btn-exportar-reporte').click(function() {
        console.log('Exportar Excel');
        if (!exportTable) return;
        // exportTable.getExportData()[''];

        var tableId = 'rptReservas';
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
        var mostrar = Number($(this).prop('checked'));       
        if (mostrar) {
            $('#rptReservas>thead>tr>th').eq(8).css('visibility', 'visible');
            $('#rptReservas>thead>tr>th').eq(9).css('visibility', 'visible');
        } else {
            $('#rptReservas>thead>tr>th').eq(8).css('visibility', 'hidden');
            $('#rptReservas>thead>tr>th').eq(9).css('visibility', 'hidden');
        }
        fn_ReporteReservas();
    })

    fn_ReporteReservas();
})

function fn_ReporteReservas() {
    let tienda = $('#tienda').val();
    let fechaDesde = $('#fechaDesde').val();
    let fechaHasta = $('#fechaHasta').val();
    let diasFaltantes = $('#diasFaltantes').val();
    let mostrarDetallado = Number($('#mostrarDetallado').prop('checked'));

    $.ajax({
        method: 'POST',
        url: '/reporte/reporteReservas_Content',
        data: {tienda: tienda, fechaDesde: fechaDesde, fechaHasta : fechaHasta, diasFaltantes: diasFaltantes, mostrarDetallado: mostrarDetallado},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#tbl_reporte').html('');
        $('#tbl_reporte').html(data);
        fn_ExportTable();
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
    exportTable = $("#rptReservas").tableExport({
        formats: ["xlsx","txt"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
        position: 'bottom',  // Posicion que se muestran los botones puedes ser: (top, bottom)
        bootstrap: true,//Usar lo estilos de css de bootstrap para los botones (true, false)
        fileName: "ReporteReservas",    //Nombre del archivo 
        exportButtons: false    
    });
    
}
