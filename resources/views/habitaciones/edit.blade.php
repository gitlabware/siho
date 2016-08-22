@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Edit Habitaciones</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::model($habitaciones, ['route' => ['habitaciones.update', $habitaciones->id], 'method' => 'patch']) !!}
                <div class="box-body">
                    @include('habitaciones.fields')
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
