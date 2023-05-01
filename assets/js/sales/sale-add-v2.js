// Declaramos las variables globales
let sale = {};
let saleDetails = [];
let salePayments = [];
let customer = {};

// Bloque jquery
$(function () {
	$.datepicker.setDefaults($.datepicker.regional["es"]);
	$.datepicker.formatDate('yy/mm/dd');

	$('#fechaSalida').datepicker({ 
		dateFormat: 'dd/mm/yy', 
		minDate: '-1M', 
		maxDate: '+6M', 
		showOtherMonths: true ,
		selectOtherMonths: true
	});
	$('#fechaDevolucion').datepicker({ 
		dateFormat: 'dd/mm/yy', 
		minDate: '-1M', 
		maxDate: '+6M', 
		showOtherMonths: true,
		selectOtherMonths: true
	});
	$('#fechaRegistro').datepicker({ 
		dateFormat: 'dd/mm/yy', 
		minDate: '-1M', 
		maxDate: '+7D',
		showButtonPanel: true, 
		showOtherMonths: true, 
		selectOtherMonths: true
	});

	var $tabButtonItem = $('#tab-button li'), $tabSelect = $('#tab-select'), $tabContents = $('.tab-contents'), activeClass = 'is-active';

	$tabButtonItem.first().addClass(activeClass);
	$tabContents.not(':first').hide();

	$tabButtonItem.find('a').on('click', function (e) {
		var target = $(this).attr('href');

		$tabButtonItem.removeClass(activeClass);
		$(this).parent().addClass(activeClass);
		$tabSelect.val(target);
		$tabContents.hide();
		$(target).show();
		e.preventDefault();
	});

	$tabSelect.on('change', function () {
		var target = $(this).val(), targetSelectNum = $(this).prop('selectedIndex');

		$tabButtonItem.removeClass(activeClass);
		$tabButtonItem.eq(targetSelectNum).addClass(activeClass);
		$tabContents.hide();
		$(target).show();
	});

	$('#tipoOperacion').change(function() {
		$tipo = $(this).val();
		$('#estado').html('');
		$('#estado').select2('destroy');
		if ($tipo == 1){
			$('#estado').append($('<option>').prop('value', 1).text("RESERVADO"));
			$('#estado').append($('<option>').prop('value', 2).text("ALQUILADO"));
		} else if ($tipo == 2) {
			$('#estado').append($('<option>').prop('value', 4).text("VENDIDO"));
		} else {
			$('#estado').append($('<option>').prop('value', 6).text("SERVICIO"));
		}
		$('#estado').select2({minimumResultsForSearch: Infinity});
	})

	// Inicializar los parametros 		
	fn_Inicializar();

	// Agregar articulos de forma rapida
	document.getElementById('codigoArticulo').addEventListener('keyup', function (evt) {
		// this.value = this.value.toUpperCase();
	})
	document.getElementById('codigoArticulo').addEventListener('keypress', function (evt) {
		var keyCode = (evt.keyCode ? evt.keyCode : evt.which);
		if (keyCode == 13) {
			if ($(this).val().length >= 4) {
				evt.preventDefault();
				// let codigo = $(this).val().substring(0, 4) + zfill(Number($(this).val().substring(4, 15)), 7);
				let codigo = fn_CompletarCodigo($(this).val());
				$(this).val(codigo);
				$('#btn-add-article-full').trigger('click');
			}
		} else {
			var $this = $(this);
			setTimeout(function () {
				$this.val($this.val().trim().toUpperCase());
			}, 40)
		}
	})
	document.getElementById('codigoArticulo').addEventListener('blur', function (evt) {
		evt.preventDefault();
		// Obtener la texto y luego la parte numerica
		if ($(this).val().length >= 4) {
			let codigo = fn_CompletarCodigo($(this).val());
			$(this).val(codigo);
		}
	})

	// Agregar prenda
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

				if(!article) { swal('', 'El código ingresado no existe', 'warning'); return;}
				if(article.estadoId == 5) { swal('','El código ingresado esta de baja.', 'warning'); return; }
				// Validar que no se encuentre agregado la prenda
				// let estadoId = data[0].estadoId;	
				// let estadoId = articulo.estadoId;	

				// Validar segun la fecha de salida y devolución
				// if (estadoId > 1) {														
				// 	swal('', 'El código ingresado no esta disponible', 'warning'); return;
				// }

				// Validar que el codigo no se haya agregado
				let salir = false;
				saleDetails.forEach(function (e, i) {
					if (e.codigo === codigo && codigo != "GEN00000001") {
						swal('', 'El codigo ya ha sido ingresado', 'warning'); salir = true; return;
					}
				})
				if (salir) return;

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
						// console.log(fechaReservas);
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
				/** ---  **/
				// console.log(article);
				item = new SaleDetail();
				item.id = Math.round(getRandomArbitrary(1111111, 9999999));
				item.articuloId = article.articuloId;
				item.codigo = codigo;
				item.nombre = article.nombre;
				item.descripcion = article.descripcion;
				item.categoriaId = article.categoriaId;
				item.categoria = article.categoria;
				item.estado = article.estado;
				item.estadoId = article.estadoId;
				item.cantidad = 1;
				item.precio = Number(article.precioAlquiler);
				item.precioAlquiler = Number(article.precioAlquiler);
				item.tipo = article.tipo;

				fn_AgregarArticulo(item);
				fn_Enumerar();
				fn_CalcularTotal();
				$('#codigoArticulo').val('');
			} else {
				swal('', 'El código ingresado no existe', 'warning');
			}
		})
		pet.fail(function (jqXHR) {
			console.log('ERROR AL BUSCAR UN CODIGO DE PRODUCTO');
			console.log(jqXHR.responseText);
		});
		pet.always(function () {

		})
	});

	// Quitar prenda
	$(document).on('click', 'div>a.btn-remove-article', function (evt) {
		evt.preventDefault();
		$(this).closest('tr').remove();
		let codigo = $(this).closest('tr').find('td').eq(1).text();
		// Obtener el indice
		let idx;
		saleDetails.forEach(function (e, i) {
			if (e.codigo === codigo) {
				idx = i;
				return;
			}
		})
		saleDetails.splice(idx, 1);
		// console.log(saleDetails);
		fn_Enumerar();
		fn_CalcularTotal();
	})	
	$(document).on('blur, keyup', 'td>input.txt-precio-item', function (evt) {
		// Actualizar el precio del array
		//let codigo = $(this).closest('tr').find('td').eq(1).text();
		let id = $(this).closest('tr').find('td').eq(1).data('id');
		let idx = 0;
		saleDetails.forEach(function (e, i) {
			//if (e.codigo === codigo) idx = i;
			if (e.id === id) idx = i;
		});
		saleDetails[idx].precio = Number($(this).val());

		fn_CalcularTotal();
	})
	$(document).on('change', 'td>input.txt-precio-item', function (evt) {
		// Actualizar el precio del array
		//let codigo = $(this).closest('tr').find('td').eq(1).text();
		let id = $(this).closest('tr').find('td').eq(1).data('id');
		let idx = 0;
		saleDetails.forEach(function (e, i) {
			//if (e.codigo === codigo) idx = i;
			if (e.id === id) idx = i;
		});
		saleDetails[idx].precio = Number($(this).val());
		//console.log(saleDetails);
		fn_CalcularTotal();
	})
	$(document).on('blur, keyup', 'td>input.txt-nombre-item', function (evt) {		
		// Actualizar el precio del array
		let codigo = $(this).closest('tr').find('td').eq(1).text();
		let id = $(this).closest('tr').find('td').eq(1).data('id');
		let nombre = $(this).val();
		//console.log(nombre);

		let idx = -1;
		saleDetails.forEach(function (e, i) {
			//if (e.codigo === codigo && codigo == "GEN00000001") idx = i;
			if (e.id === id && codigo == "GEN00000001") idx = i;
		});
		if (idx > -1) {
			saleDetails[idx].nombre = nombre;
			saleDetails[idx].descripcion = nombre;
		}
	})
	$('#totalEfectivo').on('keyup', function () {
		fn_CalcularTotal();
	})
	$('#totalVuelto').on('keyup', function () {
		fn_CalcularTotal();
	})
	$('#btn-add-tarjeta').on('click', function () {
		let tipoTarjetaId = $('#tipoTarjeta').val();
		let tipoTarjeta = $('#tipoTarjeta>option:selected').text();
		let nroTarjeta = $('#nroTarjeta').val();
		let montoTarjeta = Number($('#montoTarjeta').val());
		if (montoTarjeta <= 0) {
			swal('', 'Ingrese un monto mayor a 0.', '');
			return;
		}

		let tr;
		tr = $('<tr>').prop('tabindex',0);
		tr.append($('<td>').text(tipoTarjeta).data('tipo-tarjeta', tipoTarjetaId));
		tr.append($('<td>').text(nroTarjeta));
		tr.append($('<td>').text(montoTarjeta));
		tr.append($('<td>').html("<button class='btn btn-xs btn-danger btn-remove-tarjeta'><i class='fa fa-trash'></i></button>"));
		$('#tbl-tarjetas').append(tr);

		fn_CalcularTotalTarjeta();

		$('#tipoTarjeta').val('2');
		$('#nroTarjeta').val('');
		$('#montoTarjeta').val('');
	})
	$(document).on('click', '#tbl-tarjetas .btn-remove-tarjeta', function () {
		$(this).closest('tr').remove();
		fn_CalcularTotalTarjeta();
	})

	$(document).on('click', '.btn-show-detail-article', function(evt) {
		evt.preventDefault();
		let articulo = $(this).closest('tr').data();
		// console.log(articuloId);

		let articuloId = articulo.articulo;
		fn_ObtenerModalRegistrarArticulo(function() {
			fn_ObtenerArticuloById(articuloId, function(data) {
				App.Producto.EsEdit = true;
				fn_LimpiarArticuloFull();
				fn_MostrarArticulo(data);
			})
		});
	})

	$('#nroDocumento').on('keydown', function (evt) {
		// console.log('keydown');
	})
		.on('keypress', function (evt) {
			var keyCode = (evt.keyCode) ? evt.keyCode : evt.which;
			if (keyCode == 13) {
				evt.preventDefault();
				fn_ObtenerDatosCliente($(this).val());
			}
			// return false;
			// console.log('keypress');
		})
		.on('keyup', function (evt) {
			// console.log('keyup');
		})
		.on('blur', function (evt) {
			// console.log('blur');
			evt.preventDefault();
			fn_ObtenerDatosCliente($(this).val());
		});

	$('#nombres, #apellidos, #direccion').keypress(function() {
		fn_Mayusculas(this);
	})
	$('#nombres, #apellidos').change(function(evt) {	
		$(this).val($(this).val().toUpperCase());
	})

	// Ver información del cliente
	$('#btn-show-modal-customer').on('click', function (evt) {
		evt.preventDefault();
		// console.log($('#nroDocumento').data('clienteId'));
		if ($('#nroDocumento').data('clienteId')) {
			let clienteId = $('#nroDocumento').data('clienteId');
			let nroDocumento = $('#nroDocumento').val();
			fn_ObtenerModalRegistrarCliente(function () {
				fn_LimpiarCliente();
				$('#customerId_Add').val(clienteId);
				$('#nroDocumento_Add').val(nroDocumento);
				$('#nroDocumento_Add').data('valueOld', nroDocumento);
				fn_ObtenerCliente(function () {
					fn_CargarDatosClienteModal();
					$('#modal-register-customer').modal('show');
				});
			})
		} else {
			$('#customerId_Add').val(0);
			fn_ObtenerModalRegistrarCliente(function () {
				fn_CargarDatosClienteModal();
				$('#modal-register-customer').modal('show');
			});
		}
	})
	$(document).on('customerAction', function (evt, data) {
		// Recargar los datos del cliente registrado
		// console.log(data);
		var cliente = data.cliente;
		if (data.action == "insert") $('#nroDocumento').data('clienteId', cliente.customerId_Add);
		$('#nroDocumento').val(cliente.nroDocumento_Add);
		$('#nombres').val(cliente.nombres_Add);
		$('#apellidos').val(cliente.apellidos_Add);
		$('#telefono').val(cliente.telefono_Add);
		$('#email').val(cliente.email_Add);
		$('#direccion').val(cliente.direccion_Add);
		$('#observaciones').val(cliente.observaciones_Add);
	})

	function fn_ObtenerDatosCliente(numero) {
		// Obtener los datos del cliente si aun no ha sido cargado
		// console.log($('#nroDocumento').val());
		// console.log('1: ' + $('#nroDocumento').data('valueOld'));
		if ($('#nroDocumento').data('valueOld') == $('#nroDocumento').val().trim()) return;
		// if ($('#nroDocumento').data('clienteId')) return;
		if (numero.length >= 8) {
			validateCustomer.resetForm();

			// Verificar si cliente tiene devoluciones pendientes 
			$.ajax({
				type: 'POST',
				url: '/ventas/verificaClienteDevoluciones',
				data: { numero: $('#nroDocumento').val() },
				beforeSend: Call_Progress(true),
				// contentType: 'application/json; charset=utf-8'
				dataType: 'json'
			})
			.done(function(data) {
				console.log(data);
				
				if (data.length > 0) {
					swal({
						title: "¿El cliente con devoluciones pendientes?",
						text: "El cliente tiene " +data.length + " devoluciones pendientes. \n Desea continuar registrando la venta!",
						icon: "warning",
						buttons: true,
						dangerMode: true,
					  })
					  .then((yes) => {
						if (yes) {
						  	/* continuar obteniendo los datos del cliente*/
							fn_CargarCliente();
							/*********************** */
						}						
					  });
				} else {
					fn_CargarCliente();
				}
			})
			.fail(function(jqXHR) {
				console.log(jqXHR.responseText);
			})
			.always(function() {
				Call_Progress(false);
			})


			
		}
		// console.log('4: ' + $('#nroDocumento').data('valueOld'));
	}

	function fn_CargarCliente() {
		$.ajax({
			type: 'POST',
			url: '/ventas/obtenerClienteByNumero',
			data: { numero: $('#nroDocumento').val() },
			beforeSend: Call_Progress(true),
			// contentType: 'application/json; charset=utf-8'
			dataType: 'json'
			})
			.done(function (data) {
				// console.log(data);
				if (data.length > 0) {
					fn_LimpiarClienteVenta();
					let cliente = data[0];
					$('#tipoDocumento').val(cliente.tipo_documento);
					$('#nroDocumento').data('clienteId', cliente.clienteId);
					$('#nroDocumento').val(cliente.nro_documento);
					$('#nombres').val(cliente.nombres);
					$('#apellidos').val(cliente.apellido_paterno);
					$('#telefono').val(cliente.telefono);
					$('#direccion').val(cliente.direccion);
					$('#email').val(cliente.email);
					$('#observaciones').val(cliente.observaciones);
					$('#nroDocumento').data('valueOld', $('#nroDocumento').val().trim());
				}
			})
			.fail(function (xhr) {
				console.log('error');
			})
			.always(function () {
				Call_Progress(false);
			})
		$('#nroDocumento').data('valueOld', $('#nroDocumento').val().trim());
	}

	/**
	 * Actualizar los datos actualizados al modal de cliente
	 */
	function fn_CargarDatosClienteModal() {
		$('#tipoDocumento_Add').val($('#tipoDocumento').val());
		$('#nroDocumento_Add').val($('#nroDocumento').val());
		$('#nombres_Add').val($('#nombres').val());
		$('#apellidos_Add').val($('#apellidos').val());
		$('#telefono_Add').val($('#telefono').val());
		$('#email_Add').val($('#email').val());
		$('#direccion_Add').val($('#direccion').val());
		$('#observaciones_Add').val($('#observaciones').val());
	}

	$('#btn-reniec').on('click', function () {
		myPopup('https://portaladminusuarios.reniec.gob.pe/validacionweb/index.html#no-back-button', '', 500, 500);
	})

	// OPCIONES GENERALES	
	$('#btn-register-sale').on('click', function (evt) {
		evt.preventDefault();
		let isValidSale;
		let isValidCustomer;
		isValidSale = $('#form-sale-add').valid();
		isValidCustomer = $('#form-customer-add').valid();

		if (!isValidSale) {
			console.log('venta invalida'); return;
		}
		if (!isValidCustomer) {
			swal('','Complete los datos del cliente', 'warning');
			$('#btn-tab-cliente').trigger('click');
			console.log('cliente invalido'); return;
		}

		// Validar Detalle
		if (!fn_ValidaDetalle()) {
			swal('', 'No ha agregado ninguna prenda a la solicitud o estas no tienen precio', 'warning'); return;
		}

		// Validar la cancelación del alquiler o venta
		if ($('#tipoOperacion').val() == 1){
			if ($('#estado').val() == 1) {	// RESERVADO
				// Validar Cancelación depende si es alquiler o reserva
				if ($('#totalPagado').val() <= 0) {
					swal('', 'No ha realizado la cancelación de la reserva', 'warning'); return;
				}
			}
			else if ($('#estado').val() == 2) {	// ALQUILADO
				if($('#totalSaldo').val() > 0){
					swal('', 'No ha realizado la cancelación total del alquiler', 'warning'); return;
				}
			}
		} else if ($('#tipoOperacion').val() == 2) {
			if($('#totalSaldo').val() > 0){
				swal('', 'No ha realizado la cancelación total de la venta', 'warning'); return;
			}
		}

		// Obtener datos del cliente 
		let formData0 = new FormData(document.getElementById('form-sale-add'));
		let formData = new FormData(document.getElementById('form-customer-add'));

		formData.append('clienteId', $('#nroDocumento').data('cliente-id'));
		customer = fn_GenerarCliente();
		sale = fn_GenerarVenta();
		salePayments = fn_GenerarPago();

		formData.append('cliente', JSON.stringify(customer));
		formData.append('venta', JSON.stringify(sale));
		formData.append('venta-details', JSON.stringify(saleDetails));
		formData.append('venta-payments', JSON.stringify(salePayments));

		sale.customer = customer;
		// console.log(sale);
		// return;

		$.ajax({
			type: 'POST',
			url: '/ventas/registrar_venta',
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: Call_Progress(true)
		})
			.done(function (data) {
				console.log(data);
				if (data) {
					// Mensaje de registro correcto
					swal('', 'Venta registrada correctamente', 'info');

					//sale.ventaId = Number(data);
					sale.nroOperacion = data;

					var pr = fn_ImprimirTicket(sale);
					pr.done(function (data) {
						console.log('Imprimiendo ticket');
					})
					$('#msg-debug').html(data);
					fn_LimpiarFactura();
					// fn_ObtenerNroVenta();
					fn_ObtenerNroTicket();
				}
				else {
					swal('Ocurrio un error al registrar la operación','error');
				}

				// $.when(print).then(function() { console.log('Imprimir ticket'); })
				// window.location.href = '/ventas/listar';
				// let json = JSON.parse(data)
			})
			.fail(function (jqXHR, textStatus) {
				console.log('ERROR AL REGISTRAR LA VENTA');
				console.log(jqXHR.responseText);
			})
			.always(function () {
				Call_Progress(false);
			})
	})

	$('#btn-new-sale').on('click', function (evt) {
		// fn_ObtenerNroVenta();
		fn_ObtenerNroTicket();
		fn_LimpiarFactura();
		fn_LimpiarClienteVenta();
		validateSale.resetForm();
		validateCustomer.resetForm();
	})

	// Validación de formularios
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
		let hoy = new Date();
		return fecha.getTime() <= hoy.setDate(hoy.getDate() + days);
	}, "La fecha no debe ser mayor a 7 días.");

	var validateSale = $('#form-sale-add').validate({
		ignore: [],
		//errorPlacement: function() {},
		submitHandler: function () {
			// alert('Successfully saved!');
			console.log('Successfully saved!');
		},
		// invalidHandler: function () {
		// 	setTimeout(function () {
		// 		$('.nav-tabs a small.required').remove();
		// 		var validatePane = $('.tab-content #top-tab-venta .tab-pane:has(input.error)').each(function () {
		// 			console.log(this);
		// 			var id = $(this).attr('id');
		// 			$('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">***</small>');
		// 		});
		// 	});
		// },
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
				maxDays: 30
			},
			fechaRegistro: 'required'
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
			},
			fechaRegistro: 'La fecha de registro es obligatorio'
		}
	});

	var validateCustomer = $('#form-customer-add').validate({
		ignore: [],
		// errorPlacement: function() {},
		submitHandler: function () {
			// alert('Successfully saved!');
			console.log('Successfully saved!');
		},
		// invalidHandler: function() {
		//     setTimeout(function() {
		//         $('.nav-tabs a small.required').remove();
		//         var validatePane = $('.tab-content #top-tab-cliente .tab-pane:has(input.error)').each(function() {
		//             var id = $(this).attr('id');
		//             $('.nav-tabs').find('a[href^="#' + id + '"]').append(' <small class="required">***</small>');
		//         });
		//     });            
		// },
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

// Registrar el comprobante
// Primero se registra el cliente
// Traer los datos del cliente en caso ya exista
// Validar numero en campo DNI
// Obtener la lista de vendedores
// Cargar usuarios vendedores

function fn_GenerarVenta() {
	let sale = new Sale();
	// let fecha = $('#fechaSalida').val();
	// fecha = new Date(Number(fecha.substring(6, 10)), Number(fecha.substring(3, 5)) - 1, fecha.substring(0, 2)); 
	// console.log(fecha.toISOString())
	sale.ventaId = 0; //Number($('#nroOperacion').val()); // Se obtendra al registrar
	sale.tipoDoc = $('#nroOperacion').data('tipoDoc');
	sale.nroOperacion = $('#nroOperacion').val(); // Ticket
	sale.clienteId = $('#nroDocumento').data('cliente-id'); // en caso sea nuevo se obtendra despues
	sale.vendedorId = $('#vendedor').val(); 	//se optendra de la session
	sale.tiendaId = $('#tienda').val();
	sale.tipoId = $('#tipoOperacion').val(); 	// 1: Alquiler y 2: Venta
	let fecha = new Date();
	sale.fecha = fecha.toISOString();
	sale.fechaRegistro = fn_GetDate($('#fechaRegistro').val()).toISOString();	// Cambiar por moment toLocaleString()
	sale.fechaSalida = fn_GetDate($('#fechaSalida').val()).toISOString();
	sale.fechaDevolucion = fn_GetDate($('#fechaDevolucion').val()).toISOString();
	sale.etapaId = 0;
	sale.estadoId = $('#estado').val();
	sale.clienteNro = $('#nroDocumento').val();
	sale.clienteNombres = $('#nombres').val()+ $('#apellidos').val();
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
	sale.details = saleDetails;
	return sale;
}
function fn_GenerarCliente() {
	let customer = new Customer();
	customer.clienteId = $('#nroDocumento').data('cliente-id');
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
	// Obteniendo el pago en efectivo
	let payments = [];
	let payment;
	let totalEfectivo = Number($('#totalEfectivo').val());
	if (totalEfectivo > 0) {
		payment = new SalePayment();
		payment.tipoPagoId = 1;
		payment.ingreso = totalEfectivo;
		payment.salida = 0;
		payment.nroTarjeta = "";
		payments.push(payment);
	}

	let totalVuelto = Number($('#totalVuelto').val());
	if (totalVuelto > 0) {
		payment = new SalePayment();
		payment.tipoPagoId = 4;
		payment.ingreso = 0;
		payment.salida = totalVuelto;
		payment.nroTarjeta = "";
		payments.push(payment);
	}

	// Pago con Tarjetas
	$('#tbl-tarjetas>tr').each(function (i, e) {
		totalTarjeta += Number($(e).find('td').eq(2).text());
		payment = new SalePayment();
		payment.tipoPagoId = Number($(e).find('td').eq(0).data('tipo-tarjeta'));
		payment.ingreso = Number($(e).find('td').eq(2).text());
		payment.salida = 0;
		payment.nroTarjeta = $(e).find('td').eq(1).text();
		payments.push(payment);
	})
	return payments;
}
function fn_LimpiarFactura() {
	$('#estado').val(1);
	$('#nroOperacion').val('');
	$('#vendedor').val(usuarioId);
	$('#tienda').val(tiendaSel.tiendaId);

	let fecha1 = moment();
	let fecha2 = moment().add(1, 'days');
	$('#fechaRegistro').val(fecha1.format('DD/MM/YYYY'));
	$('#fechaSalida').val(fecha1.format('DD/MM/YYYY'));
	$('#fechaDevolucion').val(fecha2.format('DD/MM/YYYY'));

	$('#observacionesVenta').val('');
	$('#tieneDocumento').prop('checked', false)
	$('#tieneRecibo').prop('checked', false);
	$('#tbl-detail-sale').html('');

	fn_LimpiarClienteVenta();
	fn_LimpiarPago();

	sale = {};
	saleDetails = [];
	salePayments = [];
	customer = {};
}
function fn_LimpiarClienteVenta() {
	$('#nroDocumento').data('valueOld', '');
	$('#nroDocumento').val('');
	$('#nroDocumento').data('cliente-id', 0);
	$('#nombres').val('');
	$('#apellidos').val('');
	$('#telefono').val('');
	$('#direccion').val('');
	$('#email').val('');
	$('#observaciones').val('');
}
function fn_LimpiarPago() {
	$('#totalEfectivo').val('0');
	$('#totalTarjeta').val('0');
	$('#totalVuelto').val('0');

	$('#totalGeneral').val('0');
	$('#totalPagado').val('0');
	$('#totalSaldo').val('0');

	$('#tipoTarjeta').val('2');
	$('#tipoTarjeta').data('tipo-tarjeta', 0);
	$('#nroTarjeta').val('');
	$('#montoTarjeta').val('');
	$('#tbl-tarjetas').html('');
}
function fn_ValidaDetalle() {
	let sinPrecio = false;
	let tipo;
	$('#tbl-detail-sale > tr').each(function (i, e) {
		tipo = $(e).data('tipo');
		if (!Number($(e).eq(0).find('input.txt-precio-item').val())) {
			if (tipo == "Principal") {
				sinPrecio = true;
				return;
			}
		}
	});
	return $('#tbl-detail-sale>tr').length && !sinPrecio;
}

// En las peticiones ajax agregar el efecto de cargando
function fn_CompletarCodigo(codigo) {
	if (codigo.length >= 11)
	return codigo;

	let prefijo = "";
	let correlativo;
	let newCodigo;
	for (i = 0; i < codigo.length; i++) {
		if (isNaN(codigo[i]))
			prefijo += codigo[i];
		else
			break;
	}
	correlativo = Number(codigo.substr(prefijo.length, codigo.length - prefijo.length));	
	newCodigo = prefijo + zfill(correlativo, 11 - prefijo.length);
	return newCodigo;
}
function fn_Agregar(el) {
	// Validar que no se encuentre agregado la prenda
	let codigo = $(el).find('td').eq(0).text();
	let salir = false;
	saleDetails.forEach(function (e, i) {
		if (e.codigo === codigo && codigo != "GEN00000001") {
			swal('', 'El codigo ya ha sido ingresado', 'warning');
			salir = true;
			return;
		}
	})
	if (salir) return;
	item = new SaleDetail();
	item.id = $(el).find('td').eq(0).data('id');
	item.codigo = codigo;
	item.nombre = $(el).find('td').eq(1).text();
	item.descripcion = $(el).find('td').eq(2).text();
	item.categoriaId = $(el).find('td').eq(3).data('categoria-id');
	item.categoria = $(el).find('td').eq(3).text();
	item.estado = $(el).find('td').eq(4).data('estado-id');
	item.estadoId = $(el).find('td').eq(4).text();
	item.cantidad = 1;
	item.precio = Number($(el).find('td').eq(5).text());
	item.precioAlquiler = $(el).find('td').eq(5).text();
	fn_AgregarArticulo(item);
	fn_Enumerar();
	fn_CalcularTotal();
	$('#modal-search-article2').modal('hide');
}
function fn_CalcularTotalTarjeta() {
	// Calcular el total tarjetas
	let totalTarjeta = 0;
	$('#tbl-tarjetas>tr').each(function (i, e) {
		totalTarjeta += Number($(e).find('td').eq(2).text());
	})
	$('#totalTarjeta').val(totalTarjeta.toFixed(2));
	fn_CalcularTotal();
}
// Mostrar Resultados busqueda
function fn_mostrarArticulos(data) {
	$('#list-articles-search').html('');
	$.each(data, function (i, el) {
		// console.log(el);
		let tr, div, a;
		tr = $('<tr>');
		tr.append($('<td>').text(el.codigo).data('id', el.articuloId).data('codigo', el.codigo));
		tr.append($('<td>').text(el.nombre));
		tr.append($('<td>').text(el.descripcion));
		tr.append($('<td>').text(el.categoria).data('categoria-id', el.categoriaId));
		tr.append($('<td>').text(el.estado).data('estado-id', el.estadoId));
		tr.append($('<td>').text(el.precioAlquiler)); // precio sugerido
		a = $('<a>').addClass('btn btn-dark btn-sm btn-add-article').prop('href', '#').html("<i class='fa fa-check'></i>");
		div = $('<div>').append(a);
		tr.append($('<td>').addClass('center').append(div)); // Opciones: agregar 
		$('#list-articles-search').append(tr);
	})
}

// Agregar Prenda
function fn_AgregarArticulo(item) {	
	let tr, input, a, div;
	tr = $('<tr>').data('id', item.id).data('articulo', item.articuloId).data('tipo', item.tipo).prop('tabindex', 0);;
	tr.append($('<td>').text(0));
	tr.append($('<td>').text(item.codigo).data('id', item.id).data('articuloId', item.articuloId));
	if (item.codigo == "GEN00000001"){		
		tr.append($('<td>').html("<input type='text' name='txt-descripcion-generico' class='form-control txt-nombre-item' placeholder='Ingrese la descripcion aquí'/>"));			
	}
	else {
		tr.append($('<td>').text(item.nombre));
	}
	tr.append($('<td>').text(item.categoria).data('categoria-id', item.categoriaId));
	// tr.append($('<td>').text(item.cantidad));
	input = $('<input type=number>').prop('name', 'precio-item').addClass('form-control txt-precio-item').val(Number(item.precio));
	tr.append($('<td>').append(input).data('precio-alquiler', item.precioAlquiler));
	//<a href="#" class="btn btn-primary btn-sm btn-show-detail-article"><i class="icon icon-search4"></i>
	a = $('<a>').addClass('btn btn-primary btn-sm btn-show-detail-article').prop('href', '#').html("<i class='icon icon-search4'></i>");
	div = $('<div>').append(a).append('&nbsp;');
	a = $('<a>').addClass('btn btn-danger btn-sm btn-remove-article').prop('href', '#').html("<i class='icon icon-bin'></i>");
	div.append(a).append('&nbsp;');
	a = $('<a>').addClass('btn btn-dark btn-sm btn-item-schedule').prop('href', '#').html("<i class='icon icon-calendar22'></i>").data('item', item.articuloId);
    div.append(a);
	tr.append($('<td>').addClass('center').append(div));
	$('#tbl-detail-sale').append(tr);	
	saleDetails.push(item);
}
function fn_Enumerar() {
	$('#tbl-detail-sale > tr').each(function (i, e) {
		$(e).find('td').eq(0).text(i + 1);
	});
}
function fn_CalcularTotal() {
	let total = 0;
	let pagado = 0;
	let saldo = 0;

	saleDetails.forEach(function (e, i) {
		total += e.precio;
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
// Obtener el correlativo de venta
function fn_ObtenerNroVenta() {
	$.ajax({
		method: 'POST',
		url: '/ventas/obtenerNroVenta',
		dataType: 'json'
	})
		.done(function (res) {
			if (res) 
				$('#nroOperacion').val(res);			
		})
		.fail(function (jqXHR) {
			console.log('Error al obtener el correlativo');
			console.log(jqXHR);
		})
		.always(function () { 

		});
}
function fn_ObtenerNroTicket() {
	$.ajax({
		method: 'POST',
		url: '/ventas/obtenerNroTicket',
		data: {tiendaId : $('#tienda').val() },		
		dataType: 'json'
	})
		.done(function (data) {
			// console.log(data);
			if (data){
				$('#nroOperacion').data('tipoDoc', data.tipoDoc).val(data.serie+'-'+data.numeroActual);			
			}
		})
		.fail(function (jqXHR) {
			console.log('Error al obtener el correlativo');
			console.log(jqXHR);
		})
		.always(function () { 			
		});
}
function fn_Inicializar() {
	// fn_ObtenerNroVenta();
	fn_ObtenerNroTicket();

	// Seleccionar el vendedor y la tienda
	pet.done(function (data) {
		// Seleccionare el vendedor	
		if (rolId == "2") $('#vendedor').prop('disabled', true);
		$('#vendedor').val(usuarioId);
		$('#vendedor').trigger('change');

		// Seleccionar la tienda
		$('#tienda').val(tiendaSel.tiendaId);
		$('#tienda').trigger('change');
	});
	fecha = moment();
	var fecha2 = moment().add(1, 'days');
	//fecha.add(-1, 'days');
	
	$('#tipoOperacion').select2({minimumResultsForSearch: Infinity});
	$('#estado').select2({minimumResultsForSearch: Infinity});
	$('#vendedor').select2({minimumResultsForSearch: Infinity});
	$('#tienda').select2({minimumResultsForSearch: Infinity});
	$('#tipoDocumento').select2({minimumResultsForSearch: Infinity});
	$('#tipoTarjeta').select2({minimumResultsForSearch: Infinity});

	$('#fechaRegistro').val(fecha.format('DD/MM/YYYY'));
	$('#fechaSalida').val(fecha.format('DD/MM/YYYY'));
	$('#fechaDevolucion').val(fecha2.format('DD/MM/YYYY'));
	$('#tipoDocumento').val(1).change();
	$('#tipoTarjeta').val(2).change();
}

function fn_ImprimirTicket(ticket) {
	return $.ajax({
		method: 'POST',
		url: 'http://localhost:8080/printer/imprimir-ticket.php',
		data: { ticket: JSON.stringify(ticket) }
	})
}
