@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" media="screen"
          href="{{ asset('/plugins/datepicker/bootstrap-datetimepicker.min.css') }}">
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Registro de
                Habitacion {!! $habitacion->nombre.' - ',$habitacion->rpiso->nombre !!}</h1>
            @if(isset($registro->grupo_id))
                <a class="btn btn-primary pull-right" style="margin-top: 25px"
                   href="{!! route('registrosgrupos',[$registro->grupo_id]) !!}">Ir a Grupo</a>
            @endif
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        <div class="col-md-7">
            <div class="box box-primary">
                @if(isset($registro))
                    {!! Form::model($registro, ['route' => ['guarda_registro',$registro->id], 'method' => 'post']) !!}
                @else
                    {!! Form::open(['route' => ['guarda_registro']]) !!}
                @endif
                <div class="box-body">
                    @if(isset($registro) && $registro->estado != 'Ocupando' || !isset($registro))
                    <div class="form-group col-sm-6">
                        {!! Form::radio('estado','Ocupando',null,['class' => 'ch-ocupar']) !!}
                        Ocupar habitacion
                    </div>
                    <div class="form-group col-sm-6">
                        {!! Form::radio('estado','Reservado',null,['class' => 'ch-reservar']) !!}
                        Reservar habitacion
                    </div>
                    @endif
                    <div class="form-group col-sm-6">
                        <label>Fecha inicial Reserva</label>
                        {!! Form::text('fech_ini_reserva', null, ['class' => 'form-control fechas']) !!}
                    </div>

                    <!-- Nacionalidad Field -->
                    <div class="form-group col-sm-6">
                        <label>Fecha Final Reserva</label>
                        {!! Form::text('fech_fin_reserva', null, ['class' => 'form-control fechas']) !!}
                    </div>
                    @if(!isset($registro) && !empty($cliente))
                        <div id="nuevo-grupo">
                            <div class="form-group col-sm-10">
                                <label>Nombre del Grupo</label>
                                {!! Form::text('nuevogrupo', $cliente->nombre, ['class' => 'form-control','placeholder' => 'Ingrese el nombre del nuevo grupo']) !!}
                            </div>
                            <div class="form-group col-sm-2">
                                <label>&nbsp;</label>
                                <a href="javascript:"
                                   onclick="m_selec_grupo();"
                                   class="btn btn-block btn-info" title="Seleccionar un grupo"><i
                                            class="fa fa-exchange"></i></a>
                            </div>
                        </div>
                        <div id="seleccion-grupo" style="display: none;">
                            <div class="form-group col-sm-10">
                                <label>Seleccione el Grupo</label>
                                {!! Form::select('grupo_id', $grupos,null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group col-sm-2">
                                <label>&nbsp;</label>
                                <a href="javascript:"
                                   onclick="m_nuev_grupo();"
                                   class="btn btn-block btn-success" title="Nuevo Grupo"><i class="fa fa-exchange"></i></a>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="form-group col-sm-12">
                                <label>Seleccione el Grupo</label>
                                {!! Form::select('grupo_id', $grupos,null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    @endif

                    <div class="form-group col-sm-6">
                        <label>Equipaje</label>
                        {!! Form::select('equipaje', [null => '','Sin equipaje' => 'Sin equipaje','Poco equipaje' => 'Poco equipaje','Con equipaje' => 'Con equipaje'],null, ['class' => 'form-control','required']) !!}
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Seleccione el precio</label>
                        {!! Form::select('precio', $precios,null, ['class' => 'form-control','required']) !!}
                    </div>
                    <div class="form-group col-sm-12">
                        <h4 class="text-center">Listado de Huespedes</h4>
                        <table class="table table-bordered" id="tabla-huespedes">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Pasaporte</th>
                                <th>C.I.</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($hospedantes))
                                @foreach($hospedantes as $hospedante)
                                    <tr class="success">
                                        <td>{!! $hospedante->cliente->nombre !!}</td>
                                        <td>{!! $hospedante->cliente->pasaporte !!}</td>
                                        <td>{!! $hospedante->cliente->ci !!}</td>
                                        <td>
                                            <a href="javascript:" title="Eliminar Hospedante del registro"
                                               onclick="if(confirm('Esta seguro de quitar el huesped del registro??')){window.location.href = '{!! route('quitarhuesped',[$hospedante->id]) !!}';}"
                                               class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                            @if($hospedante->estado == 'Ocupando')
                                                <a href="javascript:" title="Marcar salida de huesped"
                                                   onclick="if(confirm('Esta seguro de Marcar salida del huesped??')){window.location.href = '{!! route('msalidahuesped',[$hospedante->id]) !!}';}"
                                                   class="btn btn-info btn-xs"><i class="fa fa-sign-out"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if(!empty($cliente))
                                <tr id="huesped-{!! $cliente->id !!}">
                                    <td>{!! $cliente->nombre !!}</td>
                                    <td>{!! $cliente->pasaporte !!}</td>
                                    <td>{!! $cliente->ci !!}</td>
                                    <td>
                                        <a href="javascript:" onclick="quitarhues({!! $cliente->id !!})"
                                           class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                        <input type="hidden" name="huespedes[{!! $cliente->id !!}][cliente_id]"
                                               value="{!! $cliente->id !!}" class="form-control">
                                    </td>
                                </tr>
                                {!! Form::hidden('cliente_id',$cliente->id) !!}
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('clientes.index') !!}" class="btn btn-default">Cancelar</a>
                    </div>
                </div>

                {!! Form::hidden('user_id',Auth::user()->id) !!}
                {!! Form::hidden('habitacione_id',$habitacion->id) !!}
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

    function addcli(objeto) {
        if ($('#huesped-' + $(objeto).attr('data-id')).length == 0) {
            var formuhues = '<input type="hidden" name="huespedes[' + $(objeto).attr('data-id') + '][cliente_id]" value="' + $(objeto).attr('data-id') + '" class="form-control">';
            var aquitarhues = '<a href="javascript:" onclick="quitarhues(' + $(objeto).attr('data-id') + ')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
            $('#tabla-huespedes tbody').append('<tr id="huesped-' + $(objeto).attr('data-id') + '"><td>' + formuhues + $(objeto).attr('data-nombre') + '</td><td>' + $(objeto).attr('data-pasaporte') + '</td><td>' + $(objeto).attr('data-ci') + '</td><td>' + aquitarhues + '</td></tr>');
        } else {
            alert('El cliente ya es huesped!!');
        }

    }
    function quitarhues(idCli) {
        $('#huesped-' + idCli).remove();
    }

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
<script>
    @if(!isset($registro) && !empty($cliente))
    function m_selec_grupo() {
        $('#nuevo-grupo').hide(400);
        $('#seleccion-grupo').show(400);
        $('#nuevo-grupo input').attr('required', false).val('');
        $('#seleccion-grupo select').attr('required', true);
    }
    function m_nuev_grupo() {
        $('#nuevo-grupo').show(400);
        $('#seleccion-grupo').hide(400);
        $('#nuevo-grupo input').attr('required', true);
        $('#seleccion-grupo select').attr('required', false);
    }
    m_nuev_grupo();
    @endif
</script>
@endpush