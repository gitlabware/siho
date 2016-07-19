@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Flujo</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($flujo, ['route' => ['flujos.update', $flujo->id], 'method' => 'patch']) !!}

            @include('flujos.fields')

            {!! Form::close() !!}
        </div>
@endsection
