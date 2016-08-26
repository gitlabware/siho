<table class="table table-responsive" id="facturas-table">
    <thead>
        <th>Codigo Control</th>
        <th>Cliente</th>
        <th>Nit</th>
        <th>Nit P</th>
        <th>Importetotal</th>
        <th>Fecha</th>
        <th>Fecha Limite</th>
        <th>Numero</th>
        <th>Autorizacion</th>
        <th>Qr</th>
        <th>Montoliteral</th>
        <th>Created</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($facturas as $factura)
        <tr>
            <td>{!! $factura->codigo_control !!}</td>
            <td>{!! $factura->cliente !!}</td>
            <td>{!! $factura->nit !!}</td>
            <td>{!! $factura->nit_p !!}</td>
            <td>{!! $factura->importetotal !!}</td>
            <td>{!! $factura->fecha !!}</td>
            <td>{!! $factura->fecha_limite !!}</td>
            <td>{!! $factura->numero !!}</td>
            <td>{!! $factura->autorizacion !!}</td>
            <td>{!! $factura->qr !!}</td>
            <td>{!! $factura->montoliteral !!}</td>
            <td>{!! $factura->created !!}</td>
            <td>
                {!! Form::open(['route' => ['facturas.destroy', $factura->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('facturas.show', [$factura->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('facturas.edit', [$factura->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
