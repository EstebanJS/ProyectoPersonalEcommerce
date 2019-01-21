<?php

require_once "../Controladores/productos.controlador.php";
require_once "../Modelos/productos.modelo.php";

class AjaxProductos{
    public $valor;
    public $item;
    public $ruta;

	public function ajaxVistaProducto(){
        
        $valor1 = $this->valor;
        $item1 = $this->item;
        $valor2 = $this->ruta;
        $item2 ="ruta";
        
        $respuesta = ControladorProductos::ctrActualizarProducto($item1,$valor1,$item2,$valor2);
		echo $respuesta;
	}


}
if(isset($_POST["item"])){
    $vista = new AjaxProductos();
    $vista -> valor = $_POST["valor"];
    $vista -> item = $_POST["item"];
    $vista -> ruta = $_POST["ruta"];
    $vista -> ajaxVistaProducto();
}
