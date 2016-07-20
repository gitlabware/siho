@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Caja</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($caja, ['route' => ['cajas.update', $caja->id], 'method' => 'patch']) !!}

            @include('cajas.fields')

            {!! Form::close() !!}
        </div>
@endsection
