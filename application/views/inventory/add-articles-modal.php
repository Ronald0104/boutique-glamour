<!-- Modal Registrar Articulo-->
<div class="modal fade" id="modal-article-add" tabindex="-1" role="dialog" aria-labelledby="modal-article-add" aria-hidden="true" style="padding-right: 17px;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-indigo-600">
                <h5 class="modal-title mt-0"><i class="icon-menu7 mr-2"></i>Nuevo Artículo</h5>
                <!-- <button type="button" class="close" data-dismiss="modal">×</button> -->
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
                                    <form action="" method="POST" class="form-horizontal" name="form-article-add" id="form-article-add">
                                        <input type="hidden" name="articuloId" id="articuloId" value="0" />
                                        <div style="position: absolute; top: 0.85rem; right: 1.2rem;">
                                            <label class="switch ">
                                                <input type="checkbox" class="default" name="estadoArticulo" id="estadoArticulo">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <ul class="nav nav-tabs nav-tabs-top">
                                            <li class="nav-item"><a href="#top-tab-article" class="nav-link font-weight-bold active show" data-toggle="tab">Datos Artículo</a></li>
                                            <li class="nav-item"><a href="#top-tab-article-aditional" class="nav-link font-weight-bold" data-toggle="tab">Datos Adicionales</a></li>
                                            <li class="nav-item"><a href="#top-tab-article-history" class="nav-link font-weight-bold" data-toggle="tab">Historial</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="top-tab-article">
                                                <div class="alert alert-warning" id="form-article-add-error" style="display: none"><b>¡ERROR!</b> artículo ya existe</div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="categoriaArticulo" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Categoria: </label>
                                                                    <div class="col-sm-8 col-md-8 col-lg-8 m-0">
                                                                        <select name="categoriaArticulo" id="categoriaArticulo" class="form-control">
                                                                            <option value="">.. Seleccione ..</option>
                                                                            <?php foreach ($categorias as $categoria) : ?>
                                                                            <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="PRD_codigoArticulo" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Codigo: </label>
                                                                    <div class="col-sm-8 col-md-8 col-lg-8 m-0">
                                                                        <input type="text" class="form-control" name="PRD_codigoArticulo" id="PRD_codigoArticulo" placeholder="Código">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                                <div class="form-group row">
                                                                    <label for="nombreArticulo" class="col-sm-2 col-md-2 col-lg-2 col-form-label align-self-center">Nombre: </label>
                                                                    <div class="col-md-10 col-lg-10 m-0"><input type="text" class="form-control" name="nombreArticulo" id="nombreArticulo" placeholder="Nombre"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tiendaArticulo" class="col-sm-4 col-md-4 col-form-label">Tienda: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0">
                                                                        <select name="tiendaArticulo" id="tiendaArticulo" class="form-control">
                                                                            <option value="">.. Seleccione ..</option>
                                                                            <?php foreach ($tiendas as $tienda) : ?>
                                                                            <option value="<?php echo $tienda->id?>"><?php echo $tienda->nombre; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="etapaArticulo" class="col-sm-4 col-md-4 col-form-label">Estado: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0">
                                                                        <select name="etapaArticulo" id="etapaArticulo" class="form-control">
                                                                            <option value="">.. Seleccione ..</option>
                                                                            <?php foreach ($estados as $estado) : ?>
                                                                            <option value="<?php echo $estado->id?>"><?php echo $estado->nombre; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="marcaArticulo" class="col-sm-4 col-md-4 col-form-label">Marca: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input type="text" class="form-control" name="marcaArticulo" id="marcaArticulo" placeholder="Marca"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                            
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tallaArticulo" class="col-sm-4 col-md-4 col-form-label">Talla: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input type="text" class="form-control" name="tallaArticulo" id="tallaArticulo" placeholder="Talla"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tallaArticuloSelect" class="col-sm-4 col-md-4 col-form-label">Talla: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><select class="form-control" name="tallaArticuloSelect" id="tallaArticuloSelect"></select></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="colorArticulo" class="col-sm-4 col-md-4 col-form-label">Color: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input type="text" class="form-control" name="colorArticulo" id="colorArticulo" placeholder="Color"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="colorArticuloSelect" class="col-sm-4 col-md-4 col-form-label">Color: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><select class="form-control" name="colorArticuloSelect" id="colorArticuloSelect"></select></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="telaArticulo" class="col-sm-4 col-md-4 col-form-label">Diseño: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input type="text" class="form-control" name="telaArticulo" id="telaArticulo" placeholder="Tela"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="disenoArticuloSelect" class="col-sm-4 col-md-4 col-form-label">Diseño: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><select class="form-control" name="disenoArticuloSelect" id="disenoArticuloSelect"></select></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tipoArticulo" class="col-sm-4 col-md-4 col-form-label">Tipo: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0">
                                                                        <select name="tipoArticulo" id="tipoArticulo" class="form-control">
                                                                            <option value="0">.. SELECCIONE ..</option>
                                                                            <option value="1">CABALLEROS</option>
                                                                            <option value="2">DAMAS</option>
                                                                            <option value="3">NIÑOS</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="caracteristicasArticulo" class="col-sm-2 col-form-label">Características: </label>
                                                                    <div class="col-md-10 m-0">
                                                                        <textarea name="caracteristicasArticulo" class="form-control" id="caracteristicasArticulo" rows="4"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="top-tab-article-aditional">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group row">
                                                                    <label for="fechaRegistroArticulo" class="col-sm-4 col-form-label">Fecha Registro: </label>
                                                                    <div class="col-sm-8 m-0 d-inline-flex">
                                                                        <input type="text" class="form-control" name="fechaRegistroArticulo" id="fechaRegistroArticulo" placeholder="" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group row">
                                                                    <label for="fechaCompraArticulo" class="col-sm-4 col-form-label">Fecha Compra: </label>
                                                                    <div class="col-sm-8 m-0 d-inline-flex">
                                                                        <input type="text" class="form-control" name="fechaCompraArticulo" id="fechaCompraArticulo" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group row">
                                                                    <label for="precioCompraArticulo" class="col-sm-4 col-form-label">Precio Compra: </label>
                                                                    <div class="col-sm-8 m-0 d-inline-flex">
                                                                        <input type="number" class="form-control" name="precioCompraArticulo" id="precioCompraArticulo" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group row">
                                                                    <label for="precioAlquilerArticulo" class="col-sm-4 col-form-label">Precio Alquiler: </label>
                                                                    <div class="col-sm-8 m-0 d-inline-flex">
                                                                        <input type="number" class="form-control" name="precioAlquilerArticulo" id="precioAlquilerArticulo" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group row">
                                                                    <label for="precioVentaArticulo" class="col-sm-4 col-form-label">Precio Venta: </label>
                                                                    <div class="col-sm-8 m-0 d-inline-flex">
                                                                        <input type="number" class="form-control" name="precioVentaArticulo" id="precioVentaArticulo" placeholder="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group row">
                                                                    <label for="precioVentaArticulo" class="col-sm-4 col-form-label">Condición: </label>
                                                                    <div class="col-sm-8 m-0 d-inline-flex">
                                                                        <select name="condicionArticulo" id="condicionArticulo" class="form-control">
                                                                            <option value="">.. Seleccione ..</option>
                                                                            <option value="ESTRENO">ESTRENO</option>
                                                                            <option value="USADO">USADO</option>
                                                                            <option value="OFERTA">OFERTA</option>
                                                                        </select>
                                                                    </div>    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-12">
                                                            <div class="form-group row">
                                                                <div class="col-md-12 m-0">
                                                                    <input id="fileInput" name="fileInput[]" type="file" multiple>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="top-tab-article-history">
                                                <div class="table-responsive" style="max-height : 350px;">
                                                    <table class="table table-bordered" data-select="true" data-navigator="true">
                                                        <thead>
                                                            <tr>
                                                                <th>N° Ope.</th>
                                                                <th>Tipo</th>
                                                                <th>Estado</th>
                                                                <th>DNI</th>
                                                                <th>Nombres</th>
                                                                <th>Fecha</th>
                                                                <th>Importe</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tb_article_history">
                                                        </tbody>
                                                    </table>
                                                </div> 
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-10">
                                                            <h4 class="text-right"><b>TOTAL:</b></h4>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <h4 id="total-articulo"><b></b></h4>
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
                                <button class="btn btn-block btn-lg btn-blue" id="btn-article-add">
                                    <i class="fa fa-save" style="font-size: 1.2rem"></i>
                                    <p class="mb-0">Guardar</p>
                                </button>
                                <button class="btn btn-block btn-lg btn-success" id="btn-article-new">
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
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btn-article-add">Guardar</button>
            </div> -->
        </div>
    </div>
</div>
<!-- *********************** -->

<script>
    var EsNuevo = false;
    var EsEdit = false;
</script>

<script src="/assets/js/inventory/article-add.js">
    
    // importarScript("/assets/js/test.js");
</script>