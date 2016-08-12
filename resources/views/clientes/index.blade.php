@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Clientes</h1>
    <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('clientes.create') !!}">Add New</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @include('clientes.table')
        </div>
    </div>

@endsection


