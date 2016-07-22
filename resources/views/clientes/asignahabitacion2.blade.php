@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Registro de {!! $cliente->nombre !!}</h1>
    <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('habitaciones.create') !!}">Formulario</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <table class="table table-responsive" id="habitaciones-table">
        <thead>
        <th>Piso</th>
        <th>Nombre</th>
        <th>Estado</th>
        <th>Observaciones</th>
        <th colspan="3">Action</th>
        </thead>
        <tbody>
        @foreach($habitaciones as $habitaciones)
            <tr>
                <td>{!! $habitaciones->piso_id !!}</td>
                <td>{!! $habitaciones->nombre !!}</td>
                <td>{!! $habitaciones->estado !!}</td>
                <td>{!! $habitaciones->observaciones !!}</td>
                <td>
                    {!! Form::open(['route' => ['habitaciones.destroy', $habitaciones->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('habitaciones.show', [$habitaciones->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="javascript:" onclick="cargarmodal('{!! route('nuevoregistro',[$cliente->id,$habitaciones->id]) !!}')" class='btn btn-primary btn-xs' title="Formulario"><i class="glyphicon glyphicon-edit"></i></a>
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
