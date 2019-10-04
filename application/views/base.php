<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <title><?= $title ?></title>
        <link rel="shortcut icon" href="<?= assets('favicon.ico') ?>" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- global css -->
        <link href="<?= assets('css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= assets('css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <link type="text/css" href="<?= assets('css/custom_css/metisMenu.css') ?>" rel="stylesheet" />
        <link type="text/css" href="<?= assets('css/custom_css/fitness.css') ?>" rel="stylesheet"/>
        <link type="text/css" href="<?= assets('vendors/datatables/css/dataTables.bootstrap.css') ?>" rel="stylesheet" />
        <link type="text/css" href="<?= assets('js/lib/noty.css') ?>" rel="stylesheet">
        <link type="text/css" href="<?= assets('js/lib/themes/nest.css') ?>" rel="stylesheet">
        <link type="text/css" href="<?= assets('vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') ?>" rel="stylesheet" />
        <link type="text/css" href="<?= assets('vendors/select2/css/select2.css') ?>" rel="stylesheet" />
        <link type="text/css" href="<?= assets('vendors/select2/css/select2-bootstrap.min.css') ?>" rel="stylesheet" />
        <script src="<?= assets('js/jquery.min.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('vendors/datatables/js/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('vendors/datatables/js/dataTables.bootstrap.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('js/lib/noty.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('js/vue.min.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('vendors/holder/holder.js') ?>" type="text/javascript"></script>
    </head>
    <body>
        <div class="se-pre-con"></div>
        <!-- header logo: style can be found in header-->
        <header class="header">
            <nav class="navbar navbar-static-top">
                <!-- Header Navbar: style can be found in header-->
                <!-- Sidebar toggle button-->
                <!-- Sidebar toggle button-->
                <div>
                    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> 
                        <i class="fa fa-fw fa-navicon"></i>
                    </a>
                </div>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown-->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle padding-user" data-toggle="dropdown">
                                <img src="<?= archivos($this->session->userdata('img')) ?>" width="35" class="img-responsive img-circle img-responsive pull-left" height="35" alt="User Image">
                                <div class="riot">
                                    <div>
                                        <?= $this->session->userdata('user') ?>
                                        <span>
                                            <i class="caret"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= archivos($this->session->userdata('img')) ?>" class="img-circle" alt="Perfil">
                                    <p><?= $this->session->userdata('user') ?></p>
                                </li>
                                <!-- Menu Body -->
                                <li class="pad-3">
                                    <a href="<?= site_url('#') ?>">
                                        <i class="fa fa-fw fa-user"></i> Perfil
                                    </a>
                                </li>
                                <li role="presentation" class="divider"></li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= site_url('Admin/logout') ?>">
                                            <i class="fa fa-fw fa-sign-out"></i> Cerrar Sesión
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <script>
            $.fn.dataTable.ext.errMode = 'none';
        </script>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php $this->load->view('menu') ?>

            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <!--section ends-->
                <div class="container-fluid">
                    <?php $this->load->view($content) ?>
                </div>
                <!-- /#right -->
                <!-- /.content -->
            </aside>
        </div>
        <script>
            $('.aplicar').DataTable({
                "ordering": true,
                "aaSorting": [[0, 'desc']],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        </script>
        <script src="<?= assets('js/bootstrap.min.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('js/custom_js/app.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('js/custom_js/metisMenu.js') ?>" type="text/javascript"></script>
    </body>

</html>
