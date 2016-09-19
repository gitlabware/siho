@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Grupos</h1>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box">
        <div class="box-body table-responsive">
            <table class="table table-responsive">
                <thead>
                <th>creado</th>
                <th>Nombre</th>
                <th colspan="3">Action</th>
                </thead>
                <tbody>
                @foreach($grupos as $grupo)
                    <tr>
                        <td>{!! $grupo->created_at !!}</td>
                        <td>{!! $grupo->nombre !!}</td>
                        <td>
                            {!! Form::open(['route' => ['eliminargrupo', $grupo->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{!! route('registrosgrupos', [$grupo->id]) !!}" title="Registros" class='btn btn-primary btn-xs'><i class="fa fa-list"></i></a>
                                <a href="{!! route('grupo', [$grupo->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                                {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar el grupo?')"]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>


@endsection
