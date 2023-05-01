$(document).ready(function () {
    fn_ListarVentas();
    $.datepicker.formatDate('yy/mm/dd');

    $('#fechaDesde').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-3M',
        maxDate: '+7D',
        showOtherMonths: true,
        selectOtherMonths: true
    });
    $('#fechaHasta').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-3M',
        maxDate: '+2D',
        showOtherMonths: true,
        selectOtherMonths: true
    });

    $('#tienda').select2({ minimumResultsForSearch: Infinity })
    $('#estado').select2({ minimumResultsForSearch: Infinity })

    // if (usuario.rol_id != 1) {
    //     $('#tienda').prop('disabled', true);
    // }
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
        //let nroDocumento = $(this).text();
        let nroDocumento = $(this).data('cliente-nro');
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
    //fn_ListarVentas_Json();

    $(function () {
        $.contextMenu({
            selector: '#tbl_sales>tbody>tr',
            callback: function (key, options) {
                var m = "clicked: " + key;
                // window.console && console.log(m) || alert(m);
                // console.log(options);
                var el = $(this)[0];
                var ventaId = Number($(el).find('td').eq(0).text());
                
                if (key == "delete") {
                    fn_anularVenta(ventaId);
                }
            },
            items: {
                "delete": { name: "Anular", icon: "delete"}
                // "edit": { name: "Edit", icon: "edit" },
                // "cut": { name: "Cut", icon: "cut" },
                // copy: { name: "Copy", icon: "copy" },
                // "paste": { name: "Paste", icon: "paste" },
                // "delete": { name: "Delete", icon: "delete" },
                // "sep1": "---------",
                // "quit": {
                //     name: "Quit", icon: function () {
                //         return 'context-menu-icon context-menu-icon-quit';
                //     }
                // }
            }
        });

        // $('.context-menu-one').on('click', function (e) {
        //     console.log(this);
        //     if (this) {

        //     }
        //     console.log('clicked', this);
        // })
    });
})

function fn_ListarVentas_Json() {
    $.ajax({
        method: "POST",
        url: "/ventas/listarJson",
        data: { fechaDesde: '01/06/2019', fechaHasta: '10/07/2019', tienda: 2, estado: 2 }
    })
        .done(function (data) {
            console.log(data);
        })
        .fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
        })
}

var table;
var fn_ListarVentas = function () {
    table = $('#tbl_sales').DataTable({
        language: language_espanol,
        order: [[3, "asc"], [0, "asc"]],
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
            // {
            //     data: "ventaId", render: function (data) {
            //         var size = 40;
            //         if (usuario.rol_id == 1) size = 76;
            //         var str = "<div class='center' style='min-width:" + size + "px'>";
            //         str += "<button type='button' class='btn btn-blue btn-icon btn-sale-show' data-toggle='modal' data-target='#' data-venta=" + data + "><i class='icon icon-checkbox-checked2'></i></button>";
            //         if (usuario.rol_id == 1) {
            //             str += "&nbsp;"
            //             str += "<button type='button' class='btn btn-dark btn-icon btn-sale-delete' data-toggle='modal' data-target='#' data-venta=" + data + "><i class='icon icon-trash'></i></button>";
            //         }
            //         str += "</div>";
            //         return str;
            //     }
            // },
            {
                data: "ventaId", render: function (data, type, row) {
                    return $('<div>').append($('<a>').attr('href', '#').addClass('btn btn-link btn-sale-show').attr('data-venta', data).append(zfill(data, 6))).html();
                }
            },
            // {
            //     data: "clienteDNI", render: function (data, type, row) {
            //         return $('<div>').append($('<a>').attr('href', '#').addClass('btn btn-link btn-customer-show').attr('data-cliente', row.clienteId).append(data)).html();
            //     }
            // },
            {
                data: "cliente", render: function (data, type, row) {
                    return $('<div>').append($('<a>').attr('href', '#').addClass('btn btn-link btn-customer-show').attr('data-cliente', row.clienteId).attr('data-cliente-nro', row.clienteDNI).append(data)).html();
                }, width: "30%;"
            },
            // { data: "cliente", width: "30%;" },
            { data: "estado" },
            { data: "fechaRegistro", render: function (data, type, row) { var fecha = reviver('', data); return fecha.format() } },
            { data: "fechaSalidaProgramada", render: function (data) {                 
                if (data == null) {
                    return "";
                } else  {
                    var fecha = reviver('', data); 
                    return fecha.format() } 
                }                
            },
            // { data: "fechaDevolucionProgramada", render: function (data) { var fecha = reviver('', data); return fecha.format() } },
            { data: "precioTotal" },
            { data: "totalPagadoAnterior" },
            //{ data: "totalPagado" },
            { data: "totalEfectivo" },
            { data: "totalTarjeta" },
            { data: "totalSaldo" },
            { data: "totalGarantia" }
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) { return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0; };
            // Total over all pages
            total = api.column(5).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // Total over this page
            pageTotal = api.column(5, { page: 'current' }).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // A Cuenta Anterior
            cuentaAnterior = api.column(6).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // A Cuenta
            //cuenta = api.column(9).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            efectivo = api.column(7).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            tarjeta = api.column(8).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // Saldo
            saldo = api.column(9).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);
            // Garantia
            garantia = api.column(10).data().reduce(function (a, b) { return intVal(a) + intVal(b); }, 0);

            // Update footer
            $(api.column(5).footer()).html('<h5><b>S/' + Number(total).toFixed(2) + '</b></h5>');
            $(api.column(6).footer()).html('<h5><b>S/' + Number(cuentaAnterior).toFixed(2) + '</b></h5>');
            $(api.column(7).footer()).html('<h5><b>S/' + Number(efectivo).toFixed(2) + '</b></h5>');
            $(api.column(8).footer()).html('<h5><b>S/' + Number(tarjeta).toFixed(2) + '</b></h5>');
            $(api.column(9).footer()).html('<h5><b>S/' + Number(saldo).toFixed(2) + '</b></h5>');
            $(api.column(10).footer()).html('<h5><b>S/' + Number(garantia).toFixed(2) + '</b></h5>');
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

function fn_anularVenta(ventaId) {
    //let ventaId = $(this).data('venta');
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
}

