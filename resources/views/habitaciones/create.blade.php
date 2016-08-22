@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Nueva Habitacion</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::open(['route' => 'habitaciones.store']) !!}
                <div class="box-body">
                    @include('habitaciones.fields')
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
