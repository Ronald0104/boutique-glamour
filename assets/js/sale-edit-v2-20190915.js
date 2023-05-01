// Declaramos las variables globales
let sale = {};
let saleDetails = [];
let salePayments = [];
let customer = {};
let saleDetailsDelete = []; // items eliminados existentes

$('#fechaSalida').datepicker({
	dateFormat: 'dd/mm/yy',
	minDate: '-2M',
	maxDate: '+12M'
});
$('#fechaDevolucion').datepicker({
	dateFormat: 'dd/mm/yy',
	minDate: '-2M',
	maxDate: '+12M'
});
$('#estado').select2({minimumResultsForSearch: Infinity});
$('#tipoPago').select2({minimumResultsForSearch: Infinity});
$('#tienda').select2({ minimumResultsForSearch: Infinity });

$(function() {

    // Agregar articulos de forma rapida    
	$('#btn-add-article-full').on('click', function (evt) {
		evt.preventDefault();
		let codigo = $('#codigoArticulo').val().trim();
		if (codigo.length < 11) return;

		var pet = $.ajax({
			method: 'POST',
			url: '/inventario/articuloByCodeFull',
			data: { articuloCode: codigo },
			//content: 'application/json; charset=utf-8',
			dataType: 'json'
		})
		pet.done(function (data) {
			if (data) {
              
                let article = data.articulo;
                let articleReserves = data.articulo_reservas;
                console.log(articleReserves);

                // Quitar esta reserva
                let ventaId = Number($('#saleId').val());
                articleReserves.forEach(function(e, i) {
                    if (e.ventaId == ventaId)
                        articleReserves.splice(i, 1);
                })
                
                if(!article) {
					swal('', 'El código ingresado no existe', 'warning'); return;
				}

				// console.log(data);
				// Validar que no se encuentre agregado la prenda
				// let estadoId = data[0].estadoId;
                // let article = data[0];

                // Validar que el codigo no se haya agregado
				let salir = false;
				saleDetails.forEach(function (e, i) {
					if (e.codigo === codigo && codigo != "GEN00000001") {
						swal('', 'El codigo ya ha sido ingresado', 'warning'); salir = true; return;
					}
				})
				if (salir) return;

                // Validar segun la fecha de salida y devolución
                // if(!fn_ExisteItemDelete(article.articuloId)){
                //     console.log(article.articuloId);
                //     if (estadoId > 1) {
                //         swal('', 'El código ingresado no esta disponible', 'warning');
                //         return;
                //     }
                // }	
                // if (salir) return;			

                // Validaciòn de reservas
                if (articleReserves.length && codigo.substr(0, 3) != "GEN") {
					// verificar las fecha 
					let fechaSalida = $('#fechaSalida').val();
					let fechaDevolucion = $('#fechaDevolucion').val();
					if (!fechaSalida || !fechaDevolucion) {
						swal({
							title: "¿Reserva rechazada?",
							text: "El artículo se encuentra reservado, por favor ingrese las fechas de recogo y devolución para verificar su disponibilidad en esas fechas!",
							icon: "warning",
							buttons: { 'calendar': 'Ver Reservas', 'cancel': 'OK' }
							// dangerMode: true
						})
							.then((value) => {
								switch (value) {
									case 'calendar':
										fn_ObtenerModalCalendar(function () {
											$('#calendar-reserva').datepicker();
											$('#modal-calender').modal('show');
										});
										break;
									default:
										break;
								}
							});
						return;
					}
					else {
						var hayConflicto = false;
						var fechaInicio = fn_GetDate($('#fechaSalida').val());
						var fechaFin = fn_GetDate($('#fechaDevolucion').val());
						var fechaReservas = [];
						// verificar si hay conflicto con otras reservas

						var diffDias = function (fecha1, fecha2) {
							var tiempo = fecha2.getTime() - fecha1.getTime();
							var dias = Math.floor(tiempo / (1000 * 60 * 60 * 24));
							return dias;
						}
						articleReserves.forEach(function (e) {
							console.log(e);
							var { fechaDevolucion, fechaSalida } = e;
							fechaSalida = new Date(fechaSalida);
							fechaSalida.setHours(0);
							fechaDevolucion = new Date(fechaDevolucion);
							fechaDevolucion.setHours(0);							

							var fechaTemp = fechaSalida;
							
							var dias = diffDias(fechaSalida, fechaDevolucion)+1;
							for (let i = 1; i <= dias; i++) {		
								console.log(fechaTemp.toISOString());
								fechaReservas.push(fechaTemp.toISOString());
								fechaTemp.setDate(fechaTemp.getDate()+1)
							}

							if (fechaInicio.getTime() >= fechaSalida.getTime() && fechaInicio.getTime() <= fechaDevolucion.getTime()) {
								hayConflicto = true;
								// break;
								return;
							} else if (fechaFin.getTime() >= fechaSalida.getTime() && fechaFin.getTime() <= fechaDevolucion.getTime()) {
								hayConflicto = true;
							} else if (fechaInicio.getTime() <= fechaSalida.getTime() && fechaFin.getTime() >= fechaDevolucion.getTime()) {
								hayConflicto = true;
							}
						})
						console.log(fechaReservas);
						if (hayConflicto) {
							// mostrar mensaje e impedir registrar
							swal({
								title: "¿Reserva rechazada?",
								text: "El artículo se encuentra reservado durante esas fechas, por favor indique otras fechas o seleccione otros códigos de prenda!",
								icon: "warning",
								buttons: { 'calendar': 'Ver Reservas', 'cancel': 'OK' }
								// dangerMode: true
							})
								.then((value) => {
									switch (value) {
										case 'calendar':
                                            fn_MostrarReservasArticulo(fechaReservas);
											// fn_ObtenerModalCalendar(function () {
											// 	$('#calendar-reserva').datepicker();
											// 	$('#modal-calender').modal('show');
											// });
											break;
										default:
											break;
									}
								});
							return;
						} else {
							// Alertar para que verifique las fecha
							swal({
								title: "¿Artículo reservado correctamente?",
								text: 'El artículo ha sido reservado correctamente, para evitar conflictos con otras reservas puede verificar las reservas programadas de este artículo.',
								icon: "info",
								buttons: { 'calendar': 'Ver Reservas', 'cancel': 'OK' }
							})
								.then((value) => {
									switch (value) {
										case 'calendar':
											// var reservas_fechas = articleReserves.forEach
											// fn_ObtenerModalCalendar(function () {
											// 	$('#calendar-reserva').datepicker();
											// 	$('#modal-calender').modal('show');
											// });
											fn_MostrarReservasArticulo(fechaReservas);
											break;
										default:
											break;
									}
								});
						}
					}
                }
                // Fin Validaciòn de reservas
				
                item = new SaleDetail();

                // Validar si es un codigo eliminado para el caso de los NORMALES
                if (codigo != 'GEN00000001')   {
                    if (fn_ExisteItemDelete(article.articuloId)){                        
                        // Se esta devolviendo el item que ya estaba agregadp
                        let itemDelete = fn_ObtenerItemDelete(article.articuloId);
                        item.id = itemDelete.id;
                        item.accion = 1; 
                        item.precioAnterior = itemDelete.precioAnterior;
                        item.precio = itemDelete.precioAnterior;
                        fn_QuitarItemDelete(article.articuloId);
                    }
                    else {
                        item.id = fn_GenerarIdTemp();
                        item.accion = 2; 
                        item.precioAnterior = Number(article.precioAlquiler);
                    }
                }                                 
                else {                    
                    item.id = fn_GenerarIdTemp();
                    item.accion = 2; 
                    item.precioAnterior = Number(article.precioAlquiler);
                }
        
                item.articuloId = article.articuloId;
				item.codigo = codigo;
				item.nombre = article.nombre;
				item.descripcion = article.descripcion;
				item.categoriaId = article.categoriaId;
				item.categoria = article.categoria;
				item.estado = article.estado;
				item.estadoId = article.estadoId;
                item.cantidad = 1;
                
                if (item.precio == 0 || item.precio == undefined)
                    item.precio =  Number(article.precioAlquiler);
                
                item.precioAlquiler = Number(article.precioAlquiler);
                item.tipo = article.tipo;    

				fn_AgregarArticulo(item);
				fn_Enumerar();
				fn_CalcularTotal();				
				$('#codigoArticulo').val('');
			} else {
				swal('', 'El código ingresado no existe', '');
			}
		})
		pet.fail(function (xhr) {
			console.log('ERROR AL BUSCAR UN CODIGO DE PRODUCTO')
		});
    });
    
    $(document).on('click', '.btn-item-delete', function(evt) {
        let accion = $(this).closest('tr').data('accion');
        if (accion == "1"){
            let articuloId = $(this).closest('tr').data('articulo');
            let id = $(this).closest('tr').data('id');
            if (!fn_ExisteItemDelete(id)){
                let itemDelete = new SaleDetail();
                itemDelete.id = id;
                itemDelete.articuloId = articuloId;
                itemDelete.codigo = $(this).closest('tr').find('td').eq(1).text();
                itemDelete.precioAnterior = Number($(this).closest('tr').find('td').eq(4).data('precio'));
                itemDelete.precio = Number($(this).closest('tr').find('td').eq(4).find('input').val());
                itemDelete.accion = 3;
                fn_AgregarItemDelete(itemDelete);
            }            
        }
        $(this).closest('tr').remove();
        fn_Enumerar();
        fn_CalcularTotal();
    })

    function fn_MostrarReservasArticulo(reservas) {
        // var reservasISO = reservas.map(function (f) { return f.toISOString(); });
        var fecha = new Date();
        var minDate = fecha; maxDate = fecha;
        minDate.setDate(minDate.getDate() - 30);
        maxDate.setDate(maxDate.getDate() + 30);
    
        fn_ObtenerModalCalendar(function () {
            $("#calendar-reserva").datepicker("option", { minDate: null, maxDate: null });
            // $("#calendar1").datepicker("destroy");
            $('#calendar-reserva').datepicker({
                minDate: new Date(fecha.getFullYear(), fecha.getMonth() - 1, fecha.getDate()),
                maxDate: new Date(fecha.getFullYear(), fecha.getMonth() + 1, fecha.getDate()),
                beforeShowDay: function (d) {
                    var cl = "bg-primary";
                    if ($.inArray(d.toISOString(), reservas) != -1) {
                        return [true, cl, "Available"];
                    } else {
                        return [true, "", "unAvailable"];
                    }
                }
            });
            $('#modal-calender').modal('show');
        });
    }

    function fn_AgregarItemDelete(itemDelete) {        
        saleDetailsDelete.push(itemDelete);
    }

    function fn_ExisteItemDelete(articuloId) {
        let existe = false;
        saleDetailsDelete.forEach(function(e, i){
            if(e.articuloId == articuloId){
                existe = true; return;                                                    
            }
        })
        return existe;
    }

    function fn_QuitarItemDelete(articuloId){
        saleDetailsDelete.forEach(function(e, i){
            if(e.articuloId == articuloId)
                saleDetailsDelete.splice(i, 1);
        })
    }

    function fn_ObtenerItemDelete(articuloId) {
        //let id = 0;
        let item;
        saleDetailsDelete.forEach(function(e, i){
            if(e.articuloId == articuloId)
                //id = e.id;
                item = e;
        });
        //return id;
        return item;
    }

    function fn_GenerarIdTemp() {
        return 'N' + Math.round(getRandomArbitrary(1111111, 9999999));
    }

    $(document).on('click', '.btn-item-show', function(evt) {

    })

    $(document).on('click', '.btn-item-schedule', function(evt) {

    })

    document.getElementById('codigoArticulo').addEventListener('keyup', function (evt) {
        this.value = this.value.toUpperCase();
    })
    document.getElementById('codigoArticulo').addEventListener('keypress', function (evt) {
        // evt.preventDefault();
        var code = (evt.keyCode ? evt.keyCode : evt.which);        
        if (code == 13) {            
            if ($(this).val().length >= 4) {                
                let codigo = fn_CompletarCodigo($(this).val());
                console.log(codigo);
                $(this).val(codigo);
                $('#btn-add-article-full').trigger('click');
            }
        }		
    })
    document.getElementById('codigoArticulo').addEventListener('blur', function (evt) {
        evt.preventDefault();
        if ($(this).val().length >= 4) {
            let codigo = fn_CompletarCodigo($(this).val());
            $(this).val(codigo);
        }
    })

    $(document).on('blur, keyup', 'td>input.txt-precio-item', function (evt) {
		// let codigo = $(this).closest('tr').find('td').eq(1).text();
		// let idx = 0;
		// saleDetails.forEach(function (e, i) {
		// 	if (e.codigo === codigo) idx = i;
		// });
		// saleDetails[idx].precio = Number($(this).val());
		// console.log(saleDetails);
		fn_CalcularTotal();
    })
    $(document).on('change', 'td>input.txt-precio-item', function(evt) {
        fn_CalcularTotal();
    })
    
    $('#btn-add-pago').on('click', function () {
		let tipoPagoId = $('#tipoPago').val();
		let tipoPago = $('#tipoPago>option:selected').text();
		let montoPago = Number($('#montoPago').val());
        let nroTarjeta = $('#nroTarjeta').val();
        let fecha = new Date();
        let saldo = Number($('#totalSaldo').val());

        if (!tipoPagoId){
            swal('', 'Seleccione la forma de pago.', 'warning');
			return;
        }
		if (montoPago <= 0) {
			swal('', 'Ingrese un monto mayor a 0.', 'warning');
			return;
        }
        if (tipoPagoId != 4 && montoPago > saldo ) {
            swal('', 'La operación ya se encuentra cancelada en su totalidad', 'warning');
			return;
        }

		let tr;
		tr = $('<tr>').data('pago', 0);
        tr.append($('<td>').text(tipoPago).data('tipo-pago', tipoPagoId));
        if (tipoPagoId == 4) {
            tr.append($('<td>').text(Number(0).toFixed(2)));
            tr.append($('<td>').text(montoPago.toFixed(2)));
        }else {
            tr.append($('<td>').text(montoPago.toFixed(2)));
            tr.append($('<td>').text(Number(0).toFixed(2)));
        }		
		tr.append($('<td>').text(nroTarjeta));
		tr.append($('<td>').text(fecha.format()));
		tr.append($('<td>').html("<button class='btn btn-xs btn-danger btn-remove-pago'><i class='fa fa-trash'></i></button>"));
		$('#tbl-forma-pago').append(tr);
		fn_CalcularTotalTarjeta();

		$('#tipoPago').val('1');
		$('#montoPago').val('');
		$('#nroTarjeta').val('');
    })

    $(document).on('click', '.btn-remove-pago', function() {
        $(this).closest('tr').remove();
        fn_CalcularTotalTarjeta();
    })
    
    $('#btn-save-sale').on('click', function (evt) {
		evt.preventDefault();
		let isValidSale;
		let isValidCustomer;
		isValidSale = $('#form-sale-edit').valid();
		isValidCustomer = $('#form-customer-edit').valid();

		if (!isValidSale) return;
		if (!isValidCustomer) return;

		// Validar Detalle
		if (!fn_ValidaDetalle()) {
			swal('', 'No ha agregado ninguna prenda a la solicitud o estas no tienen precio', 'warning');
			return;
		}

		// Validar Cancelación depende si es alquiler o reserva
		if ($('#totalPagado').val() <= 0) {
			swal('', 'No ha realizado la cancelación de la reserva', 'warning');
			return;
		}

		// Obtener datos del cliente 
		let formDataSale = new FormData(document.getElementById('form-sale-edit'));
		let formDataCustomer = new FormData(document.getElementById('form-customer-edit'));

		customer = fn_GenerarCliente();
        sale = fn_GenerarVenta();
        saleDetails = fn_GeneraDetalle();
		salePayments = fn_GenerarPago();

		formDataCustomer.append('cliente', JSON.stringify(customer));
		formDataCustomer.append('venta', JSON.stringify(sale));
		formDataCustomer.append('venta-detalle', JSON.stringify(saleDetails));
		formDataCustomer.append('venta-pago', JSON.stringify(salePayments));
		// Obtener el detalle

		// console.log(customer);
		// console.log(sale);
		// console.log(saleDetails);
		// console.log(salePayments);
		sale.customer = customer;

		$.ajax({
			type: 'POST',
			url: '/ventas/editar_venta',
			data: formDataCustomer,
			contentType: false,
			processData: false,
			beforeSend: Call_Progress(true)
		})
			.done(function (data) {
				console.log(data);
				if (data > 0) {
					// Mensaje de registro correcto
					swal('', 'Venta actualizada', 'info');
					// var pr = fn_ImprimirTicket(sale);
					// pr.done(function (data) {
					// 	// console.log('Imprimiendo ticket');
					// })
					// $('#msg-debug').html(data);
					// fn_LimpiarFactura();
                    // fn_ObtenerNroVenta();
                    window.location.href = '/ventas/editar/'+$('#saleId').val();
                }
                else {
                    swal('', 'Ocurrio un error al actualizar la operación', 'error');
                }
				// $.when(print).then(function() {
				// 	console.log('Imprimir ticket');
				// })				
			})
			.fail(function (jqXHR, textStatus) {
                swal('', 'Ocurrio un error al actualizar la operación', 'error');
				console.log('ERROR AL ACTUALIZAR LA VENTA');
				console.log(jqXHR.responseText);
			})
			.always(function () {
				Call_Progress(false);
			})
	})    

    $('#btn-check-sale').on('click', function(evt) {
        evt.preventDefault();
		let isValidSale;
		let isValidCustomer;
		isValidSale = $('#form-sale-edit').valid();
		isValidCustomer = $('#form-customer-edit').valid();

		if (!isValidSale)
			return;

		if (!isValidCustomer)
			return;

		// Validar Detalle
		if (!fn_ValidaDetalle()) {
			swal('', 'No ha agregado ninguna prenda a la solicitud o estas no tienen precio', 'warning');
			return;
		}

		// Validar Cancelación depende si es alquiler o reserva
		if ($('#totalPagado').val() <= 0) {
			swal('', 'No ha realizado la cancelación de la reserva', 'warning');
			return;
		}

		// Obtener datos del cliente 
		let formDataSale = new FormData(document.getElementById('form-sale-edit'));
		let formDataCustomer = new FormData(document.getElementById('form-customer-edit'));

		customer = fn_GenerarCliente();
        sale = fn_GenerarVenta();
        sale.estadoId = $(this).data('estado');
        saleDetails = fn_GeneraDetalle();
		salePayments = fn_GenerarPago();

		formDataCustomer.append('cliente', JSON.stringify(customer));
		formDataCustomer.append('venta', JSON.stringify(sale));
		formDataCustomer.append('venta-detalle', JSON.stringify(saleDetails));
		formDataCustomer.append('venta-pago', JSON.stringify(salePayments));
		// Obtener el detalle

		sale.customer = customer;

		$.ajax({
			type: 'POST',
			url: '/ventas/editar_venta',
			data: formDataCustomer,
			contentType: false,
			processData: false,
			beforeSend: Call_Progress(true)
		})
			.done(function (data) {
				console.log(data);
				if (data > 0) {
					swal('', 'Venta actualizada', 'info');
				}
				
				window.location.href = '/ventas/editar/'+$('#saleId').val();
			})
			.fail(function (xhr) {
				console.log('ERROR AL ACTUALIZAR LA VENTA');
			})
			.always(function () {
				Call_Progress(false);
			})
    });

    $('#btn-print-sale').on('click', function(evt) {
        console.log('imprimir');
        console.log(dataVenta);
		var fecha = new Date(dataVenta.fecha);
		//console.log(fecha.toGMTString());
		//console.log(fecha.toISOString());
		dataVenta.fecha = fecha.toISOString();
		if (dataVenta.fechaSalida == null) {
			fecha = new Date(dataVenta.fechaSalidaProgramada);		
			dataVenta.fechaSalida = fecha.toISOString();
		}
		if (dataVenta.fechaDevolucion == null) {
			fecha = new Date(dataVenta.fechaDevolucionProgramada);
			dataVenta.fechaDevolucion = fecha.toISOString();
		}
		
        console.log(dataVenta);
        
        // Identificar si han modificado, antes de enviar a imprimir
        // 
    
        var pr = fn_ImprimirTicket(dataVenta);
        pr.done(function (data) {
            console.log('Imprimiendo ticket');
        })
        pr.fail(function(){
            console.log('error al imprimir');
        })
    });

    $(document).on('click', '.btn-item-schedule', function(evt) {
        fn_ObtenerModalCalendar();
    })
})

