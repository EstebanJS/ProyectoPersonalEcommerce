/*=============================================
BUSCADOR
=============================================*/
$("#buscador input").change(function () { 
    var busqueda = $("#buscador input").val();
    var exresion = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;
    if(!exresion.test(busqueda)){
        $("#buscador input").val("");
        console.log("error")
    }
    else{
        var evaluarBusqueda = busqueda.replace(/[áéíóúÁÉÍÓÚ ]/g,"-");
        var rutaBuscador = $("#buscador a").attr("href");
        if($("#buscador input").val() != ""){
            $("#buscador a").attr("href", rutaBuscador+"/"+evaluarBusqueda);
        }
    }
});
/*=============================================
BUSCADOR CON ENTER
=============================================*/
$("#buscador input").focus(function () { 
    $(document).keyup(function (e) { 
        e.preventDefault();
        if(e.keyCode == 13 && $("#buscador input").val() != ""){
            var rutaBuscador = $("#buscador a").attr("href");
            window.location.href = rutaBuscador;
        }
    });
    
});


















