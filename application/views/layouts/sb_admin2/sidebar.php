<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <!-- <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
                <!-- /input-group -->
            <!-- </li> -->
            <li style="padding-top:10px">
                <a href="<?php echo base_url();?>"><i class="fa fa-home fa-fw"></i> Inicio</a>
            </li>
            <!-- <li style="padding-top:10px">
                <a href="<?php echo base_url();?>"><i class="fa fa-home fa-fw"></i> Alquiler</a>
            </li> -->
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Ventas/Alquiler<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url();?>ventas/clientes">Clientes</a></li>
                    <li><a href="<?php echo base_url();?>ventas/registrar">Registrar Operación</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Compras<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url();?>/compras/proveedores">Proveedores</a></li>
                    <li><a href="<?php echo base_url();?>/compras/registrar">Registro de compras</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Inventario<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="<?php echo base_url();?>inventario/articulos">Artículos</a></li>
                    <li><a href="<?php echo base_url();?>inventario/categorias">Categorias</a></li>
                    <li><a href="<?php echo base_url();?>inventario/kardex">Kardex</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Financiero<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="flot.html">Tipo Cambio</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Administrador<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="flot.html">Empresa</a></li>
                    <li>
                        <a href="<?php echo base_url()?>/user/list">Usuarios <span class="fa arrow"></span></a>
                        <!-- <ul class="nav nav-third-level">
                            <li><a href="flot.html">Third Level Item</a></li>
                            <li><a href="flot.html">Third Level Item</a></li>
                            <li><a href="flot.html">Third Level Item</a></li>
                        </ul> -->
                        <!-- /.nav-third-level -->
                    </li>
                    <li><a href="<?php echo base_url()?>user/list">Moneda</a></li>
                    <li><a href="<?php echo base_url()?>tienda/list">Tiendas</a></li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->