function fn_ImprimirTicket(ticket) {
	return $.ajax({
		method: 'POST',
		url: 'http://localhost:8080/printer/imprimir-ticket.php',
		data: { ticket: JSON.stringify(ticket) }
	})
}

function fn_Inicializar() {

}
function fn_CompletarCodigo(codigo) {
    let prefijo = "";
    let correlativo;
    let newCodigo;
    for (i=0; i <= codigo.length; i++) {
        if (isNaN(codigo[i]))
            prefijo += codigo[i];
        else
            break;
    }
    correlativo = Number(codigo.substr(prefijo.length, codigo.length - prefijo.length));
    newCodigo = prefijo + zfill(correlativo, 11 - prefijo.length);
    return newCodigo;
}
// Agregar Prenda
function fn_AgregarArticulo(item) {
    let tr, input, btn, div;
    tr = $('<tr>').data('id', item.id).data('articulo', item.articuloId).data('tipo', item.tipo).data('accion', item.accion).prop('tabindex', 0);
    tr.append($('<td>').text(0));
    tr.append($('<td>').text(item.codigo).data('id', item.id));
    if (item.codigo == "GEN00000001"){		
		tr.append($('<td>').html("<input type='text' name='txt-descripcion-generico' class='form-control txt-nombre-item' placeholder='Ingrese la descripcion aquí'/>"));			
	}
	else {
		tr.append($('<td>').text(item.nombre));
	}
    tr.append($('<td>').text(item.precioAlquiler));
    input = $('<input type=number>').prop('name', 'precio-item').addClass('form-control txt-precio-item').val(Number(item.precio));
    tr.append($('<td>').data('precio', item.precioAnterior).append(input));
    div = $('<div>').addClass('center');
    btn = $('<button>').addClass('btn btn-blue btn-sm btn-item-show').html("<i class='icon icon-clipboard6'></i>").data('item', item.articuloId);
    div.append(btn).append(' ');
    btn = $('<button>').addClass('btn btn-danger btn-sm btn-item-delete').html("<i class='icon icon-bin'></i>").data('item', item.articuloId);
    div.append(btn).append(' ');
    btn = $('<button>').addClass('btn btn-dark btn-sm btn-item-schedule').html("<i class='icon icon-calendar22'></i>").data('item', item.articuloId);
    div.append(btn);
    tr.append($('<td>').append(div).css('width', '170px'));
    $('#tbl-detail-sale').append(tr);
    // saleDetails.push(item);
}
function fn_Enumerar() {
    $('#tbl-detail-sale > tr').each(function (i, e) {
        $(e).find('td').eq(0).text(i + 1);
    });
}
function fn_CalcularTotalTarjeta() {
    // Calcular el total
    let totalEfectivo = 0;
    let totalTarjeta = 0;
    let totalVuelto = 0;

    let tipoPago;
    let totalItem = 0;
    let totalItemVuelto = 0;
    $('#tbl-forma-pago>tr').each(function (i, e) {    
        totalItem = Number($(e).find('td').eq(1).text());
        totalItemVuelto = Number($(e).find('td').eq(2).text());
        tipoPago = $(e).find('td').eq(0).data('tipo-pago');    
        
        if(tipoPago == "1") 
            totalEfectivo += totalItem;                    
        else if(tipoPago == "4") 
            totalVuelto += totalItemVuelto;        
        else 
            totalTarjeta += totalItem;        
    })
    $('#totalEfectivo').val(totalEfectivo.toFixed(2));
    $('#totalVuelto').val(totalVuelto.toFixed(2));
    $('#totalTarjeta').val(totalTarjeta.toFixed(2));
    fn_CalcularTotal();
}
function fn_CalcularTotal() {
    let total = 0;
    let pagado = 0;
    let saldo = 0;

    // saleDetails.forEach(function (e, i) {
    //     total += e.precio;
    // });
    let precio = 0;
    $('#tbl-detail-sale>tr').each(function(i, e) {
        precio = Number($(e).find('td').eq(4).find('input').val());        
        total += precio;
    });
    let efectivo = Number($('#totalEfectivo').val());
    let tarjeta = Number($('#totalTarjeta').val());
    let vuelto = Number($('#totalVuelto').val());
    pagado = efectivo + tarjeta - vuelto;
    saldo = total - pagado;
    $('#totalGeneral').val(total.toFixed(2));
    $('#totalPagado').val(pagado.toFixed(2));
    $('#totalSaldo').val(saldo.toFixed(2));
}
function fn_GenerarVenta() {
    let sale = new Sale();
    sale.ventaId = Number($('#saleId').val());
    sale.clienteId = $('#customerId').val(); // en caso sea nuevo se obtendra despues
    sale.vendedorId = $('#vendedor').val(); 	//se optendra de la session
    sale.tiendaId = $('#tienda').val();
    sale.tipoId = 1; // 1: Alquiler y 2: Venta
    let fecha = new Date();
    sale.fecha = fecha.toISOString();    
    sale.fechaSalida = fn_GetDate($('#fechaSalida').val()).toISOString();
    sale.fechaDevolucion = fn_GetDate($('#fechaDevolucion').val()).toISOString();
    sale.etapaId = 0;
    sale.estadoId = $('#estado').val(); //data('estado-id');
    sale.estadoId_Anterior = $('#estado').data('estadoAnterior');
    sale.observaciones = $('#observacionesVenta').val();
    sale.dejoDocumento = Number($('#tieneDocumento').prop('checked'));
    sale.dejoRecibo = Number($('#tieneRecibo').prop('checked'));
    sale.precioTotal = Number($('#totalGeneral').val());
    sale.totalEfectivo = Number($('#totalEfectivo').val());
    sale.totalTarjeta = Number($('#totalTarjeta').val());
    sale.totalVuelto = Number($('#totalVuelto').val());
    sale.totalPagado = Number($('#totalPagado').val());
    sale.totalSaldo = Number($('#totalSaldo').val());
    sale.totalGarantia = Number($('#totalGarantia').val());
    sale.dejoDocumento = Number($('#dejoDocumento').prop('checked'))
    sale.dejoRecibo = Number($('#dejoRecibo').prop('checked'))
    return sale;
}
function fn_GeneraDetalle() {
    let detail = {};
    let details = [];
    $('#tbl-detail-sale>tr').each(function(i, e) {
        detail = new SaleDetail();
        detail.id = $(e).data('id');
        detail.articuloId = $(e).data('articulo');
        detail.codigo = $(e).find('td').eq(1).text();
        
        detail.precioAlquiler = Number($(e).find('td').eq(3).text());
        detail.precio = Number($(e).find('td').eq(4).find('input').val());
        detail.precioAnterior = Number($(e).find('td').eq(4).data('precio'));
        detail.accion = $(e).data('accion');
        if(detail.codigo == "GEN00000001")  
            if(detail.accion == 2)
                detail.nombre = $(e).find('td').eq(2).find('input').val();
            else 
                detail.nombre = $(e).find('td').eq(2).text();
        else 
            detail.nombre = "";
        details.push(detail);
    })

    saleDetailsDelete.forEach(function(e, i) {
        detail = new SaleDetail();
        detail.id = e.id;
        detail.articuloId = e.articuloId;
        detail.codigo = e.codigo;
        detail.precio = e.precio;
        detail.precioAnterior = e.precioAnterior;
        detail.accion = 3;
        details.push(detail);
    })
    return details;
}
function fn_GenerarCliente() {
    let customer = new Customer();
    customer.clienteId = $('#customerId').val();
    customer.tipo_persona = 1;
    customer.tipo_documento = $('#tipoDocumento').val();
    customer.nro_documento = $('#nroDocumento').val();
    customer.nombres = $('#nombres').val();
    customer.apellido_paterno = $('#apellidos').val();
    customer.apellido_materno = "";
    customer.direccion = $('#direccion').val();
    customer.email = $('#email').val();
    customer.telefono = $('#telefono').val();
    customer.celular = "";
    customer.observaciones = $('#observaciones').val();
    return customer;
}
function fn_GenerarPago() {
    let payments = [];
    let payment;

    $('#tbl-forma-pago>tr').each(function (i, e) {
        totalTarjeta += Number($(e).find('td').eq(2).text());
        payment = new SalePayment();
        payment.id = $(e).data('pago');
        payment.tipoPagoId = Number($(e).find('td').eq(0).data('tipo-pago'));
        payment.ingreso = Number($(e).find('td').eq(1).text());
        payment.salida = Number($(e).find('td').eq(2).text());;
        payment.nroTarjeta = $(e).find('td').eq(3).text();
        payments.push(payment);
    })
    return payments;
}
function fn_BloqueoAlquiler() {

}

