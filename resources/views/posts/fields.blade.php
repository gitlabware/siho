<!-- Tiulo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tiulo', 'Tiulo:') !!}
    {!! Form::text('tiulo', null, ['class' => 'form-control']) !!}
</div>

<!-- Contenido Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contenido', 'Contenido:') !!}
    {!! Form::text('contenido', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('posts.index') !!}" class="btn btn-default">Cancel</a>
</div>
