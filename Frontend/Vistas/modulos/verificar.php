<!--=============================================
VERIFICAR
=============================================-->
<?php
    $usuarioVerfifcado = false;    
    $item = "emailEncriptado";
    $valor = $rutas[1];
    $respusta = ControladorUsuarios::ctrMostrarUsusario($item,$valor);
    if($valor == $respusta["emailEncriptado"]){
        $id = $respusta["id"];
        $item2 = "verificacion";
        $valor2 = 0;
        $respusta2 = ControladorUsuarios::ctrActualizarUsuario($id,$item2,$valor2);
        if($respusta2 == "ok"){
            $usuarioVerfifcado = true;
        }
    }
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center verificar">
        <?php
            if($usuarioVerfifcado){
                echo '
                <h3>Gracias</h3>
                <h2><small>Hemos verificado su correo electrónico, ya puede ingresar al sistema</small></h2>
                <br>
                <a href="#modalIngreso" data-toggle="modal"><button class="btn btn-default backColor btn-lg">INGRESAR</button></a>
                ';
            }
            else{
                echo'
                <h3>Error</h3>
                <h2><small>No se ha podido verififcar el correo electrónico, vuelva a registrarse</small></h2>
                <br>
                <a href="#modalRegistro" data-toggle="modal"><button class="btn btn-default backColor btn-lg">REGISTRO</button></a>
                ';
            }
        ?>
        </div> 
    </div>
</div>