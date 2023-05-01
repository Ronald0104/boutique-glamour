<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <!-- <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Registro de Alquiler / Venta</h4>
                <h4><i class="icon-arrow-left2 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div> -->
        <div class="header-elements-md-inline"></div>

        <!-- Colocarlo en una seccion aparte -->
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/ventas" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Ventas</a>
                    <span class="breadcrumb-item active">Registrar</span>
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
<!-- 
    <?php
        echo "<pre>";
        echo print_r($usuario);
        echo "</pre>";
    ?> -->

    <!-- Content area -->
    <div class="content">
        <div class="card">
            <!-- Opciones de cabecera -->
            <div class="card-header header-elements-inline pt-2 pb-2">
                <h5 class="card-title mt-0"><b>Registrar Venta</b></h5>
                <!-- <div class="text-warning">
                    <?php for ($i=0; $i < 5; $i++) :  ?>
                    <i class="icon-star-full" aria-hidden="true"></i>
                    <?php endfor; ?>
                </div> -->
                <div class="group-button d-none d-sm-block">
                    <button class="btn btn-blue btn-lg pull-right" id="btn-new-sale" ><i class="fa fa-file-medical"></i> &nbsp;Nuevo</button>
                    <!-- <button class="btn btn-primary btn-lg pull-right" id="btn-reniec" data-toggle="modal" data-target="#modal">Nuevo</button> -->                    
                    <!-- <a class="btn btn-success" id="btn-load-articles" href="<?php echo base_url()?>inventario/upload"><i class="glyphicon glyphicon-upload" ></i> Cargar Masiva
                    </a>  -->
                </div>
                <div class="group-button">
                    <button class="btn btn-dark btn-lg pull-right" id="btn-register-sale"><i class="icon icon-floppy-disk"></i> &nbsp;Registrar</button>
                </div>
                <!-- <p class="card-text"></p> -->
                <!-- <a href="#" class="btn btn-primary pull-right"></a> -->
            </div>
            <!-- Venta y Cliente -->
            <div class="card mb-0" style="border-left:0; border-right:0">
                <div class="card-header bg-info pt-2 pb-2">
                    <h6 class="card-title mt-0">
                        <a data-toggle="collapse" class="text-white" href="#collapsible-styled-group1" aria-expanded="true">Datos Venta</a>
                    </h6>
                </div>
                <div id="collapsible-styled-group1" class="collapse show" style="">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-tabs-top">
                            <li class="nav-item"><a href="#top-tab-venta" class="nav-link font-weight-bold active show" data-toggle="tab">Datos Venta</a></li>
                            <li class="nav-item"><a href="#top-tab-cliente" id="btn-tab-cliente" class="nav-link font-weight-bold" data-toggle="tab">Datos Cliente</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="top-tab-venta">
                                <form action="" class="form-horizontal form-body" name="form-sale-add" id="form-sale-add">
                                    <div class="alert alert-warning" id="form-sale-add-error" style="display: none"><b>¡ERROR!</b> ya existe</div>
                                    <input type="hidden" name="saleId" id="saleId" value="0" />
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="nroOperacion" class="col-md-4 col-form-label d-none d-sm-block">N° Operación: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="nroOperacion" id="nroOperacion" class="form-control" placeholder="" readonly="true">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tipoOperacion" class="col-md-4 col-form-label d-none d-sm-block">Operación: </label>
                                                        <div class="col-md-8">
                                                            <select name="tipoOperacion" id="tipoOperacion" class="form-control">
                                                                <option value="1">ALQUILER</option>
                                                                <option value="2">VENTA</option>
                                                                <option value="3">SERVICIO</option>	
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="estado" class="col-md-4 col-form-label d-none d-sm-block">Estado: </label>
                                                        <div class="col-md-8">
                                                            <select name="estado" id="estado" class="form-control">
                                                                <option value="1">RESERVADO</option>
                                                                <option value="2">ALQUILADO</option>
                                                                <!-- <option value="4">VENDIDO</option>
																<option value="6">SERVICIO</option> -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tienda" class="col-md-4 col-form-label d-none d-sm-block">Tienda: </label>
                                                        <div class="col-md-8">
                                                            <select name="tienda" id="tienda" class="form-control">
                                                                <?php foreach($tiendas as $tienda) :?>
                                                                <?php if($tienda->id == $usuario['tienda_sel']) :?>
                                                                <option value="<?php echo $tienda->id;?>"><?php echo $tienda->nombre ?></option>
                                                                <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="vendedor" class="col-md-4 col-form-label d-none d-sm-block">Vendedor:</label>
                                                        <div class="col-md-8">
                                                            <select name="vendedor" id="vendedor" class="form-control">
                                                                <?php foreach($vendedores as $vendedor) :?>
                                                                <option value="<?php echo $vendedor->usuario_id;?>"><?php echo $vendedor->nombre ." ".$vendedor->apellido_paterno;?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tipo" class="col-md-4 col-form-label">Fecha Registro: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="fechaRegistro" id="fechaRegistro" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>                                                                                         
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tipo" class="col-md-4 col-form-label">Fecha Recogo: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="fechaSalida" id="fechaSalida" class="form-control" placeholder="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tipo" class="col-md-4 col-form-label">Fecha Devol.: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="fechaDevolucion" id="fechaDevolucion" class="form-control" placeholder="">
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
                                                                            <textarea name="observacionesVenta" id="observacionesVenta" cols="30" rows="2" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="tieneDocumento" id="tieneDocumento">
                                                                <label class="form-check-label" for="tieneDocumento">
                                                                    DNI o Pasaporte
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="tieneRecibo" id="tieneRecibo">
                                                                <label class="form-check-label" for="tieneRecibo">
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
                                <form action="" class="form-horizontal form-body" name="form-customer-add" id="form-customer-add" autocomplete="nope">
                                    <div class="alert alert-warning" id="form-customer-add-error" style="display: none"><b>¡ERROR!</b> ya existe</div>
                                    <input type="hidden" name="customerId" id="customerId" value="0" />
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="tipoDocumento" class="col-md-4 col-form-label">Tipo Doc.: </label>
                                                        <div class="col-md-8">
                                                            <select name="tipoDocumento" id="tipoDocumento" class="form-control">
                                                                <option value="">..Seleccione..</option>
                                                                <option value="1">DNI</option>
                                                                <option value="2">Pasaporte</option>
                                                                <option value="3">RUC</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="nroDocumeto" class="col-md-4 col-form-label">N° Documento: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="nroDocumento" id="nroDocumento" class="form-control" placeholder="Nro. Documento" minlength=8 maxlength=15>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="nombres" class="col-md-4 col-form-label">Nombres: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Nombres">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="apellidos" class="col-md-4 col-form-label">Apellidos: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Apellidos">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="telefono" class="col-sm-4 col-form-label">Teléfono: </label>
                                                        <div class="col-md-8">
                                                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Teléfono">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                    <div class="form-group row">
                                                        <label for="email" class="col-sm-4 col-form-label">Email: </label>
                                                        <div class="col-md-8">
                                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <div class="form-group row">
                                                        <label for="direccion" class="col-sm-2 col-form-label">Dirección</label>
                                                        <div class="col-md-8 col-lg-8">
                                                            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección">
                                                        </div>
                                                        <div class="col-sm-2 col-md-2 col-lg-2">
                                                            <button class="btn btn-blue" data-toggle="modal" data-target="#modal-show-customer" id="btn-show-modal-customer"><i class="icon icon-user-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 col-lg-8">
                                                    <div class="form-group row">
                                                        <label for="observaciones" class="col-sm-2 col-md-2 col-lg-2 col-form-label">Observ.: </label>
                                                        <div class="col-md-8">
                                                            <textarea name="observaciones" id="observaciones" cols="30" rows="2" class="form-control"></textarea>
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
                        </div>
                    </div>
                </div>
            </div>
            <!-- Venta -->
            <!-- <div class="card-body inline" id="panel-venta" style="padding-top: 1.2rem">
            </div> -->
            <!-- Cliente -->
            <!-- <div class="card-body inline" id="panel-cliente">
            </div> -->
            <!-- Buscar -->
            <div class="card-body inline" id="panel-buscar">
                <form action="" class="form-horizontal form-body" name="form-search-code" id="form-search-code">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group row">
                                        <label for="codigoArticulo" class="col-sm-3 col-form-label">Código:</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="codigoArticulo" id="codigoArticulo" class="form-control" maxlength="11">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group row">
                                        <button id="btn-add-article-full" class="btn btn-success"><i class="icon icon-add-to-list" data-toggle="modal" data-target="#modal-show-customer"></i></button>
                                        &nbsp;&nbsp;
                                        <!-- <button id="btn-show-search-article" class="btn btn-primary"><i class="icon icon-search4"></i></button> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Detalle y Cancelacion -->
            <!-- <div class="card-body" id="panel-detalle-cancelacion" style="padding-top: 20px; padding-bottom: 10px; display: none">
                <div class="row">
                    <div class="tabs">
                        <div class="tab-button-outer">
                            <ul id="tab-button">
                                <li><a href="#tab01">Detalle</a></li>
                                <li><a href="#tab02">Cancelación</a></li>
                            </ul>
                        </div>
                        <div class="tab-select-outer">
                            <div class="col-sm-12">
                                <div class="container">
                                    <select id="tab-select" class="form-control">
                                        <option value="#tab01">Detalle</option>
                                        <option value="#tab02">Pago</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="tab01" class="tab-contents">
                            <h4>Tab 1</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Código</td>
                                            <td>Nombre</td>
                                            <td>Categoria</td>                                        
                                            <td>Precio</td>      
                                            <td class="center">Opciones</td>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl-detail-sale">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="tab02" class="tab-contents">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-4 col-lg-3">
                                        <div class="row">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="mx-auto">
                                                        
                                                        <div class="card" style="width: 100%">
                                                            <div class="card-header bg-green-800 p-2">
                                                    <h5 class="mb-0 font-weight-bold text-center">CANCELACIÓN</h5>
                                                </div>
                                                            <div class="card-body">
                                                                <form class="form" role="form" autocomplete="off">
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label form-control-label font-weight-bold">Total:</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="number" value="" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label form-control-label font-weight-bold">A cuenta:</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="number" value="" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-4 col-form-label form-control-label font-weight-bold">Saldo:</label>
                                                                    <div class="col-lg-8">
                                                                        <input class="form-control" type="number" value="" readonly>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-lg-9">
                                        <div class="row">
                                            <div class="card ml-3" style="width: 100%">
                                                <div class="card-body inline">
                                                    <div class="row">                                                        
                                                        <div class="col-sm-4">
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">Efectivo:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">Tarjeta:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" value="" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">Vuelto:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" value="">
                                                                </div>
                                                            </div>
                                                        </div>                                                     
                                                    </div>
                                                </div>
                                                <div class="card-body inline">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">Tarjeta:</label>
                                                                <div class="col-lg-8">
                                                                    <select name="" id="" class="form-control">
                                                                        <option value="">..Seleccione..</option>
                                                                        <option value="2">VISA</option>
                                                                        <option value="1">MASTERCARD</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">N° Tarjeta:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="text" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group row">
                                                                <label class="col-lg-4 col-form-label form-control-label font-weight-bold">Monto:</label>
                                                                <div class="col-lg-8">
                                                                    <input class="form-control" type="number" value="" readonly>
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
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Detalle -->
            <div class="card-body" id="panel-detalle" style="padding-top: 20px; padding-bottom: 10px;">
                <div class="table-responsive">
                <table class="table table-bordered" data-select="true" data-navigator="true">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Código</td>
                            <td>Nombre</td>
                            <td>Categoria</td>
                            <!-- <td>Cantidad</td> -->
                            <td style="min-width:65px">Precio</td>
                            <!-- <td>Importe</td> -->
                            <td class="center">Opciones</td>
                        </tr>
                    </thead>
                    <tbody id="tbl-detail-sale">

                    </tbody>
                </table>
                </div>                                                                                    
            </div>
            <!-- Cancelacion -->
            <div class="card-body" id="panel-cancelacion">
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
                                                        <input class="form-control" type="number" name="totalEfectivo" id="totalEfectivo" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label form-control-label">Vuelto:</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="number" name="totalVuelto" id="totalVuelto" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label form-control-label">Tarjeta:</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="number" name="totalTarjeta" id="totalTarjeta" value="0" readonly>
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
                                                    <label class="col-lg-4 col-form-label form-control-label">Tarjeta:</label>
                                                    <div class="col-lg-8">
                                                        <select name="tipoTarjeta" id="tipoTarjeta" class="form-control">
                                                            <option value="">..Seleccione..</option>
                                                            <option value="2">VISA</option>
                                                            <option value="3">MASTERCARD</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label form-control-label">Monto:</label>
                                                    <div class="col-lg-8">
                                                        <input class="form-control" type="number" name="montoTarjeta" id="montoTarjeta">
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
                                            <div class="col-sm-10">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" data-select="true" data-navigator="true">
                                                        <thead>
                                                            <th>Tarjeta</th>
                                                            <th>Número</th>
                                                            <th>Monto</th>
                                                            <th></th>
                                                        </thead>
                                                        <tbody id="tbl-tarjetas">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button class="btn btn-blue" id="btn-add-tarjeta"><i class="fa fa-plus"></i></button>
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
                                                            <input class="form-control" type="number" name="totalGeneral" id="totalGeneral" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label form-control-label font-weight-bold"> DSCTO:</label>
                                                        <div class="col-lg-8">
                                                            
                                                            <input class="form-control" type="number" name="totalDescuento" id="totalDescuento" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label form-control-label font-weight-bold">A CUENTA:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="number" name="totalPagado" id="totalPagado" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label form-control-label font-weight-bold">SALDO:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="number" name="totalSaldo" id="totalSaldo" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label form-control-label font-weight-bold">GARANTIA:</label>
                                                        <div class="col-lg-8">
                                                            <input class="form-control" type="number" name="totalGarantia" id="totalGarantia">
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
            <!-- Totales -->
            <!-- <div class="card-body" id="panel-totales" style="padding-top: 20px; padding-bottom: 20px;">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <h4 class="col-sm-2 offset-7"><b>TOTAL : </b></h4>
                                    <div class="col-sm-3" id="col-total">
                                        <input type="text" class="form-control" name="totalGeneral" id="totalGeneral" readonly style="font-size:1.2rem; text-align:rigth;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Debug -->
            <div class="card-body" id="panel-debug" style="padding-top: 20px; padding-bottom: 20px;">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-12" id="msg-debug"></div>
                        </div>
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



