<!-- Modal Registrar Compra-->
<div class="modal fade" id="modal-purchase-add" tabindex="-1" role="dialog" aria-labelledby="modal-purchase-add"
    aria-hidden="true" style="padding-right: 17px;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-600">
                <h5 class="modal-title mt-0"><i class="icon-menu7 mr-2"></i>Registrar Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0.9rem">
                <div class="container-fluid" style="padding: 0">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="card">
                                <div class="card-body inline">
                                    <form action="" method="POST" class="form-horizontal" name="form-purchase-add"
                                        id="form-purchase-add">
                                        <input type="hidden" name="compraId" id="compraId" value="0" />
                                        <!-- <div style="position: absolute; top: 0.85rem; right: 1.2rem;">
                                            <label class="switch ">
                                                <input type="checkbox" class="default" name="estadoArticulo" id="estadoArticulo">
                                                <span class="slider round"></span>
                                            </label>
                                        </div> -->
                                        <ul class="nav nav-tabs nav-tabs-top">
                                            <li class="nav-item"><a href="#top-tab-purchase"
                                                    class="nav-link font-weight-bold active show"
                                                    data-toggle="tab">Datos Compra</a></li>
                                            <li class="nav-item"><a href="#top-tab-purchase-distribution"
                                                    class="nav-link font-weight-bold" data-toggle="tab">Distribución
                                                    Gastos</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="top-tab-purchase">
                                                <div class="alert alert-warning" id="form-purchase-add-error"
                                                    style="display: none"><b>¡ERROR!</b> compra </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="codigoCompra"
                                                                        class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Código:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 col-lg-8 m-0">
                                                                        <input type="text" class="form-control"
                                                                            name="codigoCompra" id="codigoCompra"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="fechaRegistroCompra"
                                                                        class="col-sm-4 col-md-4 col-lg-4 col-form-label">Fecha:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 col-lg-8 m-0">
                                                                        <input type="text" class="form-control"
                                                                            name="fechaRegistroCompra"
                                                                            id="fechaRegistroCompra" placeholder=""
                                                                            value="<?=date('d/m/Y')?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tipoGasto"
                                                                        class="col-sm-4 col-md-4 col-form-label align-self-center">Tipo
                                                                        Gasto: </label>
                                                                    <div class="col-md-8 col-lg-8 m-0">
                                                                        <select name="tipoGasto" id="tipoGasto"
                                                                            class="form-control">
                                                                            <?php foreach($tipoGasto as $tipo) :?>
                                                                            <option value="<?=$tipo->id?>">
                                                                                <?=$tipo->nombre?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="estadoCompra"
                                                                        class="col-sm-4 col-md-4 col-form-label">Estado:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 m-0">
                                                                        <input type="text" name="estadoCompra"
                                                                            id="estadoCompra" value="PROCESADO"
                                                                            class="form-control" readonly
                                                                            data-estado-compra="2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="proveedor"
                                                                        class="col-sm-2 col-md-2 col-form-label">Proveedor:
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-10 m-0">
                                                                        <input type="text" name="proveedor"
                                                                            id="proveedor" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tipoComprobante"
                                                                        class="col-sm-4 col-md-4 col-form-label">Tipo:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 m-0">
                                                                        <select name="tipoComprobante"
                                                                            id="tipoComprobante" class="form-control">
                                                                            <?php foreach($tipoComprobante as $tipo) : ?>
                                                                            <option value="<?=$tipo->id?>">
                                                                                <?=$tipo->nombre?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="numeroComprobante"
                                                                        class="col-sm-4 col-md-4 col-form-label">Número:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input
                                                                            type="text" class="form-control"
                                                                            name="numeroComprobante"
                                                                            id="numeroComprobante"
                                                                            placeholder="000-0000000"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="descripcionCompra"
                                                                        class="col-sm-2 col-md-2 col-form-label">Descripción:
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-10 m-0">
                                                                        <textarea name="descripcionCompra"
                                                                            id="descripcionCompra" cols="30" rows="3"
                                                                            class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="importeTotal"
                                                                        class="col-sm-4 col-md-4 col-form-label font-weight-bold">Importe
                                                                        Total: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input
                                                                            type="text" class="form-control"
                                                                            name="importeTotal" id="importeTotal"
                                                                            placeholder=""></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="top-tab-purchase-distribution">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-12 mb-2">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group row">
                                                                            <label for="tiendaCompra" class="col-form-label font-weight-bold col-sm-4">Tienda:</label>
                                                                            <div class="col-sm-8">
                                                                                <select name="tiendaCompra" id="tiendaCompra" class="form-control">
                                                                                    <?php foreach ($tiendas as $tienda) : ?>
                                                                                        <option value="<?=$tienda->id?>"><?=strtoupper($tienda->nombre)?></option>
                                                                                    <?php endforeach; ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <button class="btn btn-success btn-compra-tienda-agregar" id="btn-compra-tienda-agregar"><i class="fa fa-plus"></i></button>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <h6
                                                                    class="font-weight-bold mb-2 bg-purple-800 display-8">
                                                                    <u>Distribución Gastos Tiendas</u></h6>
                                                            </div>                                                            
                                                            <div class="col-sm-12">
                                                                <table class="table table-bordered"
                                                                    id="tbl-compras-distribucion" data-select="true" data-navigator="true">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 160px;">Tienda</th>
                                                                            <th>Monto</th>
                                                                            <th>Porcentaje</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach($tiendas as $tienda) : ?>
                                                                        <tr data-tienda-id="<?=$tienda->id?>">
                                                                            <td>
                                                                                <strong
                                                                                    class="text-brown-800"><?=strtoupper($tienda->nombre)?>
                                                                                </strong>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name=""
                                                                                    class="form-control text-number"
                                                                                    data-value-old="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name=""
                                                                                    class="form-control" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <button class="btn btn-danger btn-quitar-compra"><i class="fa fa-trash"></i></button>
                                                                            </td>
                                                                        </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="" role="group" aria-label="Vertical button group">
                                <button class="btn btn-block btn-lg btn-blue" id="btn-purchase-add">
                                    <i class="fa fa-save" style="font-size: 1.2rem"></i>
                                    <p class="mb-0">Guardar</p>
                                </button>
                                <button class="btn btn-block btn-lg btn-success" id="btn-purchase-new">
                                    <i class="fa fa-file" style="font-size: 1.2rem"></i>
                                    <p class="mb-0">Nuevo</p>
                                </button>
                                <button class="btn btn-block btn-lg btn-danger" data-dismiss="modal">
                                    <i class="fa fa-power-off" style="font-size: 1.2rem"></i>
                                    <p class="mb-0">Cerrar</p>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button> -->
                <!-- <button type="submit" class="btn btn-primary" id="btn-article-add">Guardar</button> -->
            </div>
        </div>
    </div>
</div>


<!-- *********************** -->
<script src="/assets/js/purchase-add.js">    
    // importarScript("/assets/js/test.js");
</script>

<script>

</script>