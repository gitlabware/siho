@extends('layouts.app')

@section('content')
    @include('registros.show_fields')

    <div class="form-group">
           <a href="{!! route('registros.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
