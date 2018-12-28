<?php
class ControladorUsuarios{
    /*=============================================
    REGISTRO DE USUARIO
    =============================================*/
     public function ctrRegistroUsuario(){
        if(isset($_POST["regUsuario"])){
            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["regUsuario"]) && 
            preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["regEmail"]) &&
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["regPassword"])){
                $encriptar = crypt($_POST["regPassword"],'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $encriptarEmail =md5( $_POST["regEmail"]);
                $datos = array('nombre' => $_POST["regUsuario"] ,
                                'password' => $encriptar,
                                'email' => $_POST["regEmail"],
                                'foto' => "",
                                'modo' => "directo",
                                'verificacion' => 1,
                                'emailEncriptado' => $encriptarEmail);
                $tabla ="usuarios";
                $respuesta = ModeloUsuarios::mdlRegistroUsuarios($tabla,$datos);
                if($respuesta == "ok"){
                    /*=============================================
                    REGISTRO DE USUARIO
                    =============================================*/
                    date_default_timezone_set("America/Bogota");
                    $url = Ruta::ctrRuta();
                    $mail = new PHPMailer;
                    $mail ->CharSet = 'UTF_8';
                    $mail ->isMail();
                    $mail->setFrom('Teindavirtual@prueba.com','Yeisson Devloper');
                    $mail->addReplyTo('Teindavirtual@prueba.com','Yeisson Devloper');
                    $mail->Subject = "Por favor verifique su dierreción de correo electrónico";
                    $mail->addAddress($_POST["regEmail"]);
                    $mail->msgHTML('
                    <div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
                        <center>
                            <img style="padding:20px; width:10%" src="http://tutorialesatualcance.com/tienda/logo.png">
                        </center>
                        <div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
                            <center>
                                <img style="padding:20px; width:15%" src="http://tutorialesatualcance.com/tienda/icon-email.png">
                                <h3 style="font-weight:100; color:#999">VERIFIQUE SU DIRECCIÓN DE CORREO ELECTRÓNICO</h3>
                                <hr style="border:1px solid #ccc; width:80%">
                                <h4 style="font-weight:100; color:#999; padding:0 20px">Para comenzar a usar su cuenta de Tienda Virtual, debe confirmar su dirección de correo electrónico</h4>
                                <a href="'.$url.'verificar/'.$encriptarEmail.'" target="_blank" style="text-decoration:none">
                                    <div style="line-height:60px; background:#0aa; width:60%; color:white">Verifique su dirección de correo electrónico</div>
                                </a>
                                <br>
                                <hr style="border:1px solid #ccc; width:80%">
                                <h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>
                            </center>
                        </div>
                    </div>
                    ');
                    $envio = $mail->Send();
                    if(!$envio){
                        echo'<script>
                            swal({
                                title: "¡ERROR!",
                                text: "Ha ocurrido un error al enviar verificación de correo electronico a '.$_POST["regEmail"].$mail->ErrorInfo.'",
                                type:"error",
                                confirmButtonText:"Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                    history.back();
                                }
                                });
                            </script>';
                    }
                    else{
                        echo'<script>
                        swal({
                            title: "¡OK!",
                            text: "Le hemos enviado un correo a '.$_POST["regEmail"].' para verificar la cuenta, si no lo encunetra verifique la carpeta SPAM",
                            type:"success",
                            confirmButtonText:"Cerrar",
                            closeOnConfirm: false
                            },
                            function(isConfirm){
                            if(isConfirm){
                                history.back();
                            }
                            });
                        </script>';
                    }
                    
                }
            }
            else{
                echo'<script>
                swal({
                    title: "¡ERROR!",
                    text: "Caracteres invalidos",
                    type:"error",
                    confirmButtonText:"Cerrar",
                    closeOnConfirm: false
                    },
                    function(isConfirm){
                    if(isConfirm){
                        history.back();
                    }
                    });
                </script>';
            }
        }
    }
    /*=============================================
    MOSTAR USUARIO
    =============================================*/
    static public function ctrMostrarUsusario($item,$valor){
        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla,$item,$valor);
        return $respuesta;
    }
    /*=============================================
    ACTUALIZAR USUARIO
    =============================================*/
    static public function ctrActualizarUsuario($id,$item,$valor){
        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla,$id,$item,$valor);
        return $respuesta;
    }
    /*=============================================
    INGRESO DE USUARIO
    =============================================*/
    public function ctrIngresoUsuario(){
        if(isset($_POST["ingEmail"])){
            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["ingEmail"]) &&
            preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
                $encriptar = crypt($_POST["ingPassword"],'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $tabla = "usuarios";
                $item = "email";
                $valor = $_POST["ingEmail"];
                $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla,$item,$valor);
                if($respuesta["email"] == $_POST["ingEmail"] && $respuesta["password"]==$encriptar){
                    if($respuesta["verificacion"] == 1){
                        echo'<script>
                        swal({
                            title: "NO HA VERIFICADO SU CORREO ELECTRÓNICO!",
                            text: "Le hemos enviado un correo a '.$respuesta["email"].' para verificar la cuenta, si no lo encunetra verifique la carpeta SPAM",
                            type:"error",
                            confirmButtonText:"Cerrar",
                            closeOnConfirm: false
                            },
                            function(isConfirm){
                            if(isConfirm){
                                history.back();
                            }
                            });
                        </script>';
                    }
                    else{
                        $_SESSION["validarSesion"] = "ok";
                        $_SESSION["id"] = $respuesta["id"];
                        $_SESSION["nombre"] = $respuesta["nombre"];
                        $_SESSION["foto"] = $respuesta["foto"];
                        $_SESSION["email"] = $respuesta["email"];
                        $_SESSION["password"] = $respuesta["password"];
                        $_SESSION["modo"] = $respuesta["modo"];
                        echo '<script>
							
							window.location = localStorage.getItem("rutaActual");

						</script>';
                    }
                }
                else{
                    echo'<script>
                    swal({
                        title: "¡ERROR!",
                        text: "Al ingresar al sistema",
                        type:"error",
                        confirmButtonText:"Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){
                        if(isConfirm){
                            window.location = localStorage.getItem("rutaActual");
                        }
                        });
                    </script>';
                }
            }
            else{
                echo'<script>
                swal({
                    title: "¡ERROR!",
                    text: "Al ingresar al sistema ",
                    type:"error",
                    confirmButtonText:"Cerrar",
                    closeOnConfirm: false
                    },
                    function(isConfirm){
                    if(isConfirm){
                        history.back();
                    }
                    });
                </script>';
            }
        }
    }
    /*=============================================
    OLVIDO DE CONTRASEÑA
    =============================================*/
    static public function  ctrOlvidoPassword(){
        if(isset($_POST["passEmail"])){
            if(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["passEmail"])){
                /*=============================================
                GENERAR CONTRASEÑA ALEATORIA
                =============================================*/
                function generarPassword($longitud){
                    $key="";
                    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
                    $max = strlen($pattern)-1;
                    for($i = 0;$i < $longitud;$i++){
                        $key .= $pattern{mt_rand(0,$max)};
                    }
                    return $key;
                }
                $nuevaPassword = generarPassword(11);
                $encriptar = crypt($nuevaPassword,'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $tabla = "usuarios";
                $item1 = "email";
                $valor1 = $_POST["passEmail"];
                $respuesta1 = ModeloUsuarios::mdlMostrarUsuario($tabla,$item1,$valor1);
                if($respuesta1){
                    $id = $respuesta1["id"];
                    $item2 = "password";
                    $valor2= $encriptar;
                    $respuesta2 = ModeloUsuarios::mdlActualizarUsuario($tabla,$id,$item2,$valor2);
                    if($respuesta2 == "ok"){
                        /*=============================================
                        CAMBIO CONRASEÑA
                        =============================================*/
                        date_default_timezone_set("America/Bogota");
                        $url = Ruta::ctrRuta();
                        $mail = new PHPMailer;
                        $mail ->CharSet = 'UTF_8';
                        $mail ->isMail();
                        $mail->setFrom('Teindavirtual@prueba.com','Yeisson Devloper');
                        $mail->addReplyTo('Teindavirtual@prueba.com','Yeisson Devloper');
                        $mail->Subject = "Solicitud de nueva contraseña";
                        $mail->addAddress($_POST["passEmail"]);
                        $mail->msgHTML('
                            <div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
                                <center>
                                    <img style="padding:20px; width:10%" src="http://tutorialesatualcance.com/tienda/logo.png">
                                </center>
                                <div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
                                    <center>
                                        <img style="padding:20px; width:15%" src="http://tutorialesatualcance.com/tienda/icon-pass.png">
                                        <h3 style="font-weight:100; color:#999">SOLICITUD DE NUEVA CONTRASEÑA</h3>
                                        <hr style="border:1px solid #ccc; width:80%">
                                        <h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Su nueva contraseña :</strong>'.$nuevaPassword.'</h4>
                                        <a href="'.$url.'" target="_blank" style="text-decoration:none">
                                            <div style="line-height:60px; background:#0aa; width:60%; color:white">Ingresar</div>
                                        </a>
                                        <br>
                                        <hr style="border:1px solid #ccc; width:80%">
                                        <h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>
                                    </center>
                                </div>
                            </div>
                        ');
                        $envio = $mail->Send();
                        if(!$envio){
                            echo'<script>
                                swal({
                                    title: "¡ERROR!",
                                    text: "Ha ocurrido un error al enviar nueva contraseña al correo electronico '.$_POST["passEmail"].$mail->ErrorInfo.'",
                                    type:"error",
                                    confirmButtonText:"Cerrar",
                                    closeOnConfirm: false
                                    },
                                    function(isConfirm){
                                    if(isConfirm){
                                        history.back();
                                    }
                                    });
                                </script>';
                        }
                        else{
                            echo'<script>
                            swal({
                                title: "¡OK!",
                                text: "Le hemos enviado un correo a '.$_POST["passEmail"].' con una nueva contraseña, si no lo encunetra verifique la carpeta SPAM",
                                type:"success",
                                confirmButtonText:"Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                    history.back();
                                }
                                });
                            </script>';
                        }
                        
                    }
                    else{

                    }
                }
                else{
                    echo'<script>
                    swal({
                        title: "¡ERROR!",
                        text: "Correo no existe en el sistema",
                        type:"error",
                        confirmButtonText:"Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){
                        if(isConfirm){
                            history.back();
                        }
                        });
                    </script>';
                }
            }
            else{
                echo'<script>
                swal({
                    title: "¡ERROR!",
                    text: "Correo invalido",
                    type:"error",
                    confirmButtonText:"Cerrar",
                    closeOnConfirm: false
                    },
                    function(isConfirm){
                    if(isConfirm){
                        history.back();
                    }
                    });
                </script>';
            }
        }
    }
