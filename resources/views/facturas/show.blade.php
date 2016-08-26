@extends('layouts.app')

@section('content')
    @include('facturas.show_fields')

    <div class="form-group">
           <a href="{!! route('facturas.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
