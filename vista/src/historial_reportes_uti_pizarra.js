var tablaReporte;
$(document).ready(function () {
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

    $("#buscarReportesDocentes").submit(function (e) { 
        datosDocentes = {
            clase: "Clase",
            metodo: "listarClasesAuxiliares",
            idFacultad: $("#idFacultadaes").val(),
            idDepartamento: $("#idDepartamentos").val()
        };
        listarReporte(datosDocentes);
        e.preventDefault();
    })

    $("#tablaHistorialReporte tbody").on('click','button.verDetalles',function () {
        let datoReporte = tablaReporte.row( $(this).parents('tr') ).data();
        //console.log(datoReporte );
        $("#fechaClase").html(datoReporte.fecha_clase+" -> "+datoReporte.periodo_hora_clase);
        $("#nomMateria").html(datoReporte.nombre_materia);
        $("#nomResponsable").html(datoReporte.nombre_aux_docente);
        $("#idAvance").html(datoReporte.contenido_clase);
        $("#idPlataforma").html(datoReporte.plataforma_clase);
        $("#idObservacion").html(datoReporte.observaciones_clase);
        $("#idAsistencia").val(String(datoReporte.existe_falta_clase));
        console.log(datoReporte.existe_falta_clase);
        let licencia =  datoReporte.clase_con_licencia;
        if(licencia == true){
            $("#asuntoLicencia").html(datoReporte.descripcion_licencia);
            $("#enlaceLicencia").attr("href", datoReporte.enlace_licencia);
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

function listarReporte(datosDocentes){
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
            "data" : datosDocentes,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_clase"},
            {"data":"periodo_hora_clase"},
            {"data":"nombre_materia"}, 
            {"data":"nombre_aux_docente"},
            {"data":"contenido_clase"},
            {"data": null,"defaultContent":"<button type='button' class='verDetalles btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
        ]
    });

}
