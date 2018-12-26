<!--============================================================
    VALIDAR SESION
    ============================================================-->
<?php
    $url = Ruta::ctrRuta();
    $servidor = Ruta::ctrRutaServidor();
    if(!isset($_SESSION["validarSesion"])){
        echo'
        <script>
            window.location = "'.$url.'";
        </script>
        ';
        exit();
    }
?>  
<!--=====================================
BREADCRUMB PERFIL 
======================================-->
<div class="container-fluid well well-sm">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb lead text-uppercase fondoBreadcrumb">
                <li><a href="<?php echo $url; ?>">INICIO</a></li>
                <li class="active pagActiva"><?php echo $rutas[0] ?></li>
            </ul>
        </div>
    </div>
</div>  
<!--=====================================
SECCION PERFIL
======================================-->
<div class="container-fluit">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#compras">
                    <i class="fa fa-list-ul"></i>
                    MIS COMPRAS
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#deseos">
                    <i class="fa fa-gift"></i>
                    MI LISTA DE DESEOS
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#perfil">
                    <i class="fa fa-user"></i>
                    EDITAR PERFIL
                </a>
            </li>
            <li>
                <a href="<?php echo $url;?>ofertas">
                    <i class="fa fa-star"></i>
                    VER OFERTAS
                </a>
            </li>
        </ul>
        <div class="tab-content">
        <!--=====================================
        PESTAÑA COMPRAS
        ======================================-->
        <div id="compras" class="tab-pane fade in active">
            <div class="panel-group">
                <?php
                    $item ="id_usuario";
                    $valor = $_SESSION["id"];
                    $compras = ControladorUsuarios::ctrMostrarCompras($item,$valor);
                    if(!$compras){
                        echo'
                        <div class="col-xs-12 text-center error404">
                            <h1><small>¡Oops!</small></h1>
                            <h2>Aún no has realizado compras</h2>
                        </div>
                        ';
                    }
                    else{
                        foreach ($compras as $key => $value) {
                            $ordenar = "id";
                            $item = "id";
                            $valor = $value["id_producto"];
                            $productos = ControladorProductos::ctrListarProductos($ordenar,$item,$valor);
                            foreach ($productos as $key => $value2) {
                                echo'
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="col-md-2 col-sm-6 col-xs-12">
                                                <figure>
                                                    <img src="'.$servidor.$value2["portada"].'" class="img-thumbnail">
                                                </figure>
                                            </div>
                                            <div class="col-sm-6 col-xs-12">
                                                <h1><small>'.$value2["titulo"].'</small></h1>
                                                <p>'.$value2["titular"].'</p>
                                                ';
                                if($value2["tipo"] == "virtual"){
                                    echo'
                                    <a href="'.$url.'/curso">
                                        <button class="btn btn-default pull-left">Ir al curso</button>
                                    </a>
                                    ';
                                }
                                else{
                                    echo'
                                        <h6>Proceso de entrega: '.$value2["entrega"].' diás hábiles</h6>
                                    ';
                                    if($value["envio"]==0){
                                        echo'
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%"><i class="fa fa-check"></i> Despachado</div>
                                            <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%"><i class="fa fa-clock-o"></i> Enviando</div>
                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%"><i class="fa fa-clock-o"></i> Entregado</div>
                                        </div>
                                        ';
                                    }
                                    if($value["envio"]==1){
                                        echo'
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%"><i class="fa fa-check"></i> Despachado</div>
                                            <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%"><i class="fa fa-check"></i> Enviando</div>
                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%"><i class="fa fa-clock-o"></i> Entregado</div>
                                        </div>
                                        ';
                                    }
                                    if($value["envio"]==2){
                                        echo'
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info" role="progressbar" style="width:33.33%"><i class="fa fa-check"></i> Despachado</div>
                                            <div class="progress-bar progress-bar-default" role="progressbar" style="width:33.33%"><i class="fa fa-check"></i> Enviando</div>
                                            <div class="progress-bar progress-bar-success" role="progressbar" style="width:33.33%"><i class="fa fa-check"></i> Entregado</div>
                                        </div>
                                        ';
                                    }
                                }
                                echo'
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                        }
                    }
                ?>
            </div>
        </div>
        <!--=====================================
        PESTAÑA DESEOS
        ======================================-->
            <div id="deseos" class="tab-pane fade">
                <h3>Menu 1</h3>
                <p>Some content in menu 1.</p>
            </div>
        <!--=====================================
        PESTAÑA PERFIL
        ======================================-->
            <div id="perfil" class="tab-pane fade">
                <div class="row">
                    <form method="post" enctype="multipart/form-data">
                        <div class="col-md-3 col-sm-4 col-xs-12 text-center">
                            <br>
                            <figure id="imgPerfil">
                                <?php
                                    echo'<input type="hidden" name="idUsuario" value="'.$_SESSION["id"].'">';
                                    echo'<input type="hidden" name="passUsuario" value="'.$_SESSION["password"].'">';
                                    echo'<input type="hidden" name="fotoUsuario" value="'.$_SESSION["foto"].'">';
                                    echo'<input type="hidden" name="modoUsuario" value="'.$_SESSION["modo"].'">';
                                    if($_SESSION["modo"]=="directo"){
                                        if($_SESSION["foto"] != ""){
                                        echo'
                                            <img src="'.$url.$_SESSION["foto"].'" class="img-thumbnail"> 
                                        '; 
                                        }
                                        else{
                                            echo'
                                                <img src="'.$servidor.'Vistas/img/usuarios/default/anonymous.png" class="img-thumbnail">
                                            ';
                                        }
                                    }
                                    else{
                                        echo'
                                            <img src="'.$_SESSION["foto"].'" class="img-thumbnail"> 
                                        ';
                                    }
                                ?>
                            </figure>
                            <br>
                            <?php
                                if($_SESSION["modo"]=="directo"){
                                    echo'
                                        <button type="button" class="btn btn-default" id="btnCambiarFoto">Cambiar foto de perfil</button>
                                    ';
                                }
                            ?>
                            <div id="subirImagen">
                                <input type="file" accept="image/jpeg" class="form-control" name="datosImagen" id="datosImagen">
                                <img src="" alt="" class="previsualizar">
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                                <br>
                                <?php
                                    if($_SESSION["modo"] != "directo"){
                                        echo'
                                            <label class="control-label text-muted text-uppercase">Nombre:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input type="text"  class="form-control" value="'.$_SESSION["nombre"].'" readonly>
                                            </div>
                                            <br>
                                            <label class="control-label text-muted text-uppercase" >correo electrónico:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                <input type="text"  class="form-control" value="'.$_SESSION["email"].'" readonly>
                                            </div>
                                            <br>
                                            <label class="control-label text-muted text-uppercase" >modo de registro:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-'.$_SESSION["modo"].'"></i></span>
                                                <input type="text"  class="form-control text-uppercase" value="'.$_SESSION["modo"].'" readonly>
                                            </div>
                                            <br>
                                        ';
                                    }
                                    else{
                                        echo'
                                            <label class="control-label text-muted text-uppercase" for="editarNombre">Cambiar Nombre:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                                <input type="text" name="editarNombre" id="editarNombre" class="form-control" value="'.$_SESSION["nombre"].'">
                                            </div>
                                            <br>
                                            <label class="control-label text-muted text-uppercase" for="editarEmail">Cambiar correo electrónico:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                                <input type="text" name="editarEmail" id="editarEmail" class="form-control" value="'.$_SESSION["email"].'">
                                            </div>
                                            <br>
                                            <label class="control-label text-muted text-uppercase" for="editarPassword">Cambiar contraseña:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                                <input type="text" name="editarPassword" id="editarPassword" class="form-control" placeholder="Escribe la nueva contraseña">
                                            </div>
                                            <br>
                                            <button type="submit" class="btn btn-default backColor btn-md pull-left">Actualizar Datos</button>
                                        ';
                                    }
                                ?>
                        </div>
                        <?php
                            $actualizarPerfil = new ControladorUsuarios();
                            $actualizarPerfil -> ctrActualizarPerfil();
                        ?>
                    </form>
                    <button class="btn btn-danger btn-md pull-right" id="eliminarUsuario">Eliminar cuenta</button>
                </div>
            </div>
        </div>
    </div>
</div>