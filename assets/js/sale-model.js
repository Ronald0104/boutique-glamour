// Modelos 
// Venta
function Sale() {
	this.ventaId;
	this.vendedorId;
	this.tiendaId;
	this.clienteId;
	this.fecha;
	this.fechaRegistro;
	this.fechaSalida;
	this.fechaDevolucion;
	this.tipoId; 		// 1 Alquiler y 2 Venta
	this.etapaId;		// Etapa: 1: Trabajo, 2: Abierto, 3: Historico
	this.estadoId;		// 1: Reserva, 2: alquiler, 3: devolucion, 4: Venta
	this.clienteNro;
	this.clienteNombres;
	this.observaciones;
	this.dejoDocumento;
	this.dejoRecibo;
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
	this.ventaId;
	this.item;
	this.articuloId;
	this.codigo;
	this.nombre;
	this.descripcion;
	this.categoriaId;
	this.categoria;
	this.estadoId;
	this.estado;
	this.precio;
	this.precioAlquiler;
	this.precioAnterior;
	this.cantidad;
    this.tipo;
    this.accion; // 1: actualizado, 2: ingresado, 3: eliminado
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