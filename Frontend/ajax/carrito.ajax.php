<?php
require_once "../extensiones/paypal.controlador.php";
class AjaxCarrito{
    public $divisa;
	public $impuesto;
	public $total;
	public $envio;
	public $subtotal;
	public $tituloArray;
	public $cantidadArray;
	public $valorItemArray;
    public $idProductoArray;

    public function ajaxEnviarPaypal(){
        $datos = $arrayName = array(
           "divisa"=>$this->divisa,
           "impuesto"=>$this->impuesto,
           "total"=>$this->total,
           "envio"=>$this->envio,
           "subtotal"=>$this->subtotal,
           "tituloArray"=>$this->tituloArray,
           "cantidadArray"=>$this->cantidadArray,
           "valorItemArray"=>$this->valorItemArray,
           "idProductoArray"=>$this->idProductoArray         
        );

        $respuesta = Paypal::mdlPagoPaypal($datos);
        echo $respuesta;
    }
}
/*=======================================
METODO PAYPAL
=======================================*/
if(isset($_POST["divisa"])){
    $paypal = new AjaxCarrito();
    $paypal ->divisa = $_POST["divisa"];
	$paypal ->impuesto = $_POST["impuesto"];
	$paypal ->total = $_POST["total"];
	$paypal ->envio = $_POST["envio"];
	$paypal ->subtotal = $_POST["subtotal"];
	$paypal ->tituloArray = $_POST["tituloArray"];
	$paypal ->cantidadArray = $_POST["cantidadArray"];
	$paypal ->valorItemArray = $_POST["valorItemArray"];
    $paypal ->idProductoArray = $_POST["idProductoArray"];
    $paypal -> ajaxEnviarPaypal();
}