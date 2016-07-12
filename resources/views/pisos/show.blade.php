@extends('layouts.app')

@section('content')
    @include('pisos.show_fields')

    <div class="form-group">
           <a href="{!! route('pisos.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
