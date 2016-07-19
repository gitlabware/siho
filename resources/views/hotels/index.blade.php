@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Hoteles</h1>
    <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('hotels.create') !!}">Nuevo</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box">
        <div class="box-header">
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            @include('hotels.table')
        </div>
    </div>

@endsection
