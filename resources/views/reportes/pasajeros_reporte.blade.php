@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
@section('content')
    <h1 class="pull-left">Reporte de Pasajeros</h1>
    <a class="btn bg-navy btn-flat margin pull-right" onclick="printDiv('printableArea')" style="margin-top: 25px"
       href="javascript:"> <i class="fa fa-print"></i> IMPRIMIR REPORTE</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'pasajeros_reporte','id' => 'form-rep-pa']) !!}
                <div class="box-body">
                    <div class="form-group col-sm-2">
                        {!! Form::label('fecha_ini', 'Fecha Inicial:') !!}
                        {!! Form::text('fecha_ini', $fecha_ini, ['class' => 'form-control calendario','placeholder' => '','required','id' => 'cfechaingreso']) !!}
                    </div>
                    <div class="form-group col-sm-2">
                        {!! Form::label('fecha_fin', 'Fecha Final:') !!}
                        {!! Form::text('fecha_fin', $fecha_fin, ['class' => 'form-control calendario','placeholder' => '','required','id' => 'cfechaingreso']) !!}
                    </div>
                    @if(Auth::user()->rol == 'Super Administrador')
                        <div class="form-group col-sm-4">
                            {!! Form::label('hotel', 'Seleccione el Hotel:') !!}
                            {!! Form::select('hotel_id', $hoteles,null, ['class' => 'form-control','placeholder' => 'Seleccione el Hotel','required']) !!}
                        </div>
                    @else
                        {!! Form::hidden('hotel_id',Auth::user()->hotel_id) !!}
                    @endif
                    <div class="form-group col-sm-2">
                        <label>&nbsp;</label>
                        {!! Form::submit('Generar', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                    <div class="form-group col-sm-2">
                        <label>&nbsp;</label>
                        <a href="javascript:" class="btn btn-warning form-control" onclick="$('#hi-tipo').val('pdf');$('#form-rep-pa').submit();">PDF</a>
                    </div>
                </div>

                {!! Form::hidden('tipo_r','html',['id' => 'hi-tipo']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @if(!empty($datos_f))
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" id="printableArea">
                    <table class="table table-bordered">
                        <tr>
                            <td class="text-bold">Hotel: </td>
                            <td>{!! $hotel->nombre !!}</td>
                            <td class="text-bold">Direccion: </td>
                            <td>{!! $hotel->direccion !!}</td>
                        </tr>
                        <tr>
                            <td class="text-bold">Telefonos: </td>
                            <td>{!! $hotel->telefonos !!}</td>
                            <td class="text-bold">Parte del dia: </td>
                            <td>{!! $datos_f['dia_ini'] !!} <b>al</b> {!! $datos_f['dia_fin'] !!} <b>de</b> {!! $datos_f['mes'] !!} <b>de 20</b>{!! $datos_f['ano'] !!}</td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td>
                                REPORTE DE PASAJEROS
                            </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <thead style="font-size: 14px;">
                        <tr>
                            <th>D</th>
                            <th>M</th>
                            <th>A</th>
                            <th>NOMBRE Y APELLIDO</th>
                            <th>Nr de Piezas</th>
                            <th>Nacionalidad</th>
                            <th>Procedencia</th>
                            <th>Profesion</th>
                            <th>Edad</th>
                            <th>Carnet de Identidad Nr Pasaporte</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center text-bold">PERMANENTES</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($permanentes as $per)
                            <tr>
                                <td>{!! $per->dia_ingreso !!}</td>
                                <td>{!! $per->mes_ingreso !!}</td>
                                <td>{!! $per->ano_ingreso !!}</td>
                                <td class="text-left">{!! $per->cliente->nombre !!}</td>
                                <td>{!! $per->registro->habitacione->nombre !!}</td>
                                <td>{!! $per->cliente->nacionalidad !!}</td>
                                <td>{!! $per->cliente->procedencia !!}</td>
                                <td>{!! $per->cliente->profesion !!}</td>
                                <td>{!! $per->cliente->edad2 !!}</td>
                                <td>{!! $per->cliente->identidad !!}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center text-bold">SALIDAS</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($salidas as $per)
                            <tr>
                                <td>{!! $per->dia_ingreso !!}</td>
                                <td>{!! $per->mes_ingreso !!}</td>
                                <td>{!! $per->ano_ingreso !!}</td>
                                <td class="text-left">{!! $per->cliente->nombre !!}</td>
                                <td>{!! $per->registro->habitacione->nombre !!}</td>
                                <td>{!! $per->cliente->nacionalidad !!}</td>
                                <td>{!! $per->cliente->procedencia !!}</td>
                                <td>{!! $per->cliente->profesion !!}</td>
                                <td>{!! $per->cliente->edad2 !!}</td>
                                <td>{!! $per->cliente->identidad !!}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-center text-bold">INGRESOS</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @foreach($ingresos as $per)
                            <tr>
                                <td>{!! $per->dia_ingreso !!}</td>
                                <td>{!! $per->mes_ingreso !!}</td>
                                <td>{!! $per->ano_ingreso !!}</td>
                                <td class="text-left">{!! $per->cliente->nombre !!}</td>
                                <td>{!! $per->registro->habitacione->nombre !!}</td>
                                <td>{!! $per->cliente->nacionalidad !!}</td>
                                <td>{!! $per->cliente->procedencia !!}</td>
                                <td>{!! $per->cliente->profesion !!}</td>
                                <td>{!! $per->cliente->edad2 !!}</td>
                                <td>{!! $per->cliente->identidad !!}</td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@push('scriptsextras')
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script>
    $('.calendario').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endpush