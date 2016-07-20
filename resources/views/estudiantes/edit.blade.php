@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Estudiantes</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($estudiantes, ['route' => ['estudiantes.update', $estudiantes->id], 'method' => 'patch']) !!}

            @include('estudiantes.fields')

            {!! Form::close() !!}
        </div>
@endsection
