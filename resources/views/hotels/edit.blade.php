@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <h1 class="pull-left">Edicion Hotel</h1>
        </div>
    </div>

    @include('core-templates::common.errors')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! Form::model($hotel, ['route' => ['hotels.update', $hotel->id], 'method' => 'patch']) !!}
                <div class="box-body">
                    <!-- Nombre Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('nombre', 'Nombre:') !!}
                        {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
                    </div>

                    <!-- Telefonos Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('telefonos', 'Telefonos:') !!}
                        {!! Form::text('telefonos', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Direccion Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::label('direccion', 'Direccion:') !!}
                        {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('hotels.index') !!}" class="btn btn-default">Cancelar</a>
                    </div>

                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
