var tablaDeAdministrador;
$(document).ready(function () {
    $("#tablaMateriaAuxiliares").DataTable();
    listaDeFacultades();
    $("#idFacultadaes").change(function() {
        listaDepartamentos();
        $("#idAuxPizarra").empty();
        $("#idMateria").empty();
    });
    $("#idDepartamentos").change(function() {
        listaAuxiliaresPizarra();
        $("#idMateria").empty();
    });
    $("#idAuxPizarra").change(function() {
        listaMateriasAuxiliaresPizarra();
    });

    $("#formObtenerReporte").submit(function (e) {
        let departamento = $("#idDepartamentos").val();
        let auxiliar = $("#idAuxPizarra").val();
        let materia = $("#idMateria").val();
        if(departamento == "Ninguno" && auxiliar == "Ninguno" && materia == "Ninguno"){
           $("#descResultado").html("Selecione todos los campos!!");     
        }else{
            $("#descResultado").html("");
            $('#tablaMateriaAuxiliares').dataTable().fnDestroy();
            tablaDeAdministrador =$("#tablaMateriaAuxiliares").DataTable({
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
                    "data" : {'clase': 'Materia' , 'metodo':'obtenerReporteMes','fechaAntes': '2020-11-01','fechaDespues': '2020-11-30','idAuxiliar': auxiliar,'idMateria': materia, 'idDepartamento': departamento},
                    "url":"../controlador/interprete.php"
                },
                "columns":[
                    {"data":"fecha_clase"},
                    {"data":"nombre_materia"},
                    {"data":"codigo_materia"}, 
                    {"data":"plataforma_clase"},
                    {"data":"existe_falta_clase"},
                    {"data": null,"defaultContent":"<button type='button' class='revisarInforme btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal4'><i class='far fa-edit'></i></button>"}
                ]
            });
            // let datosMateria = {
            //     clase = "Clase",
            //     metodo = "obtenerReporteMes",
            //     mes = "11",
            //     idAuxiliar: auxiliar,
            //     idMateria: materia
            // };

        } 
        e.preventDefault();
    });

    $("#tablaMateriaAuxiliares tbody").on('click','button.revisarInforme',function () {
        var dataEdit = tablaDeAdministrador.row( $(this).parents('tr') ).data();
        console.log(dataEdit);
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
    });

    $("#formEditarFacultad").submit(function (e) { 
        let radioValue = $("input[name='optradio']:checked").val();
        // console.log(radioValue);
        let datosReporte = {
            clase: 'Clase',
            metodo: 'enviarReporteAsistenciaDPA',
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
                    crearTabla();
                    $("#btnCloseEditarFacultad").click();
                    $("#formEditarFacultad")[0].reset();
                }else{
                    Swal.fire('Error',response,'info');
                    crearTabla();
                    $("#btnCloseEditarFacultad").click();
                    $("#formEditarFacultad")[0].reset();
                }
            }
        });

        e.preventDefault();
        
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
            // console.log(response);
            listaFacultades = JSON.parse(response);
            $("#idFacultadaes").empty();
            listaFacultades.forEach(element => {
                $('#idFacultadaes').append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            });
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
            listaAuxiliaresPizarra();
        }
    });
}

function listaAuxiliaresPizarra(){
    let datosAuxPizarra = {
        clase: "AuxiliarDocente",
        metodo: "listaDeAuxiliares",
        idDepartamento: $("#idDepartamentos").val(),
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosAuxPizarra,
        success: function (response) {
            // console.log(response);
            let listaAuxPizarra = JSON.parse(response);
            $("#idAuxPizarra").empty();
            if(listaAuxPizarra.length == 0){
                $('#idAuxPizarra').append("<option value='Ninguno'>No existe datos</option>");
            }else{
                listaAuxPizarra.forEach(element => {
                    $('#idAuxPizarra').append("<option value='"+element.id_aux_docente+"'>"+element.nombre_aux_docente+"</option>");
                });
            }
            listaMateriasAuxiliaresPizarra();
        }
    });
}

function listaMateriasAuxiliaresPizarra(){
    let datosAuxPizarra = {
        clase: "Materia",
        metodo: "listaMateriaAuxPizarra",
        idAuxPizarra: $("#idAuxPizarra").val(),
    }
    console.log(datosAuxPizarra);
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosAuxPizarra,
        success: function (response) {
            // console.log(response);
            let listaMateria = JSON.parse(response);
            $("#idMateria").empty();
            if(listaMateria.length == 0){
                $('#idMateria').append("<option value='Ninguno'>No existe datos</option>");
            }else{
                listaMateria.forEach(element => {
                    $('#idMateria').append("<option value='"+element.id_materia+"'>"+element.nombre_materia+" - "+element.codigo_materia+"</option>");
                });
            }
        }
    });
}

// function crearTabla(){
//     $("#descResultado").html("");
//             $('#tablaMateriaAuxiliares').dataTable().fnDestroy();
//             tablaDeAdministrador =$("#tablaMateriaAuxiliares").DataTable({
//                 responsive: true,
//                 language:{
//                     "sProcessing":     "Procesando...",
//                     "sLengthMenu":     "Mostrar _MENU_ registros",
//                     "sZeroRecords":    "No se encontraron resultados",
//                     "sEmptyTable":     "Ningún reporte para evaluar",
//                     "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//                     "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
//                     "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
//                     "sInfoPostFix":    "",
//                     "sSearch":         "Buscar:",
//                     "sUrl":            "",
//                     "sInfoThousands":  ",",
//                     "sLoadingRecords": "Cargando...",
//                     "oPaginate": {
//                         "sFirst":    "Primero",
//                         "sLast":     "Último",
//                         "sNext":     "Siguiente",
//                         "sPrevious": "Anterior"
//                     },
//                     "oAria": {
//                         "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
//                         "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//                     },
//                     "buttons": {
//                         "copy": "Copiar",
//                         "colvis": "Visibilidad"
//                     }
//                 },
//                 "ajax":{
//                     "method":"POST",
//                     "data" : {'clase': 'Materia' , 'metodo':'obtenerReporteMes','fechaAntes': '2020-11-01','fechaDespues': '2020-11-30','idAuxiliar': auxiliar,'idMateria': materia, 'idDepartamento': departamento},
//                     "url":"../controlador/interprete.php"
//                 },
//                 "columns":[
//                     {"data":"fecha_clase"},
//                     {"data":"nombre_materia"},
//                     {"data":"codigo_materia"}, 
//                     {"data":"plataforma_clase"},
//                     {"data":"existe_falta_clase"},
//                     {"data": null,"defaultContent":"<button type='button' class='revisarInforme btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal4'><i class='far fa-edit'></i></button>"}
//                 ]
//             });
// }

