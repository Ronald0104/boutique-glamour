// Declaramos las variables globales
let sale = {};
let saleDetails = [];
let salePayments = [];
let customer = {};

// Modelos 
// Venta
function Sale() {
	this.ventaId;
	this.vendedorId;
	this.tiendaId;
	this.clienteId;
	this.fecha;
	this.fechaSalida;
	this.fechaDevolucion;
	this.tipoId; 		// 1 Alquiler y 2 Venta
	this.etapaId;		// Etapa: 1: Trabajo, 2: Abierto, 3: Historico
	this.estadoId;		// 1: Reserva, 2: alquiler, 3: devolucion, 4: Venta
	this.precioTotal;
	this.totalEfectivo;
	this.totalTarjeta;
	this.totalVuelto;
	this.totalPagado;
	this.totalSaldo;
	this.customer = {};
	this.details = [];
	this.payments = [];
}
// Detalle Venta
function SaleDetail() {
	this.id;
	this.codigo;
	this.nombre;
	this.descripcion;
	this.categoriaId;
	this.categoria;
	this.estadoId;
	this.estado;
	this.precio;
	this.precioAlquiler;
	this.cantidad;
}
// Pago Venta 
function SalePayment() {
	this.id;
	this.tipoPagoId;
	this.ingreso;
	this.salida;
	this.nroTarjeta;
}
// Cliente
function Customer() {
	this.clienteId;
	this.tipo_persona;
	this.tipo_documento;
	this.nro_documento;
	this.nombres;
	this.apellido_paterno;
	this.apellido_materno;
	this.direccion;
	this.email;
	this.telefono;
	this.celular;
	this.observaciones;
}

// (function () {
// console.log('función anonima');
$.datepicker.formatDate('yy/mm/dd');
$('#fechaSalida').datepicker({
	dateFormat: 'dd/mm/yy',
	minDate: '-7D',
	maxDate: '+30D'
});
$('#fechaDevolucion').datepicker({
	dateFormat: 'dd/mm/yy',
	minDate: '-7D',
	maxDate: '+30D'
});

