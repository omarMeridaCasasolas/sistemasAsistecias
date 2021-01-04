$(document).ready(function () {
    $("#editFormSelf").submit(function (e) { 
        let passwordActual = $("#passTrabajador").val();
        let getPass= $("#editPass").val();
        console.log(getPass);
        if(passwordActual != getPass){
            $("#editUsurPassSelf").html("*Ingrese su contraseña vigente");
            e.preventDefault();
        }else{
            $("#editUsurPassSelf").html("");
            if($("#nuevoPass").val() != $("#repeatPAss").val()){
                $("#changePassUser").html("Las contraseña tienen que concidir!!");
                e.preventDefault();
            }
        }
    });

    // let URLActual = location.href;
    // //console.log(URLActual);
    // let listaValores = URLActual.split("?");
    // if(listaValores.length>=2){
    //     let parametros = listaValores[listaValores.length-1].split("=");
    //     if(parametros[1] == "success"){
    //         Swal.fire('Exito',"Se ha actualizados sus datos personales",'success');
    //     }else{
    //         Swal.fire('Problema',"Problemas al actulizar sus datos",'info');
    //     }
    // }

    let d = new Date();
    let date = d.getDate();
    let month = d.getMonth()+1;
    let year = d.getFullYear();
    if (month < 10) {
        month = '0' + month;
    }
    if (date < 10) {
        date = '0' + date;
    }
    $("#div_date_time").html(year + "-" + month + "-" + date);
});