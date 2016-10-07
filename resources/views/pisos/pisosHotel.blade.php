@extends('layouts.app')

@section('content')
    <style>
        tfoot input {
            width: 100%;
            padding: 1px;
            box-sizing: border-box;
        }
    </style>
    @include('flash::message')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Hotel: {!! $hotel->nombre  !!}</h3>
            <?php
            $role = Auth::user()->rol;
            ?>
            @if($role != 'Operario')
                <div class="box-tools pull-right">
                    <a href="{!! url('nuevaHabitacion', $hotel->id) !!}" class="btn btn-success btn-box-tool"
                       style="color: white;"><b>NUEVA HABITACION</b></a>

                </div>
            @endif
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Piso</th>
                    <th>Habitacion</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>

                </thead>
                <thead>
                <tr>
                    <th>Piso</th>
                    <th>Habitacion</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($habitaciones as $h)
                    <tr
                            @if($h->estado == 'Deshabilitado')
                            style="background-color: lightgrey;"
                            @endif
                    >
                        <td>{!! $h->rpiso->nombre !!}</td>
                        <td>{!! $h->nombre !!}</td>
                        <td>
                            @foreach($h->rprecios as $precio)
                                {!! $precio->precio !!} Bs<br>
                            @endforeach
                        </td>
                        <td>
                            @if(isset($h->categoria->nombre))
                                {!! $h->categoria->nombre !!}
                            @endif
                        </td>
                        <td>
                            @foreach($h->registrosactivos as $registro)
                                <?php
                                $color_reg = 'info';
                                if ($registro->estado == 'Ocupando') {
                                    $color_reg = 'danger';
                                } elseif ($registro->estado == 'Reservado') {
                                    $color_reg = 'warning';
                                }
                                ?>
                                @if(!empty($registro->num_reg))
                                    <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:">
                                        {{ $registro->estado.' '.$registro->grupo->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                                    </a>
                                @else
                                    <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:">
                                        {{ $registro->estado.' '.$registro->grupo->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                                    </a>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <?php
                            $role = Auth::user()->rol;
                            ?>
                            @if($role != 'Operario')
                                {!! Form::open(['route' => ['habitaciones.destroy', $h->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    {{--<a href="{!! route('hotels.show', [$h->id]) !!}" class='btn btn-default btn-xs'><i--}}
                                    {{--class="glyphicon glyphicon-eye-open"></i></a>--}}
                                    <a href="{!! url('ingresaPrecio', [$h->id]) !!}" class='btn btn-success btn-xs'><i
                                                class="fa fa-fw fa-dollar"></i></a>
                                    <a href="{!! route('habitaciones.edit', [$h->id]) !!}"
                                       class='btn btn-warning btn-xs'><i
                                                class="glyphicon glyphicon-edit"></i></a>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar la habitacion?')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            @endif
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