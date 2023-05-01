<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <!-- <div class="page-title d-flex"> -->
                <!-- <h4>Mantenimiento de Tiendas</h4> -->
                <!-- <h4><i class="icon-arrow-left2 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4> -->
                <!-- <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a> -->
            <!-- </div> -->

            <!-- <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-stats-bars text-primary"></i><span>Estadisticas</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                </div>
            </div> -->
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/tienda/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Tiendas</a>
                    <span class="breadcrumb-item active">Listar</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i>
                        Soporte
                    </a>

                    <!-- <div class="breadcrumb-elements-item dropdown p-0">
                        <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-gear mr-2"></i>
                            Ajustes
                        </a> -->

                    <!-- <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Seguridad</a>
                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analisticas</a>
                        <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
                    </div> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Opciones -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Mantenimiento de Tiendas</h5>
                        <div class="text-warning">
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                        </div>
                        <div class="group-button">
                            <button class="btn btn-primary pull-right" id="btn-show-shop-add" data-toggle="modal" data-target="#modal-shop-add">Nuevo Tienda</button>
                        </div>
                        <!-- <p class="card-text"></p> -->
                        <!-- <a href="#" class="btn btn-primary pull-right"></a> -->
                    </div>

                </div>
            </div>
            <div class="col-12">
                <div class="row" id="">
                    <?php  foreach($tiendas as $tienda) : ?>
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <div class="card">
                            <a href="#" style="padding: 15px; border-bottom: 1px solid #ddd;" class="btn-shop-edit" data-tienda="<?php echo $tienda->id ?>">
                                <img src="<?php echo base_url()?>/assets/img/shops/<?php echo empty($tienda->foto) ? 'store_256.png' : 'shop_'.$tienda->id.'/'. $tienda->foto; ?>" alt="<?php echo $tienda->nombre?>" title="<?php echo $tienda->nombre?>" class="card-img-top">
                            </a>
                            <div class="card-body d-inline-block" padding="1rem">
                                <h5 class="card-title">
                                    <a href="#" class="btn-shop-edit" data-tienda="<?php echo $tienda->id ?>">
                                        <h4 class="text-center"><?php echo $tienda->nombre?><small><?php echo $tienda->sub_nombre?></small></h4>
                                    </a>
                                </h5>
                                <div class="row text-center">
                                    <address style="width: 100%">
                                        <strong><?php echo $tienda->direccion?></strong><br>
                                        <?php echo $tienda->referencia?><br>
                                        <abbr title="Phone">Telf:</abbr> <?php echo $tienda->telefono?>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- /Opciones  -->
    </div>
    <!-- /Content area -->
</div>
<!-- /Main content -->



<!-- Modal Registrar Tienda -->
<div class="modal fade" id="modal-shop-add" tabindex="-1" role="dialog" aria-labelledby="modal-shop-add">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-700">
                <h4 class="modal-title" id="myModalLabel">Nueva Tienda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="" method="POST" class="form-horizontal" name="form-shop-add" id="form-shop-add">
                <div class="modal-body">
                    <div class="alert alert-warning" id="form-shop-add-error" style="display: none"><b>¡ERROR!</b> tienda ya existe</div>
                    <input type="hidden" name="tiendaId" id="tiendaId" value="0" />
                    <div class="form-group row">
                        <label for="nombres" class="col-sm-3 col-form-label">Nombre: </label>
                        <div class="col-sm-6"><input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" aria-required></div>
                    </div>
                    <div class="form-group row">
                        <label for="nombres" class="col-sm-3 col-form-label">Alias: </label>
                        <div class="col-sm-6"><input type="text" class="form-control" name="sub_nombre" id="sub_nombre" placeholder="Alias" aria-required></div>
                    </div>
                    <div class="form-group row">
                        <label for="direccion" class="col-sm-3 col-form-label">Dirección: </label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección"></div>
                    </div>
                    <div class="form-group row">
                        <label for="referencia" class="col-sm-3 col-form-label">Referencia: </label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="referencia" id="referencia" placeholder="Referencia"></div>
                    </div>
                    <div class="form-group row">
                        <label for="telefono" class="col-sm-3 col-form-label">Telefono: </label>
                        <div class="col-sm-6"><input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono"></div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="estado" class="col-sm-3 col-form-label">Activo: </label>
                        <div class="col-sm-6">
                            <!--col-sm-offset-2 -->
                            <div class="checkbox"><label>
                                    <input type="checkbox" name="estado" id="estado" value="1" checked style="width:20px; height:20px;">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="foto" class="col-sm-3 col-form-label">Foto: </label>
                        <div class="col-sm-9">
                            <div class="droparea text-center" id="foto-drop">
                                <img src="<?php echo base_url()?>/assets/img/shops/store_256.png" alt="Drag and Drop" name="foto_preview" id="foto_preview" style="max-width: 350px"><br>
                                <span>Drag and Drop Image Here!</span>
                            </div>
                            <input type="file" name="foto" id="foto" accept="image/*" style="display:none">
                            <input type="hidden" name="fotoPath" id="fotoPath" value="">
                            <input type="hidden" name="token" id="token" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-lg" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success btn-lg" id="btn-shop-add">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Tienda -->
