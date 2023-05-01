<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="header-elements-md-inline"></div>

        <!-- Colocarlo en una seccion aparte -->
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/ventas" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Ventas</a>
                    <span class="breadcrumb-item active">Liquidación</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i> Ajustes
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- <?php
        echo "<pre>";
        echo var_dump($usuario);
        echo "</pre>";
    ?> -->
    <!-- Content area -->
    <div class="content">
        <div class="row">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-body">
                        <form action="frmLiquidacion" class="form-horizontal">
                            <input type="hidden" name="liqTiendaId" id="liqTiendaId" value="<?=$tiendaId?>">
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <label for="liqTienda" class="col-md-2 col-form-label font-weight-bold">TIENDA :
                                        </label>
                                        <div class="col-md-7">
                                            <input type="text" name="liqTienda" id="liqTienda"
                                                class="form-control font-weight-bold" placeholder="" readonly="true"
                                                value="<?=strtoupper($usuario['tienda_sel_nombre'])?>">
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <input type="text" name="liqNumero" id="liqNumero" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="text" name="liqEstado" id="liqEstado"
                                                class="form-control-plaintext font-weight-bold text-center pb-0"
                                                readonly value="PENDIENTE"
                                                style="background-color: white; font-size: 1rem;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <label for="liqFechas" class="col-md-2 col-form-label font-weight-bold">FECHA :
                                        </label>
                                        <div class="col-md-5">
                                            <input type="text" name="liqFechaDesde" id="liqFechaDesde"
                                                class="form-control" placeholder="" readonly="true"
                                                value="<?=date("d/m/Y")?>">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" name="liqFechaHasta" id="liqFechaHasta"
                                                class="form-control" placeholder="" readonly="true"
                                                value="<?=date("d/m/Y")?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="tienda" class="col-md-4 col-form-label font-weight-bold">Tienda: </label>
                                        <div class="col-md-8">
                                            <select name="tienda" id="tienda" class="form-control">
                                                <?php foreach($tiendas as $tienda) : ?>
                                                    <option value="<?=$tienda->id?>"><?=$tienda->nombre?></option>
                                                <?php endforeach; ?>
                                            </select>                                            
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <h5 class="mt-0 font-weight-bold text-brown-800">RESUMEN POR ASESOR</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" data-select="true" data-navigator="true"
                                id="liq-resumen-usuario">
                                <thead>
                                    <tr>
                                        <th>Asesor</th>
                                        <th>Cantidad</th>
                                        <th>Efectivo</th>
                                        <th>Tarjeta</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="row mb-2">
                    <div class="col-sm-4">
                        <button class="btn btn-xl btn-block btn-blue" id="liqBuscar">
                            <i class="fa fa-search"></i>
                            <p class="mb-0">Buscar</p>
                        </button>
                    </div>
                    <div class="col-sm-4">
                        <button class="btn btn-xl btn-block btn-dark" id="liqCerrar">
                            <i class="fa fa-check-circle"></i>
                            <p class="mb-0">Cerrar</p>
                        </button>
                    </div>
                </div>
                <div class="card">
                    <!-- <div class="card-header header-elements-inline pt-2 pb-2">
                        <h5 class="card-title mt-0"><b>TOTALES</b></h5>                        
                    </div> -->
                    <div class="card-header bg-brown p-1">
                        <h5 class="m-0 font-weight-bold text-center">TOTALES LIQUIDACIÓN</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="" class="col-sm-7 col-form-label font-weight-bold text-grey-800">TOTAL INGRESOS
                                :</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-right font-weight-bold"
                                    name="liqTotalIngresos" id="liqTotalIngresos" value="" readonly
                                    style="font-size: 1rem">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-7 col-form-label font-weight-bold text-grey-800">TOTAL TARJETAS
                                :</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-right font-weight-bold"
                                    name="liqTotalTarjeta" id="liqTotalTarjeta" value="" readonly
                                    style="font-size: 1rem">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-7 col-form-label font-weight-bold text-grey-800">TOTAL EGRESOS
                                :</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-right font-weight-bold"
                                    name="liqTotalEgresos" id="liqTotalEgresos" value="" readonly
                                    style="font-size: 1rem">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-7 col-form-label font-weight-bold text-grey-800">TOTAL EFECTIVO
                                :</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-right font-weight-bold"
                                    name="liqTotalEfectivo" id="liqTotalEfectivo" value="" readonly
                                    style="font-size: 1rem">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- Venta y Cliente -->
                    <div class="card mb-0" style="border-left:0; border-right:0; border: 0">
                        <!-- <div class="card-header bg-info pt-2 pb-2">
                            <h6 class="card-title mt-0">
                                <a data-toggle="collapse" class="text-white" href="#collapsible-styled-group1" aria-expanded="true">Datos Venta</a>
                            </h6>
                        </div> -->
                        <div id="collapsible-styled-group1" class="collapse show" style="">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-top">
                                    <li class="nav-item"><a href="#top-tab-liq-ingresos"
                                            class="nav-link font-weight-bold active show" data-toggle="tab">DETALLE
                                            INGRESOS</a></li>
                                    <li class="nav-item"><a href="#top-tab-liq-egresos"
                                            class="nav-link font-weight-bold" data-toggle="tab">DETALLE EGRESOS</a></li>
                                    <li class="nav-item"><a href="#top-tab-liq-anulados"
                                            class="nav-link font-weight-bold" data-toggle="tab">ANULADOS</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="top-tab-liq-ingresos">
                                        <div class="col-sm-7">
                                            <div class="form-group row">
                                                <label for="liqBuscarDetalleIngresos"
                                                    class="col-form-label font-weight-bold col-sm-2">BUSCAR :</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                        name="liqBuscarDetalleIngresos" id="liqBuscarDetalleIngresos">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" data-select="true" data-navigator="true"
                                                id="tbl-detalle-ingresos">
                                                <thead>
                                                    <tr>
                                                        <th>N° Ope.</th>
                                                        <th style="min-width:120px">Cliente</th>
                                                        <th>Fecha y Hora</th>
                                                        <th>Asesor</th>
                                                        <th>Total Ope.</th>
                                                        <th>Efectivo</th>
                                                        <th class="center">Tarjeta</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="top-tab-liq-egresos">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" data-select="true" data-navigator="true"
                                                id="tbl-detalle-egresos">
                                                <thead>
                                                    <tr>
                                                        <th>N° Operación</th>
                                                        <th style="min-width:120px">Proveedor</th>
                                                        <th>Fecha y Hora</th>
                                                        <th>Tipo Gasto</th>
                                                        <th>Descripción</th>
                                                        <th class="center">Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="top-tab-liq-anulados">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" data-select="true" data-navigator="true"
                                                id="tbl-detalle-anulados">
                                                <thead>
                                                    <tr>
                                                        <th>N° Operación</th>
                                                        <th style="min-width:120px">Cliente</th>
                                                        <th>Fecha Anulación</th>
                                                        <th>Usuario Anulación</th>
                                                        <th>Motivo</th>
                                                        <th class="center">Importe</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
        </div>
    </div>
    <!-- /Content area -->

</div>
<!-- /Main Content -->


<!-- Modal buscar producto -->
<div class="modal fade" id="modal-search-article2" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true" data-width="65%">
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
                                        <button class="btn btn-dark btn-xs col-md-1" id="btn-search-article"><i
                                                class="icon icon-search4"></i></button>
                                        <div class="col-md-6">
                                            <input type="text" name="descripcion-producto" id="descripcion-producto"
                                                class="form-control">
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