/*============================================================
  BOTON FACEBOOK                               
  ============================================================*/
$(".facebook").click(function () { 
   FB.login(function(response){
    validarUsuario();
   },{scope:'public_profile, email'});
});
/*============================================================
  VALIDAR EL INGRESO                               
  ============================================================*/
function validarUsuario(){
    FB.getLoginStatus(function(response){
        statusChangeCallback(response);
    });
}
/*============================================================
  VALIDAR EL CAMBIO DE ESTADO FACEBOOK                               
  ============================================================*/
function statusChangeCallback(response){
    if(response.status === 'connected'){
        testApi();
    }
    else{
        swal({
            title: "¡ERROR!",
            text: "Ocurrio un problema al ingresar con Facebook, vuelve a intentarlo",
            type:"error",
            confirmButtonText:"Cerrar",
            closeOnConfirm: false
            },
            function(isConfirm){
            if(isConfirm){
                window.location = localStorage.getItem("rutaActual");
            }
        });
    }
}
/*============================================================
  INGRESAMOS A LA API DE FACEBOOK                               
  ============================================================*/
function testApi(){
    FB.api('/me?fields=id,name,email,picture',function(response){
        if(response.email == null){
            swal({
                title: "¡ERROR!",
                text: "Para aceder al sistema debes proporcionar tu correo, revisa las configuraciones de tu Facebook",
                type:"error",
                confirmButtonText:"Cerrar",
                closeOnConfirm: false
                },
                function(isConfirm){
                if(isConfirm){
                    window.location = localStorage.getItem("rutaActual");
                }
            });
        }
        else{
            var email = response.email;
            var nombre = response.name;
            var foto = "http://graph.facebook.com/"+response.id+"/picture?type=large";
            var datos = new FormData();
            datos.append("email",email);
            datos.append("nombre",nombre);
            datos.append("foto",foto);
            $.ajax({
                url: rutaOculta+"ajax/usuarios.ajax.php",
                method:"POST",
                data: datos,
                cache:false,
                contentType:false,
                processData:false,
                success: function (respuesta) {
                    if(respuesta == "ok"){
                        window.location =localStorage.getItem("rutaActual");
                    }
                    else{
                        swal({
                            title: "¡ERROR!",
                            text: "El correo electronico "+email+" este corro ya esta regisrado en el sistema con un metodo diferente a Facebook",
                            type:"error",
                            confirmButtonText:"Cerrar",
                            closeOnConfirm: false
                            },
                            function(isConfirm){
                            if(isConfirm){
                                FB.getLoginStatus(function(response){
                                    if(response.status === 'connected'){
                                        FB.logout(function(response){
                                            deleteCookie("fblo_210464019699801");
                                            setTimeout(function(){
                                                window.location = rutaOculta+"salir";
                                            },500); 
                                        });
                                        function deleteCookie(name){
                                            document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT';
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            });
        }
    });
}
/*============================================================
  SALIR DE FACEBOOK                               
  ============================================================*/
  $(".salir").click(function (e) { 
      e.preventDefault();
      FB.getLoginStatus(function(response){
        if(response.status === 'connected'){
            FB.logout(function(response){
                deleteCookie("fblo_210464019699801");
                setTimeout(function(){
                    window.location = rutaOculta+"salir";
                },500); 
            });
            function deleteCookie(name){
                document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT';
            }
        }
    });
  });