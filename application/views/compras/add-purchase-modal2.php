<!-- Modal Registrar Compra-->
<div class="modal fade" id="modal-purchase-add" tabindex="-1" role="dialog" aria-labelledby="modal-purchase-add"
    aria-hidden="true" style="padding-right: 17px;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-600">
                <h5 class="modal-title mt-0"><i class="icon-menu7 mr-2"></i>Registrar Compra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0.9rem">
                <div class="container-fluid" style="padding: 0">
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="card">
                                <div class="card-body inline">
                                    <form action="" method="POST" class="form-horizontal" name="form-purchase-add"
                                        id="form-purchase-add">
                                        <input type="hidden" name="compraId" id="compraId" value="0" />
                                        <!-- <div style="position: absolute; top: 0.85rem; right: 1.2rem;">
                                            <label class="switch ">
                                                <input type="checkbox" class="default" name="estadoArticulo" id="estadoArticulo">
                                                <span class="slider round"></span>
                                            </label>
                                        </div> -->
                                        <ul class="nav nav-tabs nav-tabs-top">
                                            <li class="nav-item"><a href="#top-tab-purchase"
                                                    class="nav-link font-weight-bold active show"
                                                    data-toggle="tab">Datos Compra</a></li>
                                            <li class="nav-item"><a href="#top-tab-purchase-distribution"
                                                    class="nav-link font-weight-bold" data-toggle="tab">Distribución
                                                    Gastos</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade active show" id="top-tab-purchase">
                                                <div class="alert alert-warning" id="form-purchase-add-error"
                                                    style="display: none"><b>¡ERROR!</b> compra </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="codigoCompra"
                                                                        class="col-sm-4 col-md-4 col-lg-4 col-form-label font-weight-bold">Código:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 col-lg-8 m-0">
                                                                        <input type="text" class="form-control"
                                                                            name="codigoCompra" id="codigoCompra"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="fechaRegistroCompra"
                                                                        class="col-sm-4 col-md-4 col-lg-4 col-form-label">Fecha:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 col-lg-8 m-0">
                                                                        <input type="text" class="form-control"
                                                                            name="fechaRegistroCompra"
                                                                            id="fechaRegistroCompra" placeholder=""
                                                                            value="<?=date('d/m/Y')?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tipoGasto"
                                                                        class="col-sm-4 col-md-4 col-form-label align-self-center">Tipo
                                                                        Gasto: </label>
                                                                    <div class="col-md-8 col-lg-8 m-0">
                                                                        <select name="tipoGasto" id="tipoGasto"
                                                                            class="form-control">
                                                                            <?php foreach($tipoGasto as $tipo) :?>
                                                                            <option value="<?=$tipo->id?>">
                                                                                <?=$tipo->nombre?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="estadoCompra"
                                                                        class="col-sm-4 col-md-4 col-form-label">Estado:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 m-0">
                                                                        <input type="text" name="estadoCompra"
                                                                            id="estadoCompra" value="PROCESADO"
                                                                            class="form-control" readonly
                                                                            data-estado-compra="2">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="proveedor"
                                                                        class="col-sm-2 col-md-2 col-form-label">Proveedor:
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-10 m-0">
                                                                        <input type="text" name="proveedor"
                                                                            id="proveedor" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="tipoComprobante"
                                                                        class="col-sm-4 col-md-4 col-form-label">Tipo:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 m-0">
                                                                        <select name="tipoComprobante"
                                                                            id="tipoComprobante" class="form-control">
                                                                            <?php foreach($tipoComprobante as $tipo) : ?>
                                                                            <option value="<?=$tipo->id?>">
                                                                                <?=$tipo->nombre?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="numeroComprobante"
                                                                        class="col-sm-4 col-md-4 col-form-label">Número:
                                                                    </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input
                                                                            type="text" class="form-control"
                                                                            name="numeroComprobante"
                                                                            id="numeroComprobante"
                                                                            placeholder="000-0000000"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12 col-md-12">
                                                                <div class="form-group row">
                                                                    <label for="descripcionCompra"
                                                                        class="col-sm-2 col-md-2 col-form-label">Descripción:
                                                                    </label>
                                                                    <div class="col-sm-10 col-md-10 m-0">
                                                                        <textarea name="descripcionCompra"
                                                                            id="descripcionCompra" cols="30" rows="3"
                                                                            class="form-control"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-md-6">
                                                                <div class="form-group row">
                                                                    <label for="importeTotal"
                                                                        class="col-sm-4 col-md-4 col-form-label font-weight-bold">Importe
                                                                        Total: </label>
                                                                    <div class="col-sm-8 col-md-8 m-0"><input
                                                                            type="text" class="form-control"
                                                                            name="importeTotal" id="importeTotal"
                                                                            placeholder=""></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="top-tab-purchase-distribution">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <h6
                                                                    class="font-weight-bold mb-2 bg-purple-800 display-8">
                                                                    <u>Distribución Gastos Tiendas</u></h6>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <table class="table table-bordered"
                                                                    id="tbl-compras-distribucion">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 160px;">Tienda</th>
                                                                            <th>Monto</th>
                                                                            <th>Porcentaje</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach($tiendas as $tienda) : ?>
                                                                        <tr data-tienda-id="<?=$tienda->id?>">
                                                                            <td>
                                                                                <strong
                                                                                    class="text-brown-800"><?=strtoupper($tienda->nombre)?>
                                                                                </strong>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name=""
                                                                                    class="form-control text-number"
                                                                                    data-value-old="0">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" name=""
                                                                                    class="form-control" readonly>
                                                                            </td>
                                                                            <td></td>
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
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="" role="group" aria-label="Vertical button group">
                                <button class="btn btn-block btn-lg btn-blue" id="btn-purchase-add">
                                    <i class="fa fa-save" style="font-size: 1.2rem"></i>
                                    <p class="mb-0">Guardar</p>
                                </button>
                                <button class="btn btn-block btn-lg btn-success" id="btn-purchase-new">
                                    <i class="fa fa-file" style="font-size: 1.2rem"></i>
                                    <p class="mb-0">Nuevo</p>
                                </button>
                                <button class="btn btn-block btn-lg btn-danger" data-dismiss="modal">
                                    <i class="fa fa-power-off" style="font-size: 1.2rem"></i>
                                    <p class="mb-0">Cerrar</p>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button> -->
                <!-- <button type="submit" class="btn btn-primary" id="btn-article-add">Guardar</button> -->
            </div>
        </div>
    </div>
