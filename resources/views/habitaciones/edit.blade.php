@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Habitaciones</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($habitaciones, ['route' => ['habitaciones.update', $habitaciones->id], 'method' => 'patch']) !!}

            @include('habitaciones.fields')

            {!! Form::close() !!}
        </div>
@endsection
