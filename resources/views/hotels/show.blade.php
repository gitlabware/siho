@extends('layouts.app')

@section('content')
    @include('hotels.show_fields')

    <div class="form-group">
           <a href="{!! route('hotels.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
