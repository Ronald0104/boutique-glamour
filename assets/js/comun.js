// Variables de Session:
let usuarioId;
let rolId;
let tiendas = [];
let tiendaSel;
let usuario = {};

let pet;

// Namespace 
var App = App || {};
App.Comun = {};
App.Producto = {};
App.Venta = {};
App.Compra = {};


$(document).ready(function () {
	
	// API para seleccionar elementos de una tabla
	$(document).on('mousedown', 'table[data-select="true"]>tbody>tr', function () {
		$(this).addClass('selected');
		$(this).closest('tbody').find('tr').not($(this)).removeClass('selected');	
	})
	$(document).on('click', 'table[data-select="true"]>tbody>tr', function () {
		$(this).addClass('selected');
		$(this).closest('tbody').find('tr').not($(this)).removeClass('selected');
	})
	$(document).on('focus', 'table[data-select="true"]>tbody>tr', function () {
		$(this).addClass('selected');
		$(this).closest('tbody').find('tr').not($(this)).removeClass('selected');
	})

	// Para navegacion general con las teclas en cualquier tabla
	// $(document).on('keydown', 'table[data-navigator="true"]', function (evt) {
	// 	var current = $(this).find('tr.selected');
	// 	var c;
	// 	if (evt.which == 38) {
	// 		c = current.prev();
	// 	}
	// 	else if (evt.which == 40) {
	// 		c = current.next();
	// 	}
	// 	if (c != undefined) {
	// 		if (c.length > 0) {
	// 			current = c
	// 			current.addClass('selected');
	// 			$(this).find('tbody>tr').not(current).removeClass('selected');
	// 			current.focus();
	// 		}
	// 	}

	// });
	// API para navegar con el teclado en una tabla
	$(document).on('keydown', 'table[data-navigator="true"]>tbody>tr', function (evt) {
		let keyCode = evt.which;
		let current = $(this).closest('tbody').find('tr.selected');
		let c;
		if (keyCode == 38)
			c = current.prev();
		else if (keyCode == 40)
			c = current.next();

		if (c != undefined) {
			if (c.length > 0) {
				current = c;
				current.addClass('selected');
				$(this).closest('tbody').find('tr').not(current).removeClass('selected');
				current.focus();
			}
		}
	})	

	$.datepicker.setDefaults($.datepicker.regional["es"]);
	$.datepicker.formatDate('yy/mm/dd');
	$('#fechaSalidaConsulta').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: '0',
		maxDate: '+30D'
	});
	$('#fechaDevolucionConsulta').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: '0',
		maxDate: '+30D'
	});

	$('li.nav-item>a.sidebar-control').trigger('click');

	// Cargar los modales 
	// Modal tiendas
	// $.ajax({
	// 	method: 'POST',
	// 	url: '/Tienda/getModalTiendas'
	// })
	// 	.done(function (d) {
	// 		$('#modal-select-tienda').html(d);
	// 		// window.location.reload();
	// 	})
	// 	.fail(function (xhr) {
	// 		console.log("Error");
	// 	})

	// Modal atender reserva
	$.ajax({
		method: 'POST',
		url: '/Ventas/getModalReserva'
	})
		.done(function (d) {
			$('#modal-atender-reserva').html(d);
		})
		.fail(function (xhr) {
			console.log("Error");
		})

	// // Modal atender alquiler	
	// $.ajax({
	// 	method: 'POST',
	// 	url: '/Ventas/getModalAlquiler'
	// })
	// 	.done(function (d) {
	// 		$('#modal-atender-alquiler').html(d);
	// 	})
	// 	.fail(function (xhr) {
	// 		console.log("Error");
	// 	})

	// Cargar variables de sesion
	// pet = $.when(fn_ObtenerSession, fn_CargarTiendas);
	pet = $.when(a, b);
	pet.done(function (r1, r2) {
		r1 = r1[0];
		r2 = r2[0];

		// Cargar usuario
		usuario = r1;
		usuarioId = r1.usuario_id;
		rolId = r1.rol_id;
		tiendaSel = r1.tienda_sel;
		tiendas = r1.tiendas;

		r1.tiendas.forEach(function (e, i) {
			if (e.tiendaId == tiendaSel) {
				tiendaSel = e;
				// Almacenarlo en el local storage
			}
		})

		// Cargar tiendas
		$('#modal-select-tienda').html(r2);

		// Seleccionar la tienda
		$('#btn-show-tiendas').text(tiendaSel.tienda);
		$('#btn-show-tiendas').data('tienda', tiendaSel.tiendaId);
		$('ul#list-tiendas>li.list-group-item').each(function (i, e) {
			if ($(e).find('a').data('tienda') == tiendaSel.tiendaId) {
				$(e).addClass('selected');
				$('ul#list-tiendas>li.list-group-item').not($(e)).removeClass('selected');
			}
		});
	});
	pet.fail(function () {
		console.log("Error al obtener la sesión");
	})

	$('#btn-show-tiendas').on('click', function (evt) {
		$('#modal-select-tienda').modal('show');
	});
	$(document).on('click', 'ul#list-tiendas>li.list-group-item', function (e) {
		e.preventDefault();
		$(this).toggleClass('selected');
		$('ul#list-tiendas>li.list-group-item').not($(this)).removeClass('selected');
	})
	$(document).on('click', 'ul#list-tiendas>li.list-group-item>a', function(evt) {
		let tiendaId = $(this).data('tienda');
		let tienda = $(this).text();
		
		let objTienda = { tiendaId : tiendaId, tienda : tienda}
		fn_CambiarTienda(objTienda, 
			function(tienda) {
				$('#btn-show-tiendas').text(tienda.tienda).data('tienda', tienda.tiendaId);
				$('#modal-select-tienda').modal('hide');
			}, 
			function(tienda) {
				console.log(tienda);
				fn_ActualizarPagina(tienda);
			}
		);
	});
	$(document).on('click', '#btn-select-tienda', function (e) {
		let tiendaId = $('#list-tiendas>li.list-group-item.selected>a').data('tienda');
		let tienda = $('#list-tiendas>li.list-group-item.selected>a').text();
		
		let objTienda = { tiendaId : tiendaId, tienda : tienda}
		fn_CambiarTienda(objTienda, 
			function(tienda) {
				$('#btn-show-tiendas').text(tienda.tienda).data('tienda', tienda.tiendaId);
				$('#modal-select-tienda').modal('hide');
			}, 
			function(tienda) {
				fn_ActualizarPagina(tienda);
			}
		);
	});

	$('#btn-mostrar-atender-reserva').on('click', function (e) {
		$('#modal-atender-reserva').modal('show');
	})
	$('#btn-mostrar-atender-alquiler').on('click', function (e) {
		$('#modal-atender-alquiler').modal('show');
	})
	
	// Reservas
	$(document).on('click', '#btn-buscar-reserva', function (e) {
		e.preventDefault();
		let dni = $('#nroDocumentoConsulta').val();
		// console.log(dni);        
		fn_LimpiarAtenderReserva();
		fn_BuscarReserva(dni);
	});
	$(document).on('click', '#btn-atender-reserva', function (e) {
		// Validar que todo este checkeado
		$('#tbl-detail-sale-consulta > tr').each(function (i, e) {
			let chk = $(e).find('td').eq(5).find('input').prop('checked');
			if (!chk) {
				swal('', 'Debe marcar todas las prendas para atender la reserva.', 'success');
				return;
			}
		})

		let codigoReserva = $('#codigoReservaConsulta').data('venta-id');
		fn_AtenderReserva(codigoReserva);
	})
	$(document).on('shown.bs.modal', '#modal-atender-reserva', function () {
		$('#codigoArticuloBuscar').trigger('focus');
	})
	$(document).on('keypress', '#codigoArticuloBuscar', function (evt) {
		// console.log($(this).val())		
		// console.log(evt.keyCode);
		if (evt.keyCode == 13) {
			let codigoArticulo = $(this).val();
			console.log(codigoArticulo);
			$('#tbl-detail-sale-consulta>tr').each(function (i, e) {
				console.log($(e).find('td').eq(1).text());
				if ($(e).find('td').eq(1).text() == codigoArticulo) {
					$(e).find('td').eq(5).find('input[type=checkbox]').prop('checked', 'checked')
				}
			})
			$(this).val('');
		}
	})

})

