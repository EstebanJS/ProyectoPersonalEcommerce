<?php

require_once "../Modelos/rutas.php";
require_once "../Modelos/carrito.modelo.php";

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class Paypal{
    
    static public function mdlPagoPaypal($datos){
        
        require __DIR__ . '/bootstrap.php';
        
        $tituloArray = explode(",",$datos["tituloArray"]);
        $cantidadArray = explode(",",$datos["cantidadArray"]);
        $valorItemArray = explode(",",$datos["valorItemArray"]);
        $idProductos = str_replace(",","-",$datos["idProductoArray"]);
        $cantidadProductos = str_replace(",","-",$datos["cantidadArray"]);

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item = array();
        $variosItems = array();

        for($i = 0;$i < count($tituloArray);$i++){
            $item[$i] = new Item();
            $item[$i]->setName($tituloArray[$i])
                ->setCurrency($datos["divisa"])
                ->setQuantity($cantidadArray[$i])
                ->setPrice($valorItemArray[$i]/$cantidadArray[$i]);
                
                array_push($variosItems,$item[$i]);
        }

        $itemList = new ItemList();
        $itemList->setItems($variosItems);

        $details = new Details();
        $details->setShipping($datos["envio"])
            ->setTax($datos["impuesto"])
            ->setSubtotal($datos["subtotal"]);
        
        $amount = new Amount();
        $amount->setCurrency($datos["divisa"])
            ->setTotal($datos["total"])
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $url = Ruta::ctrRuta();
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$url//index.php?ruta=finalizar-compra&paypal=true&productos=".$idProductos."&cantidad=".$cantidadProductos)
            ->setCancelUrl("$url//carrito-de-compras");
        
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        
        try{
            $payment->create($apiContext);
        }catch(PayPal\Exception\PayPalConfigurationException $ex){
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
            return"$url//error";
        }
        foreach ($payment->getLinks() as $link) {
            if($link->getRel() == "approval_url"){
                $redirectUrl = $link->getHref();
            }
        }
        return $redirectUrl;
    }
}