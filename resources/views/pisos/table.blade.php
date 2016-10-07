<div class="box">
    <div class="box-header">
        <h3 class="box-title">Listado de Usuarios</h3>
        <div class="box-tools pull-right no-imprimir">
            <button class="btn btn-box-tool btn-success" title="Nuevo Usuario"
                    onclick="cargarmodal('{!! route('piso',[$hotel->id]) !!}')" style="color: #ffffff;"><i
                        class="fa fa-plus"></i> <b>NUEVO PISO</b></button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table table-bordered" id="example1">
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
                            <a href="{!! route('pisos.show', [$pisos->id]) !!}" class='btn btn-default btn-xs'><i
                                        class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('pisos.edit', [$pisos->id]) !!}" class='btn btn-default btn-xs'><i
                                        class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

