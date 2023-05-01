<!-- Main content -->
<div class="content-wrapper">
    <!-- Page header -->
    <div class="page-header page-header-light">
        <!-- <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4>Opciones principales</h4>
                <h4><i class="icon-arrow-left2 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
            <div class="header-elements d-none">
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-stats-bars text-primary"></i><span>Estadisticas</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
                    <a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar text-primary"></i> <span>Schedule</span></a>
                </div>
            </div>
        </div> -->

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="/" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Dashboard</span>
                </div>

                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>

            <div class="header-elements d-none">
                <div class="breadcrumb justify-content-center">
                    <a href="#" class="breadcrumb-elements-item">
                        <i class="icon-comment-discussion mr-2"></i>Soporte
                    </a>

                    <div class="breadcrumb-elements-item dropdown p-0">
                        <a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-gear mr-2"></i>
                            Ajustes
                        </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Seguridad</a>
                        <a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analisticas</a>
                        <a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Opciones -->
        <div class="row">
            <?php foreach ($opciones as $item) : ?>
                <div class="col-lg-2 col-md-2 col-sm-3 col-6">
                    <div class="card card-option">
                        <div class="card-body text-center">
                            <div class="card-img-actions d-inline-block">
                                <a href="<?=$item->urlPath?>"><img class="img-fluid"
                                        src="<?php echo base_url()?>/assets/img/options/<?=$item->imagenPath?>" width="170"
                                        height="170" alt=""></a>
                                <div class="card-img-actions-overlay card-img rounded-circle">
                                    <a href="<?=$item->urlPath?>"
                                        class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                        <i class="icon-plus3"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- <h6 class="font-weight-semibold mb-0">Ventas</h6> -->
                        </div>
                        <div class="card-footer d-flex justify-content-around text-center p-0">
                            <h4><a href="<?=$item->urlPath?>"><?=$item->nombre?></a></h4>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                <div class="card card-option">
                    <div class="card-body text-center">
                        <div class="card-img-actions d-inline-block">
                            <a href="#"><img class="img-fluid"
                                    src="<?php echo base_url()?>/assets/img/options/users_128.png" width="170"
                                    height="170" alt=""></a>
                            <div class="card-img-actions-overlay card-img rounded-circle">
                                <a href="#"
                                    class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                    <i class="icon-plus3"></i>
                                </a>
                            </div>
                        </div>
                        <h6 class="font-weight-semibold mb-0">Ventas</h6>
                    </div>
                    <div class="card-footer d-flex justify-content-around text-center p-0">
                        <h4><a href="#">Proveedores</a></h4>
                    </div>
                </div>
            </div> -->

        </div>
        <!-- /Opciones -->

    </div>
</div>