<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <!-- <div class="page-title d-flex">
                <h4>Mantenimiento de usuarios</h4>
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
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Usuarios</span>
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
                        <h5 class="card-title"><b>Mantenimiento de Usuarios</b></h5> 
                        <div class="text-warning">
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                        </div> 
                        <div class="group-button">
                            <button class="btn btn-primary pull-right" id="btn-show-user-add" data-toggle="modal" data-target="#modal-user-add">Nuevo Usuario</button> 
                        </div>                                                               
                        <!-- <p class="card-text"></p> -->                  
                        <!-- <a href="#" class="btn btn-primary pull-right"></a> -->
                    </div>                        
                    <!--div class="car-body">
                        
                    </div> -->
                    <!-- datatable-wrapper no-footer  -->
                    <div class="datatable-scroll" style="border-top: 1px solid #ddd">
                        <!-- <div class="datatable-header">
                            
                        </div> -->
                        <div style="margin-left: 10px; margin-right: 10px;" class="">
                            <table class="table table-hover text-nowrap" id="tblUsuarios" data-select="true" data-navigator="true"> 
                                <thead>
                                    <tr>             
                                        <th><span class="bold">#</span></th>
                                        <th><b>Apellidos y Nombres</b></th>
                                        <th><b>Email</b></th>
                                        <th><b>Rol</b></th>
                                        <th><b>Usuario</b></th>
                                        <th><b>Estado</b></th>
                                        <th><b>Opción</b></th>
                                    </tr>
                                </thead>
                                <tbody id="users-items">
                                    <!-- <tr class="table-border-double">
                                        <td>1</td>
                                        <td>Ronald</td>
                                        <td>Terrones</td>
                                        <td>Celis</td>
                                        <td>abc</td>
                                        <td>opciones</td>
                                    </tr> -->
                                    <?php $i = 1;?>
                                    <?php foreach($usuarios as $usuario) :?>
                                    <tr tabindex="0">
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo $usuario->nombre . " " . $usuario->apellido_paterno ?></td>
                                        <td><?php echo $usuario->email ?></td>
                                        <td><?php echo $usuario->rol ?></td>
                                        <td><?php echo $usuario->usuario ?></td>
                                        <td><?php echo ($usuario->estado == 1) ? 'Activo' : 'Inactivo' ?></td>
                                        <td>
                                            <button type="button" id="" class="btn btn-success btn-xs btn-user-edit-show" data-toggle="modal" data-target="#modal-user-edit2" data-usuario="<?php echo $usuario->usuario_id ?>"><i class="glyphicon glyphicon-edit"></i></button>
                                            <button type="button" id="" class="btn btn-warning btn-xs btn-user-delete"><i class="glyphicon glyphicon-remove" data-usuario-id="<?php echo $usuario->usuario_id ?>"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div> 
                        <!-- <div class="datatable-footer">
                            <p>opciones</p>
                        </div> -->
                    </div>
                    <!-- <div class="card-footer">
                        <p>opciones</p>
                    </div> -->
                </div>
            </div>  

        </div>    
        <!-- /Opciones  -->
    </div>
    <!-- /Content area -->

</div>
<!-- /Main content -->

