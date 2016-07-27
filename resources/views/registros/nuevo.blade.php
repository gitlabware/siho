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
                <dl class="dl-horizontal">
                    <dt>Cliente:</dt>
                    <dd>{!! $cliente->nombre !!}</dd>
                    <dt>Habitacion:</dt>
                    <dd>{!! $habitacion->nombre.' - '.$habitacion->rpiso->nombre !!}</dd>
                </dl>
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

{!! Form::hidden('cliente_id',$cliente->id) !!}
{!! Form::hidden('habitacione_id',$habitacion->id) !!}
{!! Form::hidden('user_id',0) !!}
<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
    {!! Form::submit('Save', ['class' => 'btn btn-outline pull-left']) !!}
</div>
{!! Form::close() !!}


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
        if(first == second){
            return 0;
        }else{
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

    function fechahoy(){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();

        if(dd<10) {
            dd='0'+dd
        }

        if(mm<10) {
            mm='0'+mm
        }

        today = dd+'/'+mm+'/'+yyyy;
        return today;
        //document.write(today);
    }

    $('.ch-ocupado').click(function(){
        if($(this).prop('checked') && $('.calendario2').val() == ''){
            $('.calendario2').val(fechahoy());
            calculamonto();
        }
    });


</script>