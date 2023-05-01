<!-- Main Content -->
<div class="content-wrapper">

    <!-- Filtro del Reporte -->

    <!-- Content area -->
    <div class="content">
        <h4 style="font-weight: bold; text-decoration: underline">REPORTE DE FLUJO DE CAJA</h4>
        <div class="card">
            <div class="card-header" style="padding: 0.5rem 1rem 0.5rem 1.5rem; height: 32px;">
                <!-- <h5 style="padding: 0; margin: 0">Filtros Reporte</h5> -->
                <span style="font-size: 0.85rem;font-weight: bold;float: left;margin-top: -2px;color: #6207a5;">FILTROS
                    REPORTE</span>
            </div>
            <div class="card-body" style="padding-top: .8rem">
                <!-- <h5 class="card-title">Reporte de Flujo de Caja</h5> -->
                <!-- <p class="card-text"></p> -->
                <div class="col-sm-12">

                    <div class="row">
                        <div class="col-sm-10">
                            <form action="" class="form-horizontal">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="fechaDesde"
                                                class="col-sm-4 col-form-label font-weight-bold">Fecha Desde:
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fechaDesde" id="fechaDesde"
                                                    class="form-control" value="<?=$fechaDesde->format("d/m/Y");?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="fechaHasta"
                                                class="col-sm-4 col-form-label font-weight-bold">Fecha Hasta:
                                            </label>
                                            <div class="col-sm-8">
                                                <input type="text" name="fechaHasta" id="fechaHasta"
                                                    class="form-control" value="<?=$fechaHasta->format("d/m/Y")?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="tienda" class="col-sm-4 col-form-label font-weight-bold">Tienda
                                                :</label>
                                            <div class="col-sm-8">
                                                <select name="tienda" id="tienda" class="form-control">
                                                    <?php foreach($listaTiendas as $tienda) :?>
                                                    <?php if($tienda->id == $tiendaUsuario){?>
                                                    <option value="<?=$tienda->id?>" selected><?=$tienda->nombre?>
                                                    </option>
                                                    <?php }else { ?>
                                                    <option value="<?=$tienda->id?>"><?=$tienda->nombre?></option>
                                                    <?php }?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">                                      
                                        <div class="form-check" style="padding-left: 50px; font-size: 1rem">
                                            <input type="checkbox" class="form-check-input" name ="mostrarSaldoInicial" id="mostrarSaldoInicial" style="width: 18px; height: 18px">
                                            <label class="form-check-label" for="mostrarSaldoInicial">Mostrar Saldo Inicial</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-blue btn-lg btn-block" id="btn-mostrar-reporte">
                                <i class="fa fa-chart-bar"></i> &nbsp;Mostrar
                            </button>

                            <button class="btn btn-success btn-lg btn-block" id="btn-exportar-reporte">
                                <i class="fa fa-file-excel"></i> &nbsp;Exportar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" data-select="true" data-navigator="true" id="rptFlujoCaja">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th style="width: 140px">Fecha</th>
                                <th style="width: 130px">Tipo</th>
                                <th>N° Operación</th>
                                <th>Descripción</th>
                                <!-- <th>Ingreso</th>
                                <th>Efectivo</th>
                                <th>Tarjeta</th>
                                <th>Egreso</th> -->
                                <th>Monto Actual</th>
                                <th>Saldo Acumulado</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_reporte">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <h3 class="font-weight-bold text-right mb-0">SALDO FINAL</h3>
                                </td>
                                <td>
                                    <h3 class="font-weight-bold text-right mb-0" id="saldoPeriodo">-</h3>
                                </td>
                                <td>
                                    <h3 class="font-weight-bold text-right mb-0" id="saldoFinal">-</h3>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /Content area -->

</div>
<!-- /Main content -->

<script>

</script>