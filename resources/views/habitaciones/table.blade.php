<table class="table table-responsive" id="habitaciones-table">
    <thead>
        <th>Piso</th>
        <th>Nombre</th>
        <th>Estado</th>
        <th>Observaciones</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($habitaciones as $habitaciones)
        <tr>
            <td>{!! $habitaciones->piso_id !!}</td>
            <td>{!! $habitaciones->nombre !!}</td>
            <td>{!! $habitaciones->estado !!}</td>
            <td>{!! $habitaciones->observaciones !!}</td>
            <td>
                {!! Form::open(['route' => ['habitaciones.destroy', $habitaciones->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('habitaciones.show', [$habitaciones->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('habitaciones.edit', [$habitaciones->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
