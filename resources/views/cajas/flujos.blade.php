@extends('layouts.app')

@section('content')
    <h1 class="pull-left">{!! $caja->nombre !!}</h1>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Simple Full Width Table</h3>

                    <div class="box-tools pull-right">
                        <a href="javascript:" class="btn btn-success btn-box-tool" style="color: yellow;" onclick="cargarmodal('{!!url('caja/ingreso',[$caja->id])!!}}')"><b>NUEVO INGRESO</b></a>
                        <a href="javascript:" class="btn btn-primary btn-box-tool" style="color: yellow;"><b>NUEVO EGRESO</b></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Detalle</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection