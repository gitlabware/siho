@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Actividad</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($actividad, ['route' => ['actividads.update', $actividad->id], 'method' => 'patch']) !!}

            @include('actividads.fields')

            {!! Form::close() !!}
        </div>
@endsection
