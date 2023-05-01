<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header bg-indigo-600">
            <h4 class="modal-title">Reservas</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="container-fluid">
                <h5><b>Datos Cliente</b></h5>
                <div class="card">
                    <div class="card-body inline">
                        <form action="" class="form-horizontal form-body" name="form-buscar-reserva" id="form-buscar-reserva">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-5 col-lg-5">
                                            <div class="form-group row">
                                                <label for="nroDocumetoConsulta" class="col-md-4 col-form-label">DNI: </label>
                                                <div class="col-md-6">
                                                    <input type="text" name="nroDocumentoConsulta" id="nroDocumentoConsulta" class="form-control" placeholder="Nro. Documento" minlength=8 maxlength=15>

                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-dark" id="btn-buscar-reserva"><i class="fa fa-search"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-7 col-lg-7">
                                            <div class="form-group row">
                                                <label for="nombres" class="col-md-3 col-form-label">Nombres: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="nombresConsulta" id="nombresConsulta" class="form-control" placeholder="Nombres" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <h5><b>Datos Reserva</b></h5>
                <div class="card">
                    <div class="card-body inline">
                        <form action="" class="form-horizontal form-body" name="form-buscar-reserva" id="form-buscar-reserva">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group row">
                                                <label for="codigoReservaConsulta" class="col-md-3 col-form-label">Cód. Reserva: </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="codigoReservaConsulta" id="codigoReservaConsulta" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group row">
                                                <label for="vendedorCosulta" class="col-md-3 col-form-label">Vendedor: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="vendedorConsulta" id="vendedorConsulta" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group row">
                                                <label for="tiendaConsulta" class="col-md-3 col-form-label">Tienda: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="tiendaConsulta" id="tiendaConsulta" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group row">
                                                <label for="importeConsulta" class="col-md-3 col-form-label">Importe: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="importeConsulta" id="importeConsulta" class="form-control" placeholder="" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group row">
                                                <label for="fechaSalidaConsulta" class="col-md-3 col-form-label">Fecha Salida: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="fechaSalidaConsulta" id="fechaSalidaConsulta" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-6 col-lg-6">
                                            <div class="form-group row">
                                                <label for="fechaDevolucionConsulta" class="col-md-3 col-form-label">Fecha Devol.: </label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="fechaDevolucionConsulta" id="fechaDevolucionConsulta" class="form-control" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <h5><b>Detalle Reserva</b></h5>
                <div class="form-group">
                    <input type="text" class="form-control" id="codigoArticuloBuscar" name="codigoArticuloBuscar" maxlength="11">
                </div>
                <div class="car-body" id="panel-detalle" style="padding-bottom: 10px;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Código</td>
                                <td>Nombre</td>
                                <td>Categoria</td>
                                <td>Precio</td>
                                <!-- <td>Importe</td> -->
                                <td class="center">Opciones</td>
                            </tr>
                        </thead>
                        <tbody id="tbl-detail-sale-consulta">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            <button type="button" class="btn btn-primary" id="btn-atender-reserva">Atender Reserva</button>
        </div>
    </div>
</div>