<table class="table table-responsive" id="estudiantes-table">
    <thead>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Direccion</th>
        <th>Fechanac</th>
        <th>Aula Id</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($estudiantes as $estudiantes)
        <tr>
            <td>{!! $estudiantes->nombre !!}</td>
            <td>{!! $estudiantes->telefono !!}</td>
            <td>{!! $estudiantes->direccion !!}</td>
            <td>{!! $estudiantes->fechanac !!}</td>
            <td>{!! $estudiantes->aula_id !!}</td>
            <td>
                {!! Form::open(['route' => ['estudiantes.destroy', $estudiantes->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('estudiantes.show', [$estudiantes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('estudiantes.edit', [$estudiantes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
