<?php
    require_once "../Controladores/usuarios.controlador.php";
    require_once "../Modelos/usuarios.modelo.php";
    class AjaxUsuarios{
        public $validarEmail;
        /*=============================================
        VALIDAR EMAIL 
        =============================================*/
        
        public function ajaxValidarEmail(){
            $datos =$this->validarEmail; 
            $respuesta = ControladorUsuarios::ctrMostrarUsusario("email",$datos);
            echo json_encode($respuesta);
        }
        /*=============================================
        REGISTRO CON FACEBOOK
        =============================================*/
        public $email;
        public $nombre;
        public $foto;
        public function ajaxRegistroFacebook(){
            $datos = array('nombre' =>$this->nombre , 
                            'email' =>$this->email , 
                            'foto' =>$this->foto ,  
                            'password' =>"null" ,
                            'modo' =>"facebook" ,
                            'verificacion' =>"0" ,
                            'emailEncriptado' =>"null" 
            );
            $respuesta = ControladorUsuarios::ctrRegistroRedesSociales($datos);
            echo $respuesta;
        }
        /*=============================================
        AGREGAR LISTA DE DESEOS
        =============================================*/
        public $idUsuario;
        public $idProducto;
        public function ajaxAgregarDeseo(){
            $datos = array("idUsuario" =>$this->idUsuario,"idProducto" =>$this->idProducto );
            $respuesta = ControladorUsuarios::ctrAgregarDeseo($datos);
            echo $respuesta;
        }
        /*=============================================
        QUITAR DE LISTA DE DESEOS
        =============================================*/
        public $idDeseo;
        public function ajaxQuitarDeseo(){
            $datos = $this->idDeseo;
            $respuesta = ControladorUsuarios::ctrQuitarDeseo($datos);
            echo $respuesta;
        }

    }
/*=============================================
VALIDAR EMAIL 
=============================================*/
if(isset($_POST["validarEmail"])){
    $valEmail = new AjaxUsuarios();
    $valEmail -> validarEmail = $_POST["validarEmail"];
    $valEmail -> ajaxValidarEmail();
}
/*=============================================
 REGISTRO CON FACEBOOK
=============================================*/
if(isset($_POST["email"])){
    $regFacebook = new AjaxUsuarios();
    $regFacebook -> email = $_POST["email"];
    $regFacebook -> nombre = $_POST["nombre"];
    $regFacebook -> foto = $_POST["foto"];
    $regFacebook -> ajaxRegistroFacebook();
}
/*=============================================
AGREGAR LISTA DE DESEOS
============================================*/
if(isset($_POST["idUsuario"])){
    $deso = new AjaxUsuarios();
    $deso -> idUsuario = $_POST["idUsuario"];
    $deso -> idProducto = $_POST["idProducto"];
    $deso -> ajaxAgregarDeseo();
}
/*=============================================
QUITAR DE LISTA DE DESEOS
=============================================*/
if(isset($_POST["idDeseo"])){
    $quitarDeso = new AjaxUsuarios();
    $quitarDeso -> idDeseo = $_POST["idDeseo"];
    $quitarDeso -> ajaxQuitarDeseo();
}