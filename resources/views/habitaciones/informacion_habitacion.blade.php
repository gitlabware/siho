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
                    <tr>
                        <td><b>Categoria:</b></td>
                        <td>
                            @if(isset($habitacion->categoria->nombre))
                                {!! $habitacion->categoria->nombre !!}
                            @endif
                        </td>
                        <td><b></b></td>
                        <td></td>
                    </tr>
                </table>


                @foreach($habitacion->registrosactivos as $registro)
                    <?php
                    $color_reg = 'info';
                    if ($registro->estado == 'Ocupando') {
                        $color_reg = 'danger';
                    }
                    ?>
                    @if(!empty($registro->num_reg))
                        <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:"
                           onclick="cargarmodal('{!! route('nuevos',[$registro->cliente_id,$registro->num_reg]) !!}')">
                            {{ $registro->estado.' '.$registro->cliente->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                        </a>
                    @else
                        <a class="btn btn-block btn-{!! $color_reg !!} btn-xs" href="javascript:"
                           onclick="cargarmodal('{!! route('nuevoregistro',[$registro->cliente_id,$registro->habitacione_id,$registro->id]) !!}')">
                            {{ $registro->estado.' '.$registro->cliente->nombre.' '.$registro->fecha_ingreso.' - '.$registro->fecha_salida }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
{!! Form::open(['route' => ['hotels.destroy', $habitacion->id], 'method' => 'delete']) !!}
<div class="modal-footer">
    <a href="{!! route('habitaciones.edit', [$habitacion->id]) !!}" class='btn btn-outline pull-left'>Editar</a>
    <a href="{!! url('ingresaPrecio', [$habitacion->id]) !!}" class='btn btn-outline pull-left'>Precios</a>
    @if (isset($habitacion->registro_id))
        <a href="javascript:"
           onclick="cargarmodal('{!! route('nuevoregistro',[$habitacion->registro->cliente_id,$habitacion->id,$habitacion->registro_id]) !!}','warning')"
           class='btn btn-outline pull-left' title="Registro">Registro</a>
    @endif

    {!! Form::button('Eliminar', ['type' => 'submit', 'class' => 'btn btn-outline pull-left', 'onclick' => "return confirm('Esta seguro de eliminar?')"]) !!}

    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::close() !!}