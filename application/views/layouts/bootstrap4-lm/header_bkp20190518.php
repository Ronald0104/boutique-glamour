<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ronald Terrones">
    <title>Boutique Glamour</title>

    <!-- Global stylesheets -->
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- <link href="<?php echo base_url();?>assets/bootstrap4-lm/css/css" rel="stylesheet" type="text/css"> -->
    <link href="/assets/bootstrap4-lm/css/icomoon.css" rel="stylesheet" type="text/css">
    <link href="/assets/font-glyphicons/css/font-glyphicons.css" rel="stylesheet" type="text/css">

    <!-- Boostrap 4 -->
    <link href="<?php echo base_url();?>assets/bootstrap4-lm/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/bootstrap4-lm/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/dist/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/bootstrap4-lm/css/components.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url();?>assets/bootstrap4-lm/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Custom css page -->
    <?php if(isset($css)) : ?>
    <?php foreach($css as $style) : ?>
    <link href="<?php echo base_url();?>assets/css/<?php echo $style; ?>.css" rel="stylesheet">
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- Custom css -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/estilos.css">
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
            <!-- <a href="#" class="d-inline-block">
				<img src="imagen/logo_light.png" alt="Mi Logo">
			</a> -->
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