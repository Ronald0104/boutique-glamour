<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="header-elements-md-inline"></div>

        <!-- Colocarlo en una seccion aparte -->
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/ventas/listar" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Ventas</a>
                    <span class="breadcrumb-item active">Editar</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i>Ajustes
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <?php 
        // echo "<pre>";
        // echo var_dump($venta);
        // echo "</pre>";
    
        $dataJson = json_encode($venta);  
        $usuarioJson = json_encode($usuario);
        // $obj = new stdClass();
        // $obj->id = 1;
        // $obj->name = "Ronald";
        $dataJson2 = htmlspecialchars(json_encode($venta), ENT_QUOTES, 'UTF-8');
        //$dataJson2 = json_encode($obj, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);         
		
        $fechaRegistro = new DateTime($venta->fechaRegistro);
        $fechaSalidaProgramada = new DateTime($venta->fechaSalidaProgramada);
        $fechaDevolucionProgramada = new DateTime($venta->fechaDevolucionProgramada);
        $venta->fechaRegistro = $fechaRegistro->format("d/m/Y");
        $venta->fechaSalidaProgramada = $fechaSalidaProgramada->format("d/m/Y");
        $venta->fechaDevolucionProgramada = $fechaDevolucionProgramada->format("d/m/Y");

        $cliente = $venta->customer; 
        $detalle = $venta->details;
        $pago = $venta->payments;
        $historial = $venta->historial;

        if ($venta->estadoId == 1){
            $estadoNew = 2;
        } else if ($venta->estadoId == 2) {
            $estadoNew = 3;
        } else {
            $estadoNew = $venta->estadoId;
        }                     
    ?>
    <script>
        var ventaId = <?php echo $venta->ventaId ?>
        // var dataVenta = JSON.parse('<?php echo $dataJson?>');
        var usuarioSesion = JSON.parse('<?php echo $usuarioJson?>');
    </script>
    <!-- Content area -->
    <div class="content">
        <div>
            <div class="card mb-2">
                <!-- Opciones de cabecera -->
                <div class="card-header header-elements-inline">
                    <input type="hidden" name="venta" id="venta" data-venta="<?=$dataJson2?>" value="<?=$dataJson?>">         
                    <h5 class="card-title" data-venta="<?php echo str_pad($venta->ventaId, 6, '0', STR_PAD_LEFT) ?>">
                    <?php if($venta->nroOperacion=="") :?>
                        <b>VENTA: N° <?php echo str_pad($venta->ventaId, 6, '0', STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;".(($venta->anulado==1) ? '<span style="color:red">ANULADO</span>' : '' )?></b>
                    <?php else : ?>
                        <b>VENTA: N° <?php echo $venta->nroOperacion."&nbsp;&nbsp;&nbsp;".(($venta->anulado==1) ? '<span style="color:red">ANULADO</span>' : '' ) ?></b>
                    <?php endif; ?>
                    </h5>
                    <div class="group-button">
                    <?php if($venta->anulado==0): ?>
                        <button class="btn btn-dark btn-lg pull-right" id="btn-save-sale"><i class="icon icon-floppy-disk"></i> &nbsp;Guardar</button>
                        <button class="btn btn-blue btn-lg pull-right" id="btn-print-sale"><i class="fa fa-print"></i> &nbsp;Imprimir</button>
                        <button class="btn btn-success btn-lg pull-right" id="btn-check-sale" style="margin-left: 60px;" data-estado="<?=$estadoNew?>"><i class="fa fa-check"></i> &nbsp;Atender</button>
                    <?php endif; ?>                        
                    </div>
                </div>
            </div>
            <!-- Datos Venta y Cliente -->
            <div class="card mb-2">
                <div class="card-header bg-info">
                    <h6 class="card-title">
                        <a data-toggle="collapse" class="text-white" href="#collapsible-styled-group1" aria-expanded="true">Datos Venta</a>
                    </h6>
                </div>
                <div id="collapsible-styled-group1" class="collapse show" style="">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-top">
                            <li class="nav-item"><a href="#top-tab-venta" class="nav-link font-weight-bold active show" data-toggle="tab">Datos Venta</a></li>
                            <li class="nav-item"><a href="#top-tab-cliente" class="nav-link font-weight-bold" data-toggle="tab">Datos Cliente</a></li>
                            <li class="nav-item"><a href="#top-tab-historial" class="nav-link font-weight-bold" data-toggle="tab">Historial</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="top-tab-venta">
                                <form action="" class="form-horizontal form-body" name="form-sale-edit" id="form-sale-edit">
                                    <div class="alert alert-warning" id="form-sale-edit-error" style="display: none"><b>¡ERROR!</b> ya existe</div>
                                    <input type="hidden" name="saleId" id="saleId" value="<?=$venta->ventaId?>" />
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                    <label for="tipoOperacion" class="col-md-4 col-form-label">Operación: </label>
                                                        <div class="col-md-8">
                                                            <select name="tipoOperacion" id="tipoOperacion" class="form-control">
                                                                <option value="1" <?=($venta->tipoId==1) ? "selected" : "" ?>>ALQUILER</option>
                                                                <option value="2" <?=($venta->tipoId==2) ? "selected" : "" ?>>VENTA</option>
                                                                <option value="3" <?=($venta->tipoId==3) ? "selected" : "" ?>>SERVICIO</option>	
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="estado" class="col-md-4 col-form-label">Estado: </label>
                                                        <div class="col-md-8">
                                                            <select name="estado" id="estado" class="form-control text-uppercase" data-estado-anterior="<?=$venta->estadoId?>">
                                                                <option value="1" <?=($venta->estadoId==1) ? "selected" : "" ?>>Reservado</option>
                                                                <option value="2" <?=($venta->estadoId==2) ? "selected" : "" ?>>Alquilado</option>
                                                                <option value="3" <?=($venta->estadoId==3) ? "selected" : "" ?>>Devuelto</option>
                                                                <option value="4" <?=($venta->estadoId==4) ? "selected" : "" ?>>Vendido</option>
                                                                <option value="6" <?=($venta->estadoId==6) ? "selected" : "" ?>>Servicio</option>
                                                            </select>

                                                            <!-- <select name="estado" id="estado" class="form-control" disabled="true">
                                                                <?php //foreach($estados as $estado) {
                                                                    //echo "<option value='$vendedor->usuario_id'";
                                                                    //if($venta->vendedorId == $vendedor->usuario_id) { echo "selected";}
                                                                    //echo ">";
                                                                    //echo $vendedor->nombre ." ".$vendedor->apellido_paterno;
                                                                    //echo "</option>";
                                                                //} ?>
                                                            </select>
                                                            <input type="text" name="estado" id="estado" class="form-control text-uppercase" value="<?=$venta->estado?>" readonly="true" data-estado-id="<?=$venta->estadoId?>"> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="fechaRegistro" class="col-md-4 col-form-label">Fecha Registro: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="fechaRegistro" id="fechaRegistro" class="form-control" value="<?=$venta->fechaRegistro?>" readonly="true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="vendedor" class="col-md-4 col-form-label">Vendedor:</label>
                                                        <div class="col-md-8">
                                                            <select name="vendedor" id="vendedor" class="form-control" disabled="true">
                                                                <?php foreach($vendedores as $vendedor) {
                                                                    echo "<option value='$vendedor->usuario_id'";
                                                                    if($venta->vendedorId == $vendedor->usuario_id) { echo "selected";}
                                                                    echo ">";
                                                                    echo $vendedor->nombre ." ".$vendedor->apellido_paterno;
                                                                    echo "</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tienda" class="col-md-4 col-form-label">Tienda: </label>
                                                        <div class="col-md-8">
                                                            <?php $disabledTienda = ($usuario['rol_id'] != "1") ? true : false;
                                                            // echo gettype($disabledTienda) 
                                                            ?>
                                                            <select name="tienda" id="tienda" class="form-control" disabled="true">
                                                                <?php foreach($tiendas as $tienda) {
                                                                    echo "<option value='$tienda->id'";
                                                                    if($venta->tiendaId == $tienda->id) { echo "selected";}
                                                                    echo ">";
                                                                    echo $tienda->nombre;
                                                                    echo "</option>";
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">                                                      
                                                        <label for="tipo" class="col-md-4 col-form-label">Fecha Recogo: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="fechaSalida" id="fechaSalida" class="form-control" value="<?=$venta->fechaSalidaProgramada?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tipo" class="col-md-4 col-form-label">Fecha Devol.: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="fechaDevolucion" id="fechaDevolucion" class="form-control" value="<?=$venta->fechaDevolucionProgramada?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <div class="row">
                                                                <div class="col-sm-10 col-md-12 col-lg-12">
                                                                    <div class="form-group row">
                                                                        <label for="observacionesVenta" class="col-md-3 col-lg-2 col-form-label">Observ.: </label>
                                                                        <div class="col-md-9 col-md-9">
                                                                            <textarea name="observacionesVenta" id="observacionesVenta" cols="30" rows="2" class="form-control"><?=$venta->observaciones?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="dejoDocumento" id="dejoDocumento" <?=($venta->dejoDocumento==1) ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="dejoDocumento">
                                                                    DNI o Pasaporte
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="dejoRecibo" id="dejoRecibo" <?=($venta->dejoRecibo==1) ? 'checked' : '' ?>>
                                                                <label class="form-check-label" for="dejoRecibo">
                                                                    Récibo de agua o luz
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="top-tab-cliente">
                                <form action="" class="form-horizontal form-body" name="form-customer-edit" id="form-customer-edit" autocomplete="nope">
                                    <div class="alert alert-warning" id="form-customer-edit-error" style="display: none"><b>¡ERROR!</b> ya existe</div>
                                    <input type="hidden" name="customerId" id="customerId" value="<?=$cliente->clienteId?>" />
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tipoDocumento" class="col-md-4 col-form-label">Tipo Doc.: </label>
                                                        <div class="col-md-8">
                                                            <select name="tipoDocumento" id="tipoDocumento" class="form-control">
                                                                <option value="">..Seleccione..</option>
                                                                <option value="1" <?=($cliente->tipo_documento==1) ? 'selected' : '' ?>>DNI</option>
                                                                <option value="2" <?=($cliente->tipo_documento==2) ? 'selected' : '' ?>>Pasaporte</option>
                                                                <option value="3" <?=($cliente->tipo_documento==3) ? 'selected' : '' ?>>RUC</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="nroDocumeto" class="col-md-4 col-form-label">N° Documento: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="nroDocumento" id="nroDocumento" class="form-control" placeholder="Nro. Documento" minlength=8 maxlength=15 value="<?=$cliente->nro_documento?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="nombres" class="col-md-4 col-form-label">Nombres: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres" value="<?=$cliente->nombres?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="apellidos" class="col-md-4 col-form-label">Apellidos: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos" value="<?=$cliente->apellido_paterno?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="telefono" class="col-sm-4 col-form-label">Teléfono: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono" value="<?=$cliente->telefono?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="email" class="col-sm-4 col-form-label">Email: </label>
                                                        <div class="col-md-8">
                                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?=$cliente->email?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <div class="form-group row">
                                                        <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                                                        <div class="col-md-8 col-lg-8">
                                                            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección" value="<?=$cliente->direccion?>">
                                                        </div>
                                                        <div class="col-sm-2 col-md-2 col-lg-2">
                                                            <button class="btn btn-blue" data-toggle="modal" data-target="#modal-show-customer" id="btn-show-modal-customer"><i class="icon icon-user-plus" data-cliente="<?=$cliente->clienteId?>"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <div class="form-group row">
                                                        <label for="observaciones" class="col-sm-2 col-md-2 col-lg-2 col-form-label">Observ.: </label>
                                                        <div class="col-md-8">
                                                            <textarea name="observaciones" id="observaciones" cols="30" rows="2" class="form-control"><?=$cliente->observaciones?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="calificacion" class="col-sm-4 col-md-4 col-form-label">Calificación: </label>
                                                        <div class="col-sm-8 pt-1">
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
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="top-tab-historial">
                                <div class="col-sm-10">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" data-select="true" data-navigator="true">
                                                <thead>
                                                    <tr>
                                                        <th>Estado</th>
                                                        <!-- <th>Vendedor</th> -->
                                                        <th>Usuario</th>
                                                        <th>Tienda</th>
                                                        <th>Fecha</th>
                                                        <th>Descripción</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl-history-sale">
                                                    <?php $i=1;?>
                                                    <?php foreach($historial as $item) : ?>
                                                    <?php $fecha = new DateTime($item->fecha)?>
                                                    <tr data-historial="<?=$item->historialId?>" tabindex="0">
                                                        <td data-estado="<?=$item->estadoId?>"><?=$item->estado?></td>
                                                        <!-- <td data-vendedor="<?=$item->vendedorId?>"><?=$item->vendedor?></td> -->
                                                        <td data-usuario="<?=$item->usuarioId?>"><?=$item->usuario?></td>
                                                        <td data-tienda="<?=$item->tiendaId?>"><?=$item->tienda?></td>
                                                        <td><?=$fecha->format('d/m/Y H:i:s')?></td>
                                                        <td><?=$item->observaciones?></td>
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
                </div>
            </div>
            <!-- Detalle Venta -->
            <div class="card mb-2">
                <div class="card-header bg-slate">
                    <h6 class="card-title">
                        <a class="text-white" data-toggle="collapse" href="#collapsible-styled-group2" aria-expanded="true">Detalle Venta</a>
                    </h6>
                </div>
                <div id="collapsible-styled-group2" class="collapse show" style="">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group row">
                                            <label for="codigoArticulo" class="col-sm-3 col-form-label">Código:</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="codigoArticulo" id="codigoArticulo" class="form-control" maxlength="15">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6">
                                        <div class="form-group row">
                                            <button id="btn-add-article-full" class="btn btn-success"><i class="icon icon-add-to-list"></i></button>
                                            &nbsp;&nbsp;
                                            <button id="btn-show-search-article" class="btn btn-primary"><i class="icon icon-search4"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- <h6 class="font-weight-bold"><u>Detalle Venta</u></h6> -->
                        <div class="table-responsive">
                            <table class="table table-bordered" data-select="true" data-navigator="true">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Precio Sugerido</th>
                                        <th>Precio Venta</th>
                                        <th class="center">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl-detail-sale">
                                    <?php $i=1;?>
                                    <?php foreach($detalle as $item) : ?>
                                    <tr data-item="<?=""?>" data-id="<?=$item->id?>" data-articulo="<?=$item->articuloId?>" data-tipo="<?=$item->tipo?>" data-accion="1" tabindex="0">
                                        <td><?=$i++?></td>
                                        <td><?=$item->articuloCode?></td>
                                        <td><?=($item->articuloCode == "GEN00000001") ? $item->descripcion_alternativa : $item->articuloNombre?></td>
                                        <td><?=$item->precioAlquiler?></td>
                                        <?php if($usuario['rol_id'] == 1) : ?>
                                            <td data-precio="<?=$item->precioVenta?>"><input type="number" name="item-precio" class="form-control txt-precio-item" value="<?=$item->precioVenta?>"></td>
                                        <?php  else : ?>    
                                            <td data-precio="<?=$item->precioVenta?>"><input type="number" name="item-precio" class="form-control txt-precio-item" value="<?=$item->precioVenta?>" readonly /></td>
                                        <?php endif; ?>                                        
                                        <td style="width: 170px">
                                        <div class="center">
                                                <button class="btn btn-sm btn-blue btn-item-show" data-item="<?=$item->articuloId?>"><i class="icon icon-clipboard6"></i></button>
                                                <?php if($usuario['rol_id'] == 1) : ?>
                                                    <button class="btn btn-sm btn-danger btn-item-delete" data-item="<?=$item->articuloId?>"><i class="icon icon-bin"></i></button>
                                                <?php  else : ?>  
                                                    <button class="btn btn-sm btn-danger btn-item-delete" data-item="<?=$item->articuloId?>"><i class="icon icon-bin"></i></button>
                                                <?php endif; ?>
                                                <button class="btn btn-sm btn-dark btn-item-schedule" data-item="<?=$item->articuloId?>"><i class="icon icon-calendar22"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cancelación -->
            <div class="card mb-2">
                <div class="card-header bg-purple">
                    <h6 class="card-title">
                        <a class="text-white" data-toggle="collapse" href="#collapsible-styled-group3" aria-expanded="true">Cancelación</a>
                    </h6>
                </div>
                <div id="collapsible-styled-group3" class="collapse show" style="">
                    <div class="card-body">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-8 col-lg-9">
                                    <div class="row">
                                        <div class="card mb-0 mr-3" style="width: 100%">
                                            <div class="card-body inline pb-0">
                                                <div class="row">
                                                    <!-- <form class="form" role="form" autocomplete="off"> -->
                                                    <div class="col-sm-4">
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label form-control-label">Efectivo:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="number" name="totalEfectivo" id="totalEfectivo" value="<?=$venta->totalEfectivo?>" readonly="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label form-control-label">Tarjeta:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="number" name="totalTarjeta" id="totalTarjeta" value="<?=$venta->totalTarjeta?>" readonly="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label form-control-label">Vuelto:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="number" name="totalVuelto" id="totalVuelto" value="<?=$venta->totalVuelto?>" readonly="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- </form> -->
                                                </div>
                                            </div>
                                            <div class="card-body inline">
                                                <div class="row mb-1">
                                                    <div class="col-sm-4">
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label form-control-label">Forma Pago:</label>
                                                            <div class="col-lg-8">
                                                                <select name="tipoPago" id="tipoPago" class="form-control">
                                                                    <!-- <option value="">..Seleccione..</option> -->
                                                                    <option value="1">EFECTIVO</option>
                                                                    <option value="2">VISA</option>
                                                                    <option value="3">MASTERCARD</option>
                                                                    <option value="4">VUELTO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label form-control-label">Monto:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="number" name="montoPago" id="montoPago">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label form-control-label">N° Tarjeta:</label>
                                                            <div class="col-lg-8">
                                                                <input class="form-control" type="text" name="nroTarjeta" id="nroTarjeta">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-11">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" data-select="true" data-navigator="true">
                                                                <thead>
                                                                    <th>Forma Pago</th>
                                                                    <th>Ingreso</th>
                                                                    <th>Salida</th>
                                                                    <th>N° Tarjeta</th>
                                                                    <th>Fecha</th>
                                                                    <th>Asesor</th>
                                                                    <th></th>
                                                                </thead>
                                                                <tbody id="tbl-forma-pago">
                                                                    <?php foreach ($pago as $key => $item) : ?>
                                                                    <?php  $fecha = new DateTime($item->fecha); ?>
                                                                    <tr data-pago="<?=$item->pagoId?>" tabindex=0>
                                                                        <td data-tipo-pago="<?=$item->tipoPagoId?>"><?=$item->tipoPago?></td>
                                                                        <td><?=$item->ingreso?></td>
                                                                        <td><?=$item->salida?></td>
                                                                        <td><?=$item->nroTarjeta?></td>
                                                                        <td><?=$fecha->format('d/m/Y H:i')?></td>
                                                                        <td><?=$item->usuario?></td>
                                                                        <td></td>
                                                                    </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button class="btn btn-blue" id="btn-add-pago"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-lg-3">
                                    <div class="row">
                                        <div class="container">
                                            <div class="row">
                                                <div class="mx-auto">
                                                    <!-- form user info -->
                                                    <div class="card mb-0" style="width: 100%">
                                                        <div class="card-header bg-green-800 p-2">
                                                            <h5 class="mb-0 font-weight-bold text-center">CANCELACIÓN</h5>
                                                        </div>
                                                        <div class="card-body inline">
                                                            <!-- <form class="form" role="form" autocomplete="off"> -->
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold"> TOTAL:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" name="totalGeneral" id="totalGeneral" value="<?=$venta->precioTotal?>" readonly="true" data-total-general="<?=$venta->precioTotal?>" style="font-size:1rem">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">A CUENTA:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" name="totalPagado" id="totalPagado" value="<?=$venta->totalPagado?>" readonly="true" data-total-pagado="<?=$venta->totalPagado?>" style="font-size:1rem">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">SALDO:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" name="totalSaldo" id="totalSaldo" value="<?=$venta->totalSaldo?>" readonly="true" data-total-saldo="<?=$venta->totalSaldo?>" style="font-size:1rem">
                                                                </div>
                                                            </div>
															<div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">GARANTIA:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" name="totalGarantia" id="totalGarantia" value="<?=$venta->totalGarantia?>" data-total-garantia="<?=0?>" style="font-size:1rem">
                                                                </div>
                                                            </div>
                                                            <!-- </form> -->
                                                        </div>
                                                    </div>
                                                    <!-- /form user info -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Historial Cliente -->
            <div class="card mb-2">
                <div class="card-header bg-brown-600">
                    <h6 class="card-title">
                        <a class="text-white" data-toggle="collapse" href="#collapsible-styled-group4" aria-expanded="true">Historial Cliente</a>
                    </h6>
                </div>
                <div id="collapsible-styled-group3" class="collapse show" style="">
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /Content area -->

</div>
<!-- /Main Content -->


<!-- Modal buscar producto -->
<div class="modal fade" id="modal-search-article2" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-width="65%">
    <div class="modal-dialog modal-lg w-75" role="document">
        <div class="modal-content">
            <div class="modal-header  bg-brown-600">
                <h4 class="modal-title">Buscar Prenda</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="#" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <label for="codigo" class="col-form-label col-md-2">Código:</label>
                                        <div class="col-md-3">
                                            <input type="text" name="codigo" id="codigo" class="form-control">
                                        </div>
                                        <button class="btn btn-dark btn-xs col-md-1" id="btn-search-article"><i class="icon icon-search4"></i></button>
                                        <div class="col-md-6">
                                            <input type="text" name="descripcion-producto" id="descripcion-producto" class="form-control">
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row table-responsive" style="max-height: 400px">
                                    <table class="table tabbable table-bordered">
                                        <thead>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Categoría</th>
                                            <th>Estado</th>
                                            <th>Precio Sugerido</th>
                                            <th></th>
                                        </thead>
                                        <tbody id="list-articles-search">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary" id="btn-add-article">Agregar</button>
            </div>
        </div>
    </div>
</div>