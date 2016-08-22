{!! Form::open(['url' => 'caja/guarda_egreso']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Nuevo Egreso</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('detalle', null, ['class' => 'form-control','placeholder' => 'Detalle del Egreso','required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('salida', null, ['class' => 'form-control','placeholder' => 'Monto','required','step' => 'any','type' => 'number','min' => 0]) !!}
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
{!! Form::hidden('ingreso',0) !!}
{!! Form::hidden('caja_id',$idCaja) !!}
{!! Form::hidden('user_id',0) !!}
<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
    {!! Form::submit('Save', ['class' => 'btn btn-outline pull-left']) !!}
</div>
{!! Form::close() !!}
