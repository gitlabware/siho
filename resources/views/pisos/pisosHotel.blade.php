@extends('layouts.app')

@section('content')
    <style>

    </style>
    @include('flash::message')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Hotel: {!! $hotel->nombre  !!}</h3>
            <table class="table table-bordered text-center">
                <tr>
                    <td><a href="#" type="button" class="btn btn-block btn-primary btn-sm">Nuevo Piso</a></td>
                    <td><a href="{!! url('nuevaHabitacion', $hotel->id) !!}" type="button"
                           class="btn btn-block btn-success btn-sm">Nueva Habitacion</a></td>
                </tr>
            </table>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Piso</th>
                    <th>Habitacion</th>
                    <th>Estado</th>
                    <th>Cliente</th>
                    <th>Fechas</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($habitaciones as $h)

                    <?php
                    $color_reg = null;
                    $color_reg2 = null;
                    if (isset($h->registro_id)) {
                        $color_reg = 'background-color: darkseagreen;';
                        $color_reg2 = ",'warning'";
                    }
                    ?>
                    <tr style="{{ $color_reg }}">
                        <td>{!! $h->rpiso->nombre !!}</td>
                        <td>{!! $h->nombre !!}</td>
                        <td>Activo</td>
                        <td>{{ isset($h->registro->cliente->nombre) ? $h->registro->cliente->nombre : '' }}</td>
                        <td>{{ isset($h->registro) ? $h->registro->fecha_ingreso.' - '.$h->registro->fecha_salida  : '' }}</td>
                        <td>{{ isset($h->registro) ? $h->registro->observacion : '' }}</td>
                        <td>
                            {!! Form::open(['route' => ['hotels.destroy', $h->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                {{--<a href="{!! route('hotels.show', [$h->id]) !!}" class='btn btn-default btn-xs'><i--}}
                                {{--class="glyphicon glyphicon-eye-open"></i></a>--}}
                                <a href="{!! route('habitaciones.edit', [$h->id]) !!}" class='btn btn-warning btn-xs'><i
                                            class="glyphicon glyphicon-edit"></i></a>
                                <a href="{!! url('ingresaPrecio', [$h->id]) !!}" class='btn btn-success btn-xs'><i
                                            class="fa fa-fw fa-dollar"></i></a>
                                @if (isset($h->registro_id))
                                <a href="javascript:" onclick="cargarmodal('{!! route('nuevoregistro',[$h->registro->cliente_id,$h->id,$h->registro_id]) !!}','warning')"  class='btn btn-primary btn-xs' title="Registro"><i
                                            class="glyphicon glyphicon-edit"></i></a>
                                @endif
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
@push('scriptsextras')
@include('layouts.partials.jsdatatable')
@endpush