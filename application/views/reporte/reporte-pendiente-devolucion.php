<!-- Main Content -->
<div class="content-wrapper">
    <!-- Filtro del Reporte -->

    <!-- Content area -->
    <div class="content">
        <h4 style="font-weight: bold; text-decoration: underline">REPORTE PENDIENTES DEVOLUCION</h4>
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
                        <div class="col-sm-8">
                            <form action="" class="form-horizontal">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="tienda" class="col-sm-2 col-form-label font-weight-bold">Tienda
                                                :</label>
                                            <div class="col-sm-10">
                                                <select name="tienda[]" id="tienda" multiple="multiple"
                                                    class="form-control">
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
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <label for="diasVencidos"
                                                class="col-sm-4 col-form-label font-weight-bold">Días Vencidos:
                                            </label>
                                            <div class="col-sm-6">
                                                <select name="diasVencidos" id="diasVencidos" class="form-control">
                                                    <option value="0">TODOS</option>
                                                    <option value="7">MAS DE 7 DÍAS</option>
                                                    <option value="15">MAS DE 15 DÍAS</option>
                                                    <option value="30">MAS DE 30 DÍAS</option>
                                                    <option value="60">MAS DE 60 DÍAS</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- <label for="">Buscar: </label> -->
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="buscador" id="buscador"
                                                placeholder="Ingrese el DNI o Nombres">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- <label class="custom-control fill-checkbox">
                                            <input type="checkbox" class="fill-control-input" name="soloVencidos" id="soloVencidos">
                                            <span class="fill-control-indicator"></span>
                                            <span class="fill-control-description">Sólo Vencidos</span>
                                        </label> -->
                                        <!-- <div class="checkbox checkbox-primary">
                                            <input id="checkbox2" class="styled" type="checkbox" checked>
                                            <label for="checkbox2">Primary</label>
                                        </div> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <button class="btn btn-blue btn-lg btn-block" id="btn-mostrar-reporte">
                                        <i class="fa fa-chart-bar"></i> &nbsp;Mostrar
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-success btn-lg btn-block" id="btn-exportar-reporte">
                                        <i class="fa fa-file-excel"></i> &nbsp;Exportar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" data-select="true" data-navigator="true"
                        id="rptPendienteDevolucion">
                        <thead>
                            <tr>
                                <th style="width: 50px">#</th>
                                <th style="width: 100px">DNI</th>
                                <th style="width: 280px">Cliente</th>
                                <th style="width: 100px">Teléfono</th>
                                <th>N° Op.</th>
                                <th style="width: 140px">Tienda</th>
                                <th>Fecha Salida</th>
                                <th>Fecha Dev. Prog</th>
                                <th>Dias Vencidos</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_reporte">
                        </tbody>
                        <tfoot>
                            <tr>
                                <!-- <td colspan="5">
                                    <h3 class="font-weight-bold text-right mb-0">SALDO FINAL</h3>
                                </td>
                                <td>
                                    <h3 class="font-weight-bold text-right mb-0" id="saldoPeriodo">-</h3>
                                </td>
                                <td>
                                    <h3 class="font-weight-bold text-right mb-0" id="saldoFinal">-</h3>
                                </td> -->
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

<ul id="contextMenuReporte" class="list-group" role="menu" style="display:none">
    <li class="list-group-item pt-1 pb-1"><a class="text-body font-weight-bold" tabindex="-1" id="mnIrAOperacion" href="#"><i class="fa fa-search"></i> Ir a Operación</a></li>
    <li class="list-group-item pt-1 pb-1"><a class="text-body font-weight-bold" tabindex="-1" id="mnVerCliente" href="#"><i class="fa fa-user"></i> Ver Cliente</a></li>
    <li class="list-group-item pt-1 pb-1"><a class="text-body font-weight-bold" tabindex="-1" id="mnDevolver"
    href="#"><i class="fa fa-trash"></i> Devolver</a></li>
    <!-- <li class="divider"></li> -->
</ul>

<script>
</script>