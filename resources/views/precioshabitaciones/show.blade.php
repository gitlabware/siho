@extends('layouts.app')

@section('content')
    @include('precioshabitaciones.show_fields')

    <div class="form-group">
           <a href="{!! route('precioshabitaciones.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
