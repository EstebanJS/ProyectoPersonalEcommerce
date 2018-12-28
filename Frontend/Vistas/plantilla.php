<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="title" content="Tienda Virtual">
	<meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam accusantium enim esse eos officiis sit officia">
	<meta name="keyword" content="Lorem ipsum, dolor sit amet, consectetur, adipisicing, elit, Quisquam, accusantium, enim, esse">

	<title>Tienda Virtual</title>

	<?php
		session_start();
		$servidor = Ruta::ctrRutaServidor();
		$icono = ControladorPlantilla::ctrEstiloPlantilla();
		echo '<link rel="icon" href="'.$servidor.$icono["icono"].'">
		';
		/*=============================================
		MANTENER LA RUTA FIJA DEL PROYECTO
		=============================================*/
		$url = Ruta::ctrRuta();
	?>
	<!--=============================================
	PLUGINS DE CSS
	=============================================-->
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/plugins/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/plugins/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/plugins/flexslider.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/plugins/sweetalert.css">

	<!--=============================================
	HOJAS DE ESTILOS PERSONALIZADAS
	=============================================-->
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/plantilla.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/cabezote.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/slide.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/productos.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/infoproducto.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/perfil.css">
	<link rel="stylesheet" href="<?php echo $url?>Vistas/css/carrito-de-compras.css">
	<!--=============================================
	PLGINS DE JAVASCRIPT
	=============================================-->
	<script src="<?php echo $url?>Vistas/js/plugins/jquery.min.js"></script>
	<script src="<?php echo $url?>Vistas/js/plugins/bootstrap.min.js"></script>
	<script src="<?php echo $url?>Vistas/js/plugins/jquery.easing.js"></script>
	<script src="<?php echo $url?>Vistas/js/plugins/jquery.scrollUp.js"></script>
	<script src="<?php echo $url?>Vistas/js/plugins/jquery.flexslider.js"></script>
	<script src="<?php echo $url?>Vistas/js/plugins/sweetalert.min.js"></script>
	
</head>
<body>
	<?php
		/*=============================================
		CABEZOTE
		=============================================*/
		include "modulos/cabezote.php";
		/*=============================================
		CONTENIDO DINAMICO
		=============================================*/
		$rutas = array();
		$ruta = null;
		$infoproducto = null;
		if(isset($_GET["ruta"])){
			$rutas = explode("/",$_GET["ruta"]);
			$item = "ruta";
			$valor = $rutas[0];
		/*=============================================
		URL´S AMIGABLES DE CATEGORIAS
		=============================================*/
			$rutaCategorias = ControladorProductos::ctrMostrarCategorias($item,$valor);
			if($valor == $rutaCategorias["ruta"]){
				$ruta = $valor;
			}
		/*=============================================
		URL´S AMIGABLES DE SUBCATEGORIAS
		=============================================*/
			$rutaSubCategorias = ControladorProductos::ctrMostrarSubCategorias($item,$valor);
			foreach ($rutaSubCategorias as $key => $value) {
				if($valor == $value["ruta"]){
					$ruta = $valor;
				}
			}
		/*=============================================
		URL´S AMIGABLES DE PRODUCTOS
		=============================================*/
		$rutaProductos = ControladorProductos::ctrMostrarInfoProducto($item,$valor);
		if($valor == $rutaProductos["ruta"]){
			$infoproducto = $valor;
		}
		/*=============================================
		LISTA BLANCA DE URL´S AMIGABLES
		=============================================*/
			if($ruta != null || $rutas[0] == "articulos-gratis" || $rutas[0] == "lo-mas-vendido" || $rutas[0] == "lo-mas-visto"){
				
				include "modulos/productos.php";
			}
			else if($infoproducto != null){
				include "modulos/infoproducto.php";
				
			}
			else if ($rutas[0]=="buscador" || $rutas[0]=="verificar" || $rutas[0]=="salir" || $rutas[0]=="perfil" || $rutas[0]=="carrito-de-compras" ) {
				include "modulos/".$rutas[0].".php";
			}
			else{
				include "modulos/error404.php";
			}
		}
		else{
			include "modulos/slide.php";
			include "modulos/destacados.php";

		}
	?>
	 <input type="hidden" value="<?php echo $url?>" id="rutaOculta">
	<!--=============================================
	JAVASCRIPT PERSONALIZADAS
	=============================================-->
	<script src="<?php echo $url?>Vistas/js/cabezote.js"></script>
	<script src="<?php echo $url?>Vistas/js/plantilla.js"></script>
	<script src="<?php echo $url?>Vistas/js/slide.js"></script>
	<script src="<?php echo $url?>Vistas/js/buscador.js"></script>
	<script src="<?php echo $url?>Vistas/js/infoproducto.js"></script>
	<script src="<?php echo $url?>Vistas/js/usuarios.js"></script>
	<script src="<?php echo $url?>Vistas/js/registroFacebook.js"></script>
	<script src="<?php echo $url?>Vistas/js/carrito-de-compras.js"></script>
	<script>
		window.fbAsyncInit = function() {
			FB.init({
			appId      : '210464019699801',
			cookie     : true,
			xfbml      : true,
			version    : 'v3.1'
			});
			
			FB.AppEvents.logPageView();   
			
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "https://connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

</body>
</html>