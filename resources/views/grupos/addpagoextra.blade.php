<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
<style>
    .datepicker {
        z-index: 9999 !important;
    }
</style>
{!! Form::open(['route' => ['guarda_pagoextra']]) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Formulario de Pago extra
        - {!! $registro->habitacione->nombre.'-'.$registro->habitacione->rpiso->nombre !!}</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('fecha', date('d/m/Y'), ['class' => 'form-control calendario','placeholder'
                    => '','required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('monto_total', null, ['class' => 'form-control','placeholder' => 'Ingrese el monto','required']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    {!! Form::submit('Guardar', ['class' => 'btn btn-outline pull-left']) !!}
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::hidden('registro_id',$registro->id) !!}
{!! Form::close() !!}
<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script>
    $('.calendario').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
</script>