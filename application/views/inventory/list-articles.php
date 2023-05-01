<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <!-- <div class="page-title d-flex">
                <h4>Mantenimiento de artículos</h4>
                <h4><i class="icon-arrow-left2 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div> -->

            <!-- <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-stats-bars text-primary"></i><span>Estadisticas</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar text-primary"></i> <span>Schedule</span></a>
                </div>
            </div> -->
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Inventario</a>
                    <span class="breadcrumb-item active">Articulos</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i>
                        Ajustes
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
        <!-- <div class="row">
            <div class="col-xl-12"> -->
        <!-- Card -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title font-weight-bold">Mantenimiento de artículos</h5>
                <div class="text-warning">
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                </div>
                <div class="group-button">
                    <!-- <button class="btn btn-primary pull-right" id="btn-show-article-add" data-toggle="modal" data-target="#modal-article-add">Nuevo Artículo</button> -->
                    <button class="btn btn-blue pull-right" id="btn-search-article"><i class="fa fa-search"></i>
                        Buscar</button> 
                    <button class="btn btn-primary pull-right" id="btn-show-article-add"><i class="fa fa-file"></i>
                        Nuevo Artículo</button> 
                    <a class="btn btn-success" id="btn-load-articles"
                        href="<?php echo base_url()?>inventario/upload"><i class="glyphicon glyphicon-upload"></i>
                        Cargar Masiva
                    </a>
                </div>
                <!-- <p class="card-text"></p> -->
                <!-- <a href="#" class="btn btn-primary pull-right"></a> -->
            </div>
            <div class="card-body" style="padding-top: .8rem">
                <div class="col-sm-12">
                    <form action="GET">
                        <div class="row">
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group row">
                                    <label for="categoria" class="col-md-4 col-form-label">Categoria: </label>
                                    <div class="col-sm-8">
                                        <select name="categoria" id="categoria" class="form-control">
                                            <option value="0">TODOS</option>
                                            <?php foreach ($categorias as $key => $value) : ?>
                                                <option value="<?php echo $value->categoriaId?>"><?=$value->nombre?></option>
                                            <?php endforeach; ?>                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group row">
                                    <label for="estado" class="col-md-4 col-form-label">Estado: </label>
                                    <div class="col-sm-8">
                                        <select name="estado" id="estado" class="form-control">
                                            <option value="0">TODOS</option>
                                            <?php foreach ($estados as $key => $value) : ?>
                                                <option value="<?php echo $value->id?>"><?=$value->nombre?></option>
                                            <?php endforeach; ?>                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group row">
                                    <label for="condicion" class="col-md-4 col-form-label">Condición: </label>
                                    <div class="col-sm-8">
                                        <select name="condicion" id="condicion" class="form-control">
                                            <option value="0">TODOS</option>
                                            <option value="ESTRENO">ESTRENO</option>                                          
                                            <option value="USADO">USADO</option>                                          
                                            <option value="OFERTA">OFERTA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group row">
                                    <label for="talla"
                                        class="col-sm-4 col-form-label font-weight-bold">Talla:
                                    </label>
                                    <div class="col-sm-8">
                                    <select name="talla[]" id="talla" multiple="multiple" class="form-control">
                                        <option value="0">TODOS</option>
                                        <!-- <?php foreach ($categorias as $key => $value) : ?>
                                            <option value="<?php echo $value->categoriaId?>"><?=$value->nombre?></option>
                                        <?php endforeach; ?>                                             -->
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group row">
                                    <label for="color"
                                        class="col-sm-4 col-form-label font-weight-bold">Color:
                                    </label>
                                    <div class="col-sm-8">
                                    <select name="color[]" id="color" multiple="multiple" class="form-control">
                                        <option value="0">TODOS</option>
                                        <?php foreach ($categorias as $key => $value) : ?>
                                            <!-- <option value="<?php echo $value->categoriaId?>"><?=$value->nombre?></option> -->
                                        <?php endforeach; ?>                                            
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group row">
                                    <label for="diseno"
                                        class="col-sm-4 col-form-label font-weight-bold">Diseño:
                                    </label>
                                    <div class="col-sm-8">
                                    <select name="diseno[]" id="diseno" multiple="multiple" class="form-control">
                                        <option value="0">TODOS</option>
                                        <?php foreach ($categorias as $key => $value) : ?>
                                            <!-- <option value="<?php echo $value->categoriaId?>"><?=$value->nombre?></option> -->
                                        <?php endforeach; ?>                                            
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- datatable-selection-multiple dataTable -->
            <div class="table-responsive">
                <table class="table table-bordered no-footer" id="tbl_articles" data-select="true"
                    data-navigator="true">
                    <thead>
                        <tr>
                            <th></th>
                            <!-- <th><span class="">#</span></th> -->
                            <th>Code</th>
                            <th>Nombre</th>
                            <!-- <th>Descripción</th> -->
                            <th>Categoría</th>
                            <th>Estado</th>
                            <th>Condición</th>
                            <th>Color</th>
                            <th>Talla</th>
                            <th>Diseño</th>
                            <!-- <th>Stock Actual</th>                 -->                            
                            <!-- <th>Precio Compra</th>                
                                <th>Precio Alquiler</th>                
                                <th>Precio Venta</th>                 -->
                            <!-- <th>Opciones</th> -->
                        </tr>
                    </thead>
                    <tbody id="articles-items">

                    </tbody>
                </table>
            </div>
        </div>
        <!-- /Card -->
        <!-- </div> -->
        <!-- </div>     -->
        <!-- /Opciones  -->
    </div>
    <!-- /Content area -->
