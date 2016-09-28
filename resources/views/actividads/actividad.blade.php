<link rel="stylesheet" type="text/css" media="screen"
      href="{{ asset('/plugins/datepicker/bootstrap-datetimepicker.min.css') }}">
<style>
    .datepicker {
        z-index: 9999 !important;
    }
</style>
@if(isset($actividad))
    {!! Form::model($actividad, ['route' => ['guarda_actividad',$actividad->id], 'method' => 'post']) !!}
    <?php $fecha_a = $actividad->fecha; ?>
@else
    {!! Form::open(['route' => ['guarda_actividad']]) !!}
    <?php $fecha_a = date('d/m/Y'); ?>
@endif
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Actividad</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12" style="font-size: 15px;">
                <table class="table table-bordered">
                    <tr>
                        <td><b>Cliente:</b></td>
                        <td>{!! $cliente->nombre !!}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de Actividad:</label>
                    {!! Form::text('fecha', null, ['class' => 'form-control fechas']) !!}
                </div>
            </div>
        </div>
        <div class="form-group">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Descripcion de la actividad</label>
                        {!! Form::textarea('descripcion', null, ['class' => 'form-control','placeholder' => 'Ingrese la descripcion del a actividad','rows' => 3,'required']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('cliente_id',$cliente->id) !!}
{!! Form::hidden('user_id',Auth::user()->id) !!}
{!! Form::hidden('hotel_id',Auth::user()->hotel_id) !!}
<div class="modal-footer">
    {!! Form::submit('Guardar', ['class' => 'btn btn-outline pull-left']) !!}
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::close() !!}

<!-- bootstrap datepicker -->
<script src="{{ asset('/plugins/datepicker/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/datepicker/bootstrap-datetimepicker.min.js') }}"></script>

<script>
    /*$('.calendario').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });*/
    $('.fechas').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });

</script>