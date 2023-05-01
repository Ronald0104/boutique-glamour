<!-- Main content -->
<div class="content-wrapper">

    <?php
        // echo "<pre>";
        // echo var_dump($usuario);
        // echo "</pre>";
    ?>
    <!-- Page header -->
    <div class="page-header page-header-light">
        <!-- <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Ventas de día</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div> -->
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Ventas</a>
                    <span class="breadcrumb-item active">Listar</span>
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
                <h5 class="card-title"><b>Ventas del día</b></h5>
                <div class="text-warning">
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <i class="icon-star-full" aria-hidden="true"></i>
                </div>
                <div class="group-button">
                    <!-- <button class="btn btn-dark pull-right btn-sale-register-show" id="btn-sale-register-show" data-toggle="modal" data-target="#modal-sale-register" data-option="1"> Alquiler/Venta</button> -->
                    <a class="btn btn-primary pull-right btn-lg btn-sale-search" id="btn-sale-search" href="">
                        Buscar</a>
                    <a class="btn btn-dark pull-right btn-lg btn-sale-register-show" id="btn-sale-register-show"
                        data-option="1" href="/ventas/registrar"> Alquiler/Venta</a>
                    <!-- <a href="#" class="btn btn-success pull-rigth btn-lg btn-sale-register-modal-show" id="btn-sale-register-modal-show">Registrar</a>                         -->
                    <!-- <button class="btn btn-primary pull-right btn-kardex-register" id="btn-show-kardex-2" data-toggle="modal" data-target="#modal-kardex-2" data-option="2"> Salidas</button>                                     -->
                </div>
            </div>
            <div class="card-body inline" style="border-top: 1px solid #ddd; padding-top: 1.2rem">
                <div class="row">
                    <div class="col-12">
                        <form method="GET" action="/ventas/listar" name="frmSaleSearch" id="frmSaleSearch">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="fechaDesde" class="col-md-4 col-form-label">Fecha Desde: </label>
                                        <div class="col-sm-8">
                                            <input type="text" name="fechaDesde" id="fechaDesde" class="form-control"
                                                placeholder="" value="<?php echo $fechaDesde?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="fechaHasta" class="col-md-4 col-form-label">Fecha Hasta: </label>
                                        <div class="col-sm-8">
                                            <input type="text" name="fechaHasta" id="fechaHasta" class="form-control"
                                                placeholder="" value="<?php echo $fechaHasta?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="tienda" class="col-md-4 col-form-label">Tienda: </label>
                                        <div class="col-sm-8">
                                            <?php if($usuario['rol_id'] != "1") : ?>
                                            <select name="tienda" id="tienda" class="form-control">
                                                <?php foreach ($tiendas as $key => $value) : ?>
                                                <?php if ($value->id==$tiendaId) : ?>
                                                <option value="<?=$value->id?>" selected><?=$value->nombre?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php else : ?>
                                            <select name="tienda" id="tienda" class="form-control">
                                                <?php foreach ($tiendas as $key => $value) : ?>
                                                <option value="<?=$value->id?>"
                                                    <?php echo ($value->id==$tiendaId) ? "selected" : "" ?>>
                                                    <?=$value->nombre?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="estado" class="col-md-4 col-form-label">Estado: </label>
                                        <div class="col-sm-8">
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="0" selected>TODOS</option>
                                                <option value="1">RESERVADO</option>
                                                <option value="2">ALQUILADO</option>
                                                <option value="3">DEVUELTO</option>
                                                <option value="4">VENDIDO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="vendedor" class="col-md-4 col-form-label">Vendedor: </label>
                                        <div class="col-sm-8">
                                            <select name="vendedor" id="vendedor" class="form-control">
                                            <?php if($usuario['rol_id'] == "1" || $usuario['rol_id'] == "2") : ?> 
                                                <option value="0" selected>TODOS</option>        
                                                <?php foreach ($vendedores as $vendedor) : ?>                        
                                                    <?php if ($vendedor->usuario_id==$usuario['usuario_id']) : ?>
                                                        <option value="<?php echo $vendedor->usuario_id;?>"><?php echo $vendedor->nombre ." ".$vendedor->apellido_paterno;?></option>
                                                    <?php else: ?>
                                                        <option value="<?php echo $vendedor->usuario_id;?>"><?php echo $vendedor->nombre ." ".$vendedor->apellido_paterno;?></option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>                                       
                                            <?php else : ?>
                                                <?php foreach ($vendedores as $vendedor) : ?>
                                                    <?php if ($vendedor->usuario_id==$usuario['usuario_id']) : ?>
                                                        <option value="<?php echo $vendedor->usuario_id;?>" selected><?php echo $vendedor->nombre ." ".$vendedor->apellido_paterno;?></option>
                                                    <?php endif; ?>                                                 
                                                <?php endforeach; ?>                                        
                                            <?php endif; ?>                                              
                                            </select>                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- datatable-selection-multiple dataTable -->
            <table class="table table-bordered no-footer" id="tbl_sales" data-select="true" data-navigator="true">
                <thead>
                    <!-- <th>Op</th> -->
                    <th style="min-width:85px">N° Venta</th>
                    <!--th>DNI</th-->
                    <!-- <th style="min-width:180px">Nombres y Apellidos</th> -->
                    <th style="min-width:140px">Cliente</th>
                    <th>Estado</th>
                    <th style="min-width:115px">Fecha Registro</th>
                    <th style="min-width:120px">Fecha Recogo</th>
                    <!-- <th>Fecha Devolución</th> -->
                    <th style="min-width:100px">Importe</th>
                    <th style="min-width:100px">A Cuenta Ant.</th>
                    <!-- <th>A Cuenta</th> -->
                    <th style="min-width:100px">Efectivo</th>
                    <th style="min-width:100px">Tarjeta</th>
                    <th style="min-width:100px">Saldo</th>
                    <th style="min-width:100px">Garantia</th>
                    <!-- <th>Opciones</th> -->
                </thead>
                <!-- Colocar en una vista  -->
                <tfoot>
                    <tr>
                        <th colspan=5 class="text-right"><h4><b>TOTAL:</b></h4></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /Content area -->
</div>
<!-- /Main content -->

<ul id="contextMenuVentas" class="list-group" role="menu" style="display:none">
    <li class="list-group-item pt-1 pb-1"><a class="text-body font-weight-bold" tabindex="-1" id="mnIrAOperacion" href="#"><i class="fa fa-search"></i> Ir a Operación</a></li>
    <li class="list-group-item pt-1 pb-1"><a class="text-body font-weight-bold" tabindex="-1" id="mnVerCliente" href="#"><i class="fa fa-user"></i> Ver Cliente</a></li>
    <li class="list-group-item pt-1 pb-1"><a class="text-body font-weight-bold" tabindex="-1" id="mnDevolver"
    href="#"><i class="fa fa-check-double"></i> Devolver</a></li>
    <!-- <li class="divider"></li> -->
    <li class="list-group-item pt-1 pb-1"><a class="text-body font-weight-bold" tabindex="-1" id="mnAnular"
    href="#"><i class="fa fa-trash"></i> Anular</a></li>
</ul>
