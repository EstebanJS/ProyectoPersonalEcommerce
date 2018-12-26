<?php

require_once "../Controladores/productos.controlador.php";
require_once "../Modelos/productos.modelo.php";

class AjaxProductos{
    public $valor;
    public $item;
    public $ruta;

	public function ajaxVistaProducto(){
        $datos = array('valor' =>$this->valor , 'ruta' =>$this->ruta );
        $item = $this->item;
        $respuesta = ControladorProductos::ctrActualizarVistaProducto($datos,$item);
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
