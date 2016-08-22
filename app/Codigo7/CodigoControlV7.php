<?php
namespace App\Codigo7;

require_once('AllegedRC4.php');
require_once('Verhoeff.php');

//App::uses('ParametrosFactura', 'Model');
//App::uses('Factura', 'Model');
class CodigoControlV7
{
    /*public function datosgenera($nitci, $monto,$nombre_empresa = "",$nombre_comprador = "") {
        $fecha = date('Y-m-d');
        $modelo = new ParametrosFactura();
        $mfactura = new Factura();
        $pfactura = $modelo->find('first', array('order' => 'ParametrosFactura.id DESC'));
        $numero = 1;
        if(!empty($pfactura['ParametrosFactura']['numero_ref']))
        {
            $numero = $pfactura['ParametrosFactura']['numero_ref'];
        }

        $rcodigo = array();
        if (!empty($pfactura)) {
            if (!empty($pfactura['ParametrosFactura']['fechalimite'])) {
                if ($pfactura['ParametrosFactura']['fechalimite'] >= $fecha && !empty($pfactura['ParametrosFactura']['numero_autorizacion']) && !empty($pfactura['ParametrosFactura']['llave']) && !empty($pfactura['ParametrosFactura']['nit'])) {
                    $codigo_control = $this->generar($pfactura['ParametrosFactura']['numero_autorizacion'],$numero,$nitci,ereg_replace("[-]", "", $fecha),round($monto),$pfactura['ParametrosFactura']['llave']);
                    if(!empty($codigo_control))
                    {
                        $mfactura->create();
                        $this->request->data['Factura']['nit'] = $nitci;
                        $this->request->data['Factura']['importetotal'] = $monto;
                        $this->request->data['Factura']['fecha'] = $fecha;
                        $this->request->data['Factura']['codigo_control'] = $codigo_control;
                        $this->request->data['Factura']['numero'] = $numero;
                        $this->request->data['Factura']['autorizacion'] = $pfactura['ParametrosFactura']['numero_autorizacion'];
                        if($mfactura->save($this->request->data['Factura']))
                        {
                            $modelo->create();
                            $this->request->data['ParametrosFactura']['id'] = $pfactura['ParametrosFactura']['id'];
                            $this->request->data['ParametrosFactura']['numero_ref'] = $numero+1;
                            $modelo->save($this->request->data['ParametrosFactura']);

                            $rcodigo['codigo'] = $codigo_control;
                            $rcodigo['numero_autorizacion'] = $pfactura['ParametrosFactura']['numero_autorizacion'];
                            $rcodigo['nit'] = $pfactura['ParametrosFactura']['nit'];
                            $rcodigo['fechalimite'] = $pfactura['ParametrosFactura']['fechalimite'];
                            $rcodigo['numero'] = $this->request->data['Factura']['numero'];

                            $fechalimite = split("-", $rcodigo['fechalimite']);
                            $nfechalimite = $fechalimite[2]."/".$fechalimite[1]."/".$fechalimite[0];
                            $rcodigo['qr'] = $pfactura['ParametrosFactura']['nit']."|".$nombre_empresa."|"
                                    .$rcodigo['numero']."|".$rcodigo['numero_autorizacion']."|".date('d/m/Y')."|".
                                    $monto."|".$codigo_control."|".$nfechalimite."|".$nitci."|".$nombre_comprador;
                        }
                    }
                }
            }
        }
        return $rcodigo;
    }*/
	public static function generar($numautorizacion, $numfactura, $nitcliente, $fecha, $monto, $clave)
	{
		$numfactura = self::appendVerhoeff($numfactura, 2);
		$nitcliente = self::appendVerhoeff($nitcliente, 2);
		$fecha = self::appendVerhoeff($fecha, 2);
		$monto = self::appendVerhoeff($monto, 2);
		$suma = $numfactura + $nitcliente + $fecha + $monto;
		$suma = self::appendVerhoeff($suma, 5);
		$dv = substr($suma, -5);
		$cads = array($numautorizacion, $numfactura, $nitcliente, $fecha, $monto);
		$msg = '';
		$p = 0;
		for ($i=0; $i<5; $i++)
		{
			$msg .= $cads[$i] . substr($clave, $p, 1+$dv[$i]);
			$p += 1 + $dv[$i];
		}
		$codif = AllegedRC4::encode($msg, $clave.$dv);
		$st = 0;
		$sp = array(0,0,0,0,0);
		$codif_length = strlen($codif);
		for ($i=0; $i<$codif_length; $i++)
		{
			$st += ord($codif[$i]);
			$sp[$i%5] += ord($codif[$i]);
		}
		$stt = 0;
		for ($i=0; $i<5; $i++)
			$stt += (int)(($st * $sp[$i]) / (1 + $dv[$i]));

		return implode('-', str_split(AllegedRC4::encode(self::base64($stt), $clave.$dv), 2));
	}
	public static function base64($n)
	{
		$d = array(
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 
			'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 
			'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd', 
			'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 
			'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 
			'y', 'z', '+', '/' );
		$c = 1; $r = '';
		while ($c > 0)
		{
			$c = (int)($n / 64);
			$r = $d[$n%64] . $r;
			$n = $c;
		}
		return $r;
	}
	public static function appendVerhoeff($n, $c)
	{
		for (;$c>0; $c--) $n .= Verhoeff::get($n);
		return $n;
	}
}