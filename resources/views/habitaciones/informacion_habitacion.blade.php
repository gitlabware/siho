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
                            @if(isset($habitacion->registro))
                                {!! $habitacion->registro->fecha_ingreso !!}
                            @else
                                ----
                            @endif
                        </td>
                        <td><b>Fecha Salida:</b></td>
                        <td>
                            @if(isset($habitacion->registro))
                                {!! $habitacion->registro->fecha_salida !!}
                            @else
                                ----
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>


    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar</button>


</div>



