<div class="row" style="padding: 2em">
    <div class="col-lg-12">
        <!-- Basic charts strats here-->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <i class="fa fa-fw fa-user"></i> <?= (isset($datos)) ? 'Editar Tarifa' : 'Agregar Tarifa' ?>
                </h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (!isset($datos)) {
                            echo form_open_multipart('Tarifas/agregar', 'class="form-horizontal"');
                        } else {
                            echo form_open_multipart('Tarifas/editar', 'class="form-horizontal"');
                            echo '<input type="hidden" name="id" value="' . $datos->idTarifa . '">';
                        }
                        ?>
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="usr_name">
                                    Nombre
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-fw fa-question-circle text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control" id="name" placeholder="Nombre" name="nombre" required value="<?= (isset($datos)) ? $datos->Nombre : '' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="usr_name1">
                                    Tipo
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-fw fa-list-ol text-primary"></i>
                                        </span>
                                        <select class="form-control" name="tipo" required>
                                            <option value="" <?= (!isset($datos)) ? 'selected' : '' ?> disabled>Tipo</option>
                                            <option value="visita" <?= (isset($datos) && $datos->Tipo == 'visita') ? 'selected' : '' ?>>Visita</option>
                                            <option value="semana" <?= (isset($datos) && $datos->Tipo == 'semana') ? 'selected' : '' ?>>Semanal</option>
                                            <option value="mes" <?= (isset($datos) && $datos->Tipo == 'mes') ? 'selected' : '' ?>>Mensual</option>
                                            <option value="ano" <?= (isset($datos) && $datos->Tipo == 'ano') ? 'selected' : '' ?>>Anual</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="mail">
                                    Cuota
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-money text-primary"></i>
                                        </span>
                                        <input type="number" placeholder="00" class="form-control" name="cuota" required value="<?= (isset($datos)) ? $datos->Cuota : '' ?>" step="1" min="0"/>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="usr_name">
                                    Descripción
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-fw fa-question-circle text-primary"></i>
                                        </span>
                                        <input type="text" class="form-control" id="descripcion" placeholder="Descripción" name="descripcion" required value="<?= (isset($datos)) ? $datos->Descripcion : '' ?>">
                                    </div>
                                </div>
                            </div>
                            
                            
                            
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
    </div>
</div>
<script>

    var check = $('#name');
    var btn = $('#btn_sub');

    check.keyup(function () {
        $.ajax({
            url: "<?= site_url('Tarifas/check_nombre') ?>",
            type: 'POST',
            data: {
                nombre: check.val(),
                id: <?= (isset($datos)) ? $datos->idTarifa : 0 ?>
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
</script>