<div class="row">
    <div class="col-xs-6 col-xs-offset-3" style="padding: 1em">
        <a class="btn btn-success btn-block" href="<?= site_url('View/categoria_agregar') ?>"><span class="fa fa-plus"></span> Nueva Categoria</a>
    </div>    
</div>
<div style="padding: 2em" class="row">
    <table class="table table-hover table-striped" id="ver_categoria">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Fecha Registro</th>
                <th>Editar</th>
                <!--<th>Eliminar</th>-->
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script>
    var ver = $('#ver_categoria').DataTable({});

    ver.destroy();
    ver = $('#ver_categoria').DataTable({
        "ajax": {
            url: "<?= site_url('Categoria/get_info') ?>"
        },
        "columns": [
            {"data": "id"},
            {"data": "nombre"},
            {"data": "descripcion"},
            {"data": "fecha"},
            {"data": "btn_ed"}
            /*{"data": "btn_el"}*/
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
    
</script>