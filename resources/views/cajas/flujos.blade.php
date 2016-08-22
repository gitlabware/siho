@extends('layouts.app')

@section('content')
    <h1 class="pull-left">{!! $caja->nombre !!} <span style="font-size: 17px; font-weight: bold;" class="text-primary">(SALDO: {!! $caja->total !!}
            ) Bs.</span></h1>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Flujos de caja</h3>

                    <div class="box-tools pull-right">
                        <a href="javascript:" class="btn btn-success btn-box-tool" style="color: yellow;"
                           onclick="cargarmodal('{!!url('caja/ingreso',[$caja->id])!!}}','success')"><b>NUEVO
                                INGRESO</b></a>
                        <a href="javascript:" class="btn btn-primary btn-box-tool" style="color: yellow;"
                           onclick="cargarmodal('{!!url('caja/egreso',[$caja->id])!!}}','primary')"><b>NUEVO
                                EGRESO</b></a>
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
                            <th>Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($flujos as $flu)
                            <tr>
                                <td>{!! $flu->detalle !!}</td>
                                <td>{!! $flu->ingreso !!}</td>
                                <td>{!! $flu->salida !!}</td>
                                <td>
                                    @if($flu->ingreso != 0)
                                        <a href="javascript:"
                                           onclick="cargarmodal('{!! route('facturar',[$flu->id]) !!}')"
                                           class='btn btn-info btn-xs' title="Hacer Factura"><i class="fa fa-file"></i></a>
                                    @endif

                                    <a href="javascript:"
                                       onclick="cargarmodal('{!! route('eliminaflujo',[$flu->id]) !!}','danger')"
                                       class='btn btn-danger btn-xs' title="Eliminar Flujo"><i
                                                class="fa fa-remove"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection
