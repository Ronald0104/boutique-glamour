<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Movimientos de inventario</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Inventario</a>
                    <span class="breadcrumb-item active">Operación</span>
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
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b>Movimientos</b></h5> 
                <div class="text-warning">
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                </div> 
                <div class="group-button">
                    <button class="btn btn-primary pull-right btn-kardex-register" id="btn-show-kardex-1" data-toggle="modal" data-target="#modal-kardex-1" data-option="1"> Ingresos</button>                    
                    <button class="btn btn-primary pull-right btn-kardex-register" id="btn-show-kardex-2" data-toggle="modal" data-target="#modal-kardex-2" data-option="2"> Salidas</button>                    
                    <button class="btn btn-primary pull-right btn-kardex-register" id="btn-show-kardex-3" data-toggle="modal" data-target="#modal-kardex-3" data-option="3"> Traslados</button>                    
                </div>                                                               
            </div> 
            <table class="table datatable-selection-multiple dataTable no-footer" id="tbl_articles">
                <thead>
                    <th>#</th>
                    <th>Code</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Stock Actual</th>                
                    <th>Precio Alquiler</th>                
                    <th>Precio Venta</th>                
                    <th>Opciones</th> 
                </thead>
                <tbody id="articles-items">
                    <?php $i=1; ?>
                    <?php foreach($articulos as $articulo) :?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $articulo->code ?></td>
                            <td><?php echo $articulo->nombre ?></td>
                            <td><?php echo $articulo->descripcion ?></td>
                            <td><?php echo $articulo->categoriaId ?></td>
                            <td><?php echo 0 ?></td>
                            <td><?php echo 0 ?></td>
                            <td><?php echo ($articulo->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
                            <td class="d-inline-flex">
                                <button type="button" id="btn-article-" class="btn btn-success btn-xs btn-article-edit-show" data-toggle="modal" data-target="#modal-article-edit2" data-articulo="<?php echo $articulo->articuloId ?>"><i class="glyphicon glyphicon-edit"></i> Editar</button>
                                <button type="button" id="btn-article-2" class="btn btn-warning btn-xs btn-article-delete"><i class="glyphicon glyphicon-remove" data-articulo="<?php echo $articulo->articuloId ?>"></i> Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /Content area -->
</div>
<!-- /Main content -->


<!-- Modal Registrar Articulo-->
<div class="modal fade bg-lg" id="modal-article-add" tabindex="-1" role="dialog" aria-labelledby="modal-article-add">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header modal-header-custom">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="modal-title">Nuevo Artículo</h4>
      </div>
      <form action="" method="POST" class="form-horizontal" name="form-article-add" id="form-article-add">
      <div class="modal-body">
         <div class="alert alert-warning" id="form-article-add-error" style="display: none"><b>¡ERROR!</b> artículo ya existe</div>
         <input type="hidden" name="articuloId" id="usuarioId" value="0" />
         <div class="form-group">
               <label for="categoria" class="col-sm-2 control-label">Categoria: </label>
               <div class="col-sm-4">                  
                  <select name="categoria" id="categoria" class="form-control">
                     <option value="">.. Seleccione ..</option>
                     <?php foreach ($categorias as $categoria) : ?>
                     <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <label for="code" class="col-sm-1 control-label">Code: </label>
               <div class="col-sm-3"><input type="text" class="form-control" name="code" id="code" placeholder="Código" readonly></div>
               <button class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="left" title="Desbloquear"><i class="glyphicon glyphicon-lock"></i></button>
         </div>
         <div class="form-group">
               <label for="nombre" class="col-sm-2 control-label">Nombre: </label>
               <div class="col-sm-6"><input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre"></div>
         </div>
         <div class="form-group">
               <label for="descripcion" class="col-sm-2 control-label">Descripción: </label>
               <div class="col-sm-8"><input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción"></div>
         </div>
         <hr>
         <div class="form-group">
               <label for="unidadMedida" class="col-sm-2 control-label">UM: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="unidadMedida" id="unidadMedida" placeholder="Unidad Medida"></div>
               <label for="marca" class="col-sm-1 control-label">Marca: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="marca" id="marca" placeholder="Marca"></div>
               <label for="modelo" class="col-sm-1 control-label">Módelo: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="modelo" id="modelo" placeholder="Módelo"></div>
         </div>
         <div class="form-group">
               <label for="talla" class="col-sm-2 control-label">Talla: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="talla" id="talla" placeholder="Talla"></div>
               <label for="color" class="col-sm-1 control-label">Color: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="color" id="color" placeholder="Color"></div>
               <label for="tela" class="col-sm-1 control-label">Tela: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="tela" id="tela" placeholder="Tela"></div>
         </div>
        <div class="form-group">
            <label for="caracteristicas" class="col-sm-2 control-label">Características: </label>
            <div class="col-sm-8">
                <textarea name="caracteristicas" class="form-control" id="caracteristicas" rows="4"></textarea>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label for="estado" class="col-sm-2 control-label">Activo: </label>                
               <div class="col-sm-6"><!--col-sm-offset-2 -->
                  <div class="checkbox"><label><input type="checkbox" name="estado" id="estado" value="1" checked></label></div>
               </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input id="fileInput" name="fileInput[]" type="file" multiple>
            </div>
            <!-- <div class="file-loading ">
                <!-- <input id="file-1" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2"> -->
                <!-- <input id="fileInput" name="fileInput[]" type="file" multiple> -->
            <!-- </div> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" id="btn-article-add">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modificar Articulo-->
<div class="modal fade bg-lg" id="modal-article-edit" tabindex="-1" role="dialog" aria-labelledby="modal-article-edit">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header modal-header-custom">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="modal-title">Nuevo Artículo</h4>
      </div>
      <form action="" method="POST" class="form-horizontal" name="form-article-edit" id="form-article-edit">
      <div class="modal-body">
         <div class="alert alert-warning" id="form-article-edit-error" style="display: none"><b>¡ERROR!</b> artículo ya existe</div>
         <input type="hidden" name="articuloId_edit" id="articuloId_edit" value="0" />
         <div class="form-group">
               <label for="categoria" class="col-sm-2 control-label">Categoria: </label>
               <div class="col-sm-4">                  
                  <select name="categoria_edit" id="categoria_edit" class="form-control">
                     <option value="">.. Seleccione ..</option>
                     <?php foreach ($categorias as $categoria) : ?>
                     <option value="<?php echo $categoria->categoriaId?>"><?php echo $categoria->nombre; ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
               <label for="code" class="col-sm-1 control-label">Code: </label>
               <div class="col-sm-3"><input type="text" class="form-control" name="code_edit" id="code_edit" placeholder="Código" readonly></div>
               <button class="btn btn-info btn-xs" type="button" data-toggle="tooltip" data-placement="left" title="Desbloquear"><i class="glyphicon glyphicon-lock"></i></button>
         </div>
         <div class="form-group">
               <label for="nombre" class="col-sm-2 control-label">Nombre: </label>
               <div class="col-sm-6"><input type="text" class="form-control" name="nombre_edit" id="nombre_edit" placeholder="Nombre"></div>
         </div>
         <div class="form-group">
               <label for="descripcion" class="col-sm-2 control-label">Descripción: </label>
               <div class="col-sm-8"><input type="text" class="form-control" name="descripcion_edit" id="descripcion_edit" placeholder="Descripción"></div>
         </div>
         <hr>
         <div class="form-group">
               <label for="unidadMedida" class="col-sm-2 control-label">UM: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="unidadMedida_edit" id="unidadMedida_edit" placeholder="Unidad Medida"></div>
               <label for="marca" class="col-sm-1 control-label">Marca: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="marca_edit" id="marca_edit" placeholder="Marca"></div>
               <label for="modelo" class="col-sm-1 control-label">Módelo: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="modelo_edit" id="modelo_edit" placeholder="Módelo"></div>
         </div>
         <div class="form-group">
               <label for="talla" class="col-sm-2 control-label">Talla: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="talla_edit" id="talla_edit" placeholder="Talla"></div>
               <label for="color" class="col-sm-1 control-label">Color: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="color_edit" id="color_edit" placeholder="Color"></div>
               <label for="tela" class="col-sm-1 control-label">Tela: </label>
               <div class="col-sm-2"><input type="text" class="form-control" name="tela_edit" id="tela_edit" placeholder="Tela"></div>
         </div>
        <div class="form-group">
            <label for="caracteristicas" class="col-sm-2 control-label">Características: </label>
            <div class="col-sm-8">
                <textarea class="form-control" name="caracteristicas_edit" id="caracteristicas_edit" rows="4"></textarea>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label for="estado" class="col-sm-2 control-label">Activo: </label>                
               <div class="col-sm-6"><!--col-sm-offset-2 -->
                  <div class="checkbox"><label><input type="checkbox" name="estado_edit" id="estado_edit" value="1" checked></label></div>
               </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input id="fileInput_edit" name="fileInput[]" type="file" multiple>
            </div>
            <!-- <div class="file-loading ">
                <!-- <input id="file-1" type="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2"> -->
                <!-- <input id="fileInput" name="fileInput[]" type="file" multiple> -->
            <!-- </div> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" id="btn-article-edit">Guardar</button>
      </div>
      </form>
    </div>
  </div>
</div>