// Validación de formularios
function fn_ValidaDetalle() {
    let sinPrecio = false;;
    $('#tbl-detail-sale>tr').each(function (i, e) {
        tipo = $(e).data('tipo');
        console.log(tipo);
        if (!Number($(e).eq(0).find('input.txt-precio-item').val())) {
            if(tipo=="Principal"){
                console.log(e);
                sinPrecio = true;
                return;
            }            
        }
    });
    return $('#tbl-detail-sale>tr').length && !sinPrecio;
}


// Validacion del formulario
jQuery.validator.setDefaults({ debug: true, success: "valid" });

var hoy = new Date();
jQuery.validator.addMethod("length", function (value, element) {
    if ($('#tipoDocumento').val() == "1")
        return this.optional(element) || value.length === 8;
    else
        return this.optional(element) || value.length > 8;
}, "El DNI debe tener 8 dígitos");

jQuery.validator.addMethod("maxDays", function (value, element, days) {
    let fecha = new Date(Number(value.substring(6, 10)), Number(value.substring(3, 5)) - 1, value.substring(0, 2));
    let fechaRecogo = $('#fechaSalida').val();
    fechaRecogo = new Date(Number(fechaRecogo.substring(6, 10)), Number(fechaRecogo.substring(3, 5)) - 1, fechaRecogo.substring(0, 2));
    //let hoy = new Date();
    return fecha.getTime() <= fechaRecogo.setDate(fechaRecogo.getDate() + days);
    //return fecha.getTime() <= hoy.setDate(hoy.getDate() + days);
}, "La fecha no debe ser mayor a 7 días.");

