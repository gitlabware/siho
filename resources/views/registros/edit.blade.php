@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Registro</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($registro, ['route' => ['registros.update', $registro->id], 'method' => 'patch']) !!}

            @include('registros.fields')

            {!! Form::close() !!}
        </div>
@endsection