// Bloque jquery
$(function () {

	var $tabButtonItem = $('#tab-button li'),
		$tabSelect = $('#tab-select'),
		$tabContents = $('.tab-contents'),
		activeClass = 'is-active';

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
		var target = $(this).val(),
			targetSelectNum = $(this).prop('selectedIndex');

		$tabButtonItem.removeClass(activeClass);
		$tabButtonItem.eq(targetSelectNum).addClass(activeClass);
		$tabContents.hide();
		$(target).show();
	});

	// Inicializar 		
	fn_Inicializar();

	// Obtener el correlativo de venta
	function fn_ObtenerNroVenta() {
		$.ajax({
			method: 'POST',
			url: '/ventas/obtenerNroVenta',
			dataType: 'json'
		})
			.done(function (res) {
				console.log(res);
				if (res) {
					$('#nroOperacion').val(res);
				}
			})
			.fail(function () {
				console.log('Error al obtener el correlativo');
			})
			.always(function () { });
	}
	function fn_Inicializar() {
		fn_ObtenerNroVenta();

		// fn_ObtenerSession(function() {
		// 	// console.log("datos");
		// })
		// Seleccionar el vendedor y la tienda
		pet.done(function (data) {
			// Seleccionare el vendedor	
			if (rolId == "2")
				$('#vendedor').prop('disabled', true);
			$('#vendedor').val(usuarioId);

			// Seleccionar la tienda
			$('#tienda').val(tiendaSel.tiendaId);
		});

		$('#tipoDocumento').val(1);
		$('#tipoTarjeta').val(2);
	}


	// Mostrar el modal de buscar de articulos
	$('#btn-show-search-article').on('click', function (evt) {
		evt.preventDefault();
		$('#modal-search-article2').modal({ backdrop: 'static', show: true })
	});

	$('#btn-search-article').on('click', function (evt) {
		evt.preventDefault();
		$.ajax({
			method: 'POST',
			url: '/inventario/articuloByCode',
			data: {
				articuloCode: $('#codigo').val()
			},
			//content: 'application/json; charset=utf-8',
			dataType: 'json'
		})
			.done(function (data) {
				fn_mostrarArticulos(data);
				console.log(data);
			})
			.fail(function () {
				console.log('error');
			})
	});

	$('#descripcion-producto').on('keyup', function (evt) {
		evt.preventDefault();
		if ($(this).val().trim().length < 2) return;

		$.ajax({
			method: 'POST',
			url: '/inventario/articuloByDescription',
			data: {
				descripcion: $('#descripcion-producto').val()
			},
			dataType: 'json'
		})
			.done(function (data) {
				fn_mostrarArticulos(data);
				console.log(data);
			})
			.fail(function () {
				console.log('error');
			})
	})

	// Selecciona prenda para agregar
	$(document).on('click', '#list-articles-search>tr', function (evt, el) {
		$(this).toggleClass('selected');
		$('#list-articles-search > tr').not($(this)).removeClass('selected');
	});

	// Agregar prenda
	$(document).on('click', 'div>a.btn-add-article', function () {
		// Validar que no se encuentre agregado la prenda
		let codigo = $(this).closest('tr').find('td').eq(0).text();
		let salir = false;
		saleDetails.forEach(function (e, i) {
			if (e.codigo === codigo) {
				swal('', 'El codigo ya ha sido ingresado', 'warning');
				salir = true;
				return;
			}
		})
		if (salir) return;
		item = new SaleDetail();
		item.id = $(this).closest('tr').find('td').eq(0).data('id');
		item.codigo = codigo;
		item.nombre = $(this).closest('tr').find('td').eq(1).text();
		item.descripcion = $(this).closest('tr').find('td').eq(2).text();
		item.categoriaId = $(this).closest('tr').find('td').eq(3).data('categoria-id');
		item.categoria = $(this).closest('tr').find('td').eq(3).text();
		item.estado = $(this).closest('tr').find('td').eq(4).data('estado-id');
		item.estadoId = $(this).closest('tr').find('td').eq(4).text();
		item.cantidad = 1;
		item.precio = Number($(this).closest('tr').find('td').eq(5).text());
		item.precioAlquiler = $(this).closest('tr').find('td').eq(5).text();
		fn_AgregarArticulo(item);
		fn_Enumerar();
		fn_CalcularTotal();
		$('#modal-search-article2').modal('hide');
	});

	$('#btn-add-article').on('click', function (evt) {
		evt.preventDefault();
		console.log('agregar');
		// Validar que no se encuentre agregado la prenda
		fn_Agregar($('#list-articles-search>tr.selected'));
	});

	$('#btn-add-article-full').on('click', function (evt) {
		evt.preventDefault();
		let codigo = $('#codigoArticulo').val().trim();
		if (codigo.length < 11) return;

		var pet = $.ajax({
			method: 'POST',
			url: '/inventario/articuloByCode',
			data: {
				articuloCode: codigo
			},
			//content: 'application/json; charset=utf-8',
			dataType: 'json'
		})
		pet.done(function (data) {
			if (data) {
				console.log(data);
				// Validar que no se encuentre agregado la prenda
				let estadoId = data[0].estadoId;
				// console.log(estadoId);
				if (estadoId > 1) {
					swal('', 'El código ingresado no esta disponible', 'warning');
					return;
				}
				// let codigo = $(el).find('td').eq(0).text();

				// Validar que el codigo no se haya agregado
				let salir = false;
				saleDetails.forEach(function (e, i) {
					if (e.codigo === codigo) {
						swal('', 'El codigo ya ha sido ingresado', 'warning');
						salir = true;
						return;
					}
				})
				let article = data[0];
				if (salir) return;
				item = new SaleDetail();
				item.id = article.articuloId;
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

				fn_AgregarArticulo(item);
				fn_Enumerar();
				fn_CalcularTotal();
				$('#modal-search-article2').modal('hide');
				$('#codigoArticulo').val('');
			} else {
				swal('', 'El código ingresado no existe', '');
			}
		})
		pet.fail(function (xhr) {
			console.log('ERROR AL BUSCAR UN CODIGO DE PRODUCTO')
		});

		// .done(function (data) {
		// 	fn_mostrarArticulos(data);
		// 	console.log(data);
		// })
		// .fail(function () {
		// 	console.log('error');
		// })
	});

	function fn_Agregar(el) {
		// Validar que no se encuentre agregado la prenda
		let codigo = $(el).find('td').eq(0).text();
		let salir = false;
		saleDetails.forEach(function (e, i) {
			if (e.codigo === codigo) {
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

	document.getElementById('codigoArticulo').addEventListener('keyup', function (evt) {
		this.value = this.value.toUpperCase();
	})
	document.getElementById('codigoArticulo').addEventListener('keypress', function (evt) {
		// evt.preventDefault();
		var code = (evt.keyCode ? evt.keyCode : evt.which);
		if (code == 13) {
			if ($(this).val().length >= 4) {
				// let codigo = $(this).val().substring(0, 4) + zfill(Number($(this).val().substring(4, 15)), 7);
				let codigo = fn_CompletarCodigo($(this).val());
				$(this).val(codigo);
				// $('#btn-add-article-full').trigger('click');
			}
		}		
	})
	document.getElementById('codigoArticulo').addEventListener('blur', function (evt) {
		evt.preventDefault();
		// Obtener la texto y luego la parte numerica
		if ($(this).val().length >= 4) {
			// let codigo = $(this).val().substring(0, 4) + zfill(Number($(this).val().substring(4, 15)), 7);
			let codigo = fn_CompletarCodigo($(this).val());
			$(this).val(codigo);
		}
	})

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

	// $('#codigoArticulo').on('blur', (evt) => {
	//     let codigo = substr($(this).val(),0,4)+'-'+substr($(this).val(),4,15);
	//     $(this).val(codigo);
	// })

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
		// console.log(evt);
		// Actualizar el precio del array
		let codigo = $(this).closest('tr').find('td').eq(1).text();
		let idx = 0;
		saleDetails.forEach(function (e, i) {
			if (e.codigo === codigo) idx = i;
		});
		saleDetails[idx].precio = Number($(this).val());
		console.log(saleDetails);
		fn_CalcularTotal();
	})

	$('#totalEfectivo').on('keyup', function () {
		fn_CalcularTotal();
	})
	$('#totalVuelto').on('keyup', function () {
		fn_CalcularTotal();
	})

	$('#btn-add-tarjeta').on('click', function () {
		console.log('tarjeta');
		let tipoTarjetaId = $('#tipoTarjeta').val();
		let tipoTarjeta = $('#tipoTarjeta>option:selected').text();
		let nroTarjeta = $('#nroTarjeta').val();
		let montoTarjeta = Number($('#montoTarjeta').val());
		console.log(montoTarjeta);
		if (montoTarjeta <= 0) {
			swal('', 'Ingrese un monto mayor a 0.', '');
			return;
		}

		let tr;
		tr = $('<tr>');
		tr.append($('<td>').text(tipoTarjeta).data('tipo-tarjeta', tipoTarjetaId));
		tr.append($('<td>').text(nroTarjeta));
		tr.append($('<td>').text(montoTarjeta));
		tr.append($('<td>').html("<button class='btn btn-xs btn-danger btn-remove-tarjeta'><i class='fa fa-trash'></i></button>"));
		console.log(tr);
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

	function fn_CalcularTotalTarjeta() {
		// Calcular el total tarjetas
		let totalTarjeta = 0;
		$('#tbl-tarjetas>tr').each(function (i, e) {
			totalTarjeta += Number($(e).find('td').eq(2).text());
		})
		$('#totalTarjeta').val(totalTarjeta.toFixed(2));
		fn_CalcularTotal();
	}

	$('#nroDocumento').on('blur', function (evt) {
		evt.preventDefault();
		// Obtener los datos del cliente
		if ($(this).val().length >= 8) {
			$.ajax({
				type: 'POST',
				url: '/ventas/obtenerClienteByNumero',
				data: { numero: $('#nroDocumento').val() },
				beforeSend: Call_Progress(true),
				// contentType: 'application/json; charset=utf-8'
				dataType: 'json'
			})
				.done(function (data) {					
					fn_LimpiarCliente();
					if (data.length > 0) {
						let cliente = data[0];
						// Limpiar cliente
						$('#tipoDocumento').val(cliente.tipo_documento);
						$('#nroDocumento').data('cliente-id', cliente.clienteId);
						$('#nombres').val(cliente.nombres);
						$('#apellidos').val(cliente.apellido_paterno);
						$('#telefono').val(cliente.telefono);
						$('#direccion').val(cliente.direccion);
						$('#email').val(cliente.email);
						$('#observaciones').val(cliente.observaciones);
					}
					// console.log(data);
				})
				.fail(function (xhr) {
					console.log('error');
				})
				.always(function () {
					Call_Progress(false);
				})
		}
	});

	$('#btn-reniec').on('click', function () {
		myPopup('https://portaladminusuarios.reniec.gob.pe/validacionweb/index.html#no-back-button', '', 500, 500);
	})

	// En las peticiones ajax agregar el efecto de cargando

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
		tr = $('<tr>');
		tr.append($('<td>').text(0));
		tr.append($('<td>').text(item.codigo).data('id', item.id));
		tr.append($('<td>').text(item.nombre));
		tr.append($('<td>').text(item.categoria).data('categoria-id', item.categoriaId));
		// tr.append($('<td>').text(item.cantidad));
		input = $('<input type=number>').prop('name', 'precio-item').addClass('form-control txt-precio-item').val(Number(item.precio));
		tr.append($('<td>').append(input).data('precio-alquiler', item.precioAlquiler));
		//<a href="#" class="btn btn-primary btn-sm btn-show-detail-article"><i class="icon icon-search4"></i>
		a = $('<a>').addClass('btn btn-primary btn-sm btn-show-detail-article').prop('href', '#').html("<i class='icon icon-search4'></i>");
		div = $('<div>').append(a).append('&nbsp;');
		a = $('<a>').addClass('btn btn-danger btn-sm btn-remove-article').prop('href', '#').html("<i class='icon icon-bin'></i>");
		div.append(a);
		tr.append($('<td>').addClass('center').append(div));
		$('#tbl-detail-sale').append(tr);
		//console.log(item);
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
				maxDays: 10
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

	var validateCustomer = $('#form-customer-add').validate({
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

	// Registrar el comprobante
	// Primero se registra el cliente
	// Traer los datos del cliente en caso ya exista
	// Validar numero en campo DNI
	// Obtener la lista de vendedores
	// Cargar usuarios vendedores

	$('#btn-register-sale').on('click', function (evt) {
		evt.preventDefault();
		let isValidSale;
		let isValidCustomer;
		isValidSale = $('#form-sale-add').valid();
		isValidCustomer = $('#form-customer-add').valid();

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
		// Obtener el detalle

		console.log(customer);
		console.log(sale);
		console.log(saleDetails);
		console.log(salePayments);

		sale.customer = customer;
		//console.log(formData);
		//return;
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

				if (data > 0) {
					var pr = fn_ImprimirTicket(sale);
					pr.done(function (data) {
						console.log('Imprimiendo ticket');
					})
					$('#msg-debug').html(data);
					fn_LimpiarFactura();
					fn_ObtenerNroVenta();
				}

				// $.when(print).then(function() {
				// 	console.log('Imprimir ticket');
				// })

				// window.location.href = '/ventas/listar';
				// let json = JSON.parse(data)
			})
			.fail(function (xhr) {
				console.log('ERROR AL REGISTRAR LA VENTA');
			})
			.always(function () {
				beforeSend: Call_Progress(false);
			})

	})

	$('#btn-new-sale').on('click', function (evt) {
		fn_ObtenerNroVenta();
		fn_LimpiarFactura();
		validateSale.resetForm();
		validateCustomer.resetForm();
	})
	

	function fn_GenerarVenta() {
		let sale = new Sale();
		// let fecha = $('#fechaSalida').val();
		// fecha = new Date(Number(fecha.substring(6, 10)), Number(fecha.substring(3, 5)) - 1, fecha.substring(0, 2)); 
		// console.log(fecha.toISOString())
		sale.ventaId = Number($('#nroOperacion').val()); // Se obtendra al registrar
		sale.clienteId = $('#nroDocumento').data('cliente-id'); // en caso sea nuevo se obtendra despues
		sale.vendedorId = $('#vendedor').val(); 	//se optendra de la session
		sale.tiendaId = $('#tienda').val();
		sale.tipoId = 1; // 1: Alquiler y 2: Venta
		let fecha = new Date();
		sale.fecha = fecha.toISOString();
		sale.fechaSalida = fn_GetDate($('#fechaSalida').val()).toISOString();
		sale.fechaDevolucion = fn_GetDate($('#fechaDevolucion').val()).toISOString();
		sale.etapaId = 0;
		sale.estadoId = $('#estado').val();
		sale.precioTotal = Number($('#totalGeneral').val());
		sale.totalEfectivo = Number($('#totalEfectivo').val());
		sale.totalTarjeta = Number($('#totalTarjeta').val());
		sale.totalVuelto = Number($('#totalVuelto').val());
		sale.totalPagado = Number($('#totalPagado').val());
		sale.totalSaldo = Number($('#totalSaldo').val());
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
			payment.tipoPagoId = 1;
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
		$('#fechaSalida').val('');
		$('#fechaDevolucion').val('');
		$('#tbl-detail-sale').html('');

		fn_LimpiarCliente();
		fn_LimpiarPago();

		sale = {};
		saleDetails = [];
		salePayments = [];
		customer = {};
	}
	function fn_LimpiarCliente() {
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
		let sinPrecio = false;;
		$('#tbl-detail-sale > tr').each(function (i, e) {
			if (!Number($(e).eq(0).find('input.txt-precio-item').val())) {
				sinPrecio = true;
				return
			}
		});
		return $('#tbl-detail-sale>tr').length && !sinPrecio;
	}


	// Ver información del cliente
	$('#btn-show-modal-customer').on('click', function (e) {
		e.preventDefault();
	})

})


function fn_ImprimirTicket(ticket) {
	return $.ajax({
		method: 'POST',
		url: 'http://localhost:8080/printer/imprimir-ticket.php',
		data: { ticket: JSON.stringify(ticket) }
	})
}
fn_ImprimirTicket();
// })();


function fn_GetDate(strFecha) {
	return new Date(Number(strFecha.substring(6, 10)), Number(strFecha.substring(3, 5)) - 1, strFecha.substring(0, 2));
}

function myPopup(myURL, title, myWidth, myHeight) {
	var left = (screen.width - myWidth) / 2;
	var top = (screen.height - myHeight) / 4;
	var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
}
