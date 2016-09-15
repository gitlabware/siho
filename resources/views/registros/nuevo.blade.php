@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" media="screen"
          href="{{ asset('/plugins/datepicker/bootstrap-datetimepicker.min.css') }}">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Registro de
                Habitacion {!! $habitacion->nombre.' - ',$habitacion->rpiso->nombre !!}</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                {!! Form::open(['route' => 'habitaciones.store']) !!}
                <div class="box-body">
                    <div class="form-group col-sm-6">
                        {!! Form::radio('estado','Ocupando',null,['class' => 'ch-ocupar']) !!}
                        Ocupar habitacion
                    </div>
                    <div class="form-group col-sm-6">
                        {!! Form::radio('estado','Reservado',null,['class' => 'ch-reservar']) !!}
                        Reservar habitacion
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Fecha inicial Reserva</label>
                        {!! Form::text('nombre', null, ['class' => 'form-control fechas']) !!}
                    </div>

                    <!-- Nacionalidad Field -->
                    <div class="form-group col-sm-6">
                        <label>Fecha Final Reserva</label>
                        {!! Form::text('nacionalidad', null, ['class' => 'form-control fechas']) !!}
                    </div>
                    <div id="seleccion-grupo">
                        <div class="form-group col-sm-10">
                            <label>Nombre del Grupo</label>
                            {!! Form::text('nuevogrupo', null, ['class' => 'form-control','placeholder' => 'Ingrese el nombre del nuevo grupo']) !!}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>&nbsp;</label>
                            <a href="javascript:" onclick="$('#nuevo-grupo').toggle(400);$('#seleccion-grupo').toggle(400);" class="btn btn-block btn-info" title="Seleccionar un grupo"><i class="fa fa-exchange"></i></a>
                        </div>
                    </div>
                    <div id="nuevo-grupo" style="display: none;">
                        <div class="form-group col-sm-10">
                            <label>Seleccione el Grupo</label>
                            {!! Form::select('grupo_id', [],null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group col-sm-2">
                            <label>&nbsp;</label>
                            <a href="javascript:" onclick="$('#nuevo-grupo').toggle(400);$('#seleccion-grupo').toggle(400);" class="btn btn-block btn-success" title="Nuevo Grupo"><i class="fa fa-exchange"></i></a>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Equipaje</label>
                        {!! Form::select('quepaje', [],null, ['class' => 'form-control','required']) !!}
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Seleccione el precio</label>
                        {!! Form::select('precio', $precios,null, ['class' => 'form-control','required']) !!}
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Seleccion de Huesped</h3>

                    <div class="box-tools pull-right">
                        <a href="javascript:" class="btn btn-primary btn-box-tool" style="color: yellow;"
                           onclick="cargarmodal('{!!route('cliente')!!}','primary','lg')"><b>NUEVO
                                CLIENTE</b></a>
                    </div>
                </div>
                <div class="box-body">
                    @include('clientes.tabla')
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scriptsextras')
<script src="{{ asset('/plugins/datepicker/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/datepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $('.fechas').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });

    /*var miobjeto = [];
    miobjeto['id'] = 5;
    miobjeto['nombre'] = 'dsadsad';
    function pruebaa(objeto){
        console.log(objeto);
    }
    pruebaa(miobjeto);*/

    /*function addhuesped(objeto){
        console.log(objeto);
    }*/
</script>
@endpush