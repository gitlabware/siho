<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title">{!! $habitacion->nombre !!}</h4>
</div>

<div class="modal-body">
    <div class="form-group">
        <div class="row">
            <div class="col-md-12" style="font-size: 15px;">
                <table class="table table-bordered">
                    <tr>
                        <td><b>Habitacion:</b></td>
                        <td>{!! $habitacion->nombre !!}</td>
                        <td><b>Piso:</b></td>
                        <td>{!! $habitacion->rpiso->nombre !!}</td>
                    </tr>
                </table>
                @if(isset($habitacion->registro))
                <table class="table table-bordered">
                    <tr>
                        <td><b>Cliente:</b></td>
                        <td>
                            @if(isset($habitacion->registro->cliente))
                                {!! $habitacion->registro->cliente->nombre !!}
                            @else
                                No hay cliente!!
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Pago:</b></td>
                        <td>
                            @if(isset($habitacion->registro->flujo))
                                {!! $habitacion->registro->monto_total.' en '.$habitacion->registro->flujo->caja->nombre !!}
                            @endif
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered">
                    <tr>
                        <td><b>Fecha Ingreso:</b></td>
                        <td>
                            {!! $habitacion->registro->fecha_ingreso !!}
                        </td>
                        <td><b>Fecha Salida:</b></td>
                        <td>
                            {!! $habitacion->registro->fecha_salida !!}
                        </td>
                    </tr>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
{!! Form::open(['route' => ['hotels.destroy', $habitacion->id], 'method' => 'delete']) !!}
<div class="modal-footer">
    <a href="{!! route('habitaciones.edit', [$habitacion->id]) !!}" class='btn btn-outline pull-left'>Editar</a>
    <a href="{!! url('ingresaPrecio', [$habitacion->id]) !!}" class='btn btn-outline pull-left'>Precios</a>
    @if (isset($habitacion->registro_id))
        <a href="javascript:" onclick="cargarmodal('{!! route('nuevoregistro',[$habitacion->registro->cliente_id,$habitacion->id,$habitacion->registro_id]) !!}','warning')" class='btn btn-outline pull-left' title="Registro">Registro</a>
    @endif

    {!! Form::button('Eliminar', ['type' => 'submit', 'class' => 'btn btn-outline pull-left', 'onclick' => "return confirm('Esta seguro de eliminar?')"]) !!}

    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::close() !!}