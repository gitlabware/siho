@extends('layouts.app')

@section('content')
    @include('cajas.show_fields')

    <div class="form-group">
           <a href="{!! route('cajas.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
