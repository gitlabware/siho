@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Grupos</h1>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box">
        <div class="box-body">
            <table class="table table-responsive" id="tabla">
                <thead>
                <th>creado</th>
                <th>Nombre</th>
                <th>Pagos pendientes</th>
                <th>Action</th>
                </thead>
                <tbody>
                @foreach($grupos as $grupo)
                    @if($grupo->deudas > 0)
                        <tr class="info">
                    @else
                        <tr>
                            @endif
                            <td>{!! $grupo->created_at !!}</td>
                            <td>{!! $grupo->nombre !!}</td>
                            <td>{!! $grupo->deudas.' Bs.' !!}</td>
                            <td>
                                <div class='btn-group'>
                                    <a href="{!! route('registrosgrupos', [$grupo->id]) !!}" title="Registros"
                                       class='btn btn-primary btn-xs'><i class="fa fa-list"></i></a>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>

        </div>
    </div>


@endsection

@push('scriptsextras')
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script>
    var table = $('#tabla').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        //"scrollX": true,
        'order': [],
        "bSort": false,
        "info": true,
        "autoWidth": false,
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
    $(function () {


        /*$('#tabla thead:eq( 0 ) th').each( function () {
         var title = $('#tabla thead:eq( 0 ) th').eq( $(this).index() ).text();
         if(title != ''){
         $(this).html( '<input type="text" style="width: 100%;" placeholder="'+title+'" />' );
         }

         } );

         table.columns().eq( 0 ).each( function ( colIdx ) {
         $( 'input', table.column( colIdx ).header() ).on( 'keyup change', function () {
         table
         .column( colIdx )
         .search( this.value )
         .draw();
         } );
         } );*/

    });

</script>
@endpush
