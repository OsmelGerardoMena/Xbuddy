<div class="row" style="padding: 2em">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-fw fa-user"></i> <?= (isset($datos)) ? 'Editar ' . $tipo : 'Agregar ' . $tipo ?>
                </h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (!isset($datos)) {
                            echo form_open_multipart($tipo . '/agregar', 'class="form-horizontal"');
                        } else {
                            echo form_open_multipart($tipo . '/editar', 'class="form-horizontal"');
                            echo '<input type="hidden" name="id" value="' . $datos->idInformacion . '">';
                        }
                        ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Foto</label>
                                <div class="col-md-7 text-center">
                                    <div class="input-group">
                                        <input type="file" class="btn btn-default" name="foto" <?= (isset($datos)) ? '' : 'required' ?> id="imagen" accept=".png, .jpg, .jpeg">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <center>
                                        <img data-src="holder.js/200x200" style="max-height: 200px; max-width: 200px" class="img-circle" id="img_destino" src="<?= (isset($datos)) ? archivos($datos->Foto) : '#' ?>" alt="">
                                    </center>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="usr_name">
                                    Nombre
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-fw fa-user-md text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control" id="usr_name" placeholder="Nombre" name="nombre" required value="<?= (isset($datos)) ? $datos->Nombre : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="usr_name1">
                                    Apellidos
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-fw fa-user-md text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control" id="usr_name1" placeholder="Apellidos" name="apellidos" required value="<?= (isset($datos)) ? $datos->Apellidos : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <center>
                                    <label class="radio-inline"><input type="radio" name="sexo" <?= (isset($datos) && $datos->Sexo == 'h') ? 'checked' : '' ?> value="h" required>Hombre</label>
                                    <label class="radio-inline"><input type="radio" name="sexo" <?= (isset($datos) && $datos->Sexo == 'm') ? 'checked' : '' ?> value="m">Mujer</label>
                                    <label class="radio-inline"><input type="radio" name="sexo" <?= (isset($datos) && $datos->Sexo == 'o') ? 'checked' : '' ?> value="o">Otro</label>
                                </center>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="mail">
                                    Correo
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope text-primary"></i>
                                        </span>
                                        <input type="email" placeholder="Correo Electronico" class="form-control" id="mail" name="correo" required value="<?= (isset($datos)) ? $datos->Correo : '' ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="contact">
                                    Telefono
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-fw fa-phone text-primary"></i>
                                        </span>
                                        <input type="number" placeholder="Telefono" id="telefono" class="form-control" name="telefono" required min="1000000000" max="9999999999" value="<?= (isset($datos)) ? $datos->Telefono : '' ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="mail">
                                    Contraseña
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock text-danger"></i>
                                        </span>
                                        <input type="password" placeholder="******" class="form-control" id="pass" name="contrasena" required minlength="6" value="<?= (isset($datos)) ? $datos->Contrasena : '' ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="mail">
                                    Verificar Contraseña
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock text-danger"></i>
                                        </span>
                                        <input type="password" placeholder="******" class="form-control" id="re_pass" name="re_contra" required minlength="6" value="<?= (isset($datos)) ? $datos->Contrasena : '' ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-3">
                                    <input type="submit" class="<?= (isset($datos)) ? '' : 'hidden' ?> btn btn-primary" value="<?= (isset($datos)) ? 'Guardar' : 'Agregar' ?>" id="btn_sub">
                                </div>
                                <div class="col-md-3">
                                    <a class="btn btn-default btn-block" href="javascript:history.back()"><span class="fa fa-arrow-circle-o-left"> Atras</span></a>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var telefono = $('#telefono');

    telefono.keyup(function () {
        $.ajax({
            url: "<?= site_url($tipo . '/check_telefono') ?>",
            type: 'POST',
            data: {
                tel: telefono.val(),
                id: <?= (isset($datos)) ? $datos->idInformacion : 0 ?>
            },
            success: function (check) {
                console.log(check);
                if (check != '0') {
                    new Noty({
                        type: 'alert',
                        layout: 'center',
                        theme: 'nest',
                        text: 'El telefono : <strong>' + telefono.val() + '</strong><br> ya registrado para <strong>' + check + '</strong>',
                        timeout: 5000
                    }).show();
                    telefono.val('');
                    telefono.removeClass('alert-success');
                    telefono.addClass('alert-danger');
                } else {
                    telefono.removeClass('alert-danger');
                    telefono.addClass('alert-success');
                }
            }
        });
    });

    $('#pass').keyup(function () {

        var pass = $('#pass');
        var re_pass = $('#re_pass');
        var btn = $('#btn_sub');

        re_pass.val('');
        btn.addClass('hidden');

        pass.removeClass('alert-success');
        re_pass.removeClass('alert-success');

        pass.addClass('alert-danger');
        re_pass.addClass('alert-danger');
    });

    $('#re_pass').keyup(function () {
        var pass = $('#pass');
        var re_pass = $('#re_pass');
        var btn = $('#btn_sub');

        if (pass.val() == re_pass.val()) {
            btn.removeClass('hidden');

            pass.removeClass('alert-danger');
            re_pass.removeClass('alert-danger');

            pass.addClass('alert-success');
            re_pass.addClass('alert-success');
        } else {
            btn.addClass('hidden');

            pass.removeClass('alert-success');
            re_pass.removeClass('alert-success');

            pass.addClass('alert-danger');
            re_pass.addClass('alert-danger');
        }
    });

    function mostrarImagen(input, n) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_destino' + n).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imagen").change(function () {
        mostrarImagen(this, '');
    });
</script>