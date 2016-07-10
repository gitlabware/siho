@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Hotel: {!! $hotel->nombre  !!}</h3>
            <table class="table table-bordered text-center">
                <tr>
                    <td><a href="#" type="button" class="btn btn-block btn-primary btn-sm">Nuevo Piso</a></td>
                    <td><a href="{!! route('habitaciones.create') !!}" type="button" class="btn btn-block btn-success btn-sm">Nueva Habitacion</a></td>
                </tr>
            </table>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Hotel</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pisos as $p)
                <tr>
                    <td>{!! $p->nombre !!}</td>
                    <td>
                        {!! Form::open(['route' => ['hotels.destroy', $p->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{!! route('hotels.show', [$p->id]) !!}" class='btn btn-default btn-xs'><i
                                        class="glyphicon glyphicon-eye-open"></i></a>
                            <a href="{!! route('pisos.edit', [$p->id]) !!}" class='btn btn-default btn-xs'><i
                                        class="glyphicon glyphicon-edit"></i></a>
                            <a href="{!! url('pisosHotel',[$p->id]) !!}" class='btn btn-default btn-xs'><i
                                        class="glyphicon glyphicon-th"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Hotel</th>
                    <th>Acciones</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
@push('scriptsextras')
@include('layouts.partials.jsdatatable')
@endpush