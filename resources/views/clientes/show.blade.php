@extends('layouts.app')

@section('content')
    @include('clientes.show_fields')

    <div class="form-group">
           <a href="{!! route('clientes.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
