@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => ['nuevos',$cliente->id], 'method' => 'post','id' => 'ajaxform']) !!}
    <h1 class="pull-left">Registro de {!! $tipo.' '.$cliente->nombre !!}</h1>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box">
        <div class="box-body table-responsive">
            <table class="table table-responsive table-bordered" id="tabla">
                <thead>
                <tr>
                    <th>Piso</th>
                    <th>Nombre</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th>Piso</th>
                    <th>Nombre</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>
                        Estado
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>


                @foreach($habitaciones as $key => $habitacion)
                    <?php
                    $idHabitacion = $habitacion->id;
                    $regis_checkbox = Form::checkbox("habitaciones[$idHabitacion][marca]", null, null, ['class' => 'ch-marca-h']);

                    ?>
                    <tr>
                        <td>{!! $habitacion->rpiso->nombre !!}</td>
                        <td>{!! $habitacion->nombre !!}</td>
                        <td>
                            @foreach($habitacion->rprecios as $precio)
                                {!! $precio->precio !!} Bs<br>
                            @endforeach
                        </td>
                        <td>
                            @if(isset($habitacion->categoria->nombre))
                                {!! $habitacion->categoria->nombre !!}
                            @endif
                        </td>
                        <td>
                            @foreach($habitacion->registrosactivos as $registro)
                                <?php
                                $color_reg = 'info';
                                if ($registro->estado == 'Ocupando') {
                                    $color_reg = 'danger';
                                } elseif ($registro->estado == 'Reservado') {
                                    $color_reg = 'warning';
                                }
                                ?>
                                @if(!empty($registro->grupo_id))
                                    <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:" >
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
                            <a title="Registrar habitacion" href="{!! route('nuevoregistro',[$tipo,$cliente->id,$habitacion->id]) !!}"  class='btn btn-primary btn-xs'><i
                                        class="fa fa-pencil"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {!! Form::close() !!}

@endsection
@push('scriptsextras')
@include('layouts.partials.jsdatatable')
<script>

</script>
@endpush
