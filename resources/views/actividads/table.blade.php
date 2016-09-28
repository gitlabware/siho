<div class="box">
    <div class="box-body table-responsive">
        <table class="table table-responsive" id="actividads-table">
            <thead>
            <th>Cliente Id</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Descripcion</th>
            <th colspan="3">Action</th>
            </thead>
            <tbody>
            @foreach($actividads as $actividad)
                <tr
                        @if($actividad->fecha > date('Y-m-d H:s:i'))
                        class="info"
                        @endif
                >
                    <td>{!! $actividad->cliente_id !!}</td>
                    <td>{!! $actividad->fecha !!}</td>
                    <td>{!! $actividad->cliente->nombre !!}</td>
                    <td>{!! $actividad->descripcion !!}</td>
                    <td>
                        {!! Form::open(['route' => ['actividads.destroy', $actividad->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="javascript:" onclick="cargarmodal('{!!route('actividad',[$actividad->cliente_id,$actividad->id])!!}','info')" class='btn btn-default btn-xs'><i
                                        class="glyphicon glyphicon-edit"></i></a>
                            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>