<!-- Modal registrar usuario -->
<div class="modal fade" id="modal-user-add" tabindex="-1" role="dialog" aria-labelledby="modal-user-add" style="padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-700">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <form action="" method="POST" class="form-horizontal" name="form-user-add" id="form-user-add">
                <div class="modal-body">
                    <div class="alert alert-warning" id="form-user-add-error" style="display: none"><b>¡ERROR!</b> usuario ya existe</div>
                    <input type="hidden" name="usuarioId" id="usuarioId" value="0" />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombres">Nombres:</label>
                                <input type="text" placeholder="Nombres" class="form-control" name="nombres" id="nombres" aria-required>
                            </div>

                            <div class="col-sm-6">
                                <label for="apellidoPaterno">Apellido Paterno:</label>
                                <input type="text" placeholder="Apellido Paterno" class="form-control" name="apellidoPaterno" id="apellidoPaterno">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="apellidoMaterno">Apellido Materno:</label>
                                <input type="text" placeholder="Apellido Materno" class="form-control" name="apellidoMaterno" id="apellidoMaterno">
                            </div>

                            <div class="col-sm-6">
                                <label for="email">Email:</label>
                                <input type="text" placeholder="Email" class="form-control" name="email" id="email">
                                <span class="form-text text-muted">name@domain.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion">Dirección</label>
                                <input type="text" placeholder="Direcciòn" class="form-control" name="direccion" id="direccion">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="celular">Celular: </label>
                                <input type="text" placeholder="Celular" class="form-control" name="celular" id="celular" >               
                            </div>

                            <div class="col-sm-6">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" placeholder="+99-99-9999-9999" data-mask="+99-99-9999-9999" class="form-control" name="telefono" id="telefono">
                                <!-- <span class="form-text text-muted">+99-99-9999-9999</span> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="usuario">Usuario: </label>
                                <input type="text" placeholder="Usuario" class="form-control" name="usuario" id="usuario" >              
                            </div>
                            <div class="col-sm-6">
                                <label for="clave">Clave:</label>
                                <input type="password" placeholder="" class="form-control" name="clave" id="clave">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="confirm-clave">Confirmar Clave: </label>
                                <input type="password" placeholder="Confirmar Clave" class="form-control" name="confirm_clave" id="confirm_clave" >               
                            </div>

                            <div class="col-sm-6">
                                <label for="clave">Activo:</label>                           
                                <label><input type="checkbox" name="estado" id="estado" value="1" checked></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="rol">Rol: </label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="">.. Seleccione ..</option>
                                    <?php foreach ($roles as $rol) : ?>
                                    <option value="<?php echo $rol->id?>"><?php echo $rol->nombre; ?></option>
                                    <?php endforeach; ?>
                                </select>             
                            </div>

                            <div class="col-sm-6">
                                <label for="clave">Tiendas:</label>                         
                                <select name="tiendas" id="tiendas" multiple class="form-control">
                                    <?php foreach($tiendas as $tienda) : ?>
                                    <option value="<?php echo $tienda->id?>"><?php echo $tienda->nombre?></option>
                                    <?php endforeach; ?> 
                                </select> 
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-primary" id="btn-user-add">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modificar usuario -->
<div class="modal fade" id="modal-user-edit" tabindex="-1" role="dialog" aria-labelledby="modal-user-edit" style="padding-right: 17px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-700">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <form action="" method="POST" class="form-horizontal" name="form-user-edit" id="form-user-edit">
                <div class="modal-body">
                    <div class="alert alert-warning" id="form-user-edit-error" style="display: none"><b>¡ERROR!</b> usuario ya existe</div>
                    <input type="hidden" name="usuarioId_edit" id="usuarioId_edit" value="0" />
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombres">Nombres:</label>
                                <input type="text" placeholder="Nombres" class="form-control" name="nombres_edit" id="nombres_edit" aria-required>
                            </div>

                            <div class="col-sm-6">
                                <label for="apellidoPaterno">Apellido Paterno:</label>
                                <input type="text" placeholder="Apellido Paterno" class="form-control" name="apellidoPaterno_edit" id="apellidoPaterno_edit">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="apellidoMaterno">Apellido Materno:</label>
                                <input type="text" placeholder="Apellido Materno" class="form-control" name="apellidoMaterno_edit" id="apellidoMaterno_edit">
                            </div>

                            <div class="col-sm-6">
                                <label for="email">Email:</label>
                                <input type="text" placeholder="Email" class="form-control" name="email_edit" id="email_edit">
                                <span class="form-text text-muted">name@domain.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion">Dirección</label>
                                <input type="text" placeholder="Direcciòn" class="form-control" name="direccion_edit" id="direccion_edit">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="celular">Celular: </label>
                                <input type="text" placeholder="Celular" class="form-control" name="celular_edit" id="celular_edit" >               
                            </div>

                            <div class="col-sm-6">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" placeholder="+99-99-9999-9999" data-mask="+99-99-9999-9999" class="form-control" name="telefono_edit" id="telefono_edit">
                                <!-- <span class="form-text text-muted">+99-99-9999-9999</span> -->
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="usuario">Usuario: </label>
                                <input type="text" placeholder="Usuario" class="form-control" name="usuario_edit" id="usuario_edit" >               
                            </div>

                            <div class="col-sm-6">
                                <label for="clave">Clave:</label>
                                <input type="password" placeholder="" class="form-control" name="clave_edit" id="clave_edit">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="confirm-clave">Confirmar Clave: </label>
                                <input type="password" placeholder="Confirmar Clave" class="form-control" name="confirm_clave_edit" id="confirm_clave_edit" >               
                            </div>

                            <div class="col-sm-6">
                                <label for="clave">Activo:</label>                           
                                <label><input type="checkbox" name="estado_edit" id="estado_edit" value="1" checked></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="rol">Rol: </label>
                                <select name="rol_edit" id="rol_edit" class="form-control">
                                    <option value="">.. Seleccione ..</option>
                                    <?php foreach ($roles as $rol) : ?>
                                    <option value="<?php echo $rol->id?>"><?php echo $rol->nombre; ?></option>
                                    <?php endforeach; ?>
                                </select>             
                            </div>

                            <div class="col-sm-6">
                                <label for="clave">Tiendas:</label>                         
                                <select name="tiendas_edit" id="tiendas_edit" multiple class="form-control">
                                    <?php foreach($tiendas as $tienda) : ?>
                                    <option value="<?php echo $tienda->id?>"><?php echo $tienda->nombre?></option>
                                    <?php endforeach; ?> 
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-primary" id="btn-user-edit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
