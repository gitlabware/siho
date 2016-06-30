<table class="table table-bordered table-striped" id="example1">
    <thead>
        <th>Nombre</th>
        <th>Estado</th>
        <th>Observaciones</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($pisos as $pisos)
        <tr>
            <td>{!! $pisos->nombre !!}</td>
            <td>{!! $pisos->estado !!}</td>
            <td>{!! $pisos->observaciones !!}</td>
            <td>
                {!! Form::open(['route' => ['pisos.destroy', $pisos->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('pisos.show', [$pisos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('pisos.edit', [$pisos->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
