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
            <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>

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