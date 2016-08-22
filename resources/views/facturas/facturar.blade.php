{!! Form::open(['route' => 'generar_factura']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Facturar</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('cliente', $cliente, ['class' => 'form-control','placeholder' => 'Cliente','required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::text('nit', $nit_ci, ['class' => 'form-control','placeholder' => 'NIT/CI','required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table table-cordered">
                <thead>
                <tr>
                    <th>Detalle</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        {!! $flujo->detalle !!}
                    </td>
                    <td>
                        {!! $flujo->ingreso !!}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>{!! $flujo->ingreso !!}</td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>

{!! Form::hidden('flujo_id',$flujo->id) !!}
{!! Form::hidden('user_id',Auth::user()->id) !!}
<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
    {!! Form::submit('Generar', ['class' => 'btn btn-outline pull-left']) !!}
</div>
{!! Form::close() !!}
