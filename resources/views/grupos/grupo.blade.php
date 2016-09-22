{!! Form::model($grupo, ['route' => ['guarda_grupo',$grupo->id], 'method' => 'post']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Formulario de Grupo</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::text('nombre', null, ['class' => 'form-control','placeholder' => 'Nombre del Grupo','required']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    {!! Form::submit('Guardar', ['class' => 'btn btn-outline pull-left']) !!}
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::close() !!}

