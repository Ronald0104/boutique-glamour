$(function() {
    $('#fechaDesde').datepicker({ 
        dateFormat: 'dd/mm/yy', minDate: '-2M', maxDate: '+12M', 
        showButtonPanel: true, showOtherMonths: true, selectOtherMonths: true
    });
    $('#fechaHasta').datepicker({
        dateFormat: 'dd/mm/yy', minDate: '-2M', maxDate: '+12M',
        showButtonPanel: true, showOtherMonths: true, selectOtherMonths: true
    });
    
    $('#categoria').select2({minimumResultsForSearch: Infinity});
    $('#talla').select2({minimumResultsForSearch: Infinity});
    $('#color').select2({minimumResultsForSearch: Infinity});
    $('#diseno').select2({minimumResultsForSearch: Infinity});
    $('#condicion').select2({minimumResultsForSearch: Infinity});

    $('#categoria').change(function() {
        let categoriaId = $(this).val();
        fn_ListarTallasxCategoria(categoriaId);
        fn_ListarColoresxCategoria(categoriaId);
        fn_ListarDisenosxCategoria(categoriaId);
    })

    $('#btn-mostrar-reporte').click(function(evt) {
        evt.preventDefault();
        fn_ReportePrendas();    
    })

    $('#btn-exportar-reporte').click(function() {
        // console.log('Exportar Excel');
        if (!exportTable) return;
        // exportTable.getExportData()[''];

        var tableId = 'rptPrendas';
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
        fn_ReportePrendas();
    })

    fn_ReportePrendas();
})

function fn_ListarTallasxCategoria(categoriaId) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarTallasxCategoria',
        data: { categoriaId : categoriaId},
        // dataType: "json",
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#talla').html('');
        let tallas = JSON.parse(data); 
        $('#talla').select2("destroy");               
        $('#talla').append("<option value='0'>TODOS</option>");
        if (tallas.length > 0) {        
            tallas.forEach((e) => $('#talla').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))            
        };   
        $('#talla').select2(); 
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}

function fn_ListarColoresxCategoria(categoriaId) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarColoresxCategoria',
        data: { categoriaId : categoriaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#color').html('');
        let colores = JSON.parse(data);
        $('#color').select2("destroy");
        $('#color').append("<option value='0'>TODOS</option>");        
        if (colores.length > 0) {
            colores.forEach((e) => $('#color').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))           
        };  
        $('#color').select2();
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}

function fn_ListarDisenosxCategoria(categoriaId) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarDisenosxCategoria',
        data: { categoriaId : categoriaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        $('#diseno').html('');
        let disenos = JSON.parse(data);  
        $('#diseno').select2("destroy");
        $('#diseno').append("<option value='0'>TODOS</option>");         
        if (disenos.length > 0) {
            disenos.forEach((e) => $('#diseno').append("<option value='"+e.id+"'>"+e.nombre+"</option>"))
        }; 
        $('#diseno').select2();
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}

function fn_ReportePrendas(){
    let categoria = $('#categoria').val();
    let talla = $('#talla').val();
    let color = $('#color').val();
    let diseno = $('#diseno').val();
    let condicion = $('#condicion').val();
    let fechaDesde = $('#fechaDesde').val();
    let fechaHasta = $('#fechaHasta').val();

    // console.log(categoria);
    // console.log(talla);
    // console.log(color);
    // console.log(diseno);
    // console.log(fechaDesde);
    // console.log(fechaHasta);

    $.ajax({
        method: 'POST',
        url: '/reporte/reportePrendas_Content',
        data: {categoria: categoria, talla: talla, color: color, diseno: diseno, condicion: condicion, fechaDesde: fechaDesde, fechaHasta: fechaHasta},
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
    exportTable = $("#rptPrendas").tableExport({
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