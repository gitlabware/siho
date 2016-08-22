<!-- Cliente Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente_id', 'Cliente Id:') !!}
    {!! Form::text('cliente_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Habitacione Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('habitacione_id', 'Habitacione Id:') !!}
    {!! Form::text('habitacione_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::text('estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Ingreso Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_ingreso', 'Fecha Ingreso:') !!}
    {!! Form::text('fecha_ingreso', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Salida Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_salida', 'Fecha Salida:') !!}
    {!! Form::text('fecha_salida', null, ['class' => 'form-control']) !!}
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::text('observacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Precio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('precio', 'Precio:') !!}
    {!! Form::text('precio', null, ['class' => 'form-control']) !!}
</div>

<!-- Monto Total Field -->
<div class="form-group col-sm-6">
    {!! Form::label('monto_total', 'Monto Total:') !!}
    {!! Form::text('monto_total', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('registros.index') !!}" class="btn btn-default">Cancel</a>
</div>