var validateSale = $('#form-sale-edit').validate({
    rules: {
        estado: 'required',
        nroOperacion: 'required',
        vendedor: 'required',
        tienda: 'required',
        fechaSalida: {
            required: true
        },
        fechaDevolucion: {
            required: true,
            maxDays: 7
        }
    },
    messages: {
        estado: 'El tipo de operación el obligatorio',
        nroOperacion: 'El N° de operación es obligatorio',
        vendedor: 'El vendedor es obligatorio',
        tienda: 'La tienda es obligatorio',
        fechaSalida: {
            required: 'La fecha de salida es obligatorio'
        },
        fechaDevolucion: {
            required: 'La fecha de devolución es obligatorio',
            maxDays: 'La fecha de devolución no puede superar los 7 días'
        }
    }
});

var validateCustomer = $('#form-customer-edit').validate({
    rules: {
        tipoDocumento: 'required',
        nroDocumento: {
            required: true,
            // minlength: 8,
            maxlength: 15,
            length: true
        },
        nombres: 'required',
        apellidos: 'required',
        direccion: 'required',
        email: 'email'
    },
    messages: {
        tipoDocumento: 'El tipo documento es obligatorio',
        nroDocumento: {
            required: 'El DNI el obligatorio',
            // minlength: "El N° Documento debe tener al menos 8 caracteres",
            maxlength: "El N° Documento debe tener como máximo de 15 caracteres",
            length: 'El DNI debe tener 8 dígitos'
            // function() {
            // 	if(('#tipoDocumento').val() == "1")
            // 		return 'El DNI debe tener 8 dígitos';
            // 	else 
            // 		return 'El N° de documento es inválido'	
            // }
        },
        nombres: 'Los Nombres son obligatorios',
        apellidos: 'Los Apellidos son obligatorios',
        direccion: 'La Dirección es obligatorio',
        email: 'Email no válido'
    }
});