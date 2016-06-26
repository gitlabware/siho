<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>

<!-- Telefonos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefonos', 'Telefonos:') !!}
    {!! Form::text('telefonos', null, ['class' => 'form-control']) !!}
</div>
<br>
<div class="row">
<!-- Pisos Field -->
<div class="form-group col-sm-4">
    {!! Form::label('pisos', 'Pisos:') !!}
    {!! Form::number('pisos', null, ['class' => 'form-control']) !!}
</div>

<!-- Habitaciones Field -->
<div class="form-group col-sm-4">
    {!! Form::label('habitaciones', 'Habitaciones:') !!}
    {!! Form::text('habitaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Camas Field -->
<div class="form-group col-sm-4">
    {!! Form::label('camas', 'Camas:') !!}
    {!! Form::number('camas', null, ['class' => 'form-control']) !!}
</div>
</div>
<!-- Observaciones Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('hotels.index') !!}" class="btn btn-default">Cancel</a>
</div>
