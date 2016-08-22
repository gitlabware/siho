<div class="box">
    <div class="box-body table-responsive">
        <table class="table table-responsive table-bordered" id="categorias-table">
            <thead>
            <th>Nombre</th>
            <th colspan="3">Action</th>
            </thead>
            <tbody>
            @foreach($categorias as $categoria)
                <tr>
                    <td>{!! $categoria->nombre !!}</td>
                    <td>
                        {!! Form::open(['route' => ['categorias.destroy', $categoria->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>

                            <a href="{!! route('categorias.edit', [$categoria->id]) !!}" class='btn btn-default btn-xs'><i
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
