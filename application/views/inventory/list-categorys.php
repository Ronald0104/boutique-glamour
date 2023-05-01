<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Inventario</a>
                    <span class="breadcrumb-item active">Tablas Maestras</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i>
                        Ajustes
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <div class="row">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header header-elements-inline pt-2 pb-2">
                        <h5 class="card-title font-weight-bold mt-0">Mantenimiento de Categorias</h5>
                        <div class="group-button">
                            <button class="btn btn-blue pull-right" id="btn-show-category-add" data-toggle="modal"
                                data-target="#modal-category-add"><i class="fa fa-file"></i>
                                Nuevo Categoria</button>
                        </div>
                    </div>
                    <table class="table table-bordered" data-select="true" data-navigator="true">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Prefijo</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="categorys-items">
                            <?php $i=1; ?>
                            <?php foreach($categorias as $categoria) :?>
                            <tr tabindex="0">
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $categoria->nombre ?></td>
                                <td><?php echo $categoria->prefijo_code ?></td>
                                <td><?php echo ($categoria->Estado == 1) ? 'Activo' : 'Inactivo' ?></td>
                                <td>
                                    <button type="button" id="btn-category-"
                                        class="btn btn-success btn-xs btn-category-edit-show" data-toggle="modal"
                                        data-target="#modal-category-edit2"
                                        data-categoria="<?php echo $categoria->categoriaId ?>"><i
                                            class="glyphicon glyphicon-edit"></i></button>
                                    <button type="button" id="btn-category-"
                                        class="btn btn-warning btn-xs btn-category-delete"><i
                                            class="glyphicon glyphicon-remove"
                                            data-categoria="<?php echo $categoria->categoriaId ?>"></i> </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header header-elements-inline pt-2 pb-2">
                        <h5 class="card-title font-weight-bold mt-0">Mantenimiento de Tallas</h5>
                        <div class="group-button">
                            <button class="btn btn-blue pull-right" id="btn-talla-new"><i class="fa fa-file"></i>
                                &nbsp;Nuevo</button>
                        </div>
                    </div> 
                    <div class="card-body pt-3">
                        <form action="#">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="idTalla" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">ID: </label>
                                    <div class="col-sm-4 m-0">
                                        <input type="text" class="form-control" name="idTalla" id="idTalla" readonly/>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-block" id="btn-talla-add"><i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="categoriaTalla" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Categoria: </label>
                                    <div class="col-sm-8 m-0">
                                        <select name="categoriaTalla" id="categoriaTalla" class="form-control">
                                            <option value="">.. Seleccione ..</option>
                                            <?php foreach ($categorias as $categoria) : ?>
                                            <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="nombreTalla" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Nombre: </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nombreTalla" id="nombreTalla" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="estadoTalla" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Estado: </label>
                                    <div class="col-sm-8">
                                        <select name="estadoTalla" id="estadoTalla" class="form-control">
                                            <option value="1">ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>      
                    </div>
                    <!-- <div class="table-reponsive"> -->
                        <table class="table table-bordered" data-select="true" data-navigator="true" id="tbl_tallas_categoria">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Categoria</th>
                                    <th>Talla</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    <!-- </div>             -->
                </div>                
            </div>
        </div>
        

        <div class="row">            
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header header-elements-inline pt-2 pb-2">
                        <h5 class="card-title font-weight-bold mt-0">Mantenimiento de Colores</h5>
                        <div class="group-button">
                        <button class="btn btn-blue pull-right" id="btn-color-new"><i class="fa fa-file"></i>
                                &nbsp;Nuevo</button>
                        </div>
                    </div>  
                    <div class="card-body pt-3">
                        <form action="#">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="idColor" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">ID: </label>
                                    <div class="col-sm-4 m-0">
                                        <input type="text" class="form-control" name="idColor" id="idColor" readonly/>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-block" id="btn-color-add"><i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="categoriaColor" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Categoria: </label>
                                    <div class="col-sm-8 m-0">
                                        <select name="categoriaColor" id="categoriaColor" class="form-control">
                                            <option value="">.. Seleccione ..</option>
                                            <?php foreach ($categorias as $categoria) : ?>
                                            <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="nombreColor" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Nombre: </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nombreColor" id="nombreColor" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="estadoColor" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Estado: </label>
                                    <div class="col-sm-8">
                                        <select name="estadoColor" id="estadoColor" class="form-control">
                                            <option value="1">ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>      
                    </div>
                    <table class="table table-bordered" data-select="true" data-navigator="true" id="tbl_colores_categoria">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Categoria</th>
                                <th>Color</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>      
                </div>
            </div>

            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header header-elements-inline pt-2 pb-2">
                        <h5 class="card-title font-weight-bold mt-0">Mantenimiento de Diseños</h5>
                        <div class="group-button">
                        <button class="btn btn-blue pull-right" id="btn-diseno-new"><i class="fa fa-file"></i>
                                &nbsp;Nuevo</button>
                        </div>
                    </div> 
                    <div class="card-body pt-3">
                        <form action="#">
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="idDiseno" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">ID: </label>
                                    <div class="col-sm-4 m-0">
                                        <input type="text" class="form-control" name="idDiseno" id="idDiseno" readonly/>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary btn-block" id="btn-diseno-add"><i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="categoriaDiseno" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Categoria: </label>
                                    <div class="col-sm-8 m-0">
                                        <select name="categoriaDiseno" id="categoriaDiseno" class="form-control">
                                            <option value="">.. Seleccione ..</option>
                                            <?php foreach ($categorias as $categoria) : ?>
                                            <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="nombreDiseno" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Nombre: </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="nombreDiseno" id="nombreDiseno" class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <label for="estadoColor" class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Estado: </label>
                                    <div class="col-sm-8">
                                        <select name="estadoDiseno" id="estadoDiseno" class="form-control">
                                            <option value="1">ACTIVO</option>
                                            <option value="0">INACTIVO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>      
                    </div>
                    <table class="table table-bordered" data-select="true" data-navigator="true" id="tbl_disenos_categoria">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Categoria</th>
                                <th>Diseño</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>               
                </div>
            </div>
        </div>        
    </div>
    <!-- /Content area -->
