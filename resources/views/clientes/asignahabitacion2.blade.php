@extends('layouts.app')

@section('content')
    {!! Form::open(['route' => ['nuevos',$cliente->id], 'method' => 'post','id' => 'ajaxform']) !!}
    <h1 class="pull-left">Registro de {!! $cliente->nombre !!}</h1>

    <button class="btn btn-primary pull-right" type="button" onclick="envia_form();">Formulario</button>
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>


    <table class="table table-responsive" id="habitaciones-table">
        <thead>
        <tr>
            <th>Piso</th>
            <th>Nombre</th>
            <th>Cliente</th>
            <th>Fecha Ingreso</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>


        @foreach($habitaciones as $key => $habitacion)
            <?php
            $color_reg = null;
            $color_reg2 = null;
            if (isset($habitacion->registro_id)) {
                $color_reg = 'warning';
                $color_reg2 = ",'warning'";
            }

            $idHabitacion = $habitacion->id;
            ?>
            <tr class="{{ $color_reg }}">
                <td>
                    {!! Form::checkbox("habitaciones[$idHabitacion][marca]",null,null,['class' => 'ch-marca-h']) !!}
                </td>
                <td>{!! $habitacion->rpiso->nombre !!}</td>
                <td>{!! $habitacion->nombre !!}</td>
                <td>{{ isset($habitacion->registro->cliente->nombre) ? $habitacion->registro->cliente->nombre : '' }}</td>
                <td>{{ isset($habitacion->registro->fecha_ingreso) ? $habitacion->registro->fecha_ingreso : '' }}</td>
                <td>
                    <div class='btn-group'>
                        <a href="{!! route('habitaciones.show', [$habitacion->id]) !!}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="javascript:"
                           onclick="cargarmodal('{!! route('nuevoregistro',[$cliente->id,$habitacion->id,$habitacion->registro_id]) !!}'{{ $color_reg2 }})"
                           class='btn btn-primary btn-xs' title="Formulario"><i
                                    class="glyphicon glyphicon-edit"></i></a>
                    </div>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {!! Form::close() !!}

@endsection
@push('scriptsextras')
<script>


    function envia_form(){

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