// Obtener datos de session y guardarlo en el local storage
// function fn_ObtenerSession() {
var a = $.ajax({
	method: 'POST',
	url: '/admin/obtenerUsuario',
	dataType: 'json'
});
// .done(function (d) {
// 	console.log(d);
// 	usuarioId = d.usuario_id;
// 	rolId = d.rol_id;
// 	if (Success != undefined && typeof Success == "function")
// 		Success();
// })
// .fail(function (xhr) {
// 	console.log("Error");
// })
// }

// Cargar Tiendas
// function fn_CargarTiendas() {
var b = $.ajax({
	method: 'POST',
	url: '/Tienda/getModalTiendas'
});
// }

// Buscar Venta
function fn_BuscarVentaById(ventaId, Success) {
	$.ajax({
		method: 'POST',
		url: '/ventas/obtenerVentaById',
		data: { ventaId: ventaId },
		dataType: 'json',
		beforeSend: Call_Progress(true)
	})
		.done(function (d) {
			console.log(d);
			if (Success != undefined && typeof Success == "function")
				Success(d);
		})
		.fail(function () {
			console.log('Error');
		})
		.always(function () {
			Call_Progress(false);
		})
}

// Reservas
function fn_BuscarReserva(dni) {
	$.ajax({
		method: 'POST',
		url: '/ventas/obtenerReserva',
		data: { dni: dni },
		beforeSend: Call_Progress(true)
	})
		.done(function (d) {
			let datos = JSON.parse(d);
			console.log(datos);
			if (datos.length == 0) {
				swal('', 'No se ha encontrado ninguna reserva a su nombre', 'info');
				return;
			}
			let cliente = datos.cliente[0];
			let reserva = datos.reserva[0];
			console.log(JSON.parse(d));

			// Datos cliente
			$('#nroDocumentoConsulta').val(cliente.nro_documento);
			$('#nombresConsulta').val(cliente.nombres + ' ' + cliente.apellido_paterno + ' ' + cliente.apellido_materno);

			// Datos Reserva
			$('#codigoReservaConsulta').val(reserva.codigoVentaId).data('venta-id', reserva.ventaId);
			$('#vendedorConsulta').val(reserva.vendedor).data('vendedor-id', reserva.vendedorId);
			$('#tiendaConsulta').val(reserva.tienda).data('tienda-id', reserva.tiendaId);
			$('#importeConsulta').val(reserva.precioTotal);
			let fechaSalida = new Date(reserva.fechaSalidaProgramada);
			let fechaDevolucion = new Date(reserva.fechaDevolucionProgramada);
			console.log(getFormatDate(fechaSalida));
			$('#fechaSalidaConsulta').val(getFormatDate(fechaSalida));
			$('#fechaDevolucionConsulta').val(getFormatDate(fechaDevolucion));

			// Datos detalle reserva
			let tr, td;
			let tbody = $('#tbl-detail-sale-consulta');
			let reserva_detalle = datos.reserva[0].detalle;
			reserva_detalle.forEach(function (el, i) {
				tr = $('<tr>');
				tr.append($('<td>').text(++i));
				tr.append($('<td>').text(el.articuloCode).data('articulo-id', el.articuloId));
				tr.append($('<td>').text(el.articuloNombre));
				tr.append($('<td>').text(""));
				tr.append($('<td>').text(el.precioVenta));
				td = $('<td>').html("<input type='checkbox' name='' class='form-control chkValidar' style='width:21px'>")
				tr.append(td);
				tbody.append(tr);
			});

		})
		.fail(function () {
			console.log('Error');
		})
		.always(function () {
			Call_Progress(false);
		})
}
function fn_MostrarReserva(reserva) {
	// Datos cliente
	$('#nroDocumentoConsulta').val(reserva.cliente_sel.nro_documento);
	$('#nombresConsulta').val(reserva.cliente_sel.nombres + ' ' + reserva.cliente_sel.apellido_paterno + ' ' + reserva.cliente_sel.apellido_materno);

	// Datos Reserva
	$('#codigoReservaConsulta').val(reserva.codigoVentaId).data('venta-id', reserva.ventaId);
	$('#vendedorConsulta').val(reserva.vendedor).data('vendedor-id', reserva.vendedorId);
	$('#tiendaConsulta').val(reserva.tienda).data('tienda-id', reserva.tiendaId);
	$('#importeConsulta').val(reserva.precioTotal);
	let fechaSalida = new Date(reserva.fechaSalidaProgramada);
	let fechaDevolucion = new Date(reserva.fechaDevolucionProgramada);
	console.log(getFormatDate(fechaSalida));
	$('#fechaSalidaConsulta').val(getFormatDate(fechaSalida));
	$('#fechaDevolucionConsulta').val(getFormatDate(fechaDevolucion));

	// Datos detalle reserva
	let tr, td;
	let tbody = $('#tbl-detail-sale-consulta');
	let reserva_detalle = reserva.detalle;
	reserva_detalle.forEach(function (el, i) {
		tr = $('<tr>');
		tr.append($('<td>').text(++i));
		tr.append($('<td>').text(el.articuloCode).data('articulo-id', el.articuloId));
		tr.append($('<td>').text(el.articuloNombre));
		tr.append($('<td>').text(""));
		tr.append($('<td>').text(el.precioVenta));
		td = $('<td>').html("<input type='checkbox' name='' class='form-control chkValidar' style='width:21px'>")
		tr.append(td);
		tbody.append(tr);
	});
}
function fn_LimpiarAtenderReserva() {
	$('#nroDocumentoConsulta').val('');
	$('#nombresConsulta').val('');
	$('#codigoReservaConsulta').val('').data('venta-id', 0);
	$('#vendedorConsulta').val('').data('vendedor-id', 0);
	$('#tiendaConsulta').val('').data('tienda-id', 0);
	$('#importeConsulta').val('');
	$('#fechaSalidaConsulta').val('');
	$('#fechaDevolucionConsulta').val('');
	$('#tbl-detail-sale-consulta').html('');
}
function fn_AtenderReserva(codigoReserva) {
	$.ajax({
		method: 'POST',
		url: '/Ventas/AtenderReserva',
		data: { ventaId: codigoReserva },
		beforeSend: Call_Progress(true)
	})
		.done(function (d) {
			console.log(d);
			fn_LimpiarAtenderReserva();
			swal('', 'Reserva Atendida', 'success');
			$('#modal-atender-reserva').modal('hide');
		})
		.fail(function () {
		})
		.always(function () {
			Call_Progress(false);
		})
}

