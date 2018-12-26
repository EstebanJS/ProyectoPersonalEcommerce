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