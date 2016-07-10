@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Nueva Habitacion</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        {!! Form::open(['route' => 'habitaciones.store']) !!}

            @include('habitaciones.fields')

        {!! Form::close() !!}
    </div>
@endsection
