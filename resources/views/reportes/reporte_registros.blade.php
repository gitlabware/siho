@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
@section('content')
    <h1 class="pull-left">Reporte de Registros por Hotel</h1>
    <a class="btn bg-navy btn-flat margin pull-right" onclick="printDiv('printableArea')" style="margin-top: 25px"
       href="javascript:"> <i class="fa fa-print"></i> IMPRIMIR REPORTE</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'reporte_registros']) !!}
                <div class="box-body">
                    <div class="form-group col-sm-2">
                        {!! Form::label('fecha_ini', 'Fecha Inicial:') !!}
                        {!! Form::text('fecha_ini', $fecha_ini, ['class' => 'form-control calendario','placeholder' => '','required','id' => 'cfechaingreso']) !!}
                    </div>
                    <div class="form-group col-sm-2">
                        {!! Form::label('fecha_fin', 'Fecha Final:') !!}
                        {!! Form::text('fecha_fin', $fecha_fin, ['class' => 'form-control calendario','placeholder' => '','required','id' => 'cfechaingreso']) !!}
                    </div>
                    <div class="form-group col-sm-2">
                        {!! Form::label('tipo_fecha', 'Tipo de Fecha:') !!}
                        {!! Form::select('tipo_fecha', ['Fecha de creacion' => 'Fecha de creacion','Fecha de ingreso' => 'Fecha de ingreso','Fecha de reserv-ingreso' => 'Fecha de reserv-ingreso'],$tipo_fecha_f, ['class' => 'form-control']) !!}
                    </div>
                    @if(Auth::user()->rol == 'Super Administrador')
                        <div class="form-group col-sm-2">
                            {!! Form::label('hotel', 'Seleccione el Hotel:') !!}
                            {!! Form::select('hotel_id', $hoteles,$hotel_id, ['class' => 'form-control','placeholder' => 'Todos']) !!}
                        </div>
                    @else
                        {!! Form::hidden('hotel_id',Auth::user()->hotel_id) !!}
                    @endif
                    <div class="form-group col-sm-2">
                        {!! Form::label('estado', 'Seleccione el Estado:') !!}
                        {!! Form::select('estado', ['Ocupando' => 'Ocupando','Reservado' => 'Reservado','Salida' => 'Salida','Eliminado' => 'Eliminado'],$estado, ['class' => 'form-control','placeholder' => 'Todos']) !!}
                    </div>
                    <div class="form-group col-sm-2">
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
                                REPORTE DE <b>REGISTROS</b> DE HOTEL:
                                <b>
                                    @if(!empty($hotel_id))
                                        {!! $hoteles[$hotel_id] !!}
                                    @else
                                        TODOS
                                    @endif
                                </b>
                                &nbsp;&nbsp;
                                DE ESTADO:
                                <b>
                                    @if(!empty($estado))
                                        {!! $estado !!}
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
                            <th>Creado</th>
                            <th>Ingreso-Salida</th>
                            <th>Reserva Ing-Sal</th>
                            @if(empty($hotel_id))
                                <th>Hotel</th>
                            @endif
                            @if(empty($estado))
                            <th>Estado</th>
                            @endif
                            <th>Habitacion</th>
                            <th>Grupo</th>
                            <th>Usuario</th>
                            <th>Deuda</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_pago = 0;
                        ?>
                        @foreach($registros as $registro)
                            <?php $total_pago = $total_pago + $registro->deudas;?>
                            <tr>
                                <td>{!! $registro->created_at !!}</td>
                                <td>{!! $registro->fecha_ingreso2." - ".$registro->fecha_salida !!}</td>
                                <td>{!! $registro->fech_ini_reserva2." - ".$registro->fech_fin_reserva2 !!}</td>
                                @if(empty($hotel_id))
                                    <td>{!! $registro->habitacione->rpiso->hotel->nombre !!}</td>
                                @endif
                                @if(empty($estado))
                                <td>{!! $registro->estado !!}</td>
                                @endif
                                <td>{!! $registro->habitacione->nombre !!}</td>
                                <td>{!! $registro->grupo->nombre !!}</td>
                                <td>{!! $registro->user->name !!}</td>
                                <td>{!! $registro->deudas !!}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            @if(empty($hotel_id))
                                <td></td>
                            @endif
                            @if(empty($estado))
                                <td></td>
                            @endif
                            <td></td>
                            <td></td>
                            <td><b>TOTAL:</b></td>
                            <td><b>{!! $total_pago !!}</b></td>
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
