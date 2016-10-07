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

                <table class="table table-bordered">

                    @foreach($habitacion->registrosactivos as $registro)
                        <?php
                        $color_reg = 'info';
                        $fechass = "";
                        if ($registro->estado == 'Ocupando') {
                            $color_reg = 'danger';
                            $fechass = $registro->fecha_ingreso;
                        } elseif ($registro->estado == 'Reservado') {
                            $color_reg = 'warning';
                            $fechass = $registro->fech_ini_reserva2 . ' - ' . $registro->fech_fin_reserva2;
                        }
                        ?>
                        <tr class="btn-{!! $color_reg !!}" style="cursor: pointer;" onclick="window.location.href = '{!! route('registrosgrupos',[$registro->grupo_id]) !!}';">
                            <td>{!! $registro->estado !!}</td>
                            <td>{!! $registro->grupo->nombre !!}</td>
                            <td>
                                {!! $fechass !!}
                            </td>
                            <td><b>{!! $registro->grupo->deudas !!} </b>Bs</td>
                        </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
</div>
{!! Form::open(['route' => ['habitaciones.destroy', $habitacion->id], 'method' => 'delete']) !!}
<div class="modal-footer">
    <?php
    $role = Auth::user()->rol;
    ?>
    @if($role != 'Operario')
        <a href="{!! route('habitaciones.edit', [$habitacion->id]) !!}" class='btn btn-outline pull-left'>Editar</a>
        <a href="{!! url('ingresaPrecio', [$habitacion->id]) !!}" class='btn btn-outline pull-left'>Precios</a>
        @if (isset($habitacion->registro_id))
            <a href="javascript:"
               onclick="cargarmodal('{!! route('nuevoregistro',[$habitacion->registro->cliente_id,$habitacion->id,$habitacion->registro_id]) !!}','warning')"
               class='btn btn-outline pull-left' title="Registro">Registro</a>
        @endif

        {!! Form::button('Eliminar', ['type' => 'submit', 'class' => 'btn btn-outline pull-left', 'onclick' => "return confirm('Esta seguro de eliminar?')"]) !!}
    @endif
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>
</div>
{!! Form::close() !!}