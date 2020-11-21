var tablaReporte;
$(document).ready(function () {
    $('#tablaHistorialReporte').DataTable( {
        "language": {
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
            "sLoadingRecords": "Cargando..."
        }
    });

    $("#tipoUnidad").change(function (e) {
        let tipoUnidad = $("#tipoUnidad").val();
        console.log(tipoUnidad);
        switch (tipoUnidad) {
            case "Ninguno":
                if($("#elemGrupo").hasClass("d-block")){
                    $("#elemGrupo").removeClass("d-block");
                    $("#elemGrupo").addClass("d-none");
                }
                break;
            case "Laboratorios":
                $("#labNombre").html("Selecione laboratorio");
                $("#elemGrupo").removeClass("d-none");
                $("#elemGrupo").addClass("d-block");
                actulaizarListaDeDepartamentosLab();
                break;
            default:
                break;
        }
        e.preventDefault();
    });

    $("#tipoGrupo").change(function (e) {
        let tipoUnidad = $("#tipoGrupo").val();
        console.log(tipoUnidad);
        if(tipoUnidad == "Todos"){
            if($("#elemNombre").hasClass("d-block")){
                $("#elemNombre").removeClass("d-block");
                $("#elemNombre").addClass("d-none");
            }
        }else{
                $("#elemNombre").removeClass("d-none");
                $("#elemNombre").addClass("d-block");
            obtenerAuxliaresDeLaboratorioPorUnidad();
        }
        e.preventDefault();
    });

    $("#formBusquedaReportes").submit(function (e) { 
        let tipoUnidad = $("#tipoUnidad").val();
        switch (tipoUnidad) {
            case "Laboratorios":
                let nombreLaboratorio = $("#tipoGrupo").val();
                if(nombreLaboratorio == "Todos"){
                    obtenerTodosReportesLaboratorio();
                }else{
                    let nombreAuxLaboratorio = $("#TipoNombre").val();
                    if(nombreAuxLaboratorio == "Todos"){
                        obtenerReportesAsociadosLaboratorio(nombreLaboratorio);
                    }else{
                        obtenerReportesAsociadosLabAuxiliar(nombreLaboratorio,nombreAuxLaboratorio);
                    }
                }
                break;
            case "Docente":
                console.log("Docente "+tipoUnidad);    
                break;
            case "Auxiliar de docencia":
                console.log("Auxilia docencia "+tipoUnidad);
                break;
            
            default:
                break;
        }
        e.preventDefault();
        
    });
});

function actulaizarListaDeDepartamentosLab(){
    let datosTipo = {
        clase: "Laboratorio",
        metodo: "reporteDeLaboratorios",
        idDepartamento: $("#idDepartamento").val()
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosTipo,
        success: function (response) {
            let listaLaboratorios = JSON.parse(response);
            listaLaboratorios.forEach(element => {
                $("#tipoGrupo").append("<option value='"+element.id_laboratorio+"'>"+element.nombre_laboratorio+"</option>");
            });
        }
    });
}

function obtenerAuxliaresDeLaboratorioPorUnidad(){
    let datosTipo = {
        clase: "AuxiliarLaboratorio",
        metodo: "listaDeAuxiliaresLabTrabajando",
        idDepartamento: $("#idDepartamento").val(),
        idLaboratorio: $("#tipoGrupo").val()
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosTipo,
        success: function (response) {
            console.log(response);
            let listaLaboratorios = JSON.parse(response);
            listaLaboratorios.forEach(element => {
                $("#TipoNombre").append("<option value='"+element.id_aux_laboratorio+"'>"+element.nombre_auxiliar_lab+"</option>");
            });
        }
    });
}
function obtenerTodosReportesLaboratorio(){
    $('#tablaHistorialReporte').dataTable().fnDestroy();
    let datosReporte = {
        clase: "horarioAuxiliarLaboratorio",
        metodo: "obtenerTodoReporteLaboratorio",
        idDepartamento: $("#idDepartamento").val()
    };
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
            "data" : datosReporte,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_reporte_lab"},
            {"data":"nombre_laboratorio"},
            {"data":"nombre_auxiliar_lab"},
            {"data":"trabajo_lab_hecho"},
            {"data":"obs_reporte_lab"}, 
            {"data":"doc_reporte_lab"},
            {"data": null,"defaultContent":"<button type='button' class='editarFacultad btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
        ]
    });
}

function obtenerReportesAsociadosLaboratorio(nombreLaboratorio){
    $('#tablaHistorialReporte').dataTable().fnDestroy();
    let datosReporte = {
        clase: "horarioAuxiliarLaboratorio",
        metodo: "obtenerReporteLaboratorioEspecfico",
        idDepartamento: $("#idDepartamento").val(),
        idLaboratorio: nombreLaboratorio
    };
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
            "data" : datosReporte,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_reporte_lab"},
            {"data":"nombre_laboratorio"},
            {"data":"nombre_auxiliar_lab"},
            {"data":"trabajo_lab_hecho"},
            {"data":"obs_reporte_lab"}, 
            {"data":"doc_reporte_lab"},
            {"data": null,"defaultContent":"<button type='button' class='editarFacultad btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
        ]
    });
}

function obtenerReportesAsociadosLabAuxiliar(nombreLaboratorio,nombreAuxLaboratorio){
    $('#tablaHistorialReporte').dataTable().fnDestroy();
    let datosReporte = {
        clase: "horarioAuxiliarLaboratorio",
        metodo: "obtenerReporteLaboratorioPorNombreAux",
        idDepartamento: $("#idDepartamento").val(),
        idLaboratorio: nombreLaboratorio,
        idAuxiliar: nombreAuxLaboratorio
    };
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
            "data" : datosReporte,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_reporte_lab"},
            {"data":"nombre_laboratorio"},
            {"data":"nombre_auxiliar_lab"},
            {"data":"trabajo_lab_hecho"},
            {"data":"obs_reporte_lab"}, 
            {"data":"doc_reporte_lab"},
            {"data": null,"defaultContent":"<button type='button' class='editarFacultad btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
        ]
    });
}
