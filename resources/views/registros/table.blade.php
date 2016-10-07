<div class="box">
    <div class="box-body table-responsive">
        <table class="table table-responsive table-bordered" id="tabla">
            <thead>
            <th>Grupo</th>
            <th>Habitacione Id</th>
            <th>Estado</th>
            <th>Fecha Ingreso</th>
            <th>Fecha Salida</th>
            <th>Observacion</th>
            <th>Precio</th>
            <th>Monto Total</th>
            <th>User Id</th>
            <th></th>
            </thead>
            <thead>
            <th>Grupo</th>
            <th>Habitacione Id</th>
            <th>Estado</th>
            <th>Fecha Ingreso</th>
            <th>Fecha Salida</th>
            <th>Observacion</th>
            <th>Precio</th>
            <th>Deuda</th>
            <th>User Id</th>
            <th>Action</th>
            </thead>
            <tbody>
            @foreach($registros as $registro)
                <tr
                        @if($registro->grupo->deudas > 0)
                        class="info"
                        @endif

                >

                    <td>{!! $registro->grupo->nombre !!}</td>
                    <td>{!! $registro->habitacione->nombre.' - '.$registro->habitacione->rpiso->nombre !!}</td>
                    <td>{!! $registro->estado !!}</td>
                    <td>{!! $registro->fecha_ingreso !!}</td>
                    <td>{!! $registro->fecha_salida !!}</td>
                    <td>{!! $registro->observacion !!}</td>
                    <td>{!! $registro->precio !!}</td>
                    <td>{!! $registro->grupo->deudas !!}</td>
                    <td>{!! $registro->user_id !!}</td>
                    <td>
                        {!! Form::open(['route' => ['registros.destroy', $registro->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>

                            @if($registro->estado != 'Desocupado')

                                <a class="btn btn-default btn-xs"
                                   href="{!! route('registrosgrupos',[$registro->grupo_id]) !!}">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                            @endif
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Al el eliminar el registro significa eliminar pagos y  ocupacion de habitacion.. Esta seguro de eliminar el registro?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


@push('scriptsextras')
@include('layouts.partials.jsdatatable')
@endpush