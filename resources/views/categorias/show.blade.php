@extends('layouts.app')

@section('content')
    @include('categorias.show_fields')

    <div class="form-group">
           <a href="{!! route('categorias.index') !!}" class="btn btn-default">Back</a>
    </div>
@endsection
