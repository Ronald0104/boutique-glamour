$(document).ready(function () {
    fn_ListarVentas();
    $.datepicker.formatDate('yy/mm/dd');

    $('#fechaDesde').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-3M',
        maxDate: '+7D'
    });
    $('#fechaHasta').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-3M',
        maxDate: '+2D'
    });

    $('#tienda').select2({ minimumResultsForSearch: Infinity })
    $('#estado').select2({ minimumResultsForSearch: Infinity })

    $(document).on('click', '.btn-sale-show', function (evt) {
        evt.preventDefault();
        let ventaId = $(this).data('venta');
        Call_Progress(true)
        setTimeout(function () {
            -
                Call_Progress(true);
            // window.location = "/ventas/editar/"+ventaId;
            window.open('/ventas/editar/' + ventaId, '_blank');
            Call_Progress(false);
        }, 1000)

    });
    $(document).on('click', '.btn-customer-show', function (evt) {
        evt.preventDefault();
        let clienteId = $(this).data('cliente');
		let nroDocumento = $(this).data('cliente-nro');
        //let nroDocumento = $(this).text();
        fn_ObtenerModalRegistrarCliente(function () {
            fn_LimpiarCliente();
            $('#customerId_Add').val(clienteId);
            $('#nroDocumento_Add').val(nroDocumento);
            $('#nroDocumento_Add').data('valueOld', nroDocumento);
            fn_ObtenerCliente(() => $('#modal-register-customer').modal('show'));
        })
    })
    $(document).on('click', '#btn-sale-search', function (evt) {
        evt.preventDefault();
        table.ajax.reload(null, false);
    })
    $(document).on('click', '.btn-sale-delete', function (evt) {
        evt.preventDefault();
        let ventaId = $(this).data('venta');
        swal({
            title: "¿Anular Venta?",
            text: "Esta seguro de anular la venta " + ventaId,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    //   swal("Poof! Your imaginary file has been deleted!", {
                    //     icon: "success",
                    //   });
                    console.log('anulando venta');
                    return $.ajax({
                        method: 'POST',
                        url: '/ventas/anular_venta',
                        data: { ventaId: ventaId }
                    });
                }
            })
            .then((result) => {
                console.log(result);
                if (result) {
                    console.log('El registro ha sido anulado');
                    swal('La venta ha sido anulada');
                    table.ajax.reload(null, false);
                }

            });

        //   swal({
        //     text: 'Search for a movie. e.g. "La La Land".',
        //     content: "input",
        //     button: {
        //       text: "Search!",
        //       closeModal: false,
        //     },
        //   })
        //   .then(name => {
        //     if (!name) throw null;

        //     return fetch(`https://itunes.apple.com/search?term=${name}&entity=movie`);
        //   })
        //   .then(results => {
        //     return results.json();
        //   })


        console.log(ventaId);
        // Call_Progress(true)
        // setTimeout(function() {-
        //     Call_Progress(true);
        //     // window.location = "/ventas/editar/"+ventaId;
        //     window.open('/ventas/editar/'+ventaId, '_blank');
        //     Call_Progress(false);
        // }, 1000)

    });
    
    /*
		let dni = $(this).closest('tr').find('td').eq(1).text();  
		let estado = Number($(this).closest('tr').find('td').eq(3).data('estado'));

        fn_BuscarVentaById(ventaId, function(d) {
            if(d.estadoId == 1){
                fn_LimpiarAtenderReserva()
                // fn_BuscarReserva(dni);
                fn_MostrarReserva(d);		
                $('#modal-atender-reserva').modal('show');
            }else if (d.estadoId == 2){
                fn_LimpiarAtenderAlquiler();
                // fn_BuscarAlquiler(dni);	
                fn_MostrarAlquiler(d);	
                $('#modal-atender-alquiler').modal('show');
            } 
        });   
    */
})

