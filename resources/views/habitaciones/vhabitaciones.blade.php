@extends('layouts.app')

@section('content')
    <style>

    </style>
    @include('flash::message')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Hotel: {!! $hotel->nombre  !!}</h3>
            <?php
            $role = Auth::user()->rol;
            ?>
            @if($role != 'Operario')
                <div class="box-tools pull-right">
                    <a href="{!! url('nuevaHabitacion', $hotel->id) !!}" class="btn btn-success btn-box-tool"
                       style="color: white;"><b>NUEVA HABITACION</b></a>

                </div>
            @endif
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