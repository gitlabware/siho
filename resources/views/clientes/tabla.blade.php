<table class="table table-bordered table-striped" id="clientes-table">
    <thead>
    <th>Nombre</th>
    <th>Pasaporte</th>
    <th>Ci</th>
    <th></th>
    </thead>
    <thead>
    <th>Nombre</th>
    <th>Pasaporte</th>
    <th>Ci</th>
    <th>Action</th>
    </thead>
    <tbody>

    </tbody>
</table>

<style>
    .observado{
        background-color: rgb(252, 209, 130);
    }
    #clientes-table_filter{
        display: none;
    }
    #clientes-table_length{
        display: none;
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
                {data: 'pasaporte', name: 'pasaporte'},
                {data: 'ci', name: 'ci'},
                {data: 'id', name: 'id'}
            ],
            fnCreatedRow: function (nRow, aData, iDataIndex) {
                //console.log(aData);

                var ac_editar = '<a href="javascript:" onclick="editar('+aData['id']+')" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-edit"></i></a>';
                var ac_add_cli = '<a href="javascript:" onclick="addcli(this);" data-nombre="'+aData['nombre']+'" data-pasaporte="'+aData['pasaporte']+'" data-ci="'+aData['ci']+'" data-id="'+aData['id']+'" class="btn btn-primary btn-xs add-cli"><i class="fa fa-mail-reply-all"></i></a>';
                var acciones = ac_editar+' '+ac_add_cli;
                $('td:eq(3)', nRow).html(acciones);
                if(aData['observaciones'] != ''){
                    $('td', nRow).addClass('observado');
                }

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
