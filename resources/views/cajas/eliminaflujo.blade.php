{!! Form::open(['url' => 'caja/eliminar_flujo/'.$idFlujo]) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Eliminar flujo</h4>
</div>
<div class="modal-body">
    <div class="form-group">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Motivo por el cual desea eliminar el flujo??</label>
                    {!! Form::textarea('observacion', null, ['class' => 'form-control','placeholder' => 'Observacion...','rows' => 3,'required']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
    {!! Form::submit('Eliminar Flujo', ['class' => 'btn btn-outline pull-left']) !!}
</div>
{!! Form::close() !!}
