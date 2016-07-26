
@if(isset($usuario))
    {!! Form::model($usuario, ['route' => ['guarda_usuario',$usuario->id], 'method' => 'post']) !!}
@else
    {!! Form::open(['route' => ['guarda_usuario']]) !!}
@endif
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Formulario de Usuario</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Nombre del Usuario:</label>
                    {!! Form::text('name', null, ['class' => 'form-control','placeholder' => 'Nombre del usuario','required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Email del Usuario:</label>
                    {!! Form::text('email', null, ['class' => 'form-control','placeholder' => 'Nombre del usuario','required']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::select('rol', ['Super Administrador' => 'Super Administrador','Administrador' => 'Administrador'],null, ['class' => 'form-control','placeholder' => 'Seleccione el Rol','required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::select('hotel_id', $hoteles,null, ['class' => 'form-control','placeholder' => 'Seleccione el Hotel']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Contraseña:</label>
                    {!! Form::input('password','password2', null, ['class' => 'form-control','placeholder' => 'Ingrese el nuevo password']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
    {!! Form::submit('Guardar', ['class' => 'btn btn-outline pull-left']) !!}
</div>
{!! Form::close() !!}


