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

    $('#btn-mostrar-reporte').click(function(evt) {
        evt.preventDefault();
        fn_ReporteFlujoCaja();    
    })

    $('#btn-exportar-reporte').click(function() {
        console.log('Exportar Excel');
        if (!exportTable) return;
        // exportTable.getExportData()[''];

        var tableId = 'rptFlujoCaja';
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
   
    $(document).on('click', '.link-operacion', function (evt) {
        evt.preventDefault();
        let tipo = $(this).data('tipo');
        let operacionId = $(this).data('operacion');        

        if(tipo == "INGRESO") {
            Call_Progress(true);
            setTimeout(function () {
                Call_Progress(true);
                window.open('/ventas/editar/' + operacionId, '_blank');
                Call_Progress(false);
            }, 1000)
        } else {
            fn_ObtenerModalRegistraCompra(function () {
                App.Compra.fn_LimpiarModalCompra();
                App.Compra.fn_ObtenerCompra(operacionId, function(data){                    
                    let compra = JSON.parse(data);    
                    App.Compra.fn_CargarCompra(compra);
                    $('#modal-purchase-add').modal({ show: true });
                })    
            });
        }      
    });

    fn_ReporteFlujoCaja();
})

function fn_ReporteFlujoCaja() {
    let tienda = $('#tienda').val();
    let fechaDesde = $('#fechaDesde').val();
    let fechaHasta = $('#fechaHasta').val();
    let mostrarSaldoInicial = Number($('#mostrarSaldoInicial').prop('checked'));

    $.ajax({
        method: 'POST',
        url: '/reporte/reporteFlujoCaja_Content',
        data: {tienda: tienda, fechaDesde: fechaDesde, fechaHasta : fechaHasta, mostrarSaldoInicial : mostrarSaldoInicial },
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        // console.log(data);
        $('#tbl_reporte').html('');
        $('#tbl_reporte').html(data);
        fn_CalcularSaldoFinal();
        fn_ExportTable();
    })
    .fail(function(jqXHR, textStatus){
        console.log(jqXHR.responseText);
    })
    .always(function() {
        Call_Progress(false)
    })
}

function fn_CalcularSaldoFinal() {
    var saldoInicial = 0;
    var saldoPeriodo = 0;
    var saldoFinal = 0;
    var monto = 0;
    $('#tbl_reporte>tr').each(function(i, e) {          
        if (i == 0)
            if ($(e).find('td:eq(2)').text()=="SALDO INICIAL")
                saldoInicial = Number($(e).find('td').eq(6).text().replaceAll(',',''));            
            else 
                saldoInicial = 0;
        monto = $(e).find('td').eq(5).text().replaceAll(',','');
        saldoPeriodo += Number(monto);
    });
    saldoFinal = saldoInicial + saldoPeriodo;
    // var s = new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(saldoFinal)
    $('#saldoPeriodo').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(saldoPeriodo));
    $('#saldoFinal').text(new Intl.NumberFormat("es-PE", {style: "currency", currency: "PEN"}).format(saldoFinal));
}

var exportTable;
function fn_ExportTable() {
    exportTable = $("#rptFlujoCaja").tableExport({
        formats: ["xlsx","txt"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
        position: 'bottom',  // Posicion que se muestran los botones puedes ser: (top, bottom)
        bootstrap: true,//Usar lo estilos de css de bootstrap para los botones (true, false)
        fileName: "ReporteFlujoCaja",    //Nombre del archivo 
        exportButtons: false    
    });
    
}

//reporteFlujoCaja_Content