/*=============================================
CAPTURA DE RUTA
=============================================*/
var rutaActual = location.href;
$(".btnIngreso, .facebook , .google").click(function () { 
    localStorage.setItem("rutaActual",rutaActual);
    
});
/*=============================================
FORMATEAR INPUT
=============================================*/
$("input").focus(function () { 
    $(".alert").remove();
});
/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/
var validarEmailRepetido = false;

$("#regEmail").change(function () { 
    var email = $("#regEmail").val();    
    var datos = new FormData();
    datos.append("validarEmail",email);
    $.ajax({
        url: rutaOculta+"ajax/usuarios.ajax.php",
        method:"POST",
        data: datos,
        cache:false,
        contentType:false,
        processData:false,
        success: function (respuesta) {
            if(respuesta=="false"){
                $(".alert").remove();
                validarEmailRepetido = false;
            }
            else{
            var modo = JSON.parse(respuesta).modo;
            if(modo == "directo"){
                modo = "esta página";
            }
            $("#regEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>Correo electrónico ya esta en uso de l sistema, fue registrado através de '+modo+', por favor ingrese otro diferente</div>');
                validarEmailRepetido = true;
            }
        }
    });    
});
/*=============================================
VALIDAR EL REGISTRO DE USUARIOS
=============================================*/
function registroUsuario(){
    /*=============================================
    VALIDAR NOMBRE
    =============================================*/
    var nombre = $("#regUsuario").val();
    if(nombre != ""){
        var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;
        if(!expresion.test(nombre)){
            $("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>No se permiten números ni caracteres especiales</div>');
            return false;
        }
    }else{
        $("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>Este campo este obligatorio</div>');
        return false;
    }
    /*=============================================
    VALIDAR EMAIL
    =============================================*/
    var email = $("#regEmail").val();
    if(email != ""){
        var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
        if(!expresion.test(email)){
            $("#regEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>Correo invalido</div>');
            return false;
        }
        if(validarEmailRepetido){
            $("#regEmail").parent().before('<div class="alert alert-danger"><strong>ATENCIÓN:</strong>Correo electrónico ya esta en uso en el sistema, por favor ingrese otro diferente</div>');
            return false;
        }
    }else{
        $("#regEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>Este campo este obligatorio</div>');
        return false;
    }
    /*=============================================
    VALIDAR CONTRASEÑA
    =============================================*/
    var password = $("#regPassword").val();
    if(password != ""){
        var expresion = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;
        if(!expresion.test(password)){
            $("#regPassword").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>Caracter invalido</div>');
            return false;
        }
    }else{
        $("#regPassword").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>Este campo este obligatorio</div>');
        return false;
    }
    /*=============================================
    VALIDAR POLITICAS DE PRIVACIDAD
    =============================================*/
    var politicas = $("#regPoliticas:checked").val();
    if(politicas != "on"){
        $("#regPoliticas").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong>Debe aceptar nuestras condiciones de uso y politicas de privacidad</div>');
        return false;
    }
    return true;
}

/*=======================================
CAMBIAR FOTO
=======================================*/
$("#btnCambiarFoto").click(function () { 
    $("#imgPerfil").toggle();
    $("#subirImagen").toggle();
});
$("#datosImagen").change(function () { 
    var imagen = this.files[0];
    if(imagen["type"] != "image/jpeg"){
        $("#datosImagen").val("");
        swal({
            title: "¡ERROR!",
            text: "La imagen debe estar en JPG",
            type:"error",
            confirmButtonText:"Cerrar",
            closeOnConfirm: false
            },
            function(isConfirm){
            if(isConfirm){
                window.location = rutaOculta+"perfil";
            }
        });
    }
    else if(Number(imagen["siza"]) > 2000000 ){
        $("#datosImagen").val("");
        swal({
            title: "¡ERROR!",
            text: "La imagen no debe pesar mas de 2 MB",
            type:"error",
            confirmButtonText:"Cerrar",
            closeOnConfirm: false
            },
            function(isConfirm){
            if(isConfirm){
                window.location = rutaOculta+"perfil";
            }
        });
    }
    else{
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen);
        $(datosImagen).on("load",function (event) {
            var rutaImagen = event.target.result;
            $(".previsualizar").attr("src", rutaImagen);
        })
    }
});