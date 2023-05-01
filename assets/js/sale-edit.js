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


$(function() {

    // Agregar articulos de forma rapida    
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
                let article = data[0];

                // Validar que el codigo no se haya agregado				
                let salir = false;
                $('#tbl-detail-sale>tr').each(function(i, e) {
                    if ($(e).find('td').eq(1).text() === codigo) {
						swal('', 'El codigo ya ha sido ingresado', 'warning');
						salir = true; return;
					}
                })

                // Validar segun la fecha de salida y devolución
                if(!fn_ExisteItemDelete(article.articuloId)){
                    console.log(article.articuloId);
                    if (estadoId > 1) {
                        swal('', 'El código ingresado no esta disponible', 'warning');
                        return;
                    }
                }				

				if (salir) return;
				item = new SaleDetail();
				item.id = Number(article.articuloId);
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
                if(fn_ExisteItemDelete(article.articuloId))
                {
                    item.accion = 1; 
                    fn_QuitarItemDelete(article.articuloId);
                }
                else
                    item.accion = 2; 


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
            if (!fn_ExisteItemDelete(articuloId)){
                let itemDelete = new SaleDetail();
                itemDelete.articuloId = articuloId;
                itemDelete.codigo = $(this).closest('tr').find('td').eq(1).text();
                itemDelete.accion = 3;
                saleDetailsDelete.push(itemDelete);
            }            
        }
        $(this).closest('tr').remove();
        fn_Enumerar();
        fn_CalcularTotal();
    })

    function fn_ExisteItemDelete(articuloId) {
        let existe = false;
        saleDetailsDelete.forEach(function(e, i){
            if(e.articuloId == articuloId){
                existe = true;
                return;                                                    
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
    $('#btn-add-pago').on('click', function () {
		let tipoPagoId = $('#tipoPago').val();
		let tipoPago = $('#tipoPago>option:selected').text();
		let montoPago = Number($('#montoPago').val());
        let nroTarjeta = $('#nroTarjeta').val();
        let fecha = new Date();
        if (!tipoPagoId){
            swal('', 'Seleccione la forma de pago.', '');
			return;
        }
		if (montoPago <= 0) {
			swal('', 'Ingrese un monto mayor a 0.', '');
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
        saleDetails = fn_GeneraDetalle();
		salePayments = fn_GenerarPago();

		formDataCustomer.append('cliente', JSON.stringify(customer));
		formDataCustomer.append('venta', JSON.stringify(sale));
		formDataCustomer.append('venta-detalle', JSON.stringify(saleDetails));
		formDataCustomer.append('venta-pago', JSON.stringify(salePayments));
		// Obtener el detalle

		console.log(customer);
		console.log(sale);
		console.log(saleDetails);
		console.log(salePayments);
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
				}
				// $.when(print).then(function() {
				// 	console.log('Imprimir ticket');
				// })

				window.location.href = '/ventas/editar/'+$('#saleId').val();
			})
			.fail(function (xhr) {
				console.log('ERROR AL ACTUALIZAR LA VENTA');
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
    });
    $(document).on('click', '.btn-item-schedule', function(evt) {
        fn_ObtenerModalCalendar();
    })
})

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
    tr = $('<tr>').data('articulo', item.id).data('tipo', item.tipo).data('accion', item.accion).prop('tabindex', 0);
    tr.append($('<td>').text(0));
    tr.append($('<td>').text(item.codigo).data('id', item.id));
    tr.append($('<td>').text(item.nombre));
    tr.append($('<td>').text(item.precioAlquiler));
    input = $('<input type=number>').prop('name', 'precio-item').addClass('form-control txt-precio-item').val(Number(item.precioAlquiler));
    tr.append($('<td>').append(input));
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
    sale.observaciones = $('#observacionesVenta').val();
    sale.dejoDocumento = Number($('#tieneDocumento').prop('checked'));
    sale.dejoRecibo = Number($('#tieneRecibo').prop('checked'));
    sale.precioTotal = Number($('#totalGeneral').val());
    sale.totalEfectivo = Number($('#totalEfectivo').val());
    sale.totalTarjeta = Number($('#totalTarjeta').val());
    sale.totalVuelto = Number($('#totalVuelto').val());
    sale.totalPagado = Number($('#totalPagado').val());
    sale.totalSaldo = Number($('#totalSaldo').val());
    sale.dejoDocumento = Number($('#dejoDocumento').prop('checked'))
    sale.dejoRecibo = Number($('#dejoRecibo').prop('checked'))
    return sale;
}
function fn_GeneraDetalle() {
    let detail = {};
    let details = [];
    $('#tbl-detail-sale>tr').each(function(i, e) {
        detail = new SaleDetail();
        detail.id = $(e).data('articulo');
        detail.codigo = $(e).find('td').eq(1).text();
        detail.nombre = $(e).find('td').eq(2).text();
        detail.precioAlquiler = Number($(e).find('td').eq(3).text());
        detail.precio = Number($(e).find('td').eq(4).find('input').val());
        detail.accion = $(e).data('accion');
        details.push(detail);
    })

    saleDetailsDelete.forEach(function(e, i) {
        detail = new SaleDetail();
        detail.id = e.articuloId;
        detail.codigo = e.codigo;
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