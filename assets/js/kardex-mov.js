$(function(){

    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $.datepicker.formatDate("dd-mm-yy", new Date(2018, 11, 1));

    $('#fecha').datepicker({
        altField: "#actualDate",
        gotoCurrent: true,
        altFormat : 'dd/mm/yy'
    });   

    $("#fecha").datepicker( "option", "altField", "#actualDate" );

    // Seleccionar la fecha y el codigo por defecto y la tienda

    // Generar el correlativo del articulo
    $('#categoria_simple').on('change', obtenerCodigoArticulo);
    function obtenerCodigoArticulo(){
        console.log('articulo');
        console.log($(this).val());
        var categoriaId = $(this).val();        
        var request = $.ajax({
            'type' : 'POST',
            'url' : '/inventario/obtenerCorrelativo',
            'data' : {categoriaId: categoriaId}
        })
        .done(function(data){
            console.log(data);
            $("#code_simple").val(data.trim());
            // addAEvent();
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
        });
    }

    $('#tipo').on('change', obtenerCorrelativoKardex);

    function obtenerCorrelativoKardex() {
        $.ajax({
            'type' : 'POST',
            'url' :  '/inventario/obtenerCorrelativoKardex'
        })
        .done(function(data){
            console.log(data);
            $('#code').val(data);
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            // console.log('completado');
        });
    }

    // Seleccionamos el tipo
    $('#tipo').val(tipo);

    $.validator.setDefaults({
        submitHandler: function (){
            alert( "submitted!");
        }
    });

    // reglas formularios
    $('#form-kardex-add').validate({
        rules: {
            tipo: "required",
            code: "required",
            fecha: "required",
            tienda : "required"
        },
        messages: {
            nombre: "Por favor, seleccione el tipo de operación",
            code: "Por favor, ingrese el código",
            fecha: "Por favor, seleccione una fecha",
            nombre: "Por favor, seleccione la tienda",
        },
        highlight: function (element, errorClass, validClass){
            $(element).parents(".col-sm-9").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-9").addClass("has-success").removeClass("has-error");
        }
    });

    $('#panel-article-add').css('display', 'none');
    $('#btn-show-article-add-simple').on('click', function(){
        var display = $('#panel-article-add').css('display');
        console.log(display);
        if (display == "none") {
            $('#panel-article-add').css('display', 'block');
            $('#btn-show-article-add-simple i').removeClass('glyphicon-chevron-up');
            $('#btn-show-article-add-simple i').addClass('glyphicon-chevron-down');
        }else {
            $('#panel-article-add').css('display', 'none');
            $('#btn-show-article-add-simple i').removeClass('glyphicon-chevron-down');
            $('#btn-show-article-add-simple i').addClass('glyphicon-chevron-up');
        }
    });


    // reglas formularios agregar articulo simple
    $('#form-article-add-simple').validate({
        rules: {
            categoria_simple: "required",
            code_simple: "required",
            nombre_simple: "required"
        },
        messages: {
            categoria_simple: "Por favor, seleccione la categoria",
            code_simple: "Por favor, ingrese el código",
            nombre_simple: "Por favor, ingrese el nombre"
        },
        highlight: function (element, errorClass, validClass){
            $(element).parents(".col-sm-9").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".col-sm-9").addClass("has-success").removeClass("has-error");
        }
    });

    // Registrar articulo simple
    $('#btn-article-add-simple').on('click', agregarArticuloSimple);
    function agregarArticuloSimple() {
        event.preventDefault();
        var article = $('#form-article-add-simple').serializeFormJSON();
        console.log(article);

        // Validar el formulario antes de enviarlo formulario
        if(!$('#form-article-add-simple').valid()){
            $('#form-article-add-simple #nombre_simple').focus();
            return 0;
        }
        console.log("validado");
        var request = $.ajax({
            'type' : 'POST',
            'url' : '/inventario/article_add_simple',
            'data' : article  // { nombre : nombre, descripcion : descripcion, foto : foto}
        })
        .done(function(data){
            console.log(data);
            var data =JSON.parse(data);
            if(data.code == 0){
                mostrarError($('#form-article-add-simple-error'), data.message);
            }else {
                limpiarFormulario($('#form-article-add-simple'));   
                // $('#foto_preview').attr('src', '/assets/img/default_256.png'); 
                $('#form-article-add-simple').find(".form-group .col-sm-8").removeClass('has-success');
                // $('#modal-article-add').modal('hide')
                // listarArticulos();
                alert('artículo registrado correctamente');
            }
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            console.log('completado');
        }); 
    }

    // Agregar artículo a la tabla
    $('#btn-kardex-add-item').on('click', agregarItemKardex);
    function agregarItemKardex() {
        console.log($('#codeArticulo').val());
        var articuloCode = $('#codeArticulo').val();
        // Obtenemos los datos del articulo y lo agregamos en la tabla
        $.ajax({
            'type': 'POST',
            'url' : '/inventario/articuloByCode',
            'data': {articuloCode: articuloCode}
        })
        .done(function(data){
            console.log(JSON.parse(data));
            var item = JSON.parse(data)[0];
            agregarItemKardexTable(item);
            addAEvent();
        })
        .fail(function( jqXHR, textStatus ) {
            alert("Error : " + textStatus );
        })
        .always(function(){
            // console.log('completado');
        });
    }

    function agregarItemKardexTable(item){
        console.log(item);
        var body = $('#detalle-kardex');
        var n = $('#detalle-kardex tr').length;
        var tr, td, input, btn;
        
        tr = $('<tr>');
        // <input type="number" class="form-control kdx_cantidad" style="width: 120px"></td>

        tr.append($('<td>').text(n+1)).data('articulo', item.articuloId);
        tr.append($('<td>').text(item.code));
        tr.append($('<td>').text(item.nombre));
        input = $("<input type='number'>").addClass('form-control txt-cantidad').css('width', '120px').val(1);
        tr.append($('<td>').append(input)); // cantidad
        input = $("<input type='number'>").addClass('form-control txt-costo').css('width', '120px').val(50);
        tr.append($('<td>').append(input)); // costo
        input = $("<input type='number'>").addClass('form-control txt-total').css('width', '120px').val(50).attr('readonly', true);
        tr.append($('<td>').append(input)); // importe
        btn = $('<button>').addClass('btn btn-success btn-xs btn-kardex-item-details').html('<i class="glyphicon glyphicon-th-list">');
        tr.append($('<td>').append(btn)); 
        btn = $('<button>').addClass('btn btn-danger btn-xs btn-kardex-item-delete').html('<i class="glyphicon glyphicon-remove">');
        tr.append($('<td>').append(btn)); 
        tr.append($('<td>').text("")); 
        body.append(tr);
    }

    function editarSeries() {
        console.log($(this).parent().parent().data('articulo'));
        var articuloId = $(this).parent().parent().data('articulo'); 
    }

    function recalcularTotales() {
        console.log('recalcular');
        var item = $(this).parent().parent();
        var cantidad = item.find('td input.txt-cantidad').val();
        var costo = item.find('td input.txt-costo').val();
        item.find('td input.txt-total').val(cantidad * costo);
    }

    $('#totalGeneral').css('font-size', '20px');
    $('#col-total').css('padding-right', '0');
    $('#col-total').css('padding-left', '0');
    function addAEvent(){
        $('.btn-kardex-item-details').unbind();
        $('.btn-kardex-item-details').on('click', editarSeries);    
        $('.btn-kardex-item-delete').unbind();
        $('.btn-kardex-item-delete').on('click', editarSeries);    
        $('.txt-cantidad').unbind();
        $('.txt-cantidad').on('change', recalcularTotales);    
        $('.txt-costo').unbind();
        $('.txt-costo').on('change', recalcularTotales);    
    }
})