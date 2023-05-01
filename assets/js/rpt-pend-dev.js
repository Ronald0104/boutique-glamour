$(function() {
    $('#tienda').select2({minimumResultsForSearch: Infinity})
    $('#diasVencidos').select2({minimumResultsForSearch: Infinity})

    $('#btn-mostrar-reporte').click(function(evt) {
        evt.preventDefault();
        fn_ReportePendienteDevolucion();    
    })

    // $('#soloVencidos').change(function() { 
    //     fn_ReportePendienteDevolucion(); 
    // })

    $('#buscador').keyup(function() {
        var $that = $(this).val().trim().toUpperCase();       
        $('#rptPendienteDevolucion>tbody>tr').each(function(i, e) {
            var documento = $(e).find('td:eq(1)').text().toUpperCase();
            var nombres = $(e).find('td:eq(2)').text().toUpperCase();
            var operacion = $(e).find('td:eq(4)').text().toUpperCase();
            if (documento.indexOf($that)>-1 || nombres.indexOf($that)>-1 || operacion.indexOf($that)>-1) {
                $(e).show();
            }else {
                $(e).hide();
            }
        })
    })

    // $.contextMenu({
    //     selector: '#rptPendienteDevolucion>tbody>tr',
    //     callback: function (key, options) {
    //         var m = "clicked: " + key;
    //         // window.console && console.log(m) || alert(m);
    //         // console.log(options);
    //         var el = $(this)[0];
    //         var ventaId = Number($(el).find('td').eq(0).text());
            
    //         if (key == "delete") {
    //             fn_anularVenta(ventaId);
    //         }
    //     },
    //     items: {
    //         "return": { name: "Devolver", icon: "edit"},
    //         "show": { name: "Ver Operación", icon: "show" },
    //         // "cut": { name: "Cut", icon: "cut" },
    //         // copy: { name: "Copy", icon: "copy" },
    //         // "paste": { name: "Paste", icon: "paste" },
    //         // "delete": { name: "Delete", icon: "delete" },
    //         // "sep1": "---------",
    //         // "quit": {
    //         //     name: "Quit", icon: function () {
    //         //         return 'context-menu-icon context-menu-icon-quit';
    //         //     }
    //         // }
    //     }
    // });

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
        // fn_ObtenerModalRegistrarCliente(function () {
        //     fn_LimpiarCliente();
        //     $('#customerId_Add').val(clienteId);
        //     $('#nroDocumento_Add').val(nroDocumento);
        //     $('#nroDocumento_Add').data('valueOld', nroDocumento);
        //     fn_ObtenerCliente(() => $('#modal-register-customer').modal('show'));
        // })
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

    fn_ReportePendienteDevolucion();
})

function fn_ReportePendienteDevolucion() {
    let tienda = $('#tienda').val();
    let diasVencidos = $('#diasVencidos').val();

    $.ajax({
        method: 'POST',
        url: '/reporte/reportePendienteDevolucion_Content',
        data: {tienda: tienda, diasVencidos: diasVencidos},
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
    $('#rptPendienteDevolucion>tbody>tr').find('td').contextMenu({
        menuSelector: "#contextMenuReporte",
        menuSelected: function (invokedOn, selectedMenu) { fn_MostrarMenu(invokedOn, selectedMenu) },
        menuDisabled: []
    });
}

function fn_MostrarMenu (invokedOn, selectedMenu) {
    var TipoDoc, SerieDoc, NumDoc;
    var ventaId;
    var clienteId, nroDocumento;
    switch (selectedMenu.attr('id')) {
        case "mnIrAOperacion":            
            ventaId = $(invokedOn).closest('tr').find('td').eq(4).find('a').data('venta');
            Call_Progress(true)
            setTimeout(function () {
                Call_Progress(true);
                window.open('/ventas/editar/' + ventaId, '_blank');
                Call_Progress(false);
            }, 1000)
            break;
        case "mnVerCliente":
            clienteId = $(invokedOn).closest('tr').find('td').eq(1).find('a').data('cliente');
            nroDocumento = $(invokedOn).closest('tr').find('td').eq(1).find('a').data('cliente-nro');
            fn_MostrarCliente(clienteId, nroDocumento);
            break;
        case "mnDevolver":
            // TipoDoc = $(invokedOn).closest('tr').find('td').eq(2).data('tipo');      
            // FacturaId = $(invokedOn).closest('tr').find('td').eq(2).data('idFactura'); 
            // fn_ImprimirComprobante(FacturaId, TipoDoc);
            nroDocumento = $(invokedOn).closest('tr').find('td').eq(1).find('a').data('cliente-nro');
            fn_MostrarDevolucion(nroDocumento);
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

function fn_MostrarDevolucion(nroDocumento) {
    fn_ObtenerModalVentaDevolucion(function() {
        fn_BuscarAlquiler(nroDocumento);
        $('#modal-atender-devolucion').modal('show')
    });
}