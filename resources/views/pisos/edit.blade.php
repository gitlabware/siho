@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Pisos</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($pisos, ['route' => ['pisos.update', $pisos->id], 'method' => 'patch']) !!}

            @include('pisos.fields')

            {!! Form::close() !!}
        </div>
@endsection
