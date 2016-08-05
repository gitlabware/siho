<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
<style>
    .datepicker {
        z-index: 9999 !important;
    }
</style>
@if(isset($registro))
    {!! Form::model($registro, ['route' => ['guarda_registros',$registro->num_reg], 'method' => 'post']) !!}
    <?php $fecha_ingreso = $registro->fecha_ingreso; ?>
@else
    {!! Form::open(['route' => ['guarda_registros']]) !!}
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
                <dl class="dl-horizontal">
                    <dt>Cliente:</dt>
                    <dd>{!! $cliente->nombre !!}</dd>
                </dl>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de Ingreso:</label>
                    {!! Form::text('fecha_ingreso', $fecha_ingreso, ['class' => 'form-control calendario','placeholder'
                    => '','required','id' => 'cfechaingreso']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de salida:</label>
                    {!! Form::text('fecha_salida', null, ['class' => 'form-control calendario calendario2','placeholder'
                    => '','id' => 'cfechasalida']) !!}
                </div>
            </div>
        </div>
        @foreach($habitaciones as $idHabitacion => $habitacion)
            <?php
            $precio = null;
            $monto = null;
            if (isset($habitacion['registro'])) {
                $precio = $habitacion['registro']->precio;
                $monto = $habitacion['registro']->monto_total;
                echo Form::hidden("habitaciones[$idHabitacion][registro_id]", $habitacion['registro']->id);
            }
            ?>
            <h4 class="text-center">{!! $habitacion['habitacion']->nombre.' - '.$habitacion['habitacion']->rpiso->nombre !!}</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::select("habitaciones[$idHabitacion][precio]", $habitacion['precios'],$precio, ['class' => 'form-control precio','placeholder' =>
                        'Seleccione el precio','required','data-id' => $idHabitacion,'id' => 'cprecio-'.$idHabitacion]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::text("habitaciones[$idHabitacion][monto_total]", $monto, ['class' => 'form-control monto','placeholder' => 'Monto','step' =>
                        'any','type' => 'number','min' => 0,'data-id' => $idHabitacion,'id' => 'cmontototal-'.$idHabitacion]) !!}
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row">
            <div class="col-md-6" align="right">
                <label>Total: </label>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::hidden('monto_total',null,['id' => 'totaltotal']) !!}
                    {!! Form::text('total', null, ['class' => 'form-control','placeholder' => 'Total','step' =>
                    'any','type' => 'number','min' => 0,'id' => 'cmontototalt','disabled']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::textarea('observacion', null, ['class' => 'form-control','placeholder' =>
                    'Observacion...','rows' => 3]) !!}
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
                        {!! Form::select('caja_id', $cajas,null, ['class' => 'form-control caja','required','id' =>
                        'ccaja','disabled']) !!}
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
                        {!! Form::select('caja_id', $cajas,null, ['class' => 'form-control caja','required','id' =>
                        'ccaja']) !!}
                    </div>
                </div>
            </div>
        @endif
        @if($ocupado)
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::checkbox('ocupado',null,null,['class' => 'ch-ocupado']) !!} Desocupar habitacion
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
{!! Form::hidden('flujo_id') !!}
{!! Form::hidden('cliente_id',$cliente->id) !!}
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
        var sum_total = 0;
        $('.precio').each(function (e, i) {
            idHambiente = $(i).attr('data-id');
            if ($('#cfechaingreso').val() != '' && $('#cfechasalida').val() != '' && $('#cprecio-' + idHambiente).val() != '') {
                var dias = daydiff(parseDate($('#cfechaingreso').val()), parseDate($('#cfechasalida').val()));
                var precio = parseFloat($('#cprecio-' + idHambiente).val());
                if (dias > 0) {
                    sum_total = sum_total + (dias * precio);
                    $('#cmontototal-' + idHambiente).val(dias * precio);
                }
            }
        });
        $('#cmontototalt').val(sum_total);
        $('#totaltotal').val(sum_total);
    }
    $('.calendario').change(function () {
        calculamonto();
    });
    $('.precio').change(function () {
        calculamonto();
    });

    calculamonto();
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