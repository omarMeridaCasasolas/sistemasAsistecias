var tablaReporte;
$(document).ready(function () {
    $('#tablaHistorialReporte').DataTable( {
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "Selecione elementos a buscar",
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

    $("#tablaHistorialReporte tbody").on('click','button.verDetalles',function () {
        var dataReporte = tablaReporte.row( $(this).parents('tr') ).data();
        $("#fechaReporte").html(dataReporte.fecha_reporte_lab);
        $("#laboratorioReporte").html(dataReporte.nombre_laboratorio);
        $("#responsableReporte").html(dataReporte.nombre_auxiliar_lab);
        $("#trabajoReporte").html(dataReporte.trabajo_lab_hecho);
        $("#obsReporte").html(dataReporte.obs_reporte_lab);
        let revision = dataReporte.revision;
        //$("#reporteAsistencia").val(revision); 
        if(revision != undefined){
            $("#reporteAsistencia").val(revision);
        }
        console.log(revision);

        if(dataReporte.doc_reporte_lab != ""){
            $("#enlaceReporte").removeClass("d-none");
            $("#enlaceReporte").addClass("d-inline-block");
            $("#enlaceReporte").attr("href", dataReporte.doc_reporte_lab)
        }else{
            $("#enlaceReporte").removeClass("d-inline-block");
            $("#enlaceReporte").addClass("d-none");
            $("#enlaceReporte").hide();
        }
        let x = dataReporte.sol_licencia;
        //console.log(x);
        if(dataReporte.sol_licencia != undefined){
            $("#contLicencia").show();
            $("#motivoLicencia").html(dataReporte.desc_licencia);
            if(dataReporte.enl_licencia != undefined){
                $("#enlaceLicencia").removeClass("d-none");
                $("#enlaceLicencia").addClass("d-inline-block");
                $("#enlaceLicencia").attr("href", dataReporte.enl_licencia);
                $("#enlaceLicencia").html("Enlace");
            }else{
                $("#enlaceLicencia").removeClass("d-inline-block");
                $("#enlaceLicencia").addClass("d-none");
                $("#enlaceLicencia").hide();
            }
        }else{
            $("#contLicencia").hide();
        }
    });

    // $("#tipoUnidad").change(function (e) {
    //     let tipoUnidad = $("#tipoUnidad").val();
    //     console.log(tipoUnidad);
    //     switch (tipoUnidad) {
    //         case "Ninguno":
    //             if($("#elemGrupo").hasClass("d-block")){
    //                 $("#elemGrupo").removeClass("d-block");
    //                 $("#elemGrupo").addClass("d-none");
    //             }
    //             break;
    //         case "Laboratorios":
    //             $("#labNombre").html("Selecione laboratorio");
    //             $("#elemGrupo").removeClass("d-none");
    //             $("#elemGrupo").addClass("d-block");
    //             actulaizarListaDeDepartamentosLab();
    //             break;
    //         default:
    //             break;
    //     }
    //     e.preventDefault();
    // });

    actulaizarListaDeDepartamentosLab();

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
        // let tipoUnidad = $("#tipoUnidad").val();
        // switch (tipoUnidad) {
        //     case "Laboratorios":
        //         let nombreLaboratorio = $("#tipoGrupo").val();
        //         if(nombreLaboratorio == "Todos"){
        //             obtenerTodosReportesLaboratorio();
        //         }else{
        //             let nombreAuxLaboratorio = $("#TipoNombre").val();
        //             if(nombreAuxLaboratorio == "Todos"){
        //                 obtenerReportesAsociadosLaboratorio(nombreLaboratorio);
        //             }else{
        //                 obtenerReportesAsociadosLabAuxiliar(nombreLaboratorio,nombreAuxLaboratorio);
        //             }
        //         }
        //         break;
        //     case "Docente":
        //         console.log("Docente "+tipoUnidad);    
        //         break;
        //     case "Auxiliar de docencia":
        //         console.log("Auxilia docencia "+tipoUnidad);
        //         break;
            
        //     default:
        //         break;
        // }
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
            $("#tipoGrupo").empty();
            $("#tipoGrupo").append("<option value='Todos'>Todos</option>");
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
            {"data": null,"defaultContent":"<button type='button' class='verDetalles btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
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
            {"data": null,"defaultContent":"<button type='button' class='verDetalles btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
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
            {"data": null,"defaultContent":"<button type='button' class='verDetalles btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
        ]
    });
}