<div class="modal fade" id="modal-shop-edit" tabindex="-1" role="dialog" aria-labelledby="modal-shop-edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-700">
                <h4 class="modal-title" id="">Editar Tienda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="" method="POST" class="form-horizontal" name="form-shop-edit" id="form-shop-edit">
                <div class="modal-body">
                    <div class="alert alert-warning" id="form-shop-edit-error" style="display: none"><b>¡ERROR!</b> tienda ya existe</div>
                    <input type="hidden" name="tiendaId_edit" id="tiendaId_edit" value="0" />
                    <div class="form-group row">
                        <label for="nombre_edit" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-6"><input type="text" class="form-control" name="nombre_edit" id="nombre_edit" placeholder="Nombre" aria-required></div>
                    </div>
                    <div class="form-group row">
                        <label for="nombres_edit" class="col-sm-3 control-label">Alias: </label>
                        <div class="col-sm-6"><input type="text" class="form-control" name="sub_nombre_edit" id="sub_nombre_edit" placeholder="Alias" aria-required></div>
                    </div>
                    <div class="form-group row">
                        <label for="direccion_edit" class="col-sm-3 control-label">Dirección: </label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="direccion_edit" id="direccion_edit" placeholder="Dirección"></div>
                    </div>
                    <div class="form-group row">
                        <label for="referencia_edit" class="col-sm-3 control-label">Referencia: </label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="referencia_edit" id="referencia_edit" placeholder="Referencia"></div>
                    </div>
                    <div class="form-group row">
                        <label for="telefono_edit" class="col-sm-3 control-label">Telefono: </label>
                        <div class="col-sm-6"><input type="text" class="form-control" name="telefono_edit" id="telefono_edit" placeholder="Telefono"></div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="estado_edit" class="col-sm-3 control-label">Activo: </label>
                        <div class="col-sm-6">
                            <!--col-sm-offset-2 -->
                            <div class="checkbox"><label><input type="checkbox" name="estado_edit" id="estado_edit" value="1" checked></label></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="foto_edit" class="col-sm-3 control-label">Foto: </label>
                        <div class="col-sm-9">
                            <div class="droparea text-center" id="foto-drop-edit">
                                <img src="<?php echo base_url()?>/assets/img/shops/store_256.png" alt="Drag and Drop" name="foto_preview_edit" id="foto_preview_edit" style="max-width: 350px"><br>
                                <span>Drag and Drop Image Here!</span>
                            </div>
                            <input type="file" name="foto_edit" id="foto_edit" accept="image/*" style="display:none">
                            <input type="hidden" name="fotoPath_edit" id="fotoPath_edit" value="">
                            <input type="hidden" name="token_edit" id="token_edit" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-lg" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success btn-lg" id="btn-shop-edit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>