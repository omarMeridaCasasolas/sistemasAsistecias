var tablaReporteDocente;
$(document).ready(function () {
    cargarReporteDocente();
});

function cargarReporteDocente(){
    let datosDocente = {
         clase: "Docente",
        metodo: "listarReportesDocenteDia",
        docente: $("#idDocente").val()
     };
    //console.log(datosDocente);
    tablaReporteDocente = $("#tablaReporteDocente").DataTable({
        "ajax":{
            "method":"POST",
            "data" : datosDocente,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"current_date"},
            {"data":"hora"},
            {"data":"nombre_grupo"},
            {"data":"nombre_materia"},

            {'defaultContent':"<textarea class='form-control' style='resize:none;'></textarea>"}, //contenido de clase
            //{"data":""}, //Plataforma o medio digital
            //{"data":""}, //Observacion

            {"data": null,"defaultContent":"<button type='button' class='editarPersonalLab btn btn-warning'><i class='far fa-edit'></i></button>	<button type='button' class='eliminarPersonalLab btn btn-danger'><i class='fas fa-trash-alt'></i></button>"}
        ]
    })
}