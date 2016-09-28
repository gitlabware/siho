{!! Form::open(['url' => 'grupos/eliminar_pago/'.$idPago]) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Eliminar Pago</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <td>{!! $pago->registro->habitacione->nombre !!}</td>
                        <td>{!! $pago->fecha !!}</td>
                        <td>{!! $pago->monto_total !!}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Motivo por el cual desea eliminar el Pago??</label>
                    {!! Form::textarea('observacion', null, ['class' => 'form-control','placeholder' => 'Observacion...','rows' => 3,'required']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
    {!! Form::submit('Eliminar Pago', ['class' => 'btn btn-outline pull-left']) !!}
</div>
{!! Form::close() !!}
