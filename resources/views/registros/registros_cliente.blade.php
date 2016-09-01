@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Registros de {!! $cliente->nombre !!}</h1>
    <div class="clearfix"></div>
    @include('flash::message')
    <div class="clearfix"></div>

    @if(isset($registros[0]))
        {!! Form::open(['route' => ['registrar_pago'], 'method' => 'post']) !!}
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">REGISTROS PENDIENTES</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nro</th>
                        <th>Habitacion</th>
                        <th>Fecha Ingreso</th>
                        <th>Fecha Salida</th>
                        <th>Estado</th>
                        <th>Precio</th>
                        <th>Monto Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total_monto = 0;
                    ?>
                    @foreach($registros as $key => $registro)
                        <?php $total_monto = $total_monto + $registro->monto_total ?>
                        <tr>
                            <td>{!! $key+1 !!}</td>
                            <td>{!! $registro->habitacione->nombre.' - '.$registro->habitacione->rpiso->nombre !!}</td>
                            <td>{!! $registro->fecha_ingreso !!}</td>
                            <td>{!! $registro->fecha_salida !!}</td>
                            <td>{!! $registro->estado !!}</td>
                            <td>{!! $registro->precio !!}</td>
                            <td>{!! $registro->monto_total !!}</td>
                            <td>
                                <a class="btn btn-block btn-primary btn-xs" href="javascript:" title="Editar"
                                   onclick="cargarmodal('{!! route('nuevos',[$registro->cliente_id,$registro->num_reg]) !!}')">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            {!! Form::select('caja_id', $cajas,null, ['class' => 'form-control caja','required','id' =>
                        'ccaja']) !!}
                        </td>
                        <td>

                            {!! Form::button('<i class="fa fa-money"></i> PAGAR TOTAL', ['type' => 'submit', 'class' => 'btn btn-success btn-xs', 'onclick' => "return confirm('Se registrara el pago de todos los pendientes. Desea continuar??')"]) !!}

                        </td>
                        <td class="text-warning"><b>TOTAL</b></td>
                        <td class="text-warning"><b>{!! $total_monto !!}</b></td>
                        <td>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {!! Form::hidden('monto_total', $total_monto) !!}
        {!! Form::hidden('cliente_id', $cliente->id) !!}
        {!! Form::hidden('user_id',Auth::user()->id) !!}
        {!! Form::close() !!}
    @else
        <h3 class="text-success">NO TIENE REGISTROS PENDIENTES.</h3>
    @endif

    <div class="box box-success">
        <div class="box-header">
            <h3 class="box-title">HISTORIAL DE REGISTROS</h3>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th>Nro</th>
                    <th>Habitacion</th>
                    <th>Fecha Ingreso</th>
                    <th>Fecha Salida</th>
                    <th>Estado</th>
                    <th>Precio</th>
                    <th>Monto Total</th>
                </tr>
                </thead>
                <tbody>
                @foreach($hregistros as $key => $registro)
                    <tr>
                        <td>{!! $key+1 !!}</td>
                        <td>{!! $registro->habitacione->nombre.' - '.$registro->habitacione->rpiso->nombre !!}</td>
                        <td>{!! $registro->fecha_ingreso !!}</td>
                        <td>{!! $registro->fecha_salida !!}</td>
                        <td>{!! $registro->estado !!}</td>
                        <td>{!! $registro->precio !!}</td>
                        <td>{!! $registro->monto_total !!}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection


