<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ronald Terrones">
    <title>Boutique Glamour</title>

    <?php if (ENVIRONMENT == "development") : ?>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"> -->
    <!-- <link href="/assets/font-awesome/all.css" rel="stylesheet" type="text/css"> -->
    <link href="/assets/font-icomoon/css/icomoon.css" rel="stylesheet" type="text/css">
    <link href="/assets/font-glyphicons/css/font-glyphicons.css" rel="stylesheet" type="text/css">

    <link href="/assets/bootstrap4-lm/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap4-lm/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/dist/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap4-lm/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap4-lm/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- <link href="/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"> -->
    <!-- Custom css page -->
    <?php if(isset($css)) : ?>
    <?php foreach($css as $style) : ?>
    <link href="<?php echo base_url();?>assets/css/<?php echo $style; ?>.css" rel="stylesheet">
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- Custom css -->
    <link rel="stylesheet" href="/assets/css/estilos.css">
    <?php endif; ?>

    <?php if (ENVIRONMENT == "production") : ?>
    <!-- Global stylesheets -->
    <!-- <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="/assets/font-icomoon/css/icomoon.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/font-glyphicons/css/font-glyphicons.min.css" rel="stylesheet" type="text/css">

    <!-- Boostrap 4 -->
    <link href="/assets/bootstrap4-lm/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap4-lm/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/dist/layout.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap4-lm/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap4-lm/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Custom css page -->
    <?php if(isset($css)) : ?>
    <?php foreach($css as $style) : ?>
    <link href="<?php echo base_url();?>assets/css/<?php echo $style; ?>.css" rel="stylesheet">
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- Custom css -->
    <link rel="stylesheet" href="/assets/css/estilos.min.css">
    <?php endif; ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Main navbar -->
    <div class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="navbar-brand">
            <!-- RT Rev: Cargar el titulo desde la BD -->
            <h2><a href="<?php echo base_url();?>"> <?php echo 'Boutique Glamour' ?></a></h2>
            <!-- <a href="#" class="d-inline-block"><img src="imagen/logo_light.png" alt="Mi Logo"></a> -->
        </div>
        <div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-tree"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <!-- <i class="icon-menu"></i> -->
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                        <i class="icon-paragraph-justify3"></i>
                        <!-- <i class="icon-menu"></i> -->
                    </a>
                </li>

                <!-- Actualizaciones GIT -->
                <!-- <li class="nav-item dropdown">
					<a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
						<i class="icon-git"></i>
						<span class="d-md-none ml-2">Git Updates</span>
						<span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">9</span>
					</a>

					<div class="dropdown-menu dropdown-content wmin-md-350">
						<div class="dropdown-content-header">
							<span class="font-weight-semibold">Git updates</span>
							<a href="#" class="text-default"><i class="icon-loop2"></i></a>
						</div>

						<div class="dropdown-content-body dropdown-scrollable">
							<ul class="media-list">
								<li class="media">
									<div class="mr-3">
										<a href="#" class="btn bg-transparent border-primary text-primary rounded-round border-2 btn-icon"><i class="icon-git-pull-request"></i></a>
									</div>

									<div class="media-body">
										Drop the IE <a href="#">specific hacks</a> for temporal inputs
										<div class="text-muted font-size-sm">4 minutes ago</div>
									</div>
								</li>

								<li class="media">
									<div class="mr-3">
										<a href="#" class="btn bg-transparent border-success text-success rounded-round border-2 btn-icon"><i class="icon-git-merge"></i></a>
									</div>
									
									<div class="media-body">
										<a href="#">Eugene Kopyov</a> merged <span class="font-weight-semibold">Master</span> and <span class="font-weight-semibold">Dev</span> branches
										<div class="text-muted font-size-sm">Dec 18, 18:36</div>
									</div>
                                </li>
                                
							</ul>
						</div>

						<div class="dropdown-content-footer bg-light">
							<a href="#" class="text-grey mr-auto">All updates</a>
							<div>
								<a href="#" class="text-grey" data-popup="tooltip" title="" data-original-title="Mark all as read"><i class="icon-radio-unchecked"></i></a>
								<a href="#" class="text-grey ml-2" data-popup="tooltip" title="" data-original-title="Bug tracker"><i class="icon-bug2"></i></a>
							</div>
						</div>
					</div>
                </li> -->
                <!-- Fin actualizaciones GIT -->
            </ul>

            <button type="button" name="btn-show-tiendas" id="btn-show-tiendas" class="btn btn-primary" data-tienda="0">TIENDA 1</button>
            <span class="ml-md-3 mr-md-auto">&nbsp</span>
            <!-- <span class="badge bg-success ml-md-3 mr-md-auto">Online</span> -->

            <ul class="navbar-nav">
                <!-- Usuario en linea -->
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-users"></i>
                        <span class="d-md-none ml-2">Usuarios</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-300">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Usuarios en linea</span>
                            <a href="#" class="text-default"><i class="icon-search font-size-base"></i></a>
                        </div>

                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3">
                                        <!-- <img src="imagen/face24.jpg" width="36" height="36" class="rounded-circle" alt=""> -->
                                    </div>
                                    <div class="media-body">
                                        <a href="#" class="media-title font-weight-semibold">Erick Cerna</a>
                                        <span class="d-block text-muted font-size-sm">Analista Programador</span>
                                    </div>
                                    <div class="ml-3 align-self-center"><span class="badge badge-mark border-danger"></span></div>
                                </li>

                                <li class="media">
                                    <div class="mr-3">
                                        <!-- <img src="imagen/face17.jpg" width="36" height="36" class="rounded-circle" alt=""> -->
                                    </div>
                                    <div class="media-body">
                                        <a href="#" class="media-title font-weight-semibold">Percy Mamani</a>
                                        <span class="d-block text-muted font-size-sm">Jefe de Sistemas</span>
                                    </div>
                                    <div class="ml-3 align-self-center"><span class="badge badge-mark border-success"></span></div>
                                </li>
                            </ul>
                        </div>

                        <div class="dropdown-content-footer bg-light">
                            <a href="#" class="text-grey mr-auto">Todos los usuarios</a>
                            <a href="#" class="text-grey"><i class="icon-cog"></i></a>
                        </div>
                    </div>
                </li>
                <!-- Fin usuarios en linea -->

                <!-- Mensaje de usuarios -->
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-bubbles4"></i>
                        <span class="d-md-none ml-2">Messages</span>
                        <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0">2</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header">
                            <span class="font-weight-semibold">Messages</span>
                            <a href="#" class="text-default"><i class="icon-compose"></i></a>
                        </div>

                        <div class="dropdown-content-body dropdown-scrollable">
                            <ul class="media-list">
                                <li class="media">
                                    <div class="mr-3 position-relative">
                                        <!-- <img src="imagen/face10.jpg" width="36" height="36" class="rounded-circle" alt=""> -->
                                    </div>

                                    <div class="media-body">
                                        <div class="media-title">
                                            <a href="#">
                                                <span class="font-weight-semibold">Oscar Minchan</span>
                                                <span class="text-muted float-right font-size-sm">04:58</span>
                                            </a>
                                        </div>

                                        <span class="text-muted">Ronald por favor reunamosno el domingo</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="" data-original-title="Load more"><i class="icon-menu d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
                <!-- Fin mensajes de usuarios -->

                <!-- Opciones de usuario -->
                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                        <!-- <img src="imagen/face11.jpg" class="rounded-circle mr-2" height="34" alt=""> -->
                        <span><?php echo $this->session->userdata('user')['nombre'] . " " .$this->session->userdata('user')['apellido_paterno']; ?></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> Mi Perfil</a>
                        <a href="#" class="dropdown-item"><i class="icon-mail2"></i> Mensajes <span class="badge badge-pill bg-blue ml-auto">0</span></a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url() ?>admin/logout" class="dropdown-item"><i class="icon-exit"></i> Salir</a>
                    </div>
                </li>
                <!-- Fin opciones de usuario -->
            </ul>
        </div>
    </div>
    <!-- /main navbar -->

    <!-- Page content -->
    <div class="page-content">
        <!-- Main sidebar -->
        <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
            <div class="sidebar-mobile-toggler text-center">
                <!-- Sidebar mobile toggler -->
                <a href="#" class="sidebar-mobile-main-toggle">
                    <i class="icon-arrow-left8"></i>
                </a>
                Navigation
                <a href="#" class="sidebar-mobile-expand">
                    <i class="icon-screen-full"></i>
                </a>
                <i class="icon-screen-normal"></i>
            </div>
            <!-- /sidebar mobile toggler -->

            <!-- Sidebar content -->
            <div class="sidebar-content">

                <!-- User menu -->
                <!-- <div class="sidebar-user">
        <div class="card-body">
            <div class="media">
                <div class="mr-3">
                    <a href="#"><img src="imagen/face11.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
                </div>

                <div class="media-body">
                    <div class="media-title font-weight-semibold">Victoria Baker</div>
                    <div class="font-size-xs opacity-50">
                        <i class="icon-pin font-size-sm"></i> &nbsp;Santa Ana, CA
                    </div>
                </div>

                <div class="ml-3 align-self-center">
                    <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                </div>
            </div>
        </div>
    </div> -->
                <!-- /user menu -->


                <!-- Main navigation -->
                <div class="card card-sidebar-mobile">
                    <ul class="nav nav-sidebar" data-nav-type="accordion">

                        <!-- Main -->
                        <li class="nav-item-header">
                            <div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url();?>" class="nav-link active">
                                <!-- <i class="fas fa-home"></i> -->
                                <i class="icon-home"></i>
                                <span>Inicio</span>
                            </a>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-price-tag"></i> <span>Ventas</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Ventas">
                                <li class="nav-item"><a href="<?php echo base_url();?>ventas/listar" class="nav-link active">Ventas Diarias</a></li>
                                <li class="nav-item"><a href="<?php echo base_url();?>ventas/registrar" class="nav-link active">Alquiler/Venta</a></li>
                                <li class="nav-item"><a href="#" class="nav-link active" id="btn-mostrar-atender-reserva">Atender Reserva</a></li>
                                <li class="nav-item"><a href="#" class="nav-link active" id="btn-mostrar-atender-alquiler">Devolución</a></li>
                                <li class="nav-item"><a href="/cliente/listar" class="nav-link">Clientes</a></li>
                                <!-- <li class="nav-item"><a href="#" class="nav-link disabled">Layout 6 <span class="badge bg-transparent align-self-center ml-auto">Coming soon</span></a></li> -->
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-cart"></i> <span>Compras</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Compras">
                                <li class="nav-item"><a href="<?php echo base_url();?>/compras/registrar" class="nav-link acive">Registrar Compra</a></li>
                                <li class="nav-item"><a href="<?php echo base_url();?>/compras/proveedores" class="nav-link">Proveedores</a></li>
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-table2"></i> <span>Inventario</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Inventario">
                                <li class="nav-item"><a href="<?php echo base_url();?>inventario/kardex" class="nav-link">Registrar Operación</a></li>
                                <li class="nav-item"><a href="<?php echo base_url();?>inventario/articulos" class="nav-link">Artículos</a></li>
                                <li class="nav-item"><a href="<?php echo base_url();?>inventario/stock" class="nav-link">Stock de artìculos</a></li>
                                <li class="nav-item"><a href="<?php echo base_url();?>inventario/categorias" class="nav-link">Categorias</a></li>
                                <!-- <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link">Articulos</a>
                    <ul class="nav nav-group-sub">
                        <li class="nav-item"><a href="#" class="nav-link">Categorias</a></li>
                        <li class="nav-item"><a href="#" class="nav-link">Marcas</a></li>
                    </ul>
                </li>  -->
                            </ul>
                        </li>

                        <!-- <li class="nav-item nav-item-submenu">
            <a href="#" class="nav-link"><i class="icon-credit-card"></i> <span>Financiero</span></a>

            <ul class="nav nav-group-sub" data-submenu-title="Financiero">  
                <li class="nav-item"><a href="#" class="nav-link">Registrar Tipo Cambio</a></li>
            </ul>
        </li> -->

                        <li class="nav-item">
                            <hr>
                            <!-- <a href="changelog.html" class="nav-link">
                <i class="icon-list-unordered"></i>
                <span>Changelog</span>
                <span class="badge bg-blue-400 align-self-center ml-auto">2.1</span>
            </a> -->
                        </li>
                        <!-- <li class="nav-item"><a href=#" class="nav-link"><i class="icon-width"></i> <span>RTL version</span></a></li> -->

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-file-text"></i> <span>Reportes</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Reportes">
                                <li class="nav-item"><a href="#" class="nav-link">Reporte de Inventario</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Reporte de Ventas</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Reportes General</a></li>
                            </ul>
                        </li>

                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-cogs"></i> <span>Configuraciones</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Configuraciones">
                                <li class="nav-item"><a href="<?php echo base_url()?>usuario/listar" class="nav-link">Usuarios</a></li>
                                <li class="nav-item"><a href="<?php echo base_url()?>tienda/listar" class="nav-link">Tiendas</a></li>
                                <!-- <li class="nav-item"><a href="#" class="nav-link">Empresa</a></li>   -->
                            </ul>
                        </li>
                        <!-- /main -->

                    </ul>
                </div>
                <!-- /main navigation -->

            </div>
            <!-- /sidebar content -->

        </div>
        <!-- /main sidebar -->

        <!-- Main content -->
        <div class="content-wrapper">
            <!-- <?php echo ENVIRONMENT?> -->
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

             <!-- Content area -->
            <?php include_once($page) ?>
            <!-- /Content area -->   

            <!-- Footer -->
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</span>

					<ul class="navbar-nav ml-lg-auto">
						<li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
						<li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
						<li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
					</ul>
				</div>
			</div>
			<!-- /footer -->
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /page content -->

    <div class="daterangepicker dropdown-menu ltr opensleft">
        <div class="calendars">
            <div class="calendar left">
                <div class="calendar-table"></div>
                <div class="daterangepicker_input">
                    <div class="calendar-time" style="display: none;">
                        <div></div>
                    </div>
                </div>
            </div>
            <div class="calendar right">
                <div class="calendar-table"></div>
                <div class="daterangepicker_input">
                    <div class="calendar-time" style="display: none;">
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ranges">
            <ul>
                <li data-range-key="Today">Today</li>
                <li data-range-key="Yesterday">Yesterday</li>
                <li data-range-key="Last 7 Days">Last 7 Days</li>
                <li data-range-key="Last 30 Days">Last 30 Days</li>
                <li data-range-key="This Month">This Month</li>
                <li data-range-key="Last Month">Last Month</li>
                <li data-range-key="Custom Range">Custom Range</li>
            </ul>
            <div class="daterangepicker-inputs">
                <div class="daterangepicker_input"><span class="start-date-label">Start date:</span><input class="form-control" type="text" name="daterangepicker_start" value=""><i class="icon-calendar3"></i></div>
                <div class="daterangepicker_input"><span class="end-date-label">End date:</span><input class="form-control" type="text" name="daterangepicker_end" value=""><i class="icon-calendar3"></i></div>
            </div>
            <div class="range_inputs"><button class="applyBtn btn btn-sm bg-slate-600 btn-block" disabled="disabled" type="button">Apply</button> <button class="cancelBtn btn btn-sm btn-light btn-block" type="button">Cancel</button></div>
        </div>
    </div>
    <div class="d3-tip" style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip" style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip" style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>
    <div class="d3-tip" style="position: absolute; top: 0px; display: none; pointer-events: none; box-sizing: border-box;"></div>

    <!-- Core JS files -->
    <script src="<?php echo base_url();?>assets/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/daterangepicker.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/d3.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/d3_tooltip.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/switchery.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/bootstrap_multiselect.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- /theme JS files -->

    <!-- <script src="../../../../global_assets/js/plugins/ui/moment/moment.min.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/daterangepicker.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/anytime.min.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/picker.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/picker.date.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/picker.time.js"></script>
	<script src="../../../../global_assets/js/plugins/pickers/pickadate/legacy.js"></script>
    <script src="../../../../global_assets/js/plugins/notifications/jgrowl.min.js"></script>
    <script src="assets/js/app.js"></script>
	<script src="../../../../global_assets/js/demo_pages/picker_date.js"></script> -->

    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/select2.min.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/datatables.min.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="<?php echo base_url();?>assets/js/dataTables.bootstrap4.min.js"></script> -->

    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/app.js"></script>
    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/datatables_api.js"></script>
    <!-- <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/form_checkboxes_radios.js"></script> -->

    <script src="<?php echo base_url();?>assets/bootstrap4-lm/js/dashboard.js"></script>

    <!-- jQuery Validate -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script> -->
    <script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>

    <script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>

    <script>
    var urlPath = '<?=base_url();?>';
    </script>

    <!-- Js Custom -->
    <script src="<?php echo base_url();?>assets/js/utils.js"></script>
    <script src="<?php echo base_url();?>assets/js/comun.js"></script>

    <?php if(isset($js)) : ?>
    <?php foreach($js as $script) : ?>
    <script src="<?php echo base_url();?>assets/js/<?php echo $script?>.js"></script>
    <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>

<div class="cls-loading"></div>

<!-- Modales Comunes -->

<!-- Modal seleccionar tienda -->
<div class="modal fade" id="modal-select-tienda" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
</div>

<!-- Modal atender reserva -->
<div class="modal fade" id="modal-atender-reserva" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
</div>

<!-- Modal atender devolucion -->
<div class="modal fade" id="modal-atender-alquiler" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
</div>

<div id="modal-content">

</div>
<div id="m-register-customer">

</div>
<div id="m-register-article">

</div>