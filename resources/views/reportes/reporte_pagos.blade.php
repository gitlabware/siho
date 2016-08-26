@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
@section('content')
    <h1 class="pull-left">Reporte de Ingresos por Hotel</h1>
    <a class="btn bg-navy btn-flat margin pull-right"  onclick="printDiv('printableArea')" style="margin-top: 25px" href="javascript:"> <i class="fa fa-print"></i> IMPRIMIR REPORTE</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'reporte_pagos']) !!}
                <div class="box-body">
                    <div class="form-group col-sm-3">
                        {!! Form::label('fecha_ini', 'Fecha Inicial:') !!}
                        {!! Form::text('fecha_ini', $fecha_ini, ['class' => 'form-control calendario','placeholder' => '','required','id' => 'cfechaingreso']) !!}
                    </div>
                    <div class="form-group col-sm-3">
                        {!! Form::label('fecha_fin', 'Fecha Final:') !!}
                        {!! Form::text('fecha_fin', $fecha_fin, ['class' => 'form-control calendario','placeholder' => '','required','id' => 'cfechaingreso']) !!}
                    </div>
                    <div class="form-group col-sm-3">
                        {!! Form::label('hotel', 'Seleccione el Hotel:') !!}
                        {!! Form::select('hotel_id', $hoteles,null, ['class' => 'form-control','placeholder' => 'Seleccione el Hotel']) !!}
                    </div>
                    <div class="form-group col-sm-3">
                        <label>&nbsp;</label>
                        {!! Form::submit('Generar', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" id="printableArea">
                    <table class="table">
                        <tr>
                            <td>
                                REPORTE DE INGRESOS DE HOTEL:
                                <b>
                                    @if(!empty($hotel_id))
                                        {!! $hoteles[$hotel_id] !!}
                                    @else
                                        TODOS
                                    @endif
                                </b>
                            </td>
                            <td><b>Fechas:</b> {!! "$fecha_ini a $fecha_fin" !!}</td>

                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Fecha/Hora</th>
                            <th>Hotel</th>
                            <th>Caja</th>
                            <th>Detalle</th>
                            <th>Monto</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_ingresos = 0;
                        ?>
                        @foreach($datos as $flujo)
                            <?php $total_ingresos = $total_ingresos + $flujo->ingreso;?>
                            <tr>
                                <td>{!! $flujo->created_at !!}</td>
                                <td>{!! $flujo->caja->hotel->nombre !!}</td>
                                <td>{!! $flujo->caja->nombre !!}</td>
                                <td>{!! $flujo->detalle !!}</td>
                                <td>{!! $flujo->ingreso !!}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>TOTAL:</b></td>
                            <td><b>{!! $total_ingresos !!}</b></td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

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