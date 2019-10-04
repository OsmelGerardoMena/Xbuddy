<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar-->
    <section class="sidebar">
        <div id="menu" role="navigation">
            <div class="nav_profile">
                <div class="media profile-left">
                    <div class="content-profile">
                        <h4 class="media-heading"><?= $this->session->userdata('user') ?></h4>
                    </div>
                </div>
            </div>
            <ul class="navigation">
                <li>
                    <a href="<?= site_url('View/inicio') ?>">
                        <i class="text-primary menu-icon fa fa-fw fa-home"></i>
                        <span class="mm-text ">Inicio</span>
                        <span class="arrow"></span>
                    </a>
                </li>
                <li class="menu-dropdown">
                    <a href="#">
                        <i class="text-success menu-icon fa fa-fw fa-users"></i>
                        <span class="mm-text">Clientes</span>
                        <span class="fa fa-angle-down pull-right"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= site_url('View/ver_/Cliente') ?>">
                                <i class="text-primary fa fa-fw fa-list"></i> Ver
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('View/nuevo_/Cliente') ?>">
                                <i class="text-success fa fa-fw fa-plus"></i> Agregar
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-dropdown">
                    <a href="#">
                        <i class="text-success menu-icon fa fa-fw fa-clock-o"></i>
                        <span class="mm-text">Membresía</span>
                        <span class="fa fa-angle-down pull-right"></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?= site_url('View/membrecias_ver') ?>">
                                <i class="text-primary fa fa-fw fa-list"></i> Ver
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('View/membrecias_agregar') ?>">
                                <i class="text-success fa fa-fw fa-plus"></i> Agregar
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                if ($this->session->userdata('nvl') === 1) {
                    ?>

                    <li class="menu-dropdown">
                        <a href="#">
                            <i class="text-primary menu-icon fa fa-database"></i>
                            <span class="mm-text">Administrar</span>
                            <span class="fa fa-angle-down pull-right"></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="#">
                                    <i class="text-primary fa fa-fw fa-user-secret"></i> Recepcionistas
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="<?= site_url('View/ver_/Recepcion') ?>">
                                            <i class="text-primary fa fa-fw fa-list-ul"></i> Ver
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('View/nuevo_/Recepcion') ?>">
                                            <i class="text-success fa fa-fw fa-user-plus"></i> Agregar
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="text-primary fa fa-fw fa-star-half-full"></i> Clases
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="<?= site_url('View/lst_clase') ?>">
                                            <i class="text-primary fa fa-fw fa-list"></i> Ver
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('View/clase_agregar') ?>">
                                            <i class="text-success fa fa-fw fa-plus"></i> Agregar
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="text-info fa fa-fw fa-file-o"></i> Categorias
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="sub-menu sub-submenu">
                                            <li>
                                                <a href="<?= site_url('View/lst_categoria') ?>">
                                                    <i class="text-primary fa fa-fw fa-list"></i> Ver
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?= site_url('View/categoria_agregar') ?>">
                                                    <i class="text-success fa fa-fw fa-plus"></i> Agregar
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="text-info fa fa-fw fa-user-secret"></i> Coach
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="<?= site_url('View/ver_/Couch') ?>">
                                            <i class="text-primary fa fa-fw fa-list"></i> Ver
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('View/nuevo_/Couch') ?>">
                                            <i class="text-success fa fa-fw fa-plus"></i> Agregar
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="text-info fa fa-fw fa-money"></i> Tarifas
                                    <span class="fa arrow"></span>
                                </a>
                                <ul class="sub-menu sub-submenu">
                                    <li>
                                        <a href="<?= site_url('View/tarifas_ver') ?>">
                                            <i class="text-primary fa fa-fw fa-list"></i> Ver
                                        </a>
                                        <a href="<?= site_url('View/tarifas_agregar') ?>">
                                            <i class="text-success fa fa-fw fa-plus"></i> Agregar
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <!-- / .navigation -->
        </div>
        <!-- menu -->
    </section>
    <!-- /.sidebar -->
</aside>