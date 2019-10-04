<div class="row" style="padding: 2em">
    <div class="col-lg-12">
        <!-- Basic charts strats here-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-fw fa-user"></i> <?= (isset($datos)) ? 'Editar Clase' : 'Agregar Clase' ?>
                </h4>
            </div>
            <div class="panel-body">
                <?php
                if (!isset($datos)) {
                    echo form_open_multipart('Clases/agregar', 'class="form-horizontal"');
                } else {
                    echo form_open_multipart('Clases/editar', 'class="form-horizontal"');
                    echo '<input type="hidden" name="id" value="' . $datos->idClase . '">';
                }
                ?>
                <div class="form-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Imagen</label>
                        <div class="col-md-7 text-center">
                            <div class="input-group">
                                <input type="file" class="btn btn-default" name="foto" <?= (isset($datos)) ? '' : 'required' ?> id="imagen" accept=".png, .jpg, .jpeg">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <center>
                                <img data-src="holder.js/200x200" style="max-height: 200px; max-width: 200px" class="img-circle" id="img_destino" src="<?= (isset($datos)) ? archivos($datos->Imagen) : '#' ?>" alt="">
                            </center>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="usr_name">
                            Nombre de la Clase
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-fw fa-question-circle text-primary"></i>
                                </span>
                                <input type="text" class="form-control" id="name" placeholder="Nombre" name="nombre" required value="<?= (isset($datos)) ? $datos->Clase : '' ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="usr_name1">
                            Categoria
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-fw fa-list-ol text-primary"></i>
                                </span>
                                <select class="form-control" name="categoria" required>
                                    <option value="" <?= (!isset($datos)) ? 'selected' : '' ?> disabled>Categoria</option>
                                    <?php
                                    foreach ($categoria as $row) {
                                        ?>
                                        <option value="<?= $row->idCategoria ?>" <?= (isset($datos) && $row->idCategoria == $datos->Categoria) ? 'selected' : '' ?>><?= $row->Nombre ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="usr_name1">
                            Couch
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-fw fa-list-ol text-primary"></i>
                                </span>
                                <select class="form-control" name="couch" required>
                                    <option value="" <?= (!isset($datos)) ? 'selected' : '' ?> disabled>Couch</option>
                                    <?php
                                    foreach ($couch as $row) {
                                        ?>
                                        <option value="<?= $row->idCouch ?>" <?= (isset($datos) && $row->idCouch == $datos->Couch) ? 'selected' : '' ?>><?= $row->Nombre . ' ' . $row->Apellidos ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mail">
                            No. de Miembros
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user text-primary"></i>
                                </span>
                                <input type="number" placeholder="00" class="form-control" name="miembros" required value="<?= (isset($datos)) ? $datos->Miembros : '' ?>" step="1" min="0"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mail">
                            Hora de Inicio
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o text-primary"></i>
                                </span>
                                <input type="time" class="form-control" name="h_inicio" required value="<?= (isset($datos)) ? $datos->H_inicio : '' ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mail">
                            Hora de Fin
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o text-primary"></i>
                                </span>
                                <input type="time" class="form-control" name="h_fin" required value="<?= (isset($datos)) ? $datos->H_fin : '' ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mail">
                            Fecha de Inicio
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar text-primary"></i>
                                </span>
                                <input type="date" class="form-control" name="f_inicio" value="<?= (isset($datos)) ? $datos->F_inicio : '' ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mail">
                            Fecha de Fin
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar text-primary"></i>
                                </span>
                                <input type="date" class="form-control" name="f_fin" required value="<?= (isset($datos)) ? $datos->F_fin : '' ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mail">
                            Dias
                            <span class='require'>*</span>
                        </label>
                        <div class="col-md-7">
                            <div class="input-group">
                                <?php
                                if (isset($datos)) {
                                    $array_dias = json_decode($datos->Dias);
                                }
                                ?>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?= (isset($array_dias) && in_array("lunes", $array_dias)) ? 'checked' : '' ?> value="lunes" name="dias[]">Lunes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?= (isset($array_dias) && in_array("martes", $array_dias)) ? 'checked' : '' ?> value="martes" name="dias[]">Martes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?= (isset($array_dias) && in_array("miercoles", $array_dias)) ? 'checked' : '' ?> value="miercoles" name="dias[]">Miercoles</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?= (isset($array_dias) && in_array("jueves", $array_dias)) ? 'checked' : '' ?> value="jueves" name="dias[]">Jueves</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?= (isset($array_dias) && in_array("viernes", $array_dias)) ? 'checked' : '' ?> value="viernes" name="dias[]">Viernes</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?= (isset($array_dias) && in_array("sabado", $array_dias)) ? 'checked' : '' ?> value="sabado" name="dias[]">Sabado</label>
                                </div>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?= (isset($array_dias) && in_array("domingo", $array_dias)) ? 'checked' : '' ?> value="domingo" name="dias[]">Domingo</label>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-3">
                                <input type="submit" class="<?= (isset($datos)) ? '' : 'hidden' ?> btn btn-primary btn-block" value="<?= (isset($datos)) ? 'Guardar' : 'Agregar' ?>" id="btn_sub">
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
<script>

    var check = $('#name');
    var btn = $('#btn_sub');

    check.keyup(function () {
        $.ajax({
            url: "<?= site_url('Clases/check_nombre') ?>",
            type: 'POST',
            data: {
                nombre: check.val(),
                id: <?= (isset($datos)) ? $datos->idClase : 0 ?>
            },
            success: function (check_resp) {
                console.log(check_resp);
                if (check_resp != '0') {
                    new Noty({
                        type: 'error',
                        layout: 'center',
                        theme: 'nest',
                        text: '<strong>"' + check.val() + '"</strong> ya registrado, intente con otro.',
                        timeout: 5000
                    }).show();
                    check.val('');
                    check.removeClass('alert-success');
                    check.addClass('alert-danger');
                    btn.addClass('hidden');
                } else {
                    btn.removeClass('hidden');
                    check.removeClass('alert-danger');
                    check.addClass('alert-success');
                }
            }
        });
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