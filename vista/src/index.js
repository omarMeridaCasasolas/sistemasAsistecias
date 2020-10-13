$(document).ready(function () {
    let URLActual = location.href;
    //console.log("Usando location "+ location.href);
    //console.log("Usando Windows "+ window.location);
    let listaValores = URLActual.split("?");
    let eventos = listaValores[1].split('&');
    if(eventos.length == 2){
        console.log(eventos[0]);
        let categoriaUna = eventos[0].split("=");
        let propiedadUno = categoriaUna[0];
        let valorUno = categoriaUna[1];

        
        let categoriaDos = eventos[1].split('=');
        let propiedadDos = categoriaDos[0];
        let valorDos = categoriaDos[1];
        
        if(propiedadUno == "error"){
            switch (valorUno) {
                case "auntentificacion":
                    swal("Problema de registro", "El usuario no exite!", "error");
                    break;
                default:
                    break;
            }
        }

        if(propiedadDos == "tipo"){
            switch (valorDos) {
                case "autoridad":
                    $("#idItemUno").removeClass("active");
                    $("#idLinkUno").removeClass("active");
                    $("#idItemDos").addClass("active");
                    $("#idLinkDos").addClass("active");
                    $("#indice").removeClass("active");
                    $("#indice").addClass("fade");
                    $("#autoridadesAcademicas").removeClass("fade");
                    $("#autoridadesAcademicas").addClass("active");
                    break;
                default:
                    break;
            }
        }

        
    }
});