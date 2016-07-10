@extends('layouts.app')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Hotel: </h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="pisos-table" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Hotel</th>
                    <th>Hambientes</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Hambientes</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

@endsection
@push('datatablesjs')

<script>
    $(function() {
        $('#pisos-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.data') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'hotel_id', name: 'Hotel' },
                { data: 'nombre', name: 'habientes' }
            ]
        });
    });
</script>
@endpush