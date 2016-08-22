@extends('layouts.app')

@section('content')
    <style>
        tfoot input {
            width: 100%;
            padding: 1px;
            box-sizing: border-box;
        }
        table.dataTable thead > tr > th{
            padding-right: 0px;
        }
        #tabla_filter{
            display: none;
        }
    </style>
    @include('flash::message')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">CALENDARIO</h3>
        </div>

        <div class="box-body table-responsive">
            <table id="tabla" class="table table-bordered ">
                <thead>
                <tr>
                    <th>Habitacion</th>
                    @for($i=1;$i<=$numero_dias;$i++)
                        <th></th>
                    @endfor
                </tr>

                </thead>
                <thead>
                <tr>
                    <th>Habitacion</th>
                    @for($i=1;$i<=$numero_dias;$i++)
                        <th>{!! $i !!}</th>
                    @endfor
                </tr>
                </thead>
                <tbody>
                @foreach($habitaciones as $habitacion)
                    <tr>
                        <td>{!! $habitacion->nombre !!}</td>
                        @for($i=1;$i<=$numero_dias;$i++)
                            <td></td>
                        @endfor
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
@push('scriptsextras')
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script>
    $(function () {
        var table = $('#tabla').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            //"scrollX": true,
            //"info": true,
            "autoWidth": false,
            "bPaginate": false,
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

        $('#tabla thead:eq( 0 ) th').each( function () {
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
        } );

    });

</script>
@endpush