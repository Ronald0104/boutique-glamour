<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <!-- <div class="page-title d-flex">
                <h4>Mantenimiento de clientes</h4>
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
                    <span class="breadcrumb-item active">Clientes</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i>
                        Soporte
                    </a>
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
                        <h5 class="card-title"><b>Clientes</b></h5>
                        <div class="text-warning">
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                        </div>
                        <div class="group-button">
                            <button class="btn btn-primary btn-lg pull-right" id="btn-show-user-add">
                                <i class="fa fa-file-medical"></i>&nbsp; Nuevo Cliente</button>
                            <!--data-toggle="modal" data-target="#modal-customer-add"-->
                        </div>
                        <!-- <p class="card-text"></p> -->
                        <!-- <a href="#" class="btn btn-primary pull-right"></a> -->
                    </div>
                    <!-- <div class="car-body">
                        
                    </div> -->
                    <!-- datatable-wrapper no-footer  -->
                    <div class="card-body">
                        <div class="table-responsive" style="border-top: 1px solid #ddd; margin-top: 15px;">
                            <table class="table table-hover table-bordered text-nowrap" data-select="true" data-navigator="true" id="tbl_customers">
                                <thead>
                                    <tr>
                                        <!-- <th><span class="bold">#</span></th> -->
                                        <th></th>
                                        <th><b>N° Documento</b></th>
                                        <th><b>Apellidos y Nombres</b></th>
                                        <th><b>Teléfono</b></th>
                                        <th><b>Dirección</b></th>
                                        <th><b>Email</b></th>
                                        <th><b>Celular</b></th>
                                        <!-- <th><b></b></th> -->
                                    </tr>
                                </thead>
                                <tbody id="customers-items">
                                    <!-- <?php $i = 1;?>
                                    <?php foreach($clientes as $cliente) :?>
                                    <tr tabindex="0">
                                        <td><?php echo $i++ ?></td>
                                        <td data-cliente="<?php echo $cliente->clienteId?>"><?php echo $cliente->nro_documento?></td>
                                        <td><?php echo $cliente->nombres . " " . $cliente->apellido_paterno ?></td>
                                        <td><?php echo $cliente->direccion ?></td>
                                        <td><?php echo $cliente->email ?></td>
                                        <td><?php echo $cliente->telefono ?></td>
                                        <td><?php echo $cliente->celular ?></td>
                                        <td class="center">
                                            <button type="button" id="btn-user-" class="btn btn-blue btn-xs btn-customer-edit-show" data-toggle="modal" data-target="" data-cliente="<?php echo $cliente->clienteId ?>" data-cliente-nro="<?php echo $cliente->nro_documento ?>"><i class="fa fa-edit"></i></button>
                                            <button type="button" id="btn-" class="btn btn-danger btn-xs btn-user-delete"><i class="fa fa-trash-alt" data-cliente="<?php echo $cliente->clienteId ?>"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?> -->
                                </tbody>
                            </table>
                        </div>
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