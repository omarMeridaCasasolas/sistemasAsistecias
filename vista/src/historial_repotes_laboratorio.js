var tablaReporte;
$(document).ready(function () {
    obtenerListaDeLaboratoriosAsignados();
    tablaReporte = $("#tablaHistorialReporteLaboratorio").DataTable();
});
function obtenerListaDeLaboratoriosAsignados(){
    let datosLaboratorio = {
        clase:"horarioAuxiliarLaboratorio",
        metodo: "listaLaboratoriosAsignados",
        idAuxiliarLab: $("#idAuxiliarLaboratorio").val()
    }
    // console.log(datosLaboratorio);
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosLaboratorio,
        success: function (response) {
            // console.log(response);
            let listaLaboratorios = JSON.parse(response);
            listaLaboratorios.forEach(element => {
                $('#selLaboratorio').append("<option value ="+element.id_laboratorio+">"+element.nombre_laboratorio+"</option>");
            });
        }
    });
}
$("#buscarReportesLab").submit(function (e) { 
    let laboratorio = $("#selLaboratorio").val();
    if(laboratorio != "Ninguno"){
        $('#tablaHistorialReporteLaboratorio').dataTable().fnDestroy();
        let datosLaboratorio = {
            clase: "horarioAuxiliarLaboratorio",
            metodo: "obtenerReportePorMetria",
            idAuxiliarLab: $("#idAuxiliarLaboratorio").val(),
            idLaboratorio: laboratorio
        };

        tablaReporte = $("#tablaHistorialReporteLaboratorio").DataTable({
            "ajax":{
                "method":"POST",
                "data" : datosLaboratorio,
                "url":"../controlador/interprete.php"
            },
            "columns":[
                {"data":"fecha_reporte_lab"},
                {"data":"trabajo_lab_hecho"},
                {"data":"obs_reporte_lab"}, 
                {"data":"doc_reporte_lab"},
                {"data": null,"defaultContent":"<button type='button' class='editarFacultad btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
            ]
        });

    }
    e.preventDefault();
    
});
