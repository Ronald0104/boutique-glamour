<div class="modal fade" id="modal-atender-devolucion" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-brown-700 pt-1 pb-1">
                <h4 class="modal-title mt-0">Devolución</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-1">
                <div class="container-fluid">
                    <h5><b>Datos Cliente</b></h5>
                    <div class="card">
                        <div class="card-body inline">
                            <form action="" class="form-horizontal form-body" name="form-buscar-alquiler"
                                id="form-buscar-alquiler">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-5 col-lg-5">
                                                <div class="form-group row">
                                                    <label for="nroDocumentoAlquiler"
                                                        class="col-md-3 col-form-label">DNI: </label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="nroDocumentoAlquiler"
                                                            id="nroDocumentoAlquiler" class="form-control"
                                                            placeholder="Nro. Documento" minlength=8 maxlength=15>

                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-dark" id="btn-buscar-alquiler"><i
                                                                class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-7 col-lg-7">
                                                <div class="form-group row">
                                                    <label for="nombresAlquiler"
                                                        class="col-md-3 col-form-label">Nombres: </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="nombresAlquiler" id="nombresAlquiler"
                                                            class="form-control" placeholder="Nombres" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row" id="lista-operacion-cliente">
                                <div class="col-sm-12 mt-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>N°. Ope.</th>
                                                    <th>Tienda</th>
                                                    <th>Fecha Registro</th>
                                                    <th></th>                                            
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <h5><b>Datos Alquiler</b></h5>
                    <div class="card">
                        <div class="card-body inline">
                            <form action="" class="form-horizontal form-body" name="form-buscar-alquiler"
                                id="form-buscar-alquiler">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group row">
                                                    <label for="codigoAlquiler" class="col-md-3 col-form-label">Cód.
                                                        Reserva: </label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="codigoAlquiler" id="codigoAlquiler"
                                                            class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group row">
                                                    <label for="vendedorAlquiler"
                                                        class="col-md-3 col-form-label">Vendedor: </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="vendedorAlquiler" id="vendedorAlquiler"
                                                            class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group row">
                                                    <label for="tiendaAlquiler" class="col-md-3 col-form-label">Tienda:
                                                    </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="tiendaAlquiler" id="tiendaAlquiler"
                                                            class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group row">
                                                    <label for="importeAlquiler"
                                                        class="col-md-3 col-form-label">Importe: </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="importeAlquiler" id="importeAlquiler"
                                                            class="form-control" placeholder="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group row">
                                                    <label for="fechaSalidaAlquiler"
                                                        class="col-md-3 col-form-label">Fecha Salida: </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="fechaSalidaAlquiler"
                                                            id="fechaSalidaAlquiler" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-6 col-lg-6">
                                                <div class="form-group row">
                                                    <label for="fechaDevolucionAlquiler"
                                                        class="col-md-3 col-form-label">Fecha Devol.: </label>
                                                    <div class="col-sm-9">
                                                        <input type="text" name="fechaDevolucionAlquiler"
                                                            id="fechaDevolucionAlquiler" class="form-control"
                                                            placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h5><b>Detalle Alquiler</b></h5>
                    <div class="form-group">
                        <input type="text" class="form-control" id="codigoArticuloAlquiler"
                            name="codigoArticuloAlquiler" maxlength="11">
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
                            <tbody id="tbl-detail-sale-consulta-alquiler">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary btn-lg" id="btn-atender-alquiler">Devolver</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/sale-return.js"></script>