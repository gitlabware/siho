@extends('layouts.app')

@section('content')
    <style>

    </style>
    @include('flash::message')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Hotel: {!! $hotel->nombre  !!}</h3>
            <table class="table table-bordered text-center">
                <tr>
                    <td><a href="javascript:" onclick="cargarmodal('{!! route('piso') !!}')" type="button"
                           class="btn btn-block btn-primary btn-sm">Nuevo Piso</a></td>
                    <td><a href="{!! url('nuevaHabitacion', $hotel->id) !!}" type="button"
                           class="btn btn-block btn-success btn-sm">Nueva Habitacion</a></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            @foreach($pisos as $piso)

                <h3 class="text-center text-primary"><b>{!! $piso->nombre !!}</b></h3>
                <div class="row">

                    @foreach($piso->habitaciones as $habitacion)

                        <?php
                        $color_h = 'aqua';

                        if ($habitacion->estaocupado) {
                            $color_h = 'red';
                        } elseif ($habitacion->estareservado) {
                            $color_h = 'yellow';
                        }
                        ?>

                        <div class="col-lg-2 col-xs-4">
                            <!-- small box -->
                            <div class="small-box bg-{!! $color_h !!}">
                                <div class="inner">
                                    <h3>{!! $habitacion->nombre !!}</h3>

                                    <p>Habitacion</p>
                                    <p>
                                        @if(isset($habitacion->categoria->nombre))
                                            {!! $habitacion->categoria->nombre !!}
                                        @endif
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pricetag"></i>
                                </div>
                                <a href="javascript:"
                                   onclick="cargarmodal('{!! route('informacion_habitacion',[$habitacion->id]) !!}','info')"
                                   class="small-box-footer">Mas Informacion <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>
    </div>



@endsection
@push('scriptsextras')
@include('layouts.partials.jsdatatable')
@endpush