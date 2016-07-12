<table class="table table-responsive" id="precioshabitaciones-table">
    <thead>
        <th>Habitacione Id</th>
        <th>Precio</th>
        <th>Estado</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($precioshabitaciones as $precioshabitaciones)
        <tr>
            <td>{!! $precioshabitaciones->habitacione_id !!}</td>
            <td>{!! $precioshabitaciones->precio !!}</td>
            <td>{!! $precioshabitaciones->estado !!}</td>
            <td>
                {!! Form::open(['route' => ['precioshabitaciones.destroy', $precioshabitaciones->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('precioshabitaciones.show', [$precioshabitaciones->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('precioshabitaciones.edit', [$precioshabitaciones->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
