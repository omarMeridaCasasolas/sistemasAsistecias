$(document).ready(function () {

    let tmpFecha = new Date();
    if(tmpFecha.getMonth == '01'){
        tmpFecha.setMonth(tmpFecha.getMonth() - 2);
    }else{
        tmpFecha.setMonth(tmpFecha.getMonth() - 1);
    }


    let mes = tmpFecha.getMonth()+1;
    let year = tmpFecha.getFullYear();
    let fechaReporte = mes +"-"+year;
    $("#gestionPlanilla").val(fechaReporte);

    let fechaInicio = year+"-"+mes+"-"+"01";
    console.log(fechaInicio);
    $("#fechaInicio").val(fechaInicio);

    let fechaFinal = year+"-"+mes+"-"+new Date(year,mes,0).getDate();
    $("#fechaFinal").val(fechaFinal);

    listaDeFacultades();   
    $("#enlaceVistaPrevia").hide();
    $("#enlaceVistaPrevia").click(function (e) { 
        //e.preventDefault();
        $("#enlaceVistaPrevia").attr("href", "vista_previa_reporte_docentes.php?fecha="+$("#gestionPlanilla").val()+"&fac="+$("#nomFacultad").val()+"&dep="+$("#nomDepartamento").val());
    });

});


$("#idFacultadaes").change(function (e) { 
    let nombreFacultad = $("#idFacultadaes option:selected").text();
    $("#nomFacultad").val(nombreFacultad);
    console.log(nombreFacultad);
    e.preventDefault();
});

$("idDepartamentos").change(function (e) { 
    let nombreDepartamento = $("idDepartamentos option:selected").text();
    $("#nomDepartamento").val(nombreDepartamento);
    console.log(nombreDepartamento);
    e.preventDefault();
});

function listaDeFacultades(){
    let datosFacultad = {
        clase: "Facultad",
        metodo: "mostrarFacultades"
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosFacultad,
        success: function (response) {
            // console.log(response);
            listaFacultades = JSON.parse(response);
            $("#idFacultadaes").empty();
            listaFacultades.forEach(element => {
                $('#idFacultadaes').append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            });
            let nombreFacultad = $("#idFacultadaes option:selected").text();
            $("#nomFacultad").val(nombreFacultad);
            console.log(nombreFacultad);
            listaDepartamentos();
        }
    });
}

function listaDepartamentos(){
    let datosDepartamento = {
        clase: "Departamento",
        metodo: "mostrarDepartamentos",
        idFacultad: $("#idFacultadaes").val(),
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosDepartamento,
        success: function (response) {
            // console.log(response);
            let listaDepartmentos = JSON.parse(response);
            $("#idDepartamentos").empty();
            if(listaDepartmentos.length == 0){
                $('#idDepartamentos').append("<option value='Ninguno'>No existe datos</option>");
            }else{
                listaDepartmentos.forEach(element => {
                    $('#idDepartamentos').append("<option value='"+element.id_departamento+"'>"+element.nombre_departamento+"</option>");
                });
            }
            let nombreDepartamento = $("#idDepartamentos option:selected").text();
            $("#nomDepartamento").val(nombreDepartamento);
            console.log(nombreDepartamento);
            $("#btnSubmit").prop( "disabled", false );
            let url = location.href;
            //console.log(url);
            let listaUno = url.split('?');
            //console.log(listaUno.length);
            if(listaUno.length > 1){
                let listaDos = listaUno[listaUno.length -1];
                let listaTres = listaDos.split("&");
                //console.log(listaTres);
                if(listaTres.length>1){
                    let tmpUno = listaTres[0].split('=');
                    let tmpDos = listaTres[1].split('=');
                    //console.log(tmpUno[1]);
                    //console.log(tmpDos[1]);
                    $("#idFacultadaes").val(tmpUno[1]);
                    $("#idDepartamentos").val(tmpDos[1]);
                    actualizarInfromacion();
                }
            } 
        }
    });
}

function actualizarInfromacion(){
    $("#nomFacultad").val($("#idFacultadaes option:selected").text());
    $("#nomDepartamento").val($("#idDepartamentos option:selected").text());
    $("#enlaceVistaPrevia").show();
    $("#btnSubForm").prop( "disabled", false );
}