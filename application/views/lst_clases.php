<div class="row">
    <div class="col-xs-6 col-xs-offset-3" style="padding: 1em">
        <a class="btn btn-success btn-block" href="<?= site_url('View/clase_agregar') ?>"><span class="fa fa-plus"></span> Nueva Clase</a>
    </div>    
</div>
<div style="padding: 2em" class="row">
    <table class="table table-hover table-striped table-condensed" id="ver_clases">
        <thead>
            <tr>
                <th>Miembros</th>
                <th>Clase (No. Miembros)</th>
                <th>Imagen</th>
                <th>F. Inicio</th>
                <th>Categoria</th>
                <th>Couch</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="modal fade" id="miembros" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Miembros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="datos_miembros"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><span class="fa fa-times-circle"> Cerrar</span></button>
            </div>
        </div>
    </div>
</div>
<script>
    function miembros(clase) {
        $.ajax({
            url: "<?= site_url('Clases/miembros_clase') ?>",
            dataType: 'JSON',
            type: 'POST',
            data: {
                clase: clase
            },
            success: function (miembros) {
                var html = '';
                for (var i = 0; i < miembros.length; i++) {
                    html += '<tr><td>' + miembros[i].Nombre + ' ' + miembros[i].Apellidos + '</td><td><img src="<?= archivos() ?>' + miembros[i].Foto + '" class="img-responsive img-circle" style="max-height: 50px; max-width: 50px"></td></tr>';
                }
                $('#datos_miembros').html(html);
                $('#miembros').modal("show");
            }
        });
    }

    var ver = $('#ver_clases').DataTable({});

    ver.destroy();
    ver = $('#ver_clases').DataTable({
        "ajax": {
            url: "<?= site_url('Clases/get_info') ?>"
        },
        "columns": [
            {"data": "miembros"},
            {"data": "clase"},
            {"data": "imagen"},
            {"data": "f_inicio"},
            {"data": "categoria"},
            {"data": "couch"},
            {"data": "btn_ed"},
            {"data": "btn_el"}
        ],
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

    function eliminar(id) {
        console.log(id);

        n = new Noty({
            type: 'alert',
            layout: 'center',
            theme: 'nest',
            text: '<center><strong><span class="fa fa-exclamation-triangle"></span> Eliminar <span class="fa fa-exclamation-triangle"></span></strong></center>',
            closeWith: 'button',
            buttons: [
                Noty.button('Si', 'btn btn-danger btn-block', function () {
                    $.ajax({
                        url: "<?= site_url('Clases/eliminar') ?>",
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

</script>