    <div class="modal fade" id="modal-register-customer" tabindex="-1" role="dialog" aria-labelledby="modelTitleId2"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-indigo-600">
                    <h4 class="modal-title">Registrar Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-2">
                    <div class="container-fluid" style="padding: 0">
                        <!-- <h5><b>Datos Cliente</b></h5> -->
                        <div class="card" style="margin-bottom: 0">
                            <div class="card-body inline">
                                <ul class="nav nav-tabs nav-tabs-top">
                                    <li class="nav-item"><a href="#top-tab-cliente-datos"
                                            class="nav-link font-weight-bold active show" data-toggle="tab">Datos
                                            Cliente</a></li>
                                    <li class="nav-item"><a href="#top-tab-cliente-historial"
                                            class="nav-link font-weight-bold" data-toggle="tab">Historial Cliente</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="top-tab-cliente-datos">
                                        <form action="" class="form-horizontal form-body" name="form-customer-add-full"
                                            id="form-customer-add-full" autocomplete="nope"
                                            enctype="multipart/form-data">
                                            <div class="alert alert-warning" id="form-customer-add-full-error"
                                                style="display: none"><b>¡ERROR!</b> ya existe</div>
                                            <input type="hidden" name="customerId_Add" id="customerId_Add" value="0" />
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="tipoDocumento_Add"
                                                                    class="col-md-4 col-form-label">Tipo Doc.: </label>
                                                                <div class="col-md-8">
                                                                    <select name="tipoDocumento_Add"
                                                                        id="tipoDocumento_Add" class="form-control">
                                                                        <option value="">..Seleccione..</option>
                                                                        <option value="1">DNI</option>
                                                                        <option value="2">Pasaporte</option>
                                                                        <option value="3">RUC</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="nroDocumeto_Add"
                                                                    class="col-md-4 col-form-label">N° DNI: </label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="nroDocumento_Add"
                                                                        id="nroDocumento_Add" class="form-control"
                                                                        placeholder="Nro. Documento" minlength=8
                                                                        maxlength=15>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="nombres_Add"
                                                                    class="col-md-4 col-form-label">Nombres: </label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="nombres_Add"
                                                                        id="nombres_Add" class="form-control"
                                                                        placeholder="Nombres">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="apellidos_Add"
                                                                    class="col-md-4 col-form-label">Apellidos: </label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="apellidos_Add"
                                                                        id="apellidos_Add" class="form-control"
                                                                        placeholder="Apellidos">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="telefono_Add"
                                                                    class="col-sm-4 col-form-label">Teléfono: </label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="telefono_Add"
                                                                        id="telefono_Add" class="form-control"
                                                                        placeholder="Teléfono">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="celular_Add"
                                                                    class="col-sm-4 col-form-label">Celular: </label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="celular_Add"
                                                                        id="celular_Add" class="form-control"
                                                                        placeholder="Celular">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="text-center">
                                                        <img src="/assets/img/img.svg" class="rounded img-fluid mb-2"
                                                            alt="Foto Cliente" title="Foto Cliente"
                                                            id="fotoCliente_Preview" style="border: 1px solid">
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <!-- <form> -->
                                                        <div class="form-group row">
                                                            <!-- <label for="fotoCliente_Add">Foto del cliente</label> -->
                                                            <input type="file" class="form-control-file"
                                                                id="fotoCliente_Add" name="fotoCliente_Add">
                                                        </div>
                                                        <!-- </form> -->
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-sm-7">
                                                            <div class="form-group row">
                                                                <label for="email_Add"
                                                                    class="col-sm-4 col-form-label">Email: </label>
                                                                <div class="col-md-8">
                                                                    <input type="email" name="email_Add" id="email_Add"
                                                                        class="form-control" placeholder="Email">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <div class="form-group row">
                                                                <label for="calificacion"
                                                                    class="col-sm-6 col-form-label">Calificación:
                                                                </label>
                                                                <div class="col-sm-6 pt-1">
                                                                    <div class="text-warning">
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="direccion_Add"
                                                                    class="col-sm-2 col-form-label">Dirección</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" name="direccion_Add"
                                                                        id="direccion_Add" class="form-control"
                                                                        placeholder="Dirección">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <div class="form-group row">
                                                                <label for="observaciones_Add"
                                                                    class="col-sm-2 col-form-label">Observ.: </label>
                                                                <div class="col-sm-10">
                                                                    <textarea name="observaciones_Add"
                                                                        id="observaciones_Add" cols="30" rows="2"
                                                                        class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade active" id="top-tab-cliente-historial">
                                        <!-- <h4>Historial de Clientes</h4> -->
                                        <div class="table-responsive" style="min-width: 200px;">
                                            <table class="table table-bordered" data-navigator="true" data-select="true">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Código</th>
                                                        <th>Fecha</th>
                                                        <th>Tienda</th>
                                                        <th>Operación</th>
                                                        <!-- <td>Estado</td> -->
                                                        <th>Total</th>
                                                        <th>Saldo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tb_historial_cliente">
                                                </tbody>
                                            </table>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Salir</button>
                    <button type="button" class="btn btn-primary btn-lg" id="btn-customer-add">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url();?>assets/js/customer-add.js"></script>