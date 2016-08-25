<!-- Hotel Id Field -->
<div class="form-group col-sm-6">
    {{--    {!! dd($pisosHotel) !!}--}}
    {!! Form::label('piso_id', 'Piso:') !!}

    <select name="piso_id" class="form-control">
        <?php foreach($pisosHotel as $p): ?>
        <option value="<?php echo $p->id; ?>"><?php echo $p->nombre; ?></option>
        <?php endforeach ?>
    </select>
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
    {!! Form::select('categoria_id', $categorias,null, ['class' => 'form-control','placeholder' => 'Seleccione la categoria']) !!}
</div>

<!-- Estado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estado', 'Estado:') !!}
    <select name="estado" class="form-control">
        <option value="habilitado">Habilitado</option>
        <option value="Deshabilitado">Deshabilitado</option>
    </select>
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
