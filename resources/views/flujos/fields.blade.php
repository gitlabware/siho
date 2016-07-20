<!-- Ingreso Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ingreso', 'Ingreso:') !!}
    {!! Form::text('ingreso', null, ['class' => 'form-control']) !!}
</div>

<!-- Salida Field -->
<div class="form-group col-sm-6">
    {!! Form::label('salida', 'Salida:') !!}
    {!! Form::text('salida', null, ['class' => 'form-control']) !!}
</div>

<!-- Detalle Field -->
<div class="form-group col-sm-6">
    {!! Form::label('detalle', 'Detalle:') !!}
    {!! Form::text('detalle', null, ['class' => 'form-control']) !!}
</div>

<!-- Observacion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observacion', 'Observacion:') !!}
    {!! Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => '5']) !!}
</div>


<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('flujos.index') !!}" class="btn btn-default">Cancel</a>
</div>
