@extends('layouts.app')

@section('content')
    @include('habitaciones.show_fields')

    <div class="form-group">
           <a href="{!! route('habitaciones.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
