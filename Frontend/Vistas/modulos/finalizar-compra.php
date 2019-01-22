<?php
$url = Ruta::ctrRuta();
if(!isset($_SESSION["validarSesion"])){
    echo '<script>window.location = "'.$url.'";</script>';
    exit();
}

require 'extensiones/bootstrap.php';
require_once "Modelos/carrito.modelo.php";

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

/*=============================================
PAGO PAYPAL
=============================================*/
if(isset( $_GET['paypal']) && $_GET['paypal'] === 'true'){
    $productos = explode("-", $_GET['productos']);
    $cantidad = explode("-", $_GET['cantidad']);

    $paymentId = $_GET['paymentId'];

    $payment = Payment::get($paymentId, $apiContext);

    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    $payment->execute($execution, $apiContext);

    $datosTransaccion = $payment->toJSON();
    $datosUsuario =json_decode($datosTransaccion);
    $emailComprador = $datosUsuario->payer->payer_info->email;
    $dir = $datosUsuario->payer->payer_info->shipping_address->line1;
    $ciudad = $datosUsuario->payer->payer_info->shipping_address->city;
    $estado = $datosUsuario->payer->payer_info->shipping_address->state;
    $codigoPostal = $datosUsuario->payer->payer_info->shipping_address->postal_code;
    $pais = $datosUsuario->payer->payer_info->shipping_address->country_code;
    $direccion = $dir.", ".$ciudad.", ".$estado.", ".$codigoPostal;

    for($i = 0;$i < count($productos);$i++){
        $datos = array("idUsuario"=>$_SESSION["id"],
                    "idProducto"=>$productos[$i],
                    "metodo"=>"paypal",
                    "email"=>$emailComprador,
   					"direccion"=>$direccion,
   					"pais"=>$pais
                    );
                    
        $respuesta = ControladorCarrito::ctrNuevasCompras($datos);
        $ordenar = "id";
        $item = "id";
        $valor = $productos[$i];
        $productosCompra = ControladorProductos::ctrListarProductos($ordenar,$item,$valor);
        foreach ($productosCompra as $key => $value) {
            $item1 = "ventas";
            $valor1 = $value["ventas"]+$cantidad[$i];
            $item2= "id";
            $valor2 = $value["id"];
            $actualizarCompra=ControladorProductos::ctrActualizarProducto($item1,$valor1,$item2,$valor2);
        }
        if($respuesta == "ok" && $actualizarCompra == "ok"){
            echo '<script>
                    localStorage.removeItem("listaProductos");
                    localStorage.removeItem("cantidadCesta");
                    localStorage.removeItem("sumaCesta");
                    window.location = "'.$url.'perfil";
                </script>';
        }
    }
}
/*=============================================
PAGO PAYU
=============================================*/
else if(isset($_GET['payu']) && $_GET['payu'] === 'true'){
    $respuesta = ControladorCarrito::ctrMostrarTarifas();
    $ApiKey = $respuesta["apiKeyPayu"];
    $merchant_id = $_REQUEST['merchantId'];
    $referenceCode = $_REQUEST['referenceCode'];
    $TX_VALUE = $_REQUEST['TX_VALUE'];
    $New_value = number_format($TX_VALUE, 1, '.', '');
    $currency = $_REQUEST['currency'];
    $transactionState = $_REQUEST['transactionState'];
    $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
    $firmacreada = md5($firma_cadena);
    $firma = $_REQUEST['signature'];
    $reference_pol = $_REQUEST['reference_pol'];
    $cus = $_REQUEST['cus'];
    $extra1 = $_REQUEST['description'];
    $pseBank = $_REQUEST['pseBank'];
    $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
    $transactionId = $_REQUEST['transactionId'];

    if ($_REQUEST['transactionState'] == 4 ) {
    	$estadoTx = "Transacción aprobada";
    }

    else if ($_REQUEST['transactionState'] == 6 ) {
        $estadoTx = "Transacción rechazada";
    }

    else if ($_REQUEST['transactionState'] == 104 ) {
        $estadoTx = "Error";
    }

    else if ($_REQUEST['transactionState'] == 7 ) {
        $estadoTx = "Transacción pendiente";
    }

    else {
        $estadoTx=$_REQUEST['mensaje'];
    }

    if (strtoupper($firma) == strtoupper($firmacreada) && $estadoTx == "Transacción aprobada") {
        $productos = explode("-",$_GET["productos"]);
        $cantidad = explode("-",$_GET["cantidad"]);
        for($i = 0;$i < count($productos);$i++){
            $datos = array("idUsuario"=>$_SESSION["id"],
                        "idProducto"=>$productos[$i],
                        "metodo"=>"payu",
                        "email"=>$_REQUEST['buyerEmail'],
                        "direccion"=>"",
                        "pais"=>""
                        );
                        
            $respuesta = ControladorCarrito::ctrNuevasCompras($datos);
            $ordenar = "id";
            $item = "id";
            $valor = $productos[$i];
            $productosCompra = ControladorProductos::ctrListarProductos($ordenar,$item,$valor);
            foreach ($productosCompra as $key => $value) {
                $item1 = "ventas";
                $valor1 = $value["ventas"]+$cantidad[$i];
                $item2= "id";
                $valor2 = $value["id"];
                $actualizarCompra=ControladorProductos::ctrActualizarProducto($item1,$valor1,$item2,$valor2);
            }
            if($respuesta == "ok" && $actualizarCompra == "ok"){
                echo '<script>
                        localStorage.removeItem("listaProductos");
                        localStorage.removeItem("cantidadCesta");
                        localStorage.removeItem("sumaCesta");
                        window.location = "'.$url.'perfil";
                    </script>';
            }
        }
    }
}
else{

}