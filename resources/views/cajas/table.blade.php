<table class="table table-responsive" id="cajas-table">
    <thead>
        <th>Nombre</th>
        <th>Total</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($cajas as $caja)
        <tr>
            <td>{!! $caja->nombre !!}</td>
            <td>{!! $caja->total !!}</td>
            <td>
                {!! Form::open(['route' => ['cajas.destroy', $caja->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! url('caja/flujos', [$caja->id]) !!}" title="Flujos de caja" class='btn btn-primary btn-xs'><i class="fa fa-list"></i></a>
                    <a href="{!! route('cajas.edit', [$caja->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