var table;
var fn_ListarVentas = function () {
    table = $('#tbl_sales').DataTable({
        language: language_espanol,
        pageLength: 50,
        ajax: {
            method: "POST",
            url: "/ventas/listarJson",
            data: function (d) {
                d.fechaDesde = $('#fechaDesde').val(); 
                d.fechaHasta = $('#fechaHasta').val(); 
                d.tienda = $('#tienda').val();
                d.estado = $('#estado').val();
            }
            //$('#frmSaleSearch').serializeFormJSON()
        },
        columns: [
            {
                data: "ventaId", render: function (data, type, row) {
                    return $('<div>').append($('<a>').attr('href', '#').addClass('btn btn-link btn-sale-show').attr('data-venta', data).append(zfill(data, 6))).html();
                }
            },
            //{
            //    data: "clienteDNI", render: function (data, type, row) {
            //        return $('<div>').append($('<a>').attr('href', '#').addClass('btn btn-link btn-customer-show').attr('data-cliente', row.clienteId).append(data)).html();
            //    }
            //},
            { 
				data: "cliente", render: function (data, type, row) {
					return $('<div>').append($('<a>').attr('href', '#').addClass('btn btn-link btn-customer-show').attr('data-cliente', row.clienteId).attr('data-cliente-nro', row.clienteDNI).append(data)).html();
				}, width: "30%;" 
			},
            { data: "estado" },
            { data: "fechaRegistro", render: function (data, type, row) { var fecha = reviver('', data); return fecha.format() } },
            { data: "fechaSalidaProgramada", render: function (data) { var fecha = reviver('', data); return fecha.format() } },
            { data: "fechaDevolucionProgramada", render: function (data) { var fecha = reviver('', data); return fecha.format() } },
            { data: "precioTotal" },
            { data: "totalPagadoAnterior" },
            { data: "totalPagado" },
            { data: "totalSaldo" },
            {
                data: "ventaId", render: function (data) {
                    var str = "<div class='center' style='min-width:76px'>";
                    str += "<button type='button' class='btn btn-blue btn-icon btn-sale-show' data-toggle='modal' data-target='#' data-venta=" + data + "><i class='icon icon-checkbox-checked2'></i></button>";
                    if (usuario.rol_id) {
                        str += "&nbsp;"
                        str += "<button type='button' class='btn btn-dark btn-icon btn-sale-delete' data-toggle='modal' data-target='#' data-venta=" + data + "><i class='icon icon-trash'></i></button>";
                    }
                    str += "</div>";
                    return str;
                }
            }
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) { return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; };
            // Total over all pages
            total = api.column(6).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // A Cuenta Anterior
            cuentaAnterior = api.column(7).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // A Cuenta
            cuenta = api.column(8).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // Saldo
            saldo = api.column(9).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // Total over this page
            pageTotal = api.column(6, { page: 'current' }).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // Update footer
            $(api.column(6).footer()).html('<h5><b>S/' + Number(total).toFixed(2) + '</b></h5>');
            $(api.column(7).footer()).html('<h5><b>S/' + Number(cuentaAnterior).toFixed(2) + '</b></h5>');
            $(api.column(8).footer()).html('<h5><b>S/' + Number(cuenta).toFixed(2) + '</b></h5>');
            $(api.column(9).footer()).html('<h5><b>S/' + Number(saldo).toFixed(2) + '</b></h5>');
        },
        createdRow: function (row, data, dataIndex, cells) {
            $(row).attr('tabindex', 0);
            switch (data.estadoId) {
                case "1": $(row).css('background-color', 'rgb(14, 236, 83)'); break;
                case "2":
                    var fechaDevolucion = new Date(data.fechaDevolucionProgramada);
                    var fechaActual = new Date();
                    if (fechaActual.getTime() > fechaDevolucion.getTime())
                        $(row).css('background-color', 'rgb(220, 89, 0)');
                    else
                        $(row).css('background-color', 'rgb(228, 154, 20)');
                    break;
                case "3": $(row).css('background-color', 'rgb(210, 135, 84)'); break; //rgb(122, 209, 243)
                case "4": $(row).css('background-color', 'rgb(72, 167, 204)'); break;
                default: break;
            }
        }
    });
}

var language_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}