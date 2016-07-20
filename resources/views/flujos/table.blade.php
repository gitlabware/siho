<table class="table table-responsive" id="flujos-table">
    <thead>
        <th>Ingreso</th>
        <th>Salida</th>
        <th>Detalle</th>
        <th>Observacion</th>
        <th>Flujo Id</th>
        <th>User Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($flujos as $flujo)
        <tr>
            <td>{!! $flujo->ingreso !!}</td>
            <td>{!! $flujo->salida !!}</td>
            <td>{!! $flujo->detalle !!}</td>
            <td>{!! $flujo->observacion !!}</td>
            <td>{!! $flujo->flujo_id !!}</td>
            <td>{!! $flujo->user_id !!}</td>
            <td>
                {!! Form::open(['route' => ['flujos.destroy', $flujo->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('flujos.show', [$flujo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('flujos.edit', [$flujo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
