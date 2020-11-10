var tablaReporte;
$(document).ready(function () {
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
                    console.log(nombreAuxLaboratorio);
                    if(nombreAuxLaboratorio == "Todos"){
                        obtenerReportesAsociadosLaboratorio(nombreLaboratorio);
                    }else{
                        obtenerReportesAsociadosLabAuxiliar(nombreLaboratorio,nombreAuxLaboratorio)
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
            console.log(response);
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
        idlaboratorio: nombreLaboratorio
    };
    tablaReporte = $("#tablaHistorialReporte").DataTable({
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