<table class="table table-bordered table-striped" id="tabla">
    <thead>
        <th>Nombre</th>
        <th>Direccion</th>
        <th>Telefonos</th>
        <th>Acciones</th>
    </thead>
    <tbody>
    @foreach($hotels as $hotel)
        <tr>
            <td>{!! $hotel->nombre !!}</td>
            <td>{!! $hotel->direccion !!}</td>
            <td>{!! $hotel->telefonos !!}</td>
            <td>
                {!! Form::open(['route' => ['hotels.destroy', $hotel->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('hotels.show', [$hotel->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('hotels.edit', [$hotel->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                    <a href="{!! url('pisosHotel',[$hotel->id]) !!}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-th"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <th>Nombre</th>
        <th>Direccion</th>
        <th>Telefonos</th>
        <th>Action</th>
    </tfoot>
</table>
@push('scriptsextras')
@include('layouts.partials.jsdatatable')
@endpush