var pathUrl;
function InicializarVariables() {
}


/*** MODALES ***/

// Obtener el modal para devolver una venta
function fn_ObtenerModalVentaDevolucion(func) {
	if (!$('#m-sale-return').data('load')) {
		$.ajax({
			method: 'POST',
			url: '/ventas/getModalDevolucion',
			beforeSend: Call_Progress(true)
		})
			.done(function (data) {
				$('#m-sale-return').html(data);
				$('#m-sale-return').data('load', true)
				if (func != undefined && typeof func == "function") func();
			})
			.fail(function (jqXHR) { 
				console.log(jqXHR.responseJson);
			})
			.always(function () {
				Call_Progress(false);
			})
	}
	else {
		if (func != undefined && typeof func == "function") func();
	}
}

// Obtener el modal de calendario de reservas
function fn_ObtenerModalCalendar(func) {
	if (!$('#modal-calendar').html()) {
		$.ajax({
			method: 'POST',
			url: '/ventas/getModalCalendar',
			beforeSend: Call_Progress(true)
		})
			.done(function (data) {
				$('#m-show-calendar-reserves').html(data);
				// $('#modal-calender').modal('show');
				// $('#calendar-reserva').datepicker();
				if (func != undefined && typeof func == "function") func();
			})
			.fail(function (jqXHR) { 
				console.log(jqXHR.responseText);
			})
			.always(function () {
				Call_Progress(false);
			})
	} else {
		if (funLoad != undefined && typeof funLoad == "function")
			func();
	}

}

