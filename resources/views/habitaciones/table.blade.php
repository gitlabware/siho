<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Listado de habitaciones</h3>
                <div class="box-tools pull-right no-imprimir">
                    <button class="btn btn-box-tool btn-success" title="Editar" onclick="window.location.href = '{!! route('habitaciones.create') !!}';" style="color: #ffffff;"><i class="fa fa-plus"></i> <b>Nueva habitacion</b></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-responsive table-bordered" id="tabla">
                    <thead>
                    <th>Piso</th>
                    <th>Nombre</th>
                    <th>Cliente</th>
                    <th>Fechas</th>
                    <th>Observaciones</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($habitaciones as $habitaciones)
                        <tr>
                            <td>{!! $habitaciones->piso_id !!}</td>
                            <td>{!! $habitaciones->nombre !!}</td>
                            <td>{{ isset($habitaciones->registro->cliente->nombre) ? $habitaciones->registro->cliente->nombre : '' }}</td>
                            <td>{{ isset($habitaciones->registro) ? $habitaciones->registro->fecha_ingreso.' - '.$habitaciones->registro->fecha_salida  : '' }}</td>
                            <td>{{ isset($habitaciones->registro) ? $habitaciones->registro->observacion : '' }}</td>
                            <td>
                                {!! Form::open(['route' => ['habitaciones.destroy', $habitaciones->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{!! route('habitaciones.show', [$habitaciones->id]) !!}"
                                       class='btn btn-default btn-xs'><i
                                                class="glyphicon glyphicon-eye-open"></i></a>
                                    <a href="{!! route('habitaciones.edit', [$habitaciones->id]) !!}"
                                       class='btn btn-default btn-xs'><i
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
    </div>
</div>


@push('scriptsextras')
@include('layouts.partials.jsdatatable')
@endpush