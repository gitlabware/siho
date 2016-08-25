@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => ['nuevos',$cliente->id], 'method' => 'post','id' => 'ajaxform']) !!}
    <h1 class="pull-left">Registro de {!! $cliente->nombre !!}</h1>

    <button class="btn btn-primary pull-right" type="button" onclick="envia_form();">Formulario</button>
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="box">
        <div class="box-body table-responsive">
            <table class="table table-responsive table-bordered" id="tabla">
                <thead>
                <tr>
                    <th></th>
                    <th>Piso</th>
                    <th>Nombre</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th>Action</th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th></th>
                    <th>Piso</th>
                    <th>Nombre</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>
                        Estado
                    </th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>


                @foreach($habitaciones as $key => $habitacion)
                    <?php
                    $idHabitacion = $habitacion->id;
                    $regis_checkbox = Form::checkbox("habitaciones[$idHabitacion][marca]", null, null, ['class' => 'ch-marca-h']);

                    ?>
                    <tr>
                        <td>
                            {!! $regis_checkbox !!}
                        </td>
                        <td>{!! $habitacion->rpiso->nombre !!}</td>
                        <td>{!! $habitacion->nombre !!}</td>
                        <td>
                            @foreach($habitacion->rprecios as $precio)
                                {!! $precio->precio !!} Bs<br>
                            @endforeach
                        </td>
                        <td>
                            @if(isset($habitacion->categoria->nombre))
                                {!! $habitacion->categoria->nombre !!}
                            @endif
                        </td>
                        <td>
                            @foreach($habitacion->registrosactivos as $registro)
                                <?php
                                $color_reg = 'info';
                                if ($registro->estado == 'Ocupando') {
                                    $color_reg = 'danger';
                                }elseif($registro->estado == 'Reservado') {
                                    $color_reg = 'warning';
                                }
                                ?>
                                @if(!empty($registro->num_reg))
                                    <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:"
                                       onclick="cargarmodal('{!! route('nuevos',[$registro->cliente_id,$registro->num_reg]) !!}')">
                                        {{ $registro->estado.' '.$registro->cliente->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                                    </a>
                                @else
                                    <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:"
                                       onclick="cargarmodal('{!! route('nuevoregistro',[$registro->cliente_id,$registro->habitacione_id,$registro->id]) !!}')">
                                        {{ $registro->estado.' '.$registro->cliente->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                                    </a>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <div class='btn-group'>
                                <a href="javascript:"
                                   onclick="cargarmodal('{!! route('nuevoregistro',[$cliente->id,$habitacion->id]) !!}')"
                                   class='btn btn-primary btn-xs' title="Formulario"><i
                                            class="glyphicon glyphicon-edit"></i></a>
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {!! Form::close() !!}

@endsection
@push('scriptsextras')
@include('layouts.partials.jsdatatable')
<script>


    function envia_form() {

        var postData = $("#ajaxform").serializeArray();
        var formURL = '{!! route('nuevos',[$cliente->id]) !!}';
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    /*beforeSend:function (XMLHttpRequest) {
                     alert("antes de enviar");
                     },*/
                    complete: function (XMLHttpRequest, textStatus) {
                        setTimeout(function () {
                            jQuery("#spin-cargando-mod").hide();
                            $('#divmodal').show();
                        }, 1500);
                    },
                    success: function (data, textStatus, jqXHR) {
                        //data: return data from server
                        //$("#parte").html(data);

                        $('#mimodal').attr('class', 'modal modal-primary');
                        $('#divmodal').hide();
                        jQuery("#spin-cargando-mod").show(200);
                        jQuery('#mimodal').modal('show', {backdrop: 'static'});
                        $("#divmodal").html(data);

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //if fails
                        alert("error");
                    }
                });
    }
</script>
@endpush
