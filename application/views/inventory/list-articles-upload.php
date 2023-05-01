<!-- Main content -->
<div class="content-wrapper">

    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <!-- <div class="page-title d-flex">
                <h4>Carga Masiva de Artículos</h4>
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
                    <span class="breadcrumb-item active">Inventario</span>
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
                        <h5 class="card-title"><b>Carga masiva de artículos</b></h5>
                        <div class="text-warning">
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                            <i class="icon-star-full" aria-hidden="true"></i>
                        </div>
                        <!-- <div class="group-button"> -->
                        <!-- <button class="btn btn-lg btn-primary pull-right">Iniciar Carga</button> -->
                        <!--data-toggle="modal" data-target="#modal-customer-add"-->
                        <!-- </div> -->

                        <h2 class="pull-right" id="duracion">HORA</h2>
                        <h2 class="pull-right" id="tiempo"></h2>

                        <!-- <p class="card-text"></p> -->
                        <!-- <a href="#" class="btn btn-primary pull-right"></a> -->
                    </div>

                    <div class="card-body inline" style="padding-top:1.2rem">
                        <form action="" class="form-horizontal">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="file" name="fileUpload" id="fileUpload" class="form-group">
                                    </div>
                                    <div id="kv-error" style="margin-top:10px;display:none"></div>
                                    <div id="kv-success" class="alert alert-success" style="margin-top:10px;display:none"></div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <button class="btn btn-block btn-lg btn-blue" id="btnUpload">
                                                <i class="fa fa-upload"></i>
                                                <p class="mb-0">Procesar</p>
                                                <p class="mb-0">Carga</p>
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="/inventario/download_template" class="btn btn-block btn-lg btn-warning" id="btnDownload">
                                                <i class="fa fa-download"></i>
                                                <p class="mb-0">Descargar</p>
                                                <p class="mb-0">Plantilla</p>
                                            </a>
                                        </div>
                                    </div>
                                    <!-- <div class="button-group">

                                    </div>-->
                                </div>
                            </div>

                        </form>
                    </div>

                    <!-- datatable-wrapper no-footer  -->
                    <div class="card-body">
                        <div class="container" id="data-excel">

                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="progress" style="background-color: #e0caca">
                                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 1%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive" style="border-top: 1px solid #ddd">
                            <table class="table table-hover table-bordered text-nowrap" data-select="true" data-navigator="true" id="tbCargaMasiva">
                                <thead>
                                    <th>N°</th>
                                    <th></th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Marca</th>
                                    <th>Talla</th>
                                    <th>Color</th>
                                    <th>Tela</th>
                                    <th>Diseño</th>
                                    <th>Caracteristicas</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Tienda</th>
                                    <th>Fecha Compra</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Alquiler</th>
                                    <th>Precio Venta</th>
                                </thead>
                                <tbody>

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