@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Precios habitacion: {!! $habitacion->nombre !!}<h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table table-bordered">
                        @foreach($precios as $p)
                            <tr>
                                <th>P: {!! $p->precio !!}</th>
                                <th>
                                    <div class='btn-group'>
                                        {!! Form::open(['route' => ['precioshabitaciones.destroy', $p->id], 'method' => 'delete']) !!}

                                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar el precio?')"]) !!}
                                        {!! Form::close() !!}
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>
            <!-- /.box -->

        </div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Nuevo Precio</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                {!! Form::open(['route' => 'precioshabitaciones.store']) !!}

                <!-- Habitacione Id Field -->

                    <!-- Precio Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::hidden('habitacione_id', $idHabitacion) !!}
                        {!! Form::label('precio', 'Precio:') !!}
                        {!! Form::text('precio', null, ['class' => 'form-control']) !!}
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                        <a href="{!! route('precioshabitaciones.index') !!}" class="btn btn-default">Cancel</a>
                    </div>

                    {!! Form::close() !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection