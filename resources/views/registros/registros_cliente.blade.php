@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Registros de {!! $cliente->nombre !!}</h1>
    <div class="clearfix"></div>
    @include('flash::message')
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">HISTORIAL DE CLIENTE
                    </h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Salida</th>
                            <th>Grupo</th>
                            <th>Habitacion</th>
                            <th>Estado</th>
                            <th>Deudas</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($hosp_registros as $hospe)
                            <tr>
                                <td>{!! $hospe->fecha_ingreso !!}</td>
                                <td>{!! $hospe->fecha_salida !!}</td>
                                <td>{!! $hospe->registro->grupo->nombre !!}</td>
                                <td>{!! $hospe->registro->habitacione->nombre !!}</td>
                                <td>{!! $hospe->estado !!}</td>
                                <td>{!! $hospe->registro->grupo->deudas.' Bs.' !!}</td>
                                <td>
                                    <a href="{!! route('registrosgrupos', [$hospe->registro->grupo->id]) !!}"
                                       title="Registros"
                                       class='btn btn-primary btn-xs'><i class="fa fa-list"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">ACTIVIDADES DEL CLIENTE
                    </h3>
                    <div class="box-tools pull-right">
                        <a href="javascript:" class="btn btn-success btn-box-tool" style="color: white;"
                           onclick="cargarmodal('{!!route('actividad',[$cliente->id])!!}','info')"> <i
                                    class="fa fa-plus"></i><b>
                                Actividad</b></a>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Descripcion</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cliente->actividades as $actividad)
                            <tr
                                    @if($actividad->fecha > date('Y-m-d H:s:i'))
                                    class="info"
                                    @endif
                            >
                                <td>{!! $actividad->fecha !!}</td>
                                <td>{!! $actividad->descripcion !!}</td>
                                <td>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection


