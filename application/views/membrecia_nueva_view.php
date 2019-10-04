<div id="app_membrecia">
    <div class="row" v-if="!datos" style="padding: 1em">
        <div class="col-lg-12">
            <!-- Basic charts strats here-->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="fa fa-fw fa-user"></i> Seleccione el Cliente
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row" style="padding: 1em">
                        <table class="table table-condensed table-hover table-striped aplicar">
                            <thead>
                                <tr>
                                    <th>Iniciales</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Foto</th>
                                    <th>Correo</th>
                                    <th>Telefono</th>
                                    <th>Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 0;
                                foreach ($clientes as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row->Usuario ?></td>
                                        <td><?= $row->Nombre ?></td>
                                        <td><?= $row->Apellidos ?></td>
                                        <td><img class="img img-circle" src="<?= archivos($row->Foto) ?>" style="height: 75px; width: 75px"></td>
                                        <td><?= $row->Correo ?></td>
                                        <td><?= $row->Telefono ?></td>
                                        <td><button class="btn btn-block btn-success" @click="cliente(<?= $x ?>)"><span class="fa fa-plus-circle"></span></button></td>
                                    </tr>
                                    <?php
                                    $x++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="datos" style="padding-top: 2em;padding-left: 20em; padding-right: 20em">
        <form class="form" method="post" action="<?= site_url('Membrecia/agregar') ?>">
            <input type="hidden" name="id" v-bind:value="id">
            <div class="form-group">
                <img class="img img-circle center-block" style="height: 100px; width: 100px" v-bind:src="foto">
            </div>
            <div class="form-group">
                <label>Nombre</label>
                <input class="form-control" v-bind:value="nombre" readonly>
            </div>
            <div class="form-group">
                <label>Apellidos</label>
                <input class="form-control" v-bind:value="apellidos" readonly>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input class="form-control" v-bind:value="correo" readonly>
            </div>
            <div class="form-group">
                <label>Telefono</label>
                <input class="form-control" v-bind:value="telefono" readonly>
            </div>
            <div class="form-group">
                <label>Tarifa (Nombre / $)</label>
                <select class="form-control" name="tarifa" required>
                    <option value="" disabled selected>Tarifas</option>
                    <?php
                    foreach ($tarifas as $row) {
                        ?>
                        <option value="<?= $row->idTarifa ?>"><?= '<strong>' . $row->Nombre . '</strong> / $' . $row->Cuota ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="form-actions">
                <div class="col-xs-6">
                    <button type="submit" class="btn btn-success btn-block"><span class="fa fa-check"> Agregar</span></button>
                </div>
                <div class="col-xs-6">
                    <button type="button" @click="cancelar()" class="btn btn-default btn-block"><span class="fa fa-times-circle"> Cancelar</span></button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>

    var app = new Vue({
        el: '#app_membrecia',
        data: {
            datos: false,
            foto: null,
            nombre: null,
            apellidos: null,
            correo: null,
            telefono: null,
            id: null,
            resp:<?= json_encode($clientes) ?>
        },
        methods: {
            cliente: function (x) {
                this.datos = true;
                this.id = this.resp[x].idCliente;
                this.foto = "<?= archivos() ?>" + this.resp[x].Foto;
                this.nombre = this.resp[x].Nombre;
                this.apellidos = this.resp[x].Apellidos;
                this.correo = this.resp[x].Correo;
                this.telefono = this.resp[x].Telefono;
            },
            cancelar: function () {
                this.datos = false;
                this.foto = null;
                this.nombre = null;
                this.apellidos = null;
                this.correo = null;
                this.telefono = null;
            }
        }
    });

    var check = $('#name');
    var btn = $('#btn_sub');

    check.keyup(function () {
        $.ajax({
            url: "<?= site_url('Membrecia/buscar_nombre') ?>",
            type: 'POST',
            data: {
                nombre: check.val()
            },
            dataType: 'JSON',
            success: function (check_resp) {
                console.log(check_resp);
                if (check_resp.success == '0') {

                    check.removeClass('alert-success');
                    check.addClass('alert-danger');
                    btn.addClass('hidden');
                } else {
                    btn.removeClass('hidden');
                    check.removeClass('alert-danger');
                    check.addClass('alert-success');
                }
            },
            error: function (a, b, c) {
                console.log(a, b, c);
            }
        });
    });
</script>