@extends('layouts.app')

@section('content')
    @include('estudiantes.show_fields')

    <div class="form-group">
           <a href="{!! route('estudiantes.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
