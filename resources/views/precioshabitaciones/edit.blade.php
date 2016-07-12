@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Precioshabitaciones</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($precioshabitaciones, ['route' => ['precioshabitaciones.update', $precioshabitaciones->id], 'method' => 'patch']) !!}

            @include('precioshabitaciones.fields')

            {!! Form::close() !!}
        </div>
@endsection
