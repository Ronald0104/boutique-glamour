<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Registro de operaciones</h4>
                <!-- <h4><i class="icon-arrow-left2 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4> -->
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
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
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title"><b>Registrar Operación</b></h5> 
                <div class="text-warning">
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                </div> 
                <div class="group-button">
                    <button class="btn btn-primary pull-right" id="btn-show-article-add" data-toggle="modal" data-target="#modal-article-add">Nuevo Artículo</button>
                    <!-- <a class="btn btn-success" id="btn-load-articles" href="<?php echo base_url()?>inventario/upload"><i class="glyphicon glyphicon-upload" ></i> Cargar Masiva
                    </a>  -->
                </div>                                                               
                <!-- <p class="card-text"></p> -->                  
                <!-- <a href="#" class="btn btn-primary pull-right"></a> -->
            </div> 
            <div class="card-body" id="panel-cabecera" style="border-top: 1px solid #ddd; padding-top: 20px;">                
                <form action="" class="form-horizontal" name="form-kardex-add" id="form-kardex-add"> 
                    <div class="alert alert-warning" id="form-kardex-add-error" style="display: none"><b>¡ERROR!</b> kardex ya existe</div>
                    <input type="hidden" name="kardexId" id="kardexId" value="0" />
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group row">
                                        <label for="tipo" class="col-md-3 col-form-label">Tipo</label>
                                        <div class="col-sm-9">
                                            <select name="tipo" id="tipo" class="form-control">
                                                <option value="1">Ingreso</option>
                                                <option value="2">Salida</option>
                                                <option value="3">Traslado</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group row">
                                        <label for="codigo" class="col-md-3 col-form-label">Código</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Código" value="<?php echo $correlativo; ?>" readonly>
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group row">
                                        <label for="fecha" class="col-md-3 col-form-label">Fecha</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="fecha" id="fecha" class="form-control">        
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group row">
                                        <label for="tienda" class="col-md-3 col-form-label">Tienda</label>
                                        <div class="col-sm-9">
                                            <select name="tienda" id="tienda" class="form-control">
                                            <?php foreach($tiendas as $tienda) :?>
                                            <option value="<?php echo $tienda->id;?>"><?php echo $tienda->nombre;?></option>
                                            <?php endforeach; ?>
                                            </select>       
                                        </div>
                                    </div>
                                </div>        
                            </div>
                        </div>
                    </div>     
                </form>
            </div>
            <!-- Se pasara a un modal -->
            <div class="card-body" id="panel-buscar" style="border-top: 1px solid #ddd; padding-top: 20px;">
                <form action="" class="form-horizontal">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group row">
                                        <label for="buscar" class="col-sm-3 col-form-label">Buscar</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="codeArticulo" id="codeArticulo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group row">
                                        <button type="button" id="btn-kardex-add-item" class="btn btn-success"><i class="icon icon-1"></i></button>
                                        &nbsp;&nbsp;
                                        <button type="button" id="btn-show-article-add-simple" class="btn btn-primary"><i class="icon icon-add"></i></button>
                                        &nbsp;&nbsp;
                                        <button type="button" id="btn-show-article-add" class="btn btn-primary" data-toggle="modal" data-target="#modal-article-add"><i class="icon icon-add"></i></button>
                                    </div>
                                </div>          
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
            <!-- Detalle -->
            <div class="car-body" id="panel-detalle" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 10px;">
                <table class="table table-bordered" id="tbl_kardex">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Código</td>
                            <td>Nombre</td>
                            <td>Cantidad</td>
                            <td>Costo</td>
                            <td>Importe</td>
                            <td colspan="3">Opciones</td>
                        </tr>                    
                    </thead>
                    <tbody id="detalle-kardex">

                    </tbody>
                </table>
            </div>
            <!-- Totales -->
            <div class="card-body" id="panel-totales" style="border-top: 1px solid #ddd; padding-top: 20px; padding-bottom: 20px;">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <h4 class="col-sm-2 offset-7"><b>Total : </b></h4>
                                    <div class="col-sm-3" id="col-total">
                                        <input type="text" class="form-control" name="totalGeneral" id="totalGeneral" readonly>
                                    </div>
                                </div>                                
                            </div>                            
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Content area -->

</div>
<!-- /Main Content -->








<!-- Modal Registrar Articulo-->
<div class="modal fade bg-lg" id="modal-article-add" tabindex="-1" role="dialog" aria-labelledby="modal-article-add">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header modal-header-custom">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="modal-title">Nuevo Artículo</h4>
      </div>
      <form action="" metdod="POST" class="form-horizontal" name="form-article-add" id="form-article-add">
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

<?php
    $tipo = json_decode($inicial);
    $tipo = $tipo->tipo;
?>
<script>
    var tipo = '<?php echo $tipo?>';
</script>