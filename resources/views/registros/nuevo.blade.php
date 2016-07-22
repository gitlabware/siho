{!! Form::open(['url' => 'registros/guarda_registro']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Formulario de Registro</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de Ingreso:</label>
                    {!! Form::date('fecha_ingreso', date('Y-m-d'), ['class' => 'form-control calendario','placeholder' => 'Detalle del ingrese','required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Fecha de salida:</label>
                    {!! Form::date('fecha_salida', null, ['class' => 'form-control','placeholder' => 'Detalle del ingrese']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::select('precio', $precios,null, ['class' => 'form-control','placeholder' => 'Seleccione el precio','required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('monto_total', null, ['class' => 'form-control','placeholder' => 'Monto','step' => 'any','type' => 'number','min' => 0]) !!}
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


<script>
    /*$('.calendario').datepicker({
        autoclose: true
    });*/
</script>