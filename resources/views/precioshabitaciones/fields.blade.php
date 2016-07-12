<!-- Habitacione Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('habitacione_id', 'Habitacione Id:') !!}
    {!! Form::text('habitacione_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Precio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('precio', 'Precio:') !!}
    {!! Form::text('precio', null, ['class' => 'form-control']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    {!! Form::text('estado', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('precioshabitaciones.index') !!}" class="btn btn-default">Cancel</a>
</div>
