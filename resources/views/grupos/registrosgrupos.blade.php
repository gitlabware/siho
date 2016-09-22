@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Grupo: {!! $grupo->nombre !!}</h1>


    <a class="btn btn-primary pull-right" style="margin-top: 25px"
       href="{!! route('asignahabitacion2', ['Grupo',$grupo->id]) !!}"><i class="fa fa-plus"></i> Registro</a>
    <a class="btn btn-success pull-right" style="margin-top: 25px"
       onclick="cargarmodal('{!! route('grupo',[$grupo->id]) !!}');"><i class="fa fa-edit"></i> Editar</a>
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
                } elseif ($registro->estado == 'Salida') {
                    $color = 'green';
                    $color2 = 'success';
                }

                ?>
                <div class="box box-{!! $color2 !!}">
                    <div class="box-header">
                        <h3 class="box-title">{!! $registro->habitacione->nombre.' - '.$registro->habitacione->rpiso->nombre !!}
                            <span class="badge bg-{!! $color !!}">{!! $registro->estado !!}</span>
                        </h3>
                        <div class="box-tools pull-right">
                            @if($registro->estado != 'Salida')
                                <a href="javascript:" style="color: white;"
                                   onclick="cargarmodal('{!! route('addpagoextra',[$registro->id]) !!}')"
                                   class="btn btn-success btn-box-tool"> <i class="fa fa-plus"></i><b>
                                        Pago </b></a>
                                <a href="{!!route('nuevoregistro',['Grupo',$grupo->id,$registro->habitacione->id,$registro->id])!!}"
                                   class="btn btn-default btn-box-tool"><b>
                                        EDITAR</b></a>

                                <a href="javascript:"
                                   onclick="if(confirm('Esta seguro que desea marcar la salida de este registro??')){window.location.href = '{!! route('marcasalida',[$registro->id]) !!}';}"
                                   class="btn btn-primary btn-box-tool" style="color: white;"><b>
                                        MARCAR SALIDA</b></a>

                                <a href="javascript:" class="btn btn-danger btn-box-tool" style="color: white;"
                                   onclick="if(confirm('Esta seguro de cancelar el registro??')){window.location.href = '{!! route('cancelaregistro',[$registro->id]) !!}';}"><b>
                                        CANCELAR</b></a>
                            @endif
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <tr>
                                <td class="text-{!! $color2 !!} text-bold">Fecha Ingreso</td>
                                <td>{!! $registro->fecha_ingreso2 !!}</td>
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
                    <div class="box-tools pull-right">
                        <a href="{!!route('generadeudasgrupos',[$grupo->id])!!}" title="Actualizar pagos pendientes"
                           class="btn btn-default btn-box-tool"><b>
                                <i class="fa fa-refresh"></i></b></a>
                    </div>
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
                        <?php
                        $total_p_p = 0.00;
                        ?>
                        @foreach($pagos_pendientes as $pago)
                            <?php $total_p_p = $total_p_p + $pago->monto_total;?>
                            @if($pago->estado == 'Deuda Extra')
                                <tr class="info">
                            @else
                                <tr>
                                    @endif

                                    <td>
                                        {!! Form::checkbox("pagos[".$pago->id."][marcado]", 'value',null,['class' => 'c-todos-pt'])!!}
                                    </td>
                                    <td>{!! $pago->registro->habitacione->nombre !!}</td>
                                    <td>{!! $pago->fecha !!}</td>
                                    <td>{!! $pago->monto_total !!}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><b>TOTAL</b></td>
                                    <td><b>{!! $total_p_p.' Bs.' !!}</b></td>
                                </tr>
                        </tbody>
                    </table>
                    @push('scriptsextras')
                    <script>
                        $('#c-todos-p').click(function () {
                            $('.c-todos-pt').prop('checked', $('#c-todos-p').prop('checked'));
                        });
                    </script>
                    @endpush
                    <br>

                    <div class="form-group col-sm-12">
                        {!! Form::select('caja_id', $cajas,null, ['class' => 'form-control','required']) !!}
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::button('<i class="fa fa-save"></i> Registrar', ['type' => 'submit', 'class' => 'btn btn-primary', 'onclick' => "return confirm('Esta seguro de que realizar el pago?')"]) !!}
                    </div>
                    {!! Form::hidden('grupo_id',$grupo->id) !!}
                    {!! Form::hidden('user_id',Auth::user()->id) !!}
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Pagos Recibidos</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Modificado</th>
                            <th>Habitacion</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total_p_r = 0.00;
                        ?>
                        @foreach($pagos_recibidos as $pago)
                            <?php $total_p_r = $total_p_r + $pago->monto_total;?>
                            @if($pago->estado == 'Deuda Extra')
                                <tr class="info">
                            @else
                                <tr>
                                    @endif
                                    <td>{!! $pago->modificado !!}</td>
                                    <td>{!! $pago->registro->habitacione->nombre !!}</td>
                                    <td>{!! $pago->fecha2 !!}</td>
                                    <td>{!! $pago->monto_total !!}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><b>TOTAL</b></td>
                                    <td><b>{!! $total_p_r.' Bs.' !!}</b></td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection



