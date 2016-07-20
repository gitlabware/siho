@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-edit"></i>

                <h3 class="box-title">Buttons</h3>
            </div>
            <div class="box-body pad table-responsive">
                <p>Various types of buttons. Using the base class <code>.btn</code></p>
                <table class="table table-bordered text-center">
                    {{{ $c=0 }}}
                    @for($i=1; $i<=5; $i++)
                    {{{ $c++ }}}
                    <tr>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-lg">{!! $c !!}</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-lg">{!! $c !!}</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-lg">{!! $c !!}</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-lg">{!! $c !!}</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-lg">{!! $c !!}</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-block btn-success btn-lg">{!! $c !!}</button>
                        </td>
                    </tr>
                    @endfor

                </table>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.col -->
</div>
@endsection