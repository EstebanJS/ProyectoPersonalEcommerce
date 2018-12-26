/*=============================================
PLANTILLA
=============================================*/
var rutaOculta = $("#rutaOculta").val();
// TOOLTIP

$('[data-toggle="tooltip"]').tooltip();
$.ajax({
    url: rutaOculta+"ajax/plantilla.ajax.php",
    success: function (respuesta) {
        var colorFondo = JSON.parse(respuesta).colorFondo;
        var colorTexto = JSON.parse(respuesta).colorTexto;
        var barraSuperior = JSON.parse(respuesta).barraSuperior;
        var textoSuperior = JSON.parse(respuesta).textoSuperior;

        $(".backColor, .backColor a").css({"background":colorFondo,"color":colorTexto});
        $(".barraSuperior").css({"background":barraSuperior,"color":textoSuperior});
    }
});
/*=============================================
CUADRICULA O LISTA
=============================================*/
var btnList =$(".btnList");
for(var i = 0; i < btnList.length;i++){
    
    $("#btnGrid"+i).click(function(){
        var numero = $(this).attr("id").substr(-1);
        $(".list"+numero).hide();
        $(".grid"+numero).show();
        $("#btnGrid"+numero).addClass("backColor");
        $("#btnList"+numero).removeClass("backColor");

    });
    $("#btnList"+i).click(function(){
        var numero = $(this).attr("id").substr(-1);
        $(".list"+numero).show();
        $(".grid"+numero).hide();
        $("#btnGrid"+numero).removeClass("backColor");
        $("#btnList"+numero).addClass("backColor");
    });
}
/*=============================================
EFECTOS CON SCROLL
=============================================*/
$(window).scroll(function(){
    var scrollY = window.pageYOffset;
    if(window.matchMedia("(min-width:768px)").matches){
        if($(".banner").html() != null){
            if(scrollY < ($(".banner").offset().top)-200){
                $(".banner img").css({"margin-top":-scrollY/3+"px"})
            }else{
                scrollY= 0;
            }
        }
        
    }
})
$.scrollUp({
    scrollText:"",
    scrollSpeed:2000,
    easingType:"easeOutQuint"
});
/*=============================================
BREADCRUMB
=============================================*/
var pagActiva = $(".pagActiva").html();
if(pagActiva != null){
    var regPagActiva = pagActiva.replace(/-/g," ");
    $(".pagActiva").html(regPagActiva);
}
/*=============================================
ENLACES PAGINACION
=============================================*/
var url = window.location.href;
var indicice = url.split("/");

if(indicice.length>7)
{
    var pocicion = indicice[(indicice.length-3)];  
    console.log(pocicion);
    $("#item"+pocicion).addClass("active");
}
else{
    $("#item"+indicice.pop()).addClass("active");
}

