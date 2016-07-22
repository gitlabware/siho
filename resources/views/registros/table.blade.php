<table class="table table-responsive" id="registros-table">
    <thead>
        <th>Cliente Id</th>
        <th>Habitacione Id</th>
        <th>Estado</th>
        <th>Fecha Ingreso</th>
        <th>Fecha Salida</th>
        <th>Observacion</th>
        <th>Precio</th>
        <th>Monto Total</th>
        <th>User Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($registros as $registro)
        <tr>
            <td>{!! $registro->cliente_id !!}</td>
            <td>{!! $registro->habitacione_id !!}</td>
            <td>{!! $registro->estado !!}</td>
            <td>{!! $registro->fecha_ingreso !!}</td>
            <td>{!! $registro->fecha_salida !!}</td>
            <td>{!! $registro->observacion !!}</td>
            <td>{!! $registro->precio !!}</td>
            <td>{!! $registro->monto_total !!}</td>
            <td>{!! $registro->user_id !!}</td>
            <td>
                {!! Form::open(['route' => ['registros.destroy', $registro->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('registros.show', [$registro->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('registros.edit', [$registro->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
