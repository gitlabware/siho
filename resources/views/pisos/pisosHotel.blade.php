@extends('layouts.app')

@section('content')
    <style>
        tfoot input {
            width: 100%;
            padding: 1px;
            box-sizing: border-box;
        }
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
                    <!--<a href="javascript:" class="btn btn-info btn-box-tool" onclick="opcionesh();"
                       style="color: white;"><i class="fa fa-check"></i> <b>OPCIONES</b></a>-->
                    <a href="{!! url('nuevaHabitacion', $hotel->id) !!}" class="btn btn-success btn-box-tool"
                       style="color: white;"><b>NUEVA HABITACION</b></a>
                </div>
            @endif
        </div>
        <!-- /.box-header -->
        {!! Form::open(['route' => ['opcioneshab'],'id' => 'form-habit']) !!}
        <div class="box-body table-responsive">
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <!--<th></th>-->
                    <th>Piso</th>
                    <th>Habitacion</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th></th>
                </tr>

                </thead>
                <thead>
                <tr>
                    <!--<th></th>-->
                    <th>Piso</th>
                    <th>Habitacion</th>
                    <th>Precios</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($habitaciones as $h)
                    <tr
                            @if($h->estado == 'Deshabilitado')
                            style="background-color: lightgrey;"
                            @endif
                    >
                        <!--<td>
                            <input type="checkbox" name="habitaciones[{!! $h->id !!}][valor]">
                        </td>-->
                        <td>{!! $h->rpiso->nombre !!}</td>
                        <td>{!! $h->nombre !!}</td>
                        <td>
                            @foreach($h->rprecios as $precio)
                                {!! $precio->precio !!} Bs<br>
                            @endforeach
                        </td>
                        <td>
                            @if(isset($h->categoria->nombre))
                                {!! $h->categoria->nombre !!}
                            @endif
                        </td>
                        <td>
                            @foreach($h->registrosactivos as $registro)
                                <?php
                                $color_reg = 'info';
                                if ($registro->estado == 'Ocupando') {
                                    $color_reg = 'danger';
                                } elseif ($registro->estado == 'Reservado') {
                                    $color_reg = 'warning';
                                }
                                ?>
                                @if(!empty($registro->num_reg))
                                    <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:">
                                        {{ $registro->estado.' '.$registro->grupo->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                                    </a>
                                @else
                                    <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:">
                                        {{ $registro->estado.' '.$registro->grupo->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                                    </a>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <?php
                            $role = Auth::user()->rol;
                            ?>
                            @if($role != 'Operario')
                                {!! Form::open(['route' => ['habitaciones.destroy', $h->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    {{--<a href="{!! route('hotels.show', [$h->id]) !!}" class='btn btn-default btn-xs'><i--}}
                                    {{--class="glyphicon glyphicon-eye-open"></i></a>--}}
                                    <a href="{!! url('ingresaPrecio', [$h->id]) !!}" class='btn btn-success btn-xs'><i
                                                class="fa fa-fw fa-dollar"></i></a>
                                    <a href="{!! route('habitaciones.edit', [$h->id]) !!}"
                                       class='btn btn-warning btn-xs'><i
                                                class="glyphicon glyphicon-edit"></i></a>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar la habitacion?')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    {!! Form::close() !!}
    <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
@push('scriptsextras')
@include('layouts.partials.jsdatatable')

<script>
    function opcionesh() {
        var postData = new FormData($("#form-habit")[0]);

        var formURL = $("#form-habit").attr("action");
        $.ajax(
                {
                    url: formURL,
                    type: "POST",
                    data: postData,
                    async: false,
                    processData: false,
                    cache: false,
                    contentType: false,

                    beforeSend: function (XMLHttpRequest) {
                        //alert("antes de enviar");
                        //$('#divmodal').hide();
                        //jQuery("#spin-cargando-mod").show(200);

                        $('#mimodal').attr('class', 'modal modal-primary');
                        $('#mimodal div.modal-dialog').addClass('modal-md');
                        $('#divmodal').hide();
                        jQuery("#spin-cargando-mod").show(200);
                        jQuery('#mimodal').modal('show', {backdrop: 'static'});
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        //alert('despues de enviar');
                    },
                    success: function (data, textStatus, jqXHR) {
                        jQuery("#divmodal").html(data);
                        setTimeout(function ()
                        {
                            jQuery("#spin-cargando-mod").hide();
                            $('#divmodal').show();
                        }, 1500);
                        //console.log(data);
                        /*setTimeout(function () {
                         jQuery("#spin-cargando-mod").hide();
                         $('#divmodal').show();
                         if (data['m_error'] == '') {
                         $('#mimodal').attr('class', 'modal modal-success');
                         $('#divmodal h4.modal-title').html(data['m_bueno']);
                         $('#divmodal div.modal-body').hide();
                         $('#divmodal div.modal-footer').hide();
                         setTimeout(function () {
                         $('#mimodal').modal('hide');
                         recargatabla();
                         }, 1900);
                         } else {
                         $('#mimodal').attr('class', 'modal modal-danger');
                         $('#divmodal h4.modal-title').html(data['m_error']);
                         $('#divmodal div.modal-body').hide();
                         $('#divmodal div.modal-footer').hide();
                         setTimeout(function () {
                         $('#divmodal div.modal-body').show();
                         $('#divmodal div.modal-footer').show();
                         }, 1900);
                         }


                         }, 1000);*/

                        //data: return data from server
                        //$("#parte").html(data);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        //if fails
                        alert("error");
                    }
                });
    }


</script>

@endpush