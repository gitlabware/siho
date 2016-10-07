@extends('layouts.app')

@section('content')

    @include('flash::message')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Hotel: {!! $hotel->nombre  !!} - LISTADO DE PISOS</h3>
            <div class="box-tools pull-right">
                <a href="javascript:" class="btn btn-success btn-box-tool" style="color: white;"
                   onclick="cargarmodal('{!!route('piso',[$hotel->id])!!}}','success')"><b>NUEVO PISO</b></a>

            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Piso</th>
                    <th>Habitaciones</th>
                    <th>Observaciones</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($pisos as $piso)
                    <tr>
                        <td>{!! $piso->id !!}</td>
                        <td>{!! $piso->nombre !!}</td>
                        <td>{!! $piso->habitaciones->count() !!}</td>
                        <td>{!! $piso->observaciones !!}</td>
                        <td>
                            {!! Form::open(['route' => ['pisos.destroy', $piso->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="javascript:" class='btn btn-default btn-xs' onclick="cargarmodal('{!! route('piso',[$piso->hotel_id,$piso->id]) !!}')"><i
                                            class="glyphicon glyphicon-edit"></i></a>
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
