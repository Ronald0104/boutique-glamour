<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="#" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Compras</a>
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
            <h5 class="card-title"><b>Registro de Compras</b></h5>                
                <div class="group-button">
                    <!-- <button class="btn btn-dark pull-right btn-sale-register-show" id="btn-sale-register-show" data-toggle="modal" data-target="#modal-sale-register" data-option="1"> Alquiler/Venta</button> -->
                    <a class="btn btn-primary pull-right btn-lg btn-purchase-search" id="btn-purchase-search" href="">
                        Buscar</a>
                    <a class="btn btn-dark pull-right btn-lg btn-purchase-register-show" id="btn-purchase-register-show"
                        data-option="" href="#"> Registrar</a>
                </div>
            </div>
            <div class="card-body inline" style="border-top: 1px solid #ddd; padding-top: 1.2rem">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="GET" action="" name="frmPurchaseSearch" id="frmPurchaseSeach">
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
                                        <label for="LC_tipoGasto" class="col-md-4 col-form-label">Tipo Gasto: </label>
                                        <div class="col-sm-8">        
                                            <select name="LC_tipoGasto" id="LC_tipoGasto" class="form-control">
                                                <option value="">TODOS</option>
                                                <?php foreach($tipoGasto as $tipo) :?>
                                                <option value="<?=$tipo->id?>"><?=$tipo->nombre?></option>
                                                <?php endforeach; ?>                                                                       
                                            </select>                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group row">
                                        <label for="tienda" class="col-md-4 col-form-label">Tienda: </label>
                                        <div class="col-sm-8">
                                            <select name="LC_tienda" id="LC_tienda" class="form-control">
                                            <?php if($usuario['rol_id'] != "1") : ?>
                                                <?php foreach ($tiendas as $key => $value) : ?>
                                                <?php if ($value->id==$tiendaId) : ?>
                                                <option value="<?=$value->id?>" selected><?=$value->nombre?></option>
                                                <?php endif; ?>
                                                <?php endforeach; ?>                                        
                                            <?php else : ?>                                            
                                                <?php foreach ($tiendas as $key => $value) : ?>
                                                <option value="<?=$value->id?>"
                                                    <?php echo ($value->id==$tiendaId) ? "selected" : "" ?>>
                                                    <?=$value->nombre?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            <option value="0">TODOS</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered no-footer" id="tbl_purchases" data-select="true" data-navigator="true">
                    <thead>
                        <th style="min-width: 110px; max-width: 110px"></th>
                        <th style="width: 90px">Código</th>
                        <th style="width: 160px">Tienda</th>
                        <th style="width: 100px">Fecha Compra</th>
                        <th style="min-width: 150px">Proveedor</th>
                        <th style="min-width: 300px">Descripción</th>
                        <th style="width: 150px">Tipo Gasto</th>
                        <th>Importe Compra</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan=7 class="text-right"><h4><b>TOTAL:</b></h4></th>
                        <th></th> 
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- /Content area -->

</div>
<!-- /Main Content -->