@extends('layouts.app')

@section('content')
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Edit Factura</h1>
            </div>
        </div>

        @include('core-templates::common.errors')

        <div class="row">
        <div class="col-md-12">
                        <div class="box box-primary">

            {!! Form::model($factura, ['route' => ['facturas.update', $factura->id], 'method' => 'patch']) !!}
<div class="box-body">
            @include('facturas.fields')
</div>
            {!! Form::close() !!}
            </div>
                    </div>
        </div>
@endsection