// Obtener el modal para registrar cliente
function fn_ObtenerModalRegistrarCliente(funLoad) {
	if (!$('#m-register-customer').data('load')) {
		$.ajax({
			method: 'POST',
			url: '/cliente/getModalCliente',
			beforeSend: Call_Progress(true)
		})
			.done(function (data) {
				$('#m-register-customer').html(data);
				$('#m-register-customer').data('load', true)
				if (funLoad != undefined && typeof funLoad == "function") funLoad();
			})
			.fail(function () { })
			.always(function () {
				Call_Progress(false);
			})
	}
	else {
		if (funLoad != undefined && typeof funLoad == "function") funLoad();
	}
}

// Obtener el modal para registrar compras
function fn_ObtenerModalRegistraCompra(Success) {
	if(!$('#m-register-purchase').html()){
		$.ajax({
			method: 'POST',
			url: '/compras/modalRegistrar',
			beforeSend: Call_Progress(true)
		})
		.done(function(data) {
			// console.log(data);
			$('#m-register-purchase').html(data);
			$('#m-register-purchase').data('load', true);
			if (Success != undefined && typeof Success == "function") Success();
		})
		.fail(function(jqXHR, textStatus) {
			console.log(jqXHR.responseText);
		})
		.always(function() {
			Call_Progress(false);
		})
	} else {
		if (Success != undefined && typeof Success == "function") Success();
	}
}

