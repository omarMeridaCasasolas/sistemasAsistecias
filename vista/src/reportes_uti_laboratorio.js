var listaMateriaJson, tablaLaboratorio,fechaInicio, fechaFinal;
$(document).ready(function (){
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

    listaDeFacultades();
    tablaLaboratorio =$("#tablaReporte").DataTable();
    $("#idFacultadaes").change(function (e) { 
        let nombreFacultad = $("#idFacultadaes option:selected").text();
        //$("#nomFacultad").val(nombreFacultad);
        console.log(nombreFacultad);
        listaDepartamentos();
        e.preventDefault();
    });
    
    $("idDepartamentos").change(function (e) { 
        let nombreDepartamento = $("idDepartamentos option:selected").text();
        //$("#nomDepartamento").val(nombreDepartamento);
        console.log(nombreDepartamento);
        e.preventDefault();
    });

    

    //$('#tablaReporte').dataTable().fnDestroy();
    let tmpInicioSemana = String(moment().startOf('isoweek')._d);
    let listaTmpInicio = tmpInicioSemana.split(' ');
    // console.log(listaTmpInicio);
    fechaInicio = listaTmpInicio[3] +"-"+cambiarNombreMesNumerico(listaTmpInicio[1])+"-"+listaTmpInicio[2];
    $("#fechaInicio").html(fechaInicio);
    //console.log(fechaInicio);

    let tmpFinSemana = String(moment().endOf('isoweek')._d);
    let listaTmpFin = tmpFinSemana.split(' ');
    // console.log(listaTmpFin);
    fechaFinal = listaTmpFin[3] +"-"+cambiarNombreMesNumerico(listaTmpFin[1]) +"-"+listaTmpFin[2];
    $("#fechaFinal").html(fechaFinal);
    //console.log(fechaFinal);


    $("#tablaReporte tbody").on('click','button.revisarInforme',function () {
        var dataEdit = tablaLaboratorio.row( $(this).parents('tr') ).data();
        console.log(dataEdit);
        $("#fechaReporteView").html(dataEdit.fecha_reporte_lab);
        $("#idLaboratorio").html(dataEdit.id_reporte_lab);   

        $("#nombreLaboratorio").html(dataEdit.nombre_laboratorio);
        $("#responsableLab").html(dataEdit.nombre_auxiliar_lab);
        $("#correoLab").html(dataEdit.correo_auxiliar_lab);
        $("#avanzadoLab").html(dataEdit.trabajo_lab_hecho);
        $("#observacionLab").html(dataEdit.obs_reporte_lab);

        if(dataEdit.sol_licencia == true){
            $("#descLicencia").html(dataEdit.desc_licencia);
            $("#idEnlaceLicencia").attr("href", dataEdit.enl_licencia);
            $("#idEnlaceLicencia").show();
        }else{
            $("#descLicencia").html("No tiene licencia");
            $("#idEnlaceLicencia").hide();
        }

        let entregado = !dataEdit.asistido;
        if(entregado == true){
            $("#radio1").prop('checked', true);
            $("#radio2").prop('checked', false);
        }else{
            $("#radio1").prop('checked', false);
            $("#radio2").prop('checked', true);
        }


    });

    $("#formObtenerReporte").submit(function (e) { 
        e.preventDefault();
        listaReporte();
    });

    $("#formEditarFacultad").submit(function (e) { 
        let radioValue = $("input[name='optradio']:checked").val();
        // console.log(radioValue);
        let datosReporte = {
            clase: 'Clase',
            metodo: 'enviarReporteAsistenciaJD',
            idClase: $("#idClase").val(),
            estado: radioValue
        };
        console.log(datosReporte);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datosReporte,
            success: function (response) {
                console.log(response);
                if(response == 1){
                    Swal.fire('Exito',"Se ha enviar el reporte de :"+$("#nomResponsable").val(),'success');
                }else{
                    Swal.fire('Error',response,'info');
                }
            }
        });
        e.preventDefault();
        
    });
    

});


function isUrl(s) {
    var regexp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
    return regexp.test(s);
}
    
function linkify(html) {
    return html.replace(/[^\"]http(.*)\.([a-zA-Z]*)/g, ' <a href="http$1.$2">http$1.$2</a>');
}


function cambiarNombreMesNumerico(nombMes){
    let res;
    switch (nombMes) {
        case "Jan":
            res = 1;
            break;
        case "Feb":
            res = 2;
            break;
        case "Mar":
            res = 3;
            break;
        case "Apr":
            res = 4;
            break;
        case "May":
            res = 5;
            break;
        case "Jun":
            res = 6;
            break;
        case "Jul":
            res = 7;
            break;
        case "Aug":
            res = 8;
            break;
        case "Sep":
            res = 9;
            break;
        case "Oct":
            res = 10;
            break;
        case "Nov":
            res = 11;
            break;
        case "Dec":
            res = 12;
            break;
        default:
            res= 12;
            break;
    }
    return res;
}


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

function listaReporte(){
    console.log(fechaInicio);
    console.log(fechaFinal);
    console.log($("#idDepartamentos").val());
    $('#tablaReporte').dataTable().fnDestroy();
    tablaLaboratorio =$("#tablaReporte").DataTable({
        responsive: true,
        language:{
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún reporte para evaluar",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        },
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'AuxiliarLaboratorio' , 'metodo':'obtenerReportesLaboratorioSem','fechaInicio': fechaInicio,'fechaFinal': fechaFinal, 'idDepartamento':  $("#idDepartamentos").val()},
            // "data" : {'clase': 'Materia' , 'metodo':'obtenerMateriaPorDepartamento','fechaInicio': fechaInicio,'fechaFinal': fechaFinal, 'idDepartamento': $("#idDepartamento").val()},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_reporte_lab"},
            {"data":"nombre_laboratorio"},
            {"data":"nombre_auxiliar_lab"}, 
            {"data":"trabajo_lab_hecho"},
            {"data": null,"defaultContent":"<button type='button' class='revisarInforme btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal4'><i class='far fa-edit'></i></button>"}
        ]
    });
}

