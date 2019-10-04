<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bienvenido</title>
        <link rel="shortcut icon" href="favicon.ico" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= assets('css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= assets('css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?= assets('css/custom_css/login.css') ?>" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="container">
            <div class="full-content-center">
                <div class="box bounceInLeft animated">
                    <img src="<?= assets('img/Captura.PNG') ?>" class="logo img-responsive" alt="Logo">
                    <h3 class="text-center">Entrar</h3>
                    <form class="form" action="<?= site_url('Admin/login') ?>" method="post">
                        <div class="form-group">
                            <label class="sr-only"></label>
                            <input type="text" class="form-control" name="user" placeholder="Usuario" required>
                        </div>
                        <div class="form-group">
                            <label class="sr-only"></label>
                            <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                        </div>
                        <input type="submit" class="btn btn-block btn-warning" value="Entrar">
                    </form>
                </div>
            </div>
        </div>
        <script src="<?= assets('js/jquery.min.js') ?>" type="text/javascript"></script>
        <script src="<?= assets('js/bootstrap.min.js') ?>" type="text/javascript"></script>
    </body>

</html>
