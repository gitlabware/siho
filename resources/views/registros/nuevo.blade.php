<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
<style>
    .datepicker {
        z-index: 9999 !important;
    }
</style>
@if(isset($registro))
    {!! Form::model($registro, ['route' => ['guarda_registro',$registro->id], 'method' => 'post']) !!}
    <?php $fecha_ingreso = $registro->fecha_ingreso; ?>
@else
    {!! Form::open(['route' => ['guarda_registro']]) !!}
    <?php $fecha_ingreso = date('d/m/Y'); ?>
@endif
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Formulario de Registro</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12" style="font-size: 15px;">
                <table class="table table-bordered">
                    <tr>
                        <td><b>Cliente:</b></td>
                        <td>{!! $cliente->nombre !!}</td>
                        <td><b>Habitacion:</b></td>
                        <td>{!! $habitacion->nombre.' - '.$habitacion->rpiso->nombre !!}</td>
                    </tr>
                </table>
                @if(isset($registros))
                    <table class="table table-bordered">
                        @foreach($registros as $regi)
                            @if(isset($registro) && $regi->id != $registro->id || !isset($registro))
                                <tr>
                                    <td class="text-center">
                                        {{ $regi->estado.' '.$regi->cliente->nombre.' '.$regi->fecha_ingreso.' - '.$regi->fecha_salida }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de Ingreso:</label>
                    {!! Form::text('fecha_ingreso', $fecha_ingreso, ['class' => 'form-control calendario','placeholder' => '','required','id' => 'cfechaingreso']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de salida:</label>
                    {!! Form::text('fecha_salida', null, ['class' => 'form-control calendario calendario2','placeholder' => '','id' => 'cfechasalida']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::select('precio', $precios,null, ['class' => 'form-control precio','placeholder' => 'Seleccione el precio','required','id' => 'cprecio']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('monto_total', null, ['class' => 'form-control','placeholder' => 'Monto','step' => 'any','type' => 'number','min' => 0,'id' => 'cmontototal']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::textarea('observacion', null, ['class' => 'form-control','placeholder' => 'Observacion...','rows' => 3]) !!}
                </div>
            </div>
        </div>
        @if(empty($registro->flujo_id))
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::checkbox('pagar',null,null,['class' => 'ch-pago']) !!} Registrar pago
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::select('caja_id', $cajas,null, ['class' => 'form-control caja','required','id' => 'ccaja','disabled']) !!}
                    </div>
                </div>
            </div>
        @else
            <div class="row" id="form-repago">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::checkbox('repago',null,null,['class' => 'ch-repago']) !!} Rehacer pago
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="text-success">$$ EL pago esta en {!! $registro->flujo->caja->nombre !!}</label>
                    </div>
                </div>
            </div>
            <div class="row" id="form-pago" style="display: none;">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::checkbox('pagar',null,null,['class' => 'ch-pago','checked']) !!} Registrar pago
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::select('caja_id', $cajas,null, ['class' => 'form-control caja','required','id' => 'ccaja']) !!}
                    </div>
                </div>
            </div>
        @endif
        @if(isset($registro->id) && $registro->estado == 'Ocupando')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::checkbox('ocupado',null,null,['class' => 'ch-ocupado']) !!}
                        Desocupar habitacion
                    </div>
                </div>
            </div>

        @elseif(isset($registro->id) && $registro->estado == 'Reservado')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::checkbox('ocupar',null,null,['class' => 'ch-ocupar']) !!}
                        Ocupar habitacion
                    </div>
                </div>
            </div>
        @elseif(isset($registro->id) && $registro->estado != 'Reservado' || !isset($registro->id))
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::radio('estado','Ocupando',null,['class' => 'ch-ocupar']) !!}
                        Ocupar habitacion
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::radio('estado','Reservado',null,['class' => 'ch-reservar']) !!}
                        Reservar habitacion
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
{!! Form::hidden('flujo_id') !!}
{!! Form::hidden('cliente_id',$cliente->id) !!}
{!! Form::hidden('habitacione_id',$habitacion->id) !!}
{!! Form::hidden('user_id',Auth::user()->id) !!}
<div class="modal-footer">
    {!! Form::submit('Guardar', ['class' => 'btn btn-outline pull-left']) !!}
    @if(isset($registro->id))
        <button type="button"
                onclick="if(confirm('Al el eliminar el registro significa eliminar pagos y  ocupacion de habitacion.. Esta seguro de eliminar el registro?')){$('#form-elimina').submit();}"
                class="btn btn-outline pull-left" data-dismiss="modal">Cancelar Registro
        </button>
    @endif
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::close() !!}

@if(isset($registro->id))
    {!! Form::open(['route' => ['registros.destroy', $registro->id], 'method' => 'delete','id' => 'form-elimina']) !!}
    {!! Form::close() !!}
@endif



<!-- bootstrap datepicker -->
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

<script>
    $('.calendario').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    function parseDate(str) {
        var mdy = str.split('/');
        return new Date(mdy[2], mdy[1] - 1, mdy[0]);
    }

    function daydiff(first, second) {
        if (first == second) {
            return 0;
        } else {
            return Math.round((second - first) / (1000 * 60 * 60 * 24));
        }
    }


    function calculamonto() {
        console.log($('#cfechaingreso').val());
        console.log($('#cfechasalida').val());
        console.log($('#cprecio').val());
        if ($('#cfechaingreso').val() != '' && $('#cfechasalida').val() != '' && $('#cprecio').val() != '') {
            //alert(dias);
            var dias = daydiff(parseDate($('#cfechaingreso').val()), parseDate($('#cfechasalida').val()));
            //alert(dias);
            var precio = parseFloat($('#cprecio').val());
            if (dias > 0) {
                $('#cmontototal').val(dias * precio);
            }
        }
    }
    $('.calendario').change(function () {
        calculamonto();
    });
    $('.precio').change(function () {
        calculamonto();
    });
    //console.log(fechahoy());

    function fechahoy() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        today = dd + '/' + mm + '/' + yyyy;
        return today;
        //document.write(today);
    }

    $('.ch-ocupado').click(function () {
        if ($(this).prop('checked') && $('.calendario2').val() == '') {
            $('.calendario2').val(fechahoy());
            calculamonto();
        }
    });

    $('.ch-pago').click(function () {
        if ($(this).prop('checked')) {
            $('select.caja').attr('disabled', false);
            $('#cmontototal').attr('required', true);
        } else {
            $('select.caja').attr('disabled', true);
            $('#cmontototal').attr('required', false);
        }
    });

    $('.ch-repago').click(function () {
        if (confirm("Esta seguro de rehacer el pago??")) {
            $('#form-repago').hide(400);
            $('#form-pago').show(400);
        } else {
            $(this).prop('checked', false);
        }

    });


</script>