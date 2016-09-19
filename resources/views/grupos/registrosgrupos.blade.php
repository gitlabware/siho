@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Grupo: {!! $grupo->nombre !!}</h1>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="row">
        <div class="col-md-8">
            @foreach($registros as $registro)
                <?php
                $color = 'default';
                $color2 = 'primary';
                if ($registro->estado == 'Reservado') {
                    $color = 'yellow';
                    $color2 = 'warning';
                }

                ?>
                <div class="box box-{!! $color2 !!}">
                    <div class="box-header">
                        <h3 class="box-title">{!! $registro->habitacione->nombre.' - '.$registro->habitacione->rpiso->nombre !!}
                            <span class="badge bg-{!! $color !!}">{!! $registro->estado !!}</span>
                        </h3>
                        <div class="box-tools pull-right">
                            <a href="{!!route('nuevoregistro',['Grupo',$grupo->id,$registro->habitacione->id,$registro->id])!!}"
                               class="btn btn-default btn-box-tool"><b>
                                    EDITAR</b></a>
                            <a href="javascript:" class="btn btn-primary btn-box-tool" style="color: white;"
                               onclick="cargarmodal('{!!url('caja/egreso',[0])!!}}','primary')"><b>
                                    MARCAR SALIDA</b></a>
                            <a href="javascript:" class="btn btn-danger btn-box-tool" style="color: white;"
                               onclick="cargarmodal('{!!url('caja/egreso',[0])!!}}','primary')"><b>
                                    CANCELAR</b></a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <td class="text-{!! $color2 !!} text-bold">Fecha Ingreso</td>
                                <td>{!! $registro->fecha_ingreso !!}</td>
                                <td class="text-{!! $color2 !!} text-bold">Fecha Salida</td>
                                <td>{!! $registro->fecha_salida !!}</td>
                            </tr>
                            <tr>
                                <td class="text-{!! $color2 !!} text-bold">Fecha inicial Reserva</td>
                                <td>{!! $registro->fech_ini_reserva2 !!}</td>
                                <td class="text-{!! $color2 !!} text-bold">Fecha final Reserva</td>
                                <td>{!! $registro->fech_fin_reserva2 !!}</td>
                            </tr>
                            <tr>
                                <td class="text-{!! $color2 !!} text-bold">Equipaje</td>
                                <td>{!! $registro->equipaje !!}</td>
                                <td class="text-{!! $color2 !!} text-bold">Precio</td>
                                <td>{!! $registro->precio.' Bs.' !!}</td>
                            </tr>
                        </table>
                        <h4 class="text-center">Listado de Huespedes</h4>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Pasaporte</th>
                                <th>C.I.</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($registro->hospedantes as $hospedante)
                                <tr>
                                    <td>{!! $hospedante->cliente->nombre !!}</td>
                                    <td>{!! $hospedante->cliente->pasaporte !!}</td>
                                    <td>{!! $hospedante->cliente->ci !!}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Pagos Pendientes</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['route' => ['registrapagosg']]) !!}
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>
                                {!! Form::checkbox('todos', 'value',null,['id' => 'c-todos-p'])!!}
                            </th>
                            <th>Habitacion</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pagos as $pago)
                            <tr>
                                <td>
                                    {!! Form::checkbox("pagos[".$pago->id."][marcado]", 'value',null,['class' => 'c-pagos'])!!}
                                </td>
                                <td>{!! $pago->registro->habitacione->nombre !!}</td>
                                <td>{!! $pago->fecha !!}</td>
                                <td>{!! $pago->monto_total !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table><br>
                    <div class="form-group col-sm-12">
                        {!! Form::button('<i class="fa fa-save"></i> Registrar', ['type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => "return confirm('Esta seguro de que realizar el pago?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection
