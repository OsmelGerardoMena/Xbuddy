<div class="row">
    <div class="col-xs-6 col-xs-offset-3" style="padding: 1em">
        <a class="btn btn-success btn-block" href="<?= site_url('View/nuevo_/' . $tipo) ?>"><span class="fa fa-plus"></span> Agregar</a>
    </div>    
</div>
<div style="padding: 2em" class="row">
    <table class="table table-hover table-striped" id="ver_info">
        <thead>
            <tr>
                <th>No.</th>
                <th>Info</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Foto</th>
                <th>Correo</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    var ver = $('#ver_info').DataTable({});

    ver.destroy();
    ver = $('#ver_info').DataTable({
        "ajax": {
            url: "<?= site_url($tipo . '/get_info') ?>"
        },
        "columns": [
            {"data": "id"},
            {"data": "usuario"},
            {"data": "nombre"},
            {"data": "apellidos"},
            {"data": "foto"},
            {"data": "correo"},
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
                        url: "<?= site_url($tipo . '/eliminar') ?>",
                        data: {
                            id: id
                        },
                        type: 'POST',
                        success: function () {
                            ver.ajax.reload();
                            n.close();
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