/*============================================================
  REGISTRO CON REDES SOCIALES                               
  ============================================================*/
  static public function ctrRegistroRedesSociales($datos){
    $tabla = "usuarios";
    $item="email";
    $valor = $datos["email"];
    $emailRepetido = false;
    $respuesta0 = ModeloUsuarios::mdlMostrarUsuario($tabla,$item,$valor);
    if($respuesta0){
        if($respuesta0["modo"] != $datos["modo"]){
            echo'<script>
            swal({
                title: "¡ERROR!",
                text: "El correo '.$datos["email"].' ya está registrado en el sistema con un método diferente a Google",
                type:"error",
                confirmButtonText:"Cerrar",
                closeOnConfirm: false
                },
                function(isConfirm){
                if(isConfirm){
                    history.back();
                }
                });
            </script>';
            $emailRepetido = false;

        }
        $emailRepetido = true;
    }
    else{
        $respuesta1 = ModeloUsuarios::mdlRegistroUsuarios($tabla,$datos);
    }
    if($emailRepetido ||$respuesta1 == "ok"){
        $respuesta2 = ModeloUsuarios::mdlMostrarUsuario($tabla,$item,$valor);
        if($respuesta2["modo"]=="facebook"){
            session_start();
            $_SESSION["validarSesion"] = "ok";
            $_SESSION["id"] = $respuesta2["id"];
            $_SESSION["nombre"] = $respuesta2["nombre"];
            $_SESSION["foto"] = $respuesta2["foto"];
            $_SESSION["email"] = $respuesta2["email"];
            $_SESSION["password"] = $respuesta2["password"];
            $_SESSION["modo"] = $respuesta2["modo"];
            echo "ok";
        }else if($respuesta2["modo"]=="google"){
            $_SESSION["validarSesion"] = "ok";
            $_SESSION["id"] = $respuesta2["id"];
            $_SESSION["nombre"] = $respuesta2["nombre"];
            $_SESSION["foto"] = $respuesta2["foto"];
            $_SESSION["email"] = $respuesta2["email"];
            $_SESSION["password"] = $respuesta2["password"];
            $_SESSION["modo"] = $respuesta2["modo"];
            
        }
        else{
            echo"";
        }
    }
  }
  /*=======================================
  ACTUALIZAR PERFIL
  =======================================*/
  public function ctrActualizarPerfil(){
    if(isset($_POST["editarNombre"])){
        /*=======================================
        VALIDAR IMAGEN
        =======================================*/
        $ruta="";
        if($_FILES["datosImagen"]["tmp_name"]){
            /*=======================================
            EXISTE OTRA IMAGEN EN LA BASE DE DATOS
            =======================================*/
            $directorio = "Vistas/img/usuarios/".$_POST["idUsuario"];
            if(!empty($_POST["fotoUsuario"])){
                unlink($_POST["fotoUsuario"]);
            }
            else{
                mkdir($directorio,0755);
            }
            /*=======================================
            PASAR IMAGEN A DIRECTORIO
            =======================================*/
            $aleatorio = mt_rand(100,999);
            $ruta = "Vistas/img/usuarios/".$_POST["idUsuario"]."/".$aleatorio.".jpg";
            /*=======================================
            TAMAÑO FOTO
            =======================================*/            
            list($ancho,$alto) = getimagesize($_FILES["datosImagen"]["tmp_name"]);
            $nuevoAncho = 500;
            $nuevoAlto = 500;
            $origen = imagecreatefromjpeg($_FILES["datosImagen"]["tmp_name"]);
            $destino = imagecreatetruecolor($nuevoAncho,$nuevoAlto);
            imagecopyresized($destino,$origen,0,0,0,0,$nuevoAncho,$nuevoAlto,$ancho,$alto);
            imagejpeg($destino,$ruta);
        }
        if($_POST["editarPassword"]==""){
            $password = $_POST["passUsuario"];
        }
        else{
            $password = crypt($_POST["editarPassword"],'$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        }
        $datos = array('nombre' => $_POST["editarNombre"], 
                       'email' => $_POST["editarEmail"], 
                       'password' => $password, 
                       'foto' => $ruta, 
                       'id' => $_POST["idUsuario"], 
                      );
        $tabla = "usuarios";
        $respuesta = ModeloUsuarios::mdlActualizarPerfil($tabla,$datos);
        if($respuesta =="ok"){
            $_SESSION["validarSesion"] = "ok";
            $_SESSION["id"] = $datos["id"];
            $_SESSION["nombre"] = $datos["nombre"];
            $_SESSION["foto"] = $datos["foto"];
            $_SESSION["email"] = $datos["email"];
            $_SESSION["password"] = $datos["password"];
            $_SESSION["modo"] = $_POST["modoUsuario"];
            echo'<script>
                            swal({
                                title: "¡OK!",
                                text: "Datos de la cuenta actualizados",
                                type:"success",
                                confirmButtonText:"Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                    history.back();
                                }
                                });
                            </script>';
        }
      }
  }
    /*=======================================
    MOSTRAR COMPRAS
    =======================================*/
    static public function ctrMostrarCompras($item,$valor){
        $tabla="compras";
        $respuesta = ModeloUsuarios::mdlMostrarCompras($tabla,$item,$valor);
        return $respuesta;
    }
    /*=======================================
    MOSTRAR COMENTARIOS PERFIL
    =======================================*/
    static public function ctrMostrarComentariosPerfil($datos){
        $tabla = "comentarios";
        $respuesta = ModeloUsuarios::mdlMostrarComentariosPerfil($tabla,$datos);
        return $respuesta;
    }
    /*=======================================
    ACTUALIZAR COMENTARIOS
    =======================================*/
    public function ctrActualizarComentario(){
        if(isset($_POST["idComentario"])){
            if(preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/',$_POST["comentario"])){
                if($_POST["comentario"] != ""){
                    $tabla="comentarios";
                    $datos = array("id"=>$_POST["idComentario"],
								   "calificacion"=>$_POST["puntaje"],
                                   "comentario"=>$_POST["comentario"]);
                    $respuesta = ModeloUsuarios::mdlActualizarComentario($tabla,$datos);
                    if($respuesta == "ok"){

						echo'<script>

								swal({
									  title: "¡GRACIAS POR COMPARTIR SU OPINIÓN!",
									  text: "¡Su calificación y comentario ha sido guardado!",
									  type: "success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
								},

								function(isConfirm){
										 if (isConfirm) {	   
										   history.back();
										  } 
								});

							  </script>';

					}
                }
                else{
                    echo'<script>

						swal({
							  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
							  text: "¡El comentario no puede estar vacío!",
							  type: "error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   history.back();
								  } 
						});

					  </script>';
                }
            }
            else{
                echo'<script>

					swal({
						  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
						  text: "¡El comentario no puede llevar caracteres especiales!",
						  type: "error",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							   history.back();
							  } 
					});

				  </script>';
            }
        }
    }
    /*=======================================
    AGREGAR A LISTA DE DESEOS
    =======================================*/
    static public function ctrAgregarDeseo($datos){
        $tabla = "deseos";
        $respuesta = ModeloUsuarios::mdlAgregarDeseo($tabla,$datos);
        return $respuesta;
    }
    /*=======================================
    MOSTRAR LISTA DE DESEOS
    =======================================*/
    static public function ctrMostrarDeseos($item){
        $tabla="deseos";
        $respuesta = ModeloUsuarios::mdlMostrarDeseos($tabla,$item);
        return $respuesta;
    }
    /*=======================================
    QUITAR PRODUCTO DE LISTA DESESOS
    =======================================*/
    static public function ctrQuitarDeseo($datos){
        $tabla="deseos";
        $respuesta = ModeloUsuarios::mdlQuitarDeseo($tabla,$datos);
        return $respuesta;
    }
    /*=============================================
	ELIMINAR USUARIO
	=============================================*/

	public function ctrEliminarUsuario(){

		if(isset($_GET["id"])){

			$tabla1 = "usuarios";		
			$tabla2 = "comentarios";
			$tabla3 = "compras";
			$tabla4 = "deseos";

			$id = $_GET["id"];

			if($_GET["foto"] != ""){

				unlink($_GET["foto"]);
				rmdir('vistas/img/usuarios/'.$_GET["id"]);

			}

			$respuesta = ModeloUsuarios::mdlEliminarUsuario($tabla1, $id);
			
			ModeloUsuarios::mdlEliminarComentarios($tabla2, $id);

			ModeloUsuarios::mdlEliminarCompras($tabla3, $id);

			ModeloUsuarios::mdlEliminarListaDeseos($tabla4, $id);

			if($respuesta == "ok"){

		    	$url = Ruta::ctrRuta();

		    	echo'<script>

						swal({
							  title: "¡SU CUENTA HA SIDO BORRADA!",
							  text: "¡Debe registrarse nuevamente si desea ingresar!",
							  type: "success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   window.location = "'.$url.'salir";
								  } 
						});

					  </script>';

		    }

		}

	}
} 

