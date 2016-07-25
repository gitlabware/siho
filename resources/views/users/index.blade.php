@extends('layouts.app')

@section('content')

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Listado de Usuarios</h3>
            <div class="box-tools pull-right no-imprimir">
                <button class="btn btn-box-tool btn-success" title="Nuevo Usuario"
                        onclick="cargarmodal('{!! route('usuario') !!}')" style="color: #ffffff;"><i
                            class="fa fa-plus"></i> <b>Nueva Usuario</b></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Hotel</th>
                </tr>
                </thead>
                <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{!! $usuario->name !!}</td>
                        <td>{!! $usuario->email !!}</td>
                        <td>{!! $usuario->rol !!}</td>
                        <td>{{ isset($usuario->hotel) ? $usuario->hotel->nombre : '' }}</td>
                        <td>
                            {!! Form::open(['route' => ['habitaciones.destroy', $usuario->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{!! route('habitaciones.show', [$usuario->id]) !!}"
                                   class='btn btn-default btn-xs'><i
                                            class="glyphicon glyphicon-eye-open"></i></a>
                                <a href="{!! route('habitaciones.edit', [$usuario->id]) !!}"
                                   class='btn btn-default btn-xs'><i
                                            class="glyphicon glyphicon-edit"></i></a>
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection


@push('scriptsextras')
@include('layouts.partials.jsdatatable')
@endpush