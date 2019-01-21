<?php

require_once "Controladores/plantilla.controlador.php";
require_once "Controladores/productos.controlador.php";
require_once "Controladores/slide.controlador.php";
require_once "Controladores/usuarios.controlador.php";
require_once "Controladores/carrito.controlador.php";


require_once "Modelos/plantilla.modelo.php";
require_once "Modelos/productos.modelo.php";
require_once "Modelos/slide.modelo.php";
require_once "Modelos/usuarios.modelo.php";
require_once "Modelos/carrito.modelo.php";

require_once "Modelos/rutas.php";

require_once "extensiones/PHPMailer/PHPMailerAutoload.php";
require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> plantilla();