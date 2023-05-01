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
    $('#categoria').select2({minimumResultsForSearch: Infinity});
    $('#talla').select2();
    $('#color').select2();
    $('#diseno').select2();

    $('#categoria').change(function() {
        // Call_Progress(true);
        // tbl_articulos.ajax.reload(function() {Call_Progress(false);}, false);
        let categoriaId = $(this).val();

        App.Comun.fn_ListarTallasxCategoria2(categoriaId, function(data) {
            $('#talla').html('');
            let tallas = JSON.parse(data); 
            $('#talla').select2("destroy");               
            $('#talla').append("<option value='0'>TODOS</option>");
            if (tallas.length > 0) {        
                tallas.forEach((e) => $('#talla').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))            
            };   
            $('#talla').select2(); 
        });
        App.Comun.fn_ListarColoresxCategoria2(categoriaId, function(data) {
            $('#color').html('');
            let colores = JSON.parse(data); 
            $('#color').select2("destroy");               
            $('#color').append("<option value='0'>TODOS</option>");
            if (colores.length > 0) {        
                colores.forEach((e) => $('#color').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))            
            };   
            $('#color').select2(); 
        });
        App.Comun.fn_ListarDisenosxCategoria2(categoriaId, function(data) {
            $('#diseno').html('');
            let disenos = JSON.parse(data); 
            $('#diseno').select2("destroy");               
            $('#diseno').append("<option value='0'>TODOS</option>");
            if (disenos.length > 0) {        
                disenos.forEach((e) => $('#diseno').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))            
            };   
            $('#diseno').select2(); 
        });        
    })

    $('#btn-mostrar-reporte').click(function(evt) {
        evt.preventDefault();
        fn_ReporteTopProductos();    
    })

    $('#btn-exportar-reporte').click(function() {
        if (!exportTable) return;
        // exportTable.getExportData()[''];

        var tableId = 'rptTopProductos';
        var XLS = exportTable.CONSTANTS.FORMAT.XLSX;
        // console.log(XLS);

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
    $(document).on('click', '.link-producto', function (evt) {
        evt.preventDefault();
        let articuloId = $(this).data('producto');
        fn_ObtenerModalRegistrarArticulo(function() {
            fn_ObtenerArticuloById(articuloId, function(data) {
                App.Producto.EsEdit = true;
                fn_LimpiarArticuloFull();
                fn_MostrarArticulo(data);
            })
        });
    });    

    $('#mostrarDetallado').change(function() {
        fn_ReporteTopProductos();
    })

    fn_ReporteTopProductos();
})

function fn_ReporteTopProductos() {
    let cantidadMostrar = $('#cantidadMostrar').val();
    let fechaDesde = $('#fechaDesde').val();
    let fechaHasta = $('#fechaHasta').val();
    let categoria = $('#categoria').val();
    let talla = $('#talla').val();
    let color = $('#color').val();
    let diseno = $('#diseno').val();

    $.ajax({
        method: 'POST',
        url: '/reporte/reporteTopProductos_Content',
        data: {cantidadMostrar: cantidadMostrar, fechaDesde: fechaDesde, fechaHasta: fechaHasta, categoria: categoria, talla: talla, color: color, diseno: diseno},
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
    exportTable = $("#rptTopProductos").tableExport({
        formats: ["xlsx","txt"], //Tipo de archivos a exportar ("xlsx","txt", "csv", "xls")
        position: 'bottom',  // Posicion que se muestran los botones puedes ser: (top, bottom)
        bootstrap: true,//Usar lo estilos de css de bootstrap para los botones (true, false)
        fileName: "ReporteTopProductos",    //Nombre del archivo 
        exportButtons: false    
    });
    
}

function fn_ContextMenu() {
    $('#rptTopProductos>tbody>tr').find('td').contextMenu({
        menuSelector: "#contextMenuReporte",
        menuSelected: function (invokedOn, selectedMenu) { fn_MostrarMenu(invokedOn, selectedMenu) },
        menuDisabled: []
    });
}