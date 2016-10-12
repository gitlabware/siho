<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">Formulario de Registro</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12" style="font-size: 15px;">
                @foreach($habitaciones as $habitacion)
                    |{!! $habitacion->nombre !!}|
                @endforeach
            </div>
        </div>
        {!! Form::open(['route' => ['guarda_precio_h'],'id' => 'form-add-precio']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::hidden('precio',null,['id' => 'totaltotal']) !!}
                    {!! Form::text('precio', null, ['class' => 'form-control','placeholder' => 'Nuevo Precio','step' => 'any','type' => 'number','min' => 0,'required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button type="submit" class="btn btn-outline btn-block"><i class="fa fa-plus"></i> Add Precio
                    </button>
                </div>
            </div>
        </div>
         @foreach($habitaciones as $habitacion)
             <input type="hidden" name="habitaciones[{!! $habitacion->id !!}][valor]">
        @endforeach
        {!! Form::close() !!}

        {!! Form::open(['route' => ['guarda_precio_h'],'id' => 'form-add-sss']) !!}
        <!--<div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::select('caja_id', [],null, ['class' => 'form-control caja','required','id' =>
                    'ccaja']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <button type="button" class="btn btn-outline btn-block"><i class="fa fa-save"></i> Cambiar categoria
                    </button>
                </div>
            </div>
        </div>-->
        {!! Form::close() !!}
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Precios en comun</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($precios as $precio)
                        <tr>
                            <td>{!! $precio->precio !!}</td>
                            <td>
                                {!! Form::open(['route' => ['elimina_precio_h']]) !!}
                                @foreach($habitaciones as $habitacion)
                                    <input type="hidden" name="habitaciones[{!! $habitacion->id !!}][valor]" >
                                @endforeach
                                {!! Form::hidden('precio',$precio->precio) !!}
                                <div class='btn-group'>
                                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Esta seguro de eliminar el precio en las habitaciones?')"]) !!}
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('user_id',Auth::user()->id) !!}
<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>


