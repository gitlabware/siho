@extends('layouts.app')

@section('content')
    <h1 class="pull-left">Facturas</h1>
    <a class="btn btn-primary pull-right" style="margin-top: 25px" href="{!! route('facturas.create') !!}">Add New</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="box">
        <div class="box-body table-responsive">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 35%;">

                    </td>
                    <td style="width: 30%;" align="center">

                    </td>
                    <td style="width: 35%;">
                        <table style="width: 100%;">
                            <tr>
                                <td>NIT: </td>
                                <td>{!! $factura->nit !!}</td>
                            </tr>
                            <tr>
                                <td>AUTORIZACION: </td>
                                <td>{!! $factura->autorizacion !!}</td>
                            </tr>
                            <tr>
                                <td>FACTURA</td>
                                <td>{!! $factura->numero !!}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table style="width: 100%;">
                <tr>
                    <td align="right" style="text-align: right">
                        Actividad Económica: Servicio de Hospedaje
                    </td>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="text-align: center;">
                        <h2>FACTURA</h2>
                    </td>
                </tr>
            </table>
        </div>
    </div>

@endsection