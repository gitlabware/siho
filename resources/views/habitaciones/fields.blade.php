<!-- Hotel Id Field -->
<div class="form-group col-sm-6">
    {{--    {!! dd($pisosHotel) !!}--}}
    {!! Form::label('piso_id', 'Piso:') !!}
    {!! Form::select('piso_id', $pisosHotel,null, ['class' => 'form-control','placeholder' => 'Seleccione el piso','required']) !!}

</div>

<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('camas', 'Camas por habitacion:') !!}
    {!! Form::text('camas', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('categoria_id', 'Categoria:') !!}
    {!! Form::select('categoria_id', $categorias,null, ['class' => 'form-control','placeholder' => 'Seleccione la categoria','required']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::select('estado', ['Habilitado' => 'Habilitado','Deshabilitado' => 'Deshabilitado'],null, ['class' => 'form-control','placeholder' => 'Seleccione el estado']) !!}
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('pisosHotel',[$idHotel]) !!}" class="btn btn-default">Cancelar</a>
</div>