</div>


<!-- *********************** -->
<script>
var valCompra;
// function fn_InicializaModal() {
// }
$(function() {
    $.datepicker.setDefaults($.datepicker.regional["es"]);
    $.datepicker.formatDate('yy/mm/dd');

    $('#fechaRegistroCompra').datepicker({
        dateFormat: 'dd/mm/yy',
        minDate: '-2M',
        maxDate: '+1D',
        showButtonPanel: true,
        showOtherMonths: true,
        selectOtherMonths: true,
        // changeMonth: true,
        defaultDate: +1
    });
    $('#tipoGasto').select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $('#modal-purchase-add')
    });
    $('#tipoComprobante').select2({
        minimumResultsForSearch: Infinity,
        dropdownParent: $('#modal-purchase-add')
    });
    $('#proveedor').on('keypress', function(evt) {
        var that = this;
        setTimeout(() => {
            that.value = that.value.toUpperCase();
        }, 40);
    })
    $('#numeroComprobante').on('keypress', function() {
        var that = this;
        setTimeout(() => {
            that.value = that.value.toUpperCase();
        }, 40);
    })
    $('#descripcionCompra').on('keypress', function() {
        var that = this;
        setTimeout(() => {
            that.value = that.value.toUpperCase();
        }, 40);
    })
    $('#importeTotal').on('keypress', function(evt) {
        var keyCode = (evt.keyCode) ? evt.keyCode : evt.whicth;
        if ($(this).val().indexOf('.') > -1) {
            if (!/^[0-9]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        } else {
            if (!/^[0-9.]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        }
    })
    $('input.text-number').on('keypress', function(evt) {
        //$(document).on('keypress', 'input.text-number', function(evt){
        var keyCode = (evt.keyCode) ? evt.keyCode : evt.whicth;
        if ($(this).val().indexOf('.') > -1) {
            if (!/^[0-9]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        } else {
            if (!/^[0-9.]/.test(String.fromCharCode(keyCode))) {
                evt.preventDefault();
            }
        }
    })
    $('#importeTotal').change(function() {
        // Distribuir los montos entre las tiendas
        var compraId = Number($('#compraId').val());
        if (compraId == 0){
            var importeTotal = Number($(this).val());
            var importeTienda = 0;
            var cantidad = $('#tbl-compras-distribucion>tbody>tr').length;
            importeTienda = importeTotal / cantidad;
            $('#tbl-compras-distribucion>tbody>tr').each(function() {
                $(this).closest('tr').find('td').eq(1).find('input').val(importeTienda);
                $(this).closest('tr').find('td').eq(1).find('input').trigger('change');
            })
        }        
    })
    $('#tbl-compras-distribucion input.text-number').on('change', function() {
        var importeTotal = Number($('#importeTotal').val());
        var valueOld = Number($(this).data('value-old'));
        var valueNew = Number($(this).val());
        // Validar que la suma de las distribuciones no superen el total de la compra
        if (Number($(this).val()) > importeTotal) {
            swal('', 'El monto de distribución no puede superar el importe total', 'warning');
            $(this).val(valueOld);
        } else {
            $(this).data('value-old', valueNew);
            // Calcular el porcentaje
            var porcentaje = (valueNew / importeTotal) * 100;
            $(this).closest('tr').find('td:eq(2)').find('input').val(porcentaje);
        }
    })
    $('#btn-purchase-add').click(function() {
        var isValid = $('#form-purchase-add').valid();
        if (!isValid) {
            swal('', 'No ha completado los datos de la compra.', 'warning');
            return;
        }
        // console.log('Registrar gastos');

        // Validar distribución los totales no pueden superar el importe total de la compra
        var importeTotal = Number($('#importeTotal').val());
        var importeDistribucion = 0;
        $('#tbl-compras-distribucion>tbody>tr').each(function() {
            // console.log(Number($(this).find('td').eq(1).find('input').val()));
            importeDistribucion += Number($(this).find('td').eq(1).find('input').val());
        })
        // console.log(importeDistribucion);

        // los importe de distribucion no puede ser mayor al importe total
        if (importeDistribucion > importeTotal) {
            swal('', 'El importe de distribución no puede ser mayor al importe total', 'warning');
            return false;
        }
        if (importeTotal > importeDistribucion) {
            swal('', 'El importe de distribución debe ser igual al importe total', 'warning');
            return false;
        }

        var compra = fn_GenerarCompra();
        console.log(compra);
        // return;
        if (compra.id == 0) {
            fn_RegistrarCompra(compra, function(data) {
                var compra = JSON.parse(data);
                console.log(compra);
                if (compra) {
                    swal('', 'Compra actualizado correctamente', 'info');
                    if (document.location.pathname.toLowerCase() == "/compras/") 
                        tbl_compras.ajax.reload(null, false);
                    fn_LimpiarModalCompra();
                    fn_ObtenerCorrelativoCompra(function(correlativo) {
                        $('#codigoCompra').val(correlativo);
                    });
                } else {
                    swal('', 'Ocurrio un error al registrar la compra', 'error');
                }
            });
        }
        else {
            fn_ActualizarCompra(compra, function(data) {
                var compra = JSON.parse(data);
                console.log(compra);
                if (compra) {
                    swal('', 'Compra registrada correctamente', 'info');
                    if (document.location.pathname.toLowerCase() == "/compras/") tbl_compras
                        .ajax.reload(null, false);
                    fn_LimpiarModalCompra();
                    fn_ObtenerCorrelativoCompra(function(correlativo) {
                        $('#codigoCompra').val(correlativo);
                    });
                } else {
                    swal('', 'Ocurrio un error al registrar la compra', 'error');
                }
            });
        }


    })
    $('#btn-purchase-new').click(function() {
        fn_LimpiarModalCompra();
        fn_ObtenerCorrelativoCompra(function(correlativo) {
            $('#codigoCompra').val(correlativo);
        })
    })

    valCompra = $('#form-purchase-add').validate({
        ignore: [],
        submitHandler: function() {
            console.log('formulario de compra validado');
        },
        rules: {
            codigoCompra: 'required',
            fechaRegistroCompra: 'required',
            tipoGasto: 'required',
            proveedor: 'required',
            tipoComprobante: 'required',
            numeroComprobante: 'required',
            descripcionCompra: 'required',
            importeTotal: {
                required: true,
                number: true
            }
        },
        messages: {
            codigoCompra: 'El código de compra es obligatorio',
            fechaRegistroCompra: 'La fecha de registro de compra el obligatorio',
            tipoGasto: 'El tipo de gasto es obligatorio',
            proveedor: 'El proveedor el obligatorio',
            tipoComprobante: 'El tipo de comprobante es obligatorio',
            numeroComprobante: 'El número de comprobante es obligatorio',
            descripcionCompra: 'La descripción de la compra es obligatorio',
            importeTotal: {
                required: 'El importe total de la compra es obligatorio',
                number: 'El importe de compra es númerico'
            }
        }
    })

})
</script>