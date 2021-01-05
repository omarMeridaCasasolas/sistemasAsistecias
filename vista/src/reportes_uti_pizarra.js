var listaMateriaJson, tablaMateriaAuxiliares,fechaFinal,fechaInicio;
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

    $("#formObtenerReporte").submit(function (e) { 
        e.preventDefault();
        listaReporte();
    });

    tablaMateriaAuxiliares =$("#tablaMateriaAuxiliares").DataTable();

    $("#tablaMateriaAuxiliares tbody").on('click','button.revisarInforme',function () {
        let dataEdit = tablaMateriaAuxiliares.row( $(this).parents('tr') ).data();
        console.log(dataEdit);
        console.log(" Se preciono Aqui");
        $("#fechaReporteView").html(dataEdit.fecha_clase);
        $("#idClase").val(dataEdit.codigo_clase);
        let datosAuxiliar = {
            clase: 'AuxiliarDocente',
            metodo: "obtenerAuxiliarDocente",
            idAuxilirDocente: dataEdit.id_aux_docente
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datosAuxiliar,
            success: function (response) {
                //console.log(response);
                let auxiliarDoc = JSON.parse(response);
                $("#nomResponsable").val(auxiliarDoc.nombre_aux_docente);
            }
        });

        let datosRecursos = {
            clase: 'Enlace',
            metodo: "obtenerEnlacesClase",
            idClase: dataEdit.codigo_clase
        }
        //console.log(datosRecursos);
        if(dataEdit.clase_recuperacion == null || dataEdit.clase_recuperacion == false){
            $.ajax({
                type: "POST",
                url: "../controlador/interprete.php",
                data: datosRecursos,
                success: function (response) {
                    //console.log(response);
                    listaRecursos = JSON.parse(response);
                    let cadena = "";
                    $('#listaEnlacesDiv').empty();
                    listaRecursos.forEach(element => {
                        // let aux = element.direccion_enlace_recurso;
                        // cadena = cadena + "<a href='"+element.direccion_enlace_recurso+"' target='_blank'>Enlace</a><br>";
                        $('#listaEnlacesDiv').append(
                            $(document.createElement('a')).prop({
                              target: '_blank',
                              href: element.direccion_enlace_recurso,
                              innerText: element.direccion_enlace_recurso
                            })
                          ).append(
                            $(document.createElement('br'))
                          );
                    });
                    //console.log(cadena);
                    //$("#textEnlaces").val(cadena);
                }
            });
            $("#reposClass").hide();
            $("#textAvanzado").html(dataEdit.contenido_clase);
            $("#idAvanzado").show();
            $("#enlacesClase").show();
        }else{
            $("#repAsunto").html(dataEdit.asunto_reposicion); 
            $("#repFecha").html(dataEdit.fecha_reposicion);  
            $("#repHora").html(dataEdit.hora_reposicion);  
            $("#reposClass").show();
            $("#idAvanzado").hide();
            $("#enlacesClase").hide();
            $("#repPlataforma").val(dataEdit.plataforma_reposicion);
            $("#repAvance").html(dataEdit.avanze_posicion);

            $.ajax({
                type: "POST",
                url: "../controlador/interprete.php",
                data: datosRecursos,
                success: function (response) {
                    //console.log(response);
                    listaRecursos = JSON.parse(response);
                    let cadena = "";
                    $('#enlacesReposicion').empty();
                    listaRecursos.forEach(element => {
                        // let aux = element.direccion_enlace_recurso;
                        // cadena = cadena + "<a href='"+element.direccion_enlace_recurso+"' target='_blank'>Enlace</a><br>";
                        $('#enlacesReposicion').append(
                            $(document.createElement('a')).prop({
                              target: '_blank',
                              href: element.direccion_enlace_recurso,
                              innerText: element.direccion_enlace_recurso
                            })
                          ).append(
                            $(document.createElement('br'))
                          );
                    });
                    //console.log(cadena);
                    //$("#textEnlaces").val(cadena);
                }
            });
        }
        $("#nomMateria").val(dataEdit.nombre_materia);
        $("#codMateria").val(dataEdit.codigo_materia);
        $("#plataforma").val(dataEdit.plataforma_clase);
        $("#textObservacion").html(dataEdit.observaciones_clase);
        let entregado = dataEdit.existe_falta_clase;
        if(entregado == true){
            $("#radio1").prop('checked', true);
            $("#radio2").prop('checked', false);
        }else{
            $("#radio1").prop('checked', false);
            $("#radio2").prop('checked', true);
        }

        if(dataEdit.clase_con_licencia == true){
            $("#descLicencia").html(dataEdit.descripcion_licencia);
            $("#idEnlaceLicencia").attr("href", dataEdit.enlace_licencia);
            $("#idEnlaceLicencia").show();
        }else{
            $("#idEnlaceLicencia").hide();
        }
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

    listaDeFacultades();
});


function isUrl(s) {
    var regexp = /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]+-?)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?$/i;
    return regexp.test(s);
}
    
function linkify(html) {
    return html.replace(/[^\"]http(.*)\.([a-zA-Z]*)/g, ' <a href="http$1.$2">http$1.$2</a>');
}

function listaReporte(){
    console.log(fechaInicio);
    console.log(fechaFinal);
    console.log($("#idDepartamentos").val());

    $('#tablaMateriaAuxiliares').dataTable().fnDestroy();
    tablaMateriaAuxiliares =$("#tablaMateriaAuxiliares").DataTable({
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
            "data" : {'clase': 'Materia' , 'metodo':'obtenerMateriaPorDepartamento','fechaInicio': fechaInicio,'fechaFinal': fechaFinal, 'idDepartamento': $("#idDepartamentos").val()},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_clase"},
            {"data":"nombre_materia"},
            {"data":"codigo_materia"}, 
            {"data":"plataforma_clase"},
            {"data": null,"defaultContent":"<button type='button' class='revisarInforme btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal8'><i class='far fa-edit'></i></button>"}
        ]
    });
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
                }
            } 
        }
    });
}