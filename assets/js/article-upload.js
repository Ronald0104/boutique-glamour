$(function () {

    $('#fileUpload').fileinput({
        uploadUrl: '/inventario/upload_ajax',
        uploadAsync: true,
        showPreview: false,
        allowedFileExtensions: ['xls', 'xlsx'],
        elErrorContainer: '#kv-error'
    })
        .on('filepreupload', function () {
            fecha = new Date();
            fechaSrc = fecha.getHours() + ':' + fecha.getMinutes() + ':' + fecha.getSeconds();
            $('#duracion').text('Inicio: ' + fechaSrc);
            fn_CalcularTiempo();
        })
        .on('filebatchpreupload', function (event, data, id, index) {
            $('#kv-success').html('<h4>Upload Status</h4><ul></ul>').hide();
        })
        .on('fileuploaded', function (evt, data, id, index) {
            clearInterval(time);
            // console.log(evt);
            // console.log(data.response);
            // console.log(id);
            // console.log(index);
            // $('#data-excel').html("<pre>" + JSON.stringify(data.response.data) + "</pre>");

            var fname = data.files[index].name,
                out = '<li>' + 'Uploaded file # ' + (index + 1) + ' - ' + fname + ' successfully.' + '</li>';
            $('#kv-success ul').append(out);
            $('#kv-success').fadeIn('slow');

            fn_CargarDataExcel(data.response['data']);
        })
    $('#btnUpload').click(function (evt) {
        evt.preventDefault();
        fn_ProcesarDatos();
        // Iniciar funcion recursiva
    })
})

function fn_ProcesarDatos() {
    // Tamano de pagina 1;
    // Total registro
    // Pagina actual

    var totalRows = $('#tbCargaMasiva>tbody>tr').length;
    var pageCurrent = 1;
    var pageSize = 5;
    var pageTotal = Math.ceil(totalRows / pageSize);

    console.log('iniciando proceso');
    console.log(pageTotal);
    console.log(totalRows);

    fn_Procesar(pageCurrent, async function callback(page) {
        var data = [];
        var art = {};
        var ini = ((page - 1) * pageSize);
        console.log(ini);
        for (let i = ini; i < ini + pageSize; i++) {
            art = {};
            art.idx = i;
            art.code = $('#tbCargaMasiva>tbody>tr').eq(i).find('td').eq(2).text();
            art.article = $('#tbCargaMasiva>tbody>tr').eq(i).data('article');
            data.push(art);
        }
        // console.log(data);
        // Realizar peticion ajax y mostrar el resultado actualizar la barra de progreso
        var req = await $.ajax({
            method : 'POST',
            url: '/inventario/articuloActualizar',
            data: {articulos: JSON.stringify(data)}
        }).then(function(d) {
            // console.log(d);
            d = JSON.parse(d);
            console.log(d);
        })

        data.forEach(function (el, i) {            
            $('#tbCargaMasiva>tbody>tr').eq(el.idx).removeClass('text-green-800').addClass('font-weight-bold text-blue-800');
            $('#tbCargaMasiva>tbody>tr').eq(el.idx).find('td:eq(1)').text('PROCESADO');
        });

        if (++page <= pageTotal) {
            fn_Procesar(page, callback);
        } else {
            // alert('Proceso completado');
            swal('Proceso Completado', '', 'info');
        }
    })

    // while (pageCurrent <= pageTotal) {
    //     fn_Procesar(pageCurrent, pageSize).then( data => {
    //         console.log('ok');
    //         console.log(data);
    //         // data.forEach(function (e, i) {
    //         //     $('tbCargaMasiva>tbody>tr').eq(i).find('td:eq(1)').text('PROCESADO');
    //         // })
    //     });
    //     pageCurrent++;
    // }
}
async function fn_Procesar(pageCurrent, callback) { // pageSize, params = [], 
    setTimeout(function () {
        callback(pageCurrent);
    }, 500)
    // var data = [];
    // await new Promise(resolve => setTimeout(() => {        
    //     var ini = (pageCurrent - 1) * pageSize
    //     for (let i = ini; i < pageSize; i++) {
    //         data.push($('#tbCargaMasiva>tbody>tr').eq(i).data('article'));
    //     }
    //     console.log(pageCurrent);
    //     resolve;
    // }, 500));
    // return data;
    // Realizar peticion ajax para actualizar los registros    
}


// async function wait() {
//     await new Promise(resolve => setTimeout(resolve, 1000));

//     return 10;
// }

// function f() {
//     // shows 10 after 1 second
//     wait().then(result => alert(result));
// }

// f();

function fn_CargarDataExcel(data) {
    if (data.length > 0) {
        // console.log(data);
        // var data = data.response;
        var tr;
        $('#tbCargaMasiva>tbody').html('');
        data.forEach(element => {
            //Hacer la carga dinamicamente
            // console.log(element);
            element.forEach((article, i) => {
                tr = $('<tr>').attr('tabindex', 0).css('opacity', 1).data('article', article).addClass('text-green-800');
                tr.append($('<td>').text(i + 1));
                tr.append($('<td>').text('PENDIENTE')); //font-weight-bold 
                tr.append($('<td>').text(article.Codigo));
                tr.append($('<td>').text(article.Nombre));
                tr.append($('<td>').text(article.Categoria).data('categoriaCodido', article.CategoriaCodigo));
                tr.append($('<td>').text(article.Marca));
                tr.append($('<td>').text(article.Talla));
                tr.append($('<td>').text(article.Color));
                tr.append($('<td>').text(article.Tela));
                tr.append($('<td>').text(article.Diseno));
                tr.append($('<td>').text(article.Caracteristicas));
                tr.append($('<td>').text(article.Tipo));
                tr.append($('<td>').text(article.Estado));
                tr.append($('<td>').text(article.Tienda));
                tr.append($('<td>').text(article.FechaCompra));
                tr.append($('<td>').text(article.PrecioCompra));
                tr.append($('<td>').text(article.PrecioAlquiler));
                tr.append($('<td>').text(article.PrecioVenta));
                $('#tbCargaMasiva>tbody').append(tr);
                tr.fadeIn(500);
            });
        });
    }
}

var inicio;
var time;
function fn_CalcularTiempo() {
    var i = 0;
    time = setInterval(function () {
        $('#tiempo').text(i++);
    }, 1000)
}