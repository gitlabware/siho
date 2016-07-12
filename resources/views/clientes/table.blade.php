<table class="table table-responsive" id="clientes-table">
    <thead>
        <th>Nombre</th>
        <th>Nacionalidad</th>
        <th>Edad</th>
        <th>Procedencia</th>
        <th>Profesion</th>
        <th>Pasaporte</th>
        <th>Ci</th>
        <th>Celular</th>
        <th>Referencia</th>
        <th>Estado</th>
        <th>Direccion</th>
        <th>Observaciones</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($clientes as $clientes)
        <tr>
            <td>{!! $clientes->nombre !!}</td>
            <td>{!! $clientes->nacionalidad !!}</td>
            <td>{!! $clientes->edad !!}</td>
            <td>{!! $clientes->procedencia !!}</td>
            <td>{!! $clientes->profesion !!}</td>
            <td>{!! $clientes->pasaporte !!}</td>
            <td>{!! $clientes->ci !!}</td>
            <td>{!! $clientes->celular !!}</td>
            <td>{!! $clientes->referencia !!}</td>
            <td>{!! $clientes->estado !!}</td>
            <td>{!! $clientes->direccion !!}</td>
            <td>{!! $clientes->observaciones !!}</td>
            <td>
                {!! Form::open(['route' => ['clientes.destroy', $clientes->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('clientes.show', [$clientes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('clientes.edit', [$clientes->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
