@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Hotel</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
            {!! Form::model($hotel, ['route' => ['hotels.update', $hotel->id], 'method' => 'patch']) !!}

            @include('hotels.fields')

            {!! Form::close() !!}
        </div>
@endsection
