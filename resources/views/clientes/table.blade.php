<table class="table table-bordered table-striped" id="clientes-table">
    <thead>
    <th>Nombre</th>
    <th>Nacionalidad</th>
    <th>Pasaporte</th>
    <th>Ci</th>
    <th>Celular</th>
    <th>Observaciones</th>
    <th></th>
    </thead>
    <thead>
    <th>Nombre</th>
    <th>Nacionalidad</th>
    <th>Pasaporte</th>
    <th>Ci</th>
    <th>Celular</th>
    <th>Observaciones</th>
    <th>Action</th>
    </thead>
    <tbody>

    </tbody>
</table>

<div id="td-acciones" style="display: none">
    {!! Form::open(['route' => ['clientes.destroy', 0], 'method' => 'delete']) !!}
    <div class='btn-group'>

        <a href="javascript:" onclick="editar(0)" class='btn btn-default btn-xs'><i
                    class="glyphicon glyphicon-edit"></i></a>
        <a href="{!! route('asignahabitacion2', ['Cliente',0]) !!}" title="Registrar habitacion"
           class='btn btn-success btn-xs'><i
                    class="fa fa-list"></i></a>
        <a href="{!! route('registros_cliente', [0]) !!}" title="Registros de Clientes"
           class='btn btn-primary btn-xs'><i
                    class="fa fa-tags"></i></a>
        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
    </div>
    {!! Form::close() !!}
</div>
<style>
    .observado{
        background-color: rgb(252, 209, 130);
    }
</style>

@push('scriptsextras')
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script>
    function editar(idCliente){
        cargarmodal('{!! url('cliente') !!}/'+idCliente,'primary','lg');
    }
    var table = null;
    $(function () {
        table = $('#clientes-table').DataTable({
            processing: true,
            serverSide: true,
            'order': [],
            "bSort": false,
            ajax: '{!! route('datatables.data') !!}',
            columns: [
                {data: 'nombre', name: 'nombre'},
                {data: 'nacionalidad', name: 'nacionalidad'},
                {data: 'pasaporte', name: 'pasaporte'},
                {data: 'ci', name: 'ci'},
                {data: 'celular', name: 'celular'},
                {data: 'observaciones', name: 'observaciones'},
                {data: 'id', name: 'id'}
            ],
            fnCreatedRow: function (nRow, aData, iDataIndex) {
                var acciones = $('#td-acciones').html();
                $('td:eq(6)', nRow).html(acciones);
                if(aData['observaciones'] != ''){
                    $('td', nRow).addClass('observado');
                }
                var acc_form = $('td:eq(6) form', nRow).attr('action').substring(1, ($('td:eq(6) form', nRow).attr('action').length - 1)) + aData['id'];
                $('td:eq(6) form', nRow).attr('action', acc_form);
                $('td:eq(6) form a:eq(0)', nRow).attr('onclick', 'editar('+aData['id']+')');
                var href2 = $('td:eq(6) form a:eq(1)', nRow).attr('href').substring(0, ($('td:eq(6) form a:eq(1)', nRow).attr('href').length - 1)) + aData['id'];
                $('td:eq(6) form a:eq(1)', nRow).attr('href', href2);
                var href3 = $('td:eq(6) form a:eq(2)', nRow).attr('href').substring(0, ($('td:eq(6) form a:eq(2)', nRow).attr('href').length - 1)) + aData['id'];
                $('td:eq(6) form a:eq(2)', nRow).attr('href', href3);
            },
            "language": {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });
        $('#clientes-table thead:eq( 0 ) th').each(function () {
            var title = $('#clientes-table thead:eq( 0 ) th').eq($(this).index()).text();
            if (title != '') {
                $(this).html('<input type="text" style="width: 100%;" placeholder="' + title + '" />');
            }
        });
        table.columns().eq(0).each(function (colIdx) {
            $('input', table.column(colIdx).header()).on('keyup change', function () {
                table
                        .column(colIdx)
                        .search(this.value)
                        .draw();
            });
        });
    });
    function recargatabla(){
        //table.ajax.reload();
        table.ajax.reload( null, false );
    };

</script>
@endpush
