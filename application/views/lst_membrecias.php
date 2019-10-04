<div class="row">
    <div class="col-xs-6 col-xs-offset-3" style="padding: 1em">
        <a class="btn btn-success btn-block" href="<?= site_url('View/membrecias_agregar') ?>"><span class="fa fa-plus"></span> Agregar</a>
    </div>    
</div>
<div id="app_lst">
    <div style="padding: 2em" class="row">
        <table class="table table-hover table-striped" id="ver_membrecia">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Estatus</th>
                    <th>Registro</th>
                    <th>Vencimiento</th>
                    <th>Tarifa</th>
                    <th>Cliente</th>
                    <th>Ver</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="modal_detalles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="padding-left: 10em; padding-right: 10em">
                        <div class="row">
                            <center>
                                <img class="img img-circle" id="foto" style="max-height: 150px; max-width: 150px">
                            </center>
                        </div>
                        <div class="row">
                            <center>
                                <strong><p id="cliente"></p></strong>
                            </center>
                        </div>
                        <div class="row">
                            <label>Fecha Inicio: <strong id="f_inicio"></strong></label>
                        </div>
                        <div class="row">
                            <label>Fecha Fin: <strong id="f_fin"></strong></label>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <label>Estatus: <strong id="estatus"></strong></label>
                            </div>
                            <div class="col-xs-6">
                                <label>Tipo: <strong id="tipo"></strong></label>
                            </div>
                        </div>
                        <div class="row">
                            <label>Cuota: $<strong id="cuota"></strong></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function detalles(id) {
        console.log(id);
        $.ajax({
            url: "<?= site_url('Membrecia/detalles') ?>",
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (row) {
                var tipo = '';
                $('#foto').attr('src', '<?= archivos() ?>' + row.Foto);
                $('#cliente').text(row.Nombre_Cliente);
                $('#f_inicio').text(row.Fecha_registro);
                $('#f_fin').text((row.Fecha_vencimiento == null) ? 'X Dia' : row.Fecha_vencimiento);
                $('#estatus').text(row.Estatus_Nombre);
                if (row.Tipo == 'ano') {
                    tipo = 'año';
                } else {
                    tipo = row.Tipo;
                }
                $('#tipo').text(tipo);
                $('#cuota').text(row.Cuota);

                $('#modal_detalles').modal("show");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }

    function cancelar(id) {

        n = new Noty({
            type: 'alert',
            layout: 'center',
            theme: 'nest',
            text: '<center><strong><span class="fa fa-exclamation-triangle"></span> Cancelar Membrecia <span class="fa fa-exclamation-triangle"></span></strong></center>',
            closeWith: 'button',
            buttons: [
                Noty.button('Si', 'btn btn-danger btn-block', function () {
                    $.ajax({
                        url: "<?= site_url('Membrecia/cancelar') ?>",
                        data: {
                            id: id
                        },
                        type: 'POST',
                        success: function () {
                            ver.ajax.reload();
                            n.close();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR, textStatus, errorThrown);
                        }
                    });
                }),
                Noty.button('No', 'btn btn-success btn-block', function () {
                    n.close();
                })
            ]
        }).show();
    }

    //DataTable Membrecia
    var ver = $('#ver_membrecia').DataTable({});

    ver.destroy();
    ver = $('#ver_membrecia').DataTable({
        "ajax": {
            url: "<?= site_url('Membrecia/get_info') ?>"
        },
        "columns": [
            {"data": "id"},
            {"data": "estatus"},
            {"data": "registro"},
            {"data": "vencimiento"},
            {"data": "tipo"},
            {"data": "cliente"},
            {"data": "btn_ver"},
            {"data": "btn_eli"}
        ],
        "ordering": true,
        "aaSorting": [[1, 'desc']],
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

    //Fin DataTable Membrecias
</script>