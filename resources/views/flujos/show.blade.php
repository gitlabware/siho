@extends('layouts.app')

@section('content')
    @include('flujos.show_fields')

    <div class="form-group">
           <a href="{!! route('flujos.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
