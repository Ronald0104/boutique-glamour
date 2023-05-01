$(function() {
    // Alquiler
    $(document).on('click', '#btn-buscar-alquiler', function (e) {
        e.preventDefault();
        let dni = $('#nroDocumentoAlquiler').val();
        fn_LimpiarAtenderAlquiler();
        fn_BuscarAlquiler(dni);
    });
    $(document).on('click', '#btn-atender-alquiler', function (e) {
        // Validar que todo este checkeado
        $('#tbl-detail-sale-consulta-alquiler > tr').each(function (i, e) {
            let chk = $(e).find('td').eq(5).find('input').prop('checked');
            if (!chk) {
                swal('', 'Debe marcar todas las prendas para atender el alquiler.', 'success');
                return;
            }
        })    
        let codigoAlquiler = $('#codigoAlquiler').data('venta-id');
        fn_AtenderAlquiler(codigoAlquiler);
    })
    $(document).on('shown.bs.modal', '#modal-atender-alquiler', function () {
        $('#codigoArticuloAlquiler').trigger('focus');
    })    
    $(document).on('keypress', '#codigoArticuloAlquiler', function (evt) {
        if (evt.keyCode == 13) {
            let codigoArticulo = $(this).val();
            // console.log(codigoArticulo);
            $('#tbl-detail-sale-consulta-alquiler>tr').each(function (i, e) {
                console.log($(e).find('td').eq(1).text());
                if ($(e).find('td').eq(1).text() == codigoArticulo) {
                    $(e).find('td').eq(5).find('input[type=checkbox]').prop('checked', 'checked')
                }
            })
            $(this).val('');
        }
    })
})
    
function fn_BuscarAlquiler(dni) {
	$.ajax({
		method: 'POST',
		url: '/ventas/obtenerAlquiler',
		data: { dni: dni },
		beforeSend: Call_Progress(true)
	})
		.done(function (d) {
			let datos = JSON.parse(d);
			// console.log(datos);
			if (datos.length == 0) {
				swal('', 'No se ha encontrado ningún alquiler a su nombre', 'info');
				return;
			}
			let cliente = datos.cliente[0];
			let alquiler = datos.alquiler[0];
			console.log(cliente);
			console.log(alquiler);

			// Datos cliente
			$('#nroDocumentoAlquiler').val(cliente.nro_documento);
			$('#nombresAlquiler').val(cliente.nombres + ' ' + cliente.apellido_paterno + ' ' + cliente.apellido_materno);

			// Datos Alquiler
			$('#codigoAlquiler').val(alquiler.codigoVentaId).data('venta-id', alquiler.ventaId);
			$('#vendedorAlquiler').val(alquiler.vendedor).data('vendedor-id', alquiler.vendedorId);
			$('#tiendaAlquiler').val(alquiler.tienda).data('tienda-id', alquiler.tiendaId);
			$('#importeAlquiler').val(alquiler.precioTotal);
			let fechaSalida = new Date(alquiler.fechaSalidaProgramada);
			let fechaDevolucion = new Date(alquiler.fechaDevolucionProgramada);
			console.log(getFormatDate(fechaSalida));
			$('#fechaSalidaAlquiler').val(getFormatDate(fechaSalida));
			$('#fechaDevolucionAlquiler').val(getFormatDate(fechaDevolucion));

			// Datos detalle alquiler
			let tr, td;
			let tbody = $('#tbl-detail-sale-consulta-alquiler');
			let alquiler_detalle = datos.alquiler[0].detalle;
			alquiler_detalle.forEach(function (el, i) {
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

function fn_MostrarAlquiler(alquiler) {
	// Datos cliente
	$('#nroDocumentoAlquiler').val(alquiler.cliente_sel.nro_documento);
	$('#nombresAlquiler').val(alquiler.cliente_sel.nombres + ' ' + alquiler.cliente_sel.apellido_paterno + ' ' + alquiler.cliente_sel.apellido_materno);

	// Datos Alquiler
	$('#codigoAlquiler').val(alquiler.codigoVentaId).data('venta-id', alquiler.ventaId);
	$('#vendedorAlquiler').val(alquiler.vendedor).data('vendedor-id', alquiler.vendedorId);
	$('#tiendaAlquiler').val(alquiler.tienda).data('tienda-id', alquiler.tiendaId);
	$('#importeAlquiler').val(alquiler.precioTotal);
	let fechaSalida = new Date(alquiler.fechaSalidaProgramada);
	let fechaDevolucion = new Date(alquiler.fechaDevolucionProgramada);
	console.log(getFormatDate(fechaSalida));
	$('#fechaSalidaAlquiler').val(getFormatDate(fechaSalida));
	$('#fechaDevolucionAlquiler').val(getFormatDate(fechaDevolucion));

	// Datos detalle alquiler
	let tr, td;
	let tbody = $('#tbl-detail-sale-consulta-alquiler');
	let alquiler_detalle = alquiler.detalle;
	alquiler_detalle.forEach(function (el, i) {
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

function fn_LimpiarAtenderAlquiler() {
	$('#nroDocumentoAlquiler').val('');
	$('#nombresAlquiler').val('');
	$('#codigoReservaAlquiler').val('').data('venta-id', 0);
	$('#vendedorAlquiler').val('').data('vendedor-id', 0);
	$('#tiendaAlquiler').val('').data('tienda-id', 0);
	$('#importeAlquiler').val('');
	$('#fechaSalidaAlquiler').val('');
	$('#fechaDevolucionAlquiler').val('');
	$('#tbl-detail-sale-consulta-alquiler').html('');
}

function fn_AtenderAlquiler(codigoAlquiler) {
	$.ajax({
		method: 'POST',
		url: '/Ventas/AtenderAlquiler',
		data: { ventaId: codigoAlquiler },
		beforeSend: Call_Progress(true)
	})
		.done(function (d) {
			// console.log(d);
			fn_LimpiarAtenderAlquiler();
			swal('', 'Devolucion exitosa', 'success');
			$('#modal-atender-alquiler').modal('hide');
		})
		.fail(function () {
		})
		.always(function () {
			Call_Progress(false);
		})
}