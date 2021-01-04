var tablaReporte;
$(document).ready(function () {
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

    tablaReporte = $("#tablaHistorialReporte").DataTable();
    $("#formEnviarCorreos").submit(function (e) { 
        datos = {
            clase: "Correo",
            metodo: "enviarCorreoSimple",
            to: $("#destinoCorreo").val(),
            asunto: $("#fromMail").val() +" || "+ $("#idCorreoAsunto").val(), 
            descripcion: $("#descCorreo").html()
        };
        console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                //console.log(response);
                let res = response.trim();
                if(res == "2021"){
                    Swal.fire("Exito","Se a enviado el correo a: "+datos.to,"success");
                }else{
                    Swal.fire("Problema",res,"info");
                }
            }
        });
        $("#btnCerrarVtnMail").click();
        e.preventDefault();
        
    });

    listaDeFacultades();   
    $("#idFacultadaes").change(function (e) { 
        listaDepartamentos();
        e.preventDefault();
    });

    $("#buscarReportesLaboratorio").submit(function (e) { 
        datosLaboratorio = {
            clase: "AuxiliarLaboratorio",
            metodo: "listarHistorialLaboratorio",
            idDepartamento: $("#idDepartamentos").val()
        };
        console.log(datosLaboratorio);
        listarReporte(datosLaboratorio);
        e.preventDefault();
    })

    $("#tablaHistorialReporte tbody").on('click','button.verDetalles',function () {
        let datoReporte = tablaReporte.row( $(this).parents('tr') ).data();
        console.log(datoReporte );
        $("#fechaClase").html(datoReporte.fecha_reporte_lab);
        $("#nomMateria").html(datoReporte.nombre_laboratorio);
        $("#nomResponsable").html(datoReporte.nombre_auxiliar_lab);
        $("#idAvance").html(datoReporte.trabajo_lab_hecho);
        $("#idObservacion").html(datoReporte.obs_reporte_lab);
        let resEnlace = datoReporte.doc_reporte_lab;
        //console.log(datoReporte.doc_reporte_lab);
        if(resEnlace == undefined){
            //console.log("Es indefinido");
            $("#documentoReporte").html("Sin enlace");
            $("#documentoReporte").hide();
        }else{
            //console.log("No Es indefinido");
           //$("#documentoReporte").html(datoReporte.descripcion_licencia);
            $("#documentoReporte").attr("href", datoReporte.doc_reporte_lab);
            $("#documentoReporte").show();
        }

        //console.log(String(datoReporte.asistido));
        $("#idAsistencia").val(String(datoReporte.asistido));


        let licencia =  datoReporte.sol_licencia;
        console.log(licencia);
        if(licencia == true){
            $("#asuntoLicencia").html(datoReporte.desc_licencia);
            $("#enlaceLicencia").attr("href", datoReporte.enl_licencia);
            $("#enlaceLicencia").show();
        }else{
            //$('#claseLicencia').empty();
            $("#asuntoLicencia").html("No tiene licencia");
            // $("#enlaceLicencia").attr("href", "");
            // $("#enlaceLicencia").html("Sin enlace");
            $("#enlaceLicencia").hide();
        }


        //console.log(datoReporte.clase_recuperacion);
        if(datoReporte.clase_recuperacion == true){
            $("#fechaRecuperacion").html(datoReporte.fecha_reposicion+" -> "+datoReporte.hora_reposicion);
            $("#avanzeRecuperacion").html(datoReporte.avanze_posicion);
            $("#plataformaRecuperacion").html(datoReporte.plataforma_reposicion);
            $("#claseRecuperacion").show();
        }else{
            $("#claseRecuperacion").hide();
        }
        let datosClase = {
            clase: "ejecutarConsultasEnlaces",
            metodo: "obtenerEnlacesClase",
            idClase: datoReporte.codigo_clase 
        };
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data:  datosClase,
            success: function (response) {
                let x = response.trim();
                if(x.length == 0){
                    $("#enlacesRecursos").hide();
                }else{
                    listaRecursos = JSON.parse(response);
                    console.log(listaRecursos);
                    $('#enlacesRecursos').empty();
                    $("#enlacesRecursos").show();
                    $('#enlacesRecursos').append("<h3 class='text-center'>Enlaces</h3>");
                    listaRecursos.forEach(element => {
                        // let aux = element.direccion_enlace_recurso;
                        // cadena = cadena + "<a href='"+element.direccion_enlace_recurso+"' target='_blank'>Enlace</a><br>";
                        $('#enlacesRecursos').append(
                            $(document.createElement('a')).prop({
                                target: '_blank',
                                href: element.direccion_enlace_recurso,
                                innerText: element.direccion_enlace_recurso
                            })
                            ).append(
                            $(document.createElement('br'))
                        );
                    });
                }

            }
        });
    });
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
            //console.log(response);
            listaFacultades = JSON.parse(response);
            $("#idFacultadaes").empty();
            listaFacultades.forEach(element => {
                $('#idFacultadaes').append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            });
            //let nombreFacultad = $("#idFacultadaes option:selected").text();
            //$("#nomFacultad").val(nombreFacultad);
            //console.log(nombreFacultad);
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
            //let nombreDepartamento = $("#idDepartamentos option:selected").text();
            //$("#nomDepartamento").val(nombreDepartamento);
            //console.log(nombreDepartamento);
            $("#btnBuscar").prop( "disabled", false );
        }
    });
}

function listarReporte(datosLaboratorio){
    $('#tablaHistorialReporte').dataTable().fnDestroy();
    tablaReporte = $("#tablaHistorialReporte").DataTable({
        responsive: true,
    language:{
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
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
            "data" : datosLaboratorio,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_reporte_lab"},
            {"data":"nombre_laboratorio"},
            {"data":"nombre_auxiliar_lab"}, 
            {"data":"trabajo_lab_hecho"},
            {"data": null,"defaultContent":"<button type='button' class='verDetalles btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
        ]
    });

}