</div>
<!-- /Main header -->


<!-- Modal Registrar Categoria-->
<div class="modal fade" id="modal-category-add" tabindex="-1" role="dialog" aria-labelledby="modal-category-add">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-category">Nueva Categoria</h4>
            </div>
            <form action="" method="POST" class="form-horizontal" name="form-category-add" id="form-category-add">
                <div class="modal-body">
                    <div class="alert alert-warning" id="form-category-add-error" style="display: none"><b>¡ERROR!</b>
                        categoria ya existe</div>
                    <input type="hidden" name="categoriaId" id="categoriaId" value="0" />
                    <div class="form-group">
                        <label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="nombre" id="nombre"
                                placeholder="Nombre" aria-required></div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-sm-3 control-label">Descripción: </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="descripcion" id="descripcion" rows="4"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="prefijo" class="col-sm-3 control-label">Prefijo: </label>
                        <div class="col-sm-4"><input type="text" class="form-control" name="prefijo" id="prefijo"
                                placeholder="Prefijo"></div>
                    </div>
                    <div class="form-group">
                        <label for="categoria" class="col-sm-3 control-label">Categoria Principal: </label>
                        <div class="col-sm-6">
                            <select name="categoriaPadreId" id="categoriaPadreId" class="form-control">
                                <option value="">.. Seleccione ..</option>
                                <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado" class="col-sm-3 control-label">Activo: </label>
                        <div class="col-sm-6">
                            <!--col-sm-offset-2 -->
                            <div class="checkbox"><label><input type="checkbox" name="estado" id="estado" value="1"
                                        checked></label></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imagen" class="col-sm-3 control-label">Foto: </label>
                        <div class="col-sm-8">
                            <div class="droparea text-center" id="foto-drop">
                                <img src="<?php echo base_url()?>/assets/img/default_256.png" alt="Drag and Drop"
                                    name="foto_preview" id="foto_preview" style="max-width: 350px"><br>
                                <span>Drag and Drop Image Here!</span>
                            </div>
                            <input type="file" name="foto" id="foto" accept="image/*" style="display:none">
                            <input type="hidden" name="fotoPath" id="fotoPath" value="">
                            <input type="hidden" name="token" id="token" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-category-add">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modificar Categoria-->
<div class="modal fade" id="modal-category-edit" tabindex="-1" role="dialog" aria-labelledby="modal-category-edit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modal-header-custom">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title-edit">Modificar Categoria</h4>
            </div>
            <form action="" method="POST" class="form-horizontal" name="form-category-edit" id="form-category-edit">
                <div class="modal-body">
                    <div class="alert alert-warning" id="form-category-edit-error" style="display: none"><b>¡ERROR!</b>
                        categoria ya existe</div>
                    <input type="hidden" name="categoriaId_edit" id="categoriaId_edit" value="0" />
                    <div class="form-group">
                        <label for="nombre" class="col-sm-3 control-label">Nombre: </label>
                        <div class="col-sm-8"><input type="text" class="form-control" name="nombre_edit"
                                id="nombre_edit" placeholder="Nombre" aria-required></div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion" class="col-sm-3 control-label">Descripción: </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="descripcion_edit" id="descripcion_edit"
                                rows="4"></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="prefijo" class="col-sm-3 control-label">Prefijo: </label>
                        <div class="col-sm-4"><input type="text" class="form-control" name="prefijo_edit"
                                id="prefijo_edit" placeholder="Prefijo"></div>
                    </div>
                    <div class="form-group">
                        <label for="categoria" class="col-sm-3 control-label">Categoria Principal: </label>
                        <div class="col-sm-6">
                            <select name="categoriaPadreId_edit" id="categoriaPadreId_edit" class="form-control">
                                <option value="">.. Seleccione ..</option>
                                <?php foreach ($categorias as $categoria) : ?>
                                <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado" class="col-sm-3 control-label">Activo: </label>
                        <div class="col-sm-6">
                            <div class="checkbox"><label><input type="checkbox" name="estado_edit" id="estado_edit"
                                        value="1" checked></label></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="imagen" class="col-sm-3 control-label">Foto: </label>
                        <div class="col-sm-8">
                            <div class="droparea text-center" id="foto-drop-edit">
                                <img src="<?php echo base_url()?>/assets/img/default_256.png" alt="Drag and Drop"
                                    name="foto_preview_edit" id="foto_preview_edit" style="max-width: 350px"><br>
                                <span>Drag and Drop Image Here!</span>
                            </div>
                            <input type="file" name="foto_edit" id="foto_edit" accept="image/*" style="display:none">
                            <input type="hidden" name="fotoPath_edit" id="fotoPath_edit" value="">
                            <input type="hidden" name="token_edit" id="token_edit" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success" id="btn-category-edit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>