</div>
<!-- /Main header -->


<!-- Modal Modificar Articulo-->
<div class="modal fade" id="modal-article-edit" tabindex="-1" role="dialog" aria-labelledby="modal-article-edit"
    style="padding-right: 17px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="icon-menu7 mr-2"></i>Editar Artículo</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form action="" method="POST" class="form-horizontal" name="form-article-edit" id="form-article-edit">
                <div class="modal-body">
                    <div class="alert alert-warning" id="form-article-edit-error" style="display: none"><b>¡ERROR!</b>
                        artículo ya existe</div>
                    <input type="hidden" name="articuloId_edit" id="usuarioId_edit" value="0" />

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="categoria_edit" class="col-md-3 col-form-label">Categoria: </label>
                                        <div class="col-md-9 m-0">
                                            <select name="categoria_edit" id="categoria_edit" class="form-control">
                                                <option value="">.. Seleccione ..</option>                                                
                                                <?php foreach ($categorias as $categoria) : ?>
                                                <option value="<?php echo $categoria->categoriaId?>">
                                                    <?php echo $categoria->nombre; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="code_edit" class="col-md-3 col-form-label">Code: </label>
                                        <div class="col-md-9 m-0 d-inline-flex">
                                            <input type="text" class="form-control" name="code_edit" id="code_edit"
                                                placeholder="Código" readonly>
                                            <button class="btn btn-info btn-xs" type="button" data-toggle="tooltip"
                                                data-placement="left" title="Desbloquear"><i
                                                    class="glyphicon glyphicon-lock"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="form-group row">
                                        <label for="nombre_edit"
                                            class="col-sm-3 col-md-2 col-lg-3 col-form-label align-self-center">Nombre:
                                        </label>
                                        <div class="col-md-9 col-lg-9 m-0"><input type="text" class="form-control"
                                                name="nombre_edit" id="nombre_edit" placeholder="Nombre"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="form-group row">
                                        <label for="descripcion_edit"
                                            class="col-sm-3 col-md-2 col-lg-1 col-form-label align-self-center">Descripción:
                                        </label>
                                        <div class="col-md-10 col-lg-11 offset-lg-1 m-0"><input type="text"
                                                class="form-control" name="descripcion_edit" id="descripcion_edit"
                                                placeholder="Descripción"></div>
                                    </div>
                                </div>
                                <!-- <hr style="border: 1px solid #ddd;"> -->
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group row">
                                        <label for="unidadMedida_edit" class="col-md-3 col-form-label">Unidad. M:
                                        </label>
                                        <div class="col-md-9 m-0"><input type="text" class="form-control"
                                                name="unidadMedida_edit" id="unidadMedida_edit"
                                                placeholder="Unidad Medida"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group row">
                                        <label for="marca_edit" class="col-md-3 col-form-label">Marca: </label>
                                        <div class="col-md-9 m-0"><input type="text" class="form-control"
                                                name="marca_edit" id="marca_edit" placeholder="Marca"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group row">
                                        <label for="modelo_edit" class="col-md-3 col-form-label">Módelo: </label>
                                        <div class="col-md-9 m-0"><input type="text" class="form-control"
                                                name="modelo_edit" id="modelo_edit" placeholder="Módelo"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group row">
                                        <label for="talla_edit" class="col-md-3 col-form-label">Talla: </label>
                                        <div class="col-md-9 m-0"><input type="text" class="form-control"
                                                name="talla_edit" id="talla_edit" placeholder="Talla"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group row">
                                        <label for="color_edit" class="col-md-3 col-form-label">Color: </label>
                                        <div class="col-md-9 m-0"><input type="text" class="form-control"
                                                name="color_edit" id="color_edit" placeholder="Color"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">
                                    <div class="form-group row">
                                        <label for="tela_edit" class="col-md-3 col-form-label">Tela: </label>
                                        <div class="col-md-9 m-0"><input type="text" class="form-control"
                                                name="tela_edit" id="tela_edit" placeholder="Tela"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <label for="caracteristicas_edit"
                                            class="col-sm-3 col-md-2 col-lg-1 col-form-label">Características: </label>
                                        <!-- <div class="col-md-9 m-0"><input type="text" class="form-control" name="caracteristicas" id="caracteristicas" placeholder="Tela"></div> -->
                                        <div class="col-md-10 m-0">
                                            <textarea name="caracteristicas_edit" class="form-control"
                                                id="caracteristicas_edit" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group row">
                                        <label for="estado_edit" class="col-md-3 col-form-label">Estado: </label>
                                        <div class="col-md-9 m-0 p-2">
                                            <label><input type="checkbox" name="estado_edit" id="estado_edit" value="1"
                                                    checked></label>
                                            <!-- <div class="uniform-checker"><span class="checked"><input type="checkbox" class="form-check-input-styled" checked="" data-fouc="" name="estado" id="estado"></span></div> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 m-0">
                                            <input id="fileInput_edit" name="fileInput[]" type="file" multiple>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="file-loading ">
                                <input id="file-1" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2"> 
                                <input id="fileInput" name="fileInput[]" type="file" multiple>
                            </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btn-article-edit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>