// Obtener el modal para registrar ventas
function fn_ObtenerModalRegistrarVenta(success) {
	if(!$('#m-register-sale').html()){
		$.ajax({
			method: 'POST',
			url: '/ventas/modalRegistrar',
			beforeSend: Call_Progress(true)
		})
		.done(function(data) {
			$('#m-register-sale').html(data);
			$('#m-register-sale').data('load', true);
			if (success != undefined && typeof success == "function") success();
		})
		.fail(function(jqXHR, textStatus) {
			console.log(jqXHR.responseText);
		})
		.always(function() {
			Call_Progress(false);
		})
	} else {
		if (success != undefined && typeof success == "function") success();
	}
}

// Obtener el modal para registrar productos
function fn_ObtenerModalRegistrarArticulo(success, showModal = true) {
    if($('#m-register-article').html().trim() == "") {
        $.ajax({
            method: 'POST',
            url: '/inventario/articuloAgregar',
            beforeSend: Call_Progress(true)
        })
        .done(function(data){
			$('#m-register-article').html(data);
			$('#m-register-article').data('load', true);
            if (success != undefined && typeof success == "function") success();
            if (showModal) $('#modal-article-add').modal('show');
        })
        .fail(function(jqXHR) { 
			console.log(jqXHR.responseText)})
        .always(function() {
			Call_Progress(false)
		})
    } 
    else {
        if (success != undefined && typeof success == "function") success();
        if (showModal) $('#modal-article-add').modal('show');
    }          
}

function fn_CambiarTienda(tienda, Preview, Success) {
	if (Preview != undefined && typeof Preview == "function") Preview(tienda);

	// Peticion Ajax para actualizar la tienda en la session del usuario
	$.ajax({
		method: 'POST',
		url: '/admin/cambiarTienda',
		data: {tiendaId : tienda.tiendaId}
	})
	.done(function(data) {
		window.tiendaSel = tienda.tiendaId;
		usuario.tienda_sel = tienda.tiendaId;
		usuario.tienda_sel_nombre = tienda.tienda;
		if (Success != undefined && typeof Success == "function") Success(tienda);
	})
	.fail(function(jqXHR){
		console.log('Error al seleccionar la tienda');
		console.log(jqXHR.responseText);
	})
}

function fn_ActualizarPagina(tienda) {
	switch (window.location.pathname.trim()) {
		case "/ventas/liquidacion":
			// Actualizar la pagina de liquidación
			$('#liqTiendaId').val(tienda.tiendaId);
			$('#liqTienda').val(tienda.tienda);
			$('#liqBuscar').trigger('click');
			break;
	
		default:
			break;
	}
}


App.Comun.fn_ListarTallasxCategoria2 = function (categoriaId, success) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarTallasxCategoria',
        data: { categoriaId : categoriaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {        
		if (success != undefined && typeof success == "function") success(data);
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}

App.Comun.fn_ListarColoresxCategoria2 = function (categoriaId, success) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarColoresxCategoria',
        data: { categoriaId : categoriaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
        if (success != undefined && typeof success == "function") success(data);
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}

App.Comun.fn_ListarDisenosxCategoria2 = function(categoriaId, success) {
    $.ajax({
        method: 'POST',
        url: '/inventario/listarDisenosxCategoria',
        data: { categoriaId : categoriaId},
        beforeSend: Call_Progress(true)
    })
    .done(function(data) {
		if (success != undefined && typeof success == "function") success(data);
    })
    .fail(function(jqXHR){
        console.log(jqXHR.responseText);
    })
    .always(function(){
        Call_Progress(false)
    })
}