@extends('layouts.app')

@section('content')
    @include('actividads.show_fields')

    <div class="form-group">
           <a href="{!! route('actividads.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
