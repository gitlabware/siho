<!-- Codigo Control Field -->
<div class="form-group col-sm-6">
    {!! Form::label('codigo_control', 'Codigo Control:') !!}
    {!! Form::text('codigo_control', null, ['class' => 'form-control']) !!}
</div>

<!-- Cliente Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cliente', 'Cliente:') !!}
    {!! Form::text('cliente', null, ['class' => 'form-control']) !!}
</div>

<!-- Nit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nit', 'Nit:') !!}
    {!! Form::text('nit', null, ['class' => 'form-control']) !!}
</div>

<!-- Nit P Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nit_p', 'Nit P:') !!}
    {!! Form::text('nit_p', null, ['class' => 'form-control']) !!}
</div>

<!-- Importetotal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('importetotal', 'Importetotal:') !!}
    {!! Form::text('importetotal', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha', 'Fecha:') !!}
    {!! Form::text('fecha', null, ['class' => 'form-control']) !!}
</div>

<!-- Fecha Limite Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fecha_limite', 'Fecha Limite:') !!}
    {!! Form::text('fecha_limite', null, ['class' => 'form-control']) !!}
</div>

<!-- Numero Field -->
<div class="form-group col-sm-6">
    {!! Form::label('numero', 'Numero:') !!}
    {!! Form::text('numero', null, ['class' => 'form-control']) !!}
</div>

<!-- Autorizacion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('autorizacion', 'Autorizacion:') !!}
    {!! Form::text('autorizacion', null, ['class' => 'form-control']) !!}
</div>

<!-- Qr Field -->
<div class="form-group col-sm-6">
    {!! Form::label('qr', 'Qr:') !!}
    {!! Form::text('qr', null, ['class' => 'form-control']) !!}
</div>

<!-- Montoliteral Field -->
<div class="form-group col-sm-6">
    {!! Form::label('montoliteral', 'Montoliteral:') !!}
    {!! Form::text('montoliteral', null, ['class' => 'form-control']) !!}
</div>

<!-- Created Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created', 'Created:') !!}
    {!! Form::text('created', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('facturas.index') !!}" class="btn btn-default">Cancel</a>
</div>
