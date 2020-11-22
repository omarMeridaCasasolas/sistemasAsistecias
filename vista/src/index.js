$(document).ready(function () {
    //console.log("Usando location "+ location.href);
    //console.log("Usando Windows "+ window.location);
    $("#formRecuperarPassword").submit(function (e) { 
        let datosUser = {
            clase: "Director",
            metodo: "recuperarPassword",
            correo: $("#correoParaRecuparar").val()
        }
        $.ajax({
            type: "POST",
            url: "controlador/interprete.php",
            data: datosUser,
            success: function (response) {
                console.log(response);
                
                if(response == 2021){
                    //console.log("Se ha enviado su correo");
                    $("#btnCerrarVtnPass").click();
                    swal("Exito","Se ha enviado su contraseña a su correo","success");
                    
                }else{
                    //setInterval(function(){ $("#msmRespuesta").html(""); }, 1000);
                    $("#msmRespuesta").html("Este usuario no existe, intentelo de nuevo!!");
                }
            }
        });
        e.preventDefault();        
    });

    $("#formRecuperarPasswordDocente").submit(function (e) { 
        let datosUser = {
            clase: "Docente",
            metodo: "recuperarPasswordDocente",
            correo: $("#correoParaRecupararDocente").val()
        }
        $.ajax({
            type: "POST",
            url: "controlador/interprete.php",
            data: datosUser,
            success: function (response) {
                console.log(response);
                if(response == 2021){
                    //console.log("Se ha enviado su correo");
                    $("#btnCerrarVtnPassDocente").click();
                    swal("Exito","Se ha enviado su contraseña a su correo","success");
                    
                }else{
                    //setInterval(function(){ $("#msmRespuesta").html(""); }, 1000);
                    $("#msmRespuestaDocente").html("Este usuario no existe, intentelo de nuevo!!");
                }
            }
        });
        e.preventDefault();        
    });

    $("#formRecuperarPasswordAuxLab").submit(function (e) { 
        let datosUser = {
            clase: "AuxiliarLaboratorio",
            metodo: "recuperarPasswordAuxLab",
            correo: $("#correoParaRecupararAuxLab").val()
        }
        $.ajax({
            type: "POST",
            url: "controlador/interprete.php",
            data: datosUser,
            success: function (response) {
                console.log(response);
                if(response == 2021){
                    //console.log("Se ha enviado su correo");
                    $("#btnCerrarVtnPassAuxLab").click();
                    swal("Exito","Se ha enviado su contraseña a su correo","success");
                    
                }else{
                    //setInterval(function(){ $("#msmRespuesta").html(""); }, 1000);
                    $("#msmRespuestaAuxLab").html("Este usuario no existe, intentelo de nuevo!!");
                }
            }
        });
        e.preventDefault();        
    });

    $("#formRecuperarPasswordAuxDoc").submit(function (e) { 
        let datosUser = {
            clase: "AuxiliarDocente",
            metodo: "recuperarPasswordAuxDoc",
            correo: $("#correoParaRecupararAuxDoc").val()
        }
        $.ajax({
            type: "POST",
            url: "controlador/interprete.php",
            data: datosUser,
            success: function (response) {
                console.log(response);
                if(response == 2021){
                    //console.log("Se ha enviado su correo");
                    $("#btnCerrarVtnPassAuxDoc").click();
                    swal("Exito","Se ha enviado su contraseña a su correo","success");
                    
                }else{
                    //setInterval(function(){ $("#msmRespuesta").html(""); }, 1000);
                    $("#msmRespuestaAuxDoc").html("Este usuario no existe, intentelo de nuevo!!");
                }
            }
        });
        e.preventDefault();        
    });


    // let URLActual = location.href;
    // //console.log(URLActual);
    // let listaValores = URLActual.split("?");
    // if(listaValores.length >=2 ){
    //     let eventos = listaValores[1].split('&');
    //     if(eventos.length == 2){
    //         //console.log(eventos[0]);
    //         let categoriaUna = eventos[0].split("=");
    //         let propiedadUno = categoriaUna[0];
    //         let valorUno = categoriaUna[1];

            
    //         let categoriaDos = eventos[1].split('=');
    //         let propiedadDos = categoriaDos[0];
    //         let valorDos = categoriaDos[1];
            
    //         if(propiedadUno == "error"){
    //             switch (valorUno) {
    //                 case "auntentificacion":
    //                     swal("Problema de registro", "El usuario no exite!", "error");
    //                     break;
    //                 default:
    //                     break;
    //             }
    //         }

    //         if(propiedadDos == "tipo"){
    //             switch (valorDos) {
    //                 case "auxiliar_docente":
    //                     $("#idItemUno").removeClass("active");
    //                     $("#idLinkUno").removeClass("active");
    //                     $("#idItemCinco").addClass("active");
    //                     $("#idLinkCinco").addClass("active");
    //                     $("#indice").removeClass("active");
    //                     $("#indice").addClass("fade");
    //                     $("#auxiliarDocencia").removeClass("fade");
    //                     $("#auxiliarDocencia").addClass("active");
    //                     break;
    //                 case "auxiliar_laboratorio":
    //                     $("#idItemUno").removeClass("active");
    //                     $("#idLinkUno").removeClass("active");
    //                     $("#idItemCuatro").addClass("active");
    //                     $("#idLinkCuatro").addClass("active");
    //                     $("#indice").removeClass("active");
    //                     $("#indice").addClass("fade");
    //                     $("#auxiliarLaboratorio").removeClass("fade");
    //                     $("#auxiliarLaboratorio").addClass("active");
    //                     break;
    //                 case "docente":
    //                     $("#idItemUno").removeClass("active");
    //                     $("#idLinkUno").removeClass("active");
    //                     $("#idItemTres").addClass("active");
    //                     $("#idLinkTres").addClass("active");
    //                     $("#indice").removeClass("active");
    //                     $("#indice").addClass("fade");
    //                     $("#docente").removeClass("fade");
    //                     $("#docente").addClass("active");
    //                     break;
    //                 case "autoridad":
    //                     $("#idItemUno").removeClass("active");
    //                     $("#idLinkUno").removeClass("active");
    //                     $("#idItemDos").addClass("active");
    //                     $("#idLinkDos").addClass("active");
    //                     $("#indice").removeClass("active");
    //                     $("#indice").addClass("fade");
    //                     $("#autoridadesAcademicas").removeClass("fade");
    //                     $("#autoridadesAcademicas").addClass("active");
    //                     break;
    //                 default:
    //                     break;
    //             }
    //         }

            
    //     }
    // }
});