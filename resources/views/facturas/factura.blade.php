@extends('layouts.app')

@section('content')
    <style>
        table.mitablar{
            width: 100%;
        }
    </style>
    <h1 class="pull-left"></h1>
    <a class="btn bg-navy btn-flat margin pull-right"  onclick="printDiv('printableArea')" style="margin-top: 25px" href="javascript:"> <i class="fa fa-print"></i> IMPRIMIR FACTURA</a>

    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>

    <div class="box">
        <div class="box-body" id="printableArea">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 35%;">

                    </td>
                    <td style="width: 30%;" align="center">

                    </td>
                    <td style="width: 35%;">
                        <table style="width: 100%;">
                            <tr>
                                <td>NIT:</td>
                                <td>{!! $factura->nit !!}</td>
                            </tr>
                            <tr>
                                <td>AUTORIZACION:</td>
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
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">LA PAZ, <?php echo $fecha ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Sr.(es).: <?php echo $factura->cliente ?></td>
                    <td style="width: 50%;">NIT: {!! $factura->nit !!}</td>
                </tr>
            </table>
            <div style="width: 100%" align="center">
                <span class="text-center text-bold">DETALLE DE FACTURA</span>
                @if(empty($flujo->descripcion))
                    <table class="table table-bordered">

                        <tbody>
                        <tr>
                            <td>
                                {!! $flujo->detalle !!}
                            </td>
                            <td>
                                {!! $flujo->ingreso !!}
                            </td>
                        </tr>
                        <tr>
                            <td><b>TOTAL: </b></td>
                            <td>{!! $flujo->ingreso !!}</td>
                        </tr>
                        </tbody>

                    </table>
                @else
                    {!! $flujo->descripcion !!}
                @endif
            </div>
            <!--
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">Concepto:</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width: 50%; text-align: center;"> SERVICIO DE HOSPEDAJE</td>
                    <td style="width: 20%;">Bs</td>
                    <td><?php //echo $factura->importetotal ?></td>
                </tr>
                <tr>
                    <td style="width: 50%; text-align: center;"> TOTAL:</td>
                    <td style="width: 20%;">Bs</td>
                    <td><?php //echo $factura->importetotal ?></td>
                </tr>
            </table>-->
            <table style="width: 100%;">
                <tr>
                    <td colspan="2">
                        SON: <?php echo $factura->montoliteral . ' con ' . $monto_decimales . ' BOLIVIANOS' ?> </td>
                </tr>

                <tr>
                    <td style="width: 45%;">CODIGO DE
                        CONTROL: <?php echo $factura->codigo_control ?></td>
                    <td>FECHA LIMITE DE EMISION:  <?php echo $factura->fecha_limite ?></td>
                </tr>
            </table>
            <br>
            <div style="text-align: center; font-size: 11px;">
                "ESTE RECIBO NO ES VÁLIDO PARA CREIDITO FISCAL"
            </div>
            <br>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%;">

                    </td>
                    <td>
                        <div id="codigoqr">

                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    @endsection




@push('scriptsextras')
<script src="{{ asset('/js/jquery.qrcode-0.10.0.js') }}"></script>
<script>
    var textoqr = "<?php echo $factura['Factura']['qr']; ?>";

    var opcionesQRejmeplar = {
        render: 'image'
        , size: 80
        , background: '#fdfdfd'
        , text: textoqr
    };
    var divSelector = '#codigoqr';
    $(divSelector).qrcode(opcionesQRejmeplar);
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endpush