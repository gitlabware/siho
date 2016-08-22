<table class="table table-bordered table-striped" id="clientes-table">
    <thead>
    <th>Nombre</th>
    <th>Nacionalidad</th>
    <th>Profesion</th>
    <th>Pasaporte</th>
    <th>Ci</th>
    <th>Celular</th>
    <th>Referencia</th>
    <th></th>
    </thead>
    <thead>
    <th>Nombre</th>
    <th>Nacionalidad</th>
    <th>Profesion</th>
    <th>Pasaporte</th>
    <th>Ci</th>
    <th>Celular</th>
    <th>Referencia</th>
    <th>Action</th>
    </thead>
    <tbody>

    </tbody>
</table>

<div id="td-acciones" style="display: none">
    {!! Form::open(['route' => ['clientes.destroy', 0], 'method' => 'delete']) !!}
    <div class='btn-group'>

        <a href="{!! route('clientes.edit', [0]) !!}" class='btn btn-default btn-xs'><i
                    class="glyphicon glyphicon-edit"></i></a>
        <a href="{!! route('asignahabitacion2', [0]) !!}" title="Registrar habitacion"
           class='btn btn-success btn-xs'><i
                    class="fa fa-list"></i></a>
        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
    </div>
    {!! Form::close() !!}
</div>

@push('scriptsextras')
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script>
    $(function () {
        var table = $('#clientes-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.data') !!}',
            columns: [
                {data: 'nombre', name: 'nombre'},
                {data: 'nacionalidad', name: 'nacionalidad'},
                {data: 'profesion', name: 'profesion'},
                {data: 'pasaporte', name: 'pasaporte'},
                {data: 'ci', name: 'ci'},
                {data: 'celular', name: 'celular'},
                {data: 'referencia', name: 'referencia'},
                {data: 'id', name: 'id'}
            ],
            fnCreatedRow: function (nRow, aData, iDataIndex) {
                var acciones = $('#td-acciones').html();
                $('td:eq(7)', nRow).html(acciones);

                var acc_form = $('td:eq(7) form', nRow).attr('action').substring(1, ($('td:eq(7) form', nRow).attr('action').length - 1)) + aData['id'];
                $('td:eq(7) form', nRow).attr('action', acc_form);


                var href1 = $('td:eq(7) form a:eq(0)', nRow).attr('href').replace("/0/", "/"+aData['id']+"/");
                $('td:eq(7) form a:eq(0)', nRow).attr('href', href1);

                var href2 = $('td:eq(7) form a:eq(1)', nRow).attr('href').substring(0, ($('td:eq(7) form a:eq(1)', nRow).attr('href').length - 1)) + aData['id'];
                $('td:eq(7) form a:eq(1)', nRow).attr('href', href2);

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


</script>
@endpush
