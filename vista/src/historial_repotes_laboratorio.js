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
                {"data":"trabajo_lab_hecho"},
                {"data":"obs_reporte_lab"}, 
                //{"data":"doc_reporte_lab"},
                //{"data": "<a href='doc_reporte_lab' target='_blank'>Enlace</a>"},
                { 
                    "data": "doc_reporte_lab",
                    "render": function(data, type, row, meta){
                       if(type === 'display'){
                           data = '<a  href="' + data + '" + target="_blank">' + optenerNombre(data); + '</a>';
                       }
           
                       return data;
                    }
                 }, 
                {"data": null,"defaultContent":"<button type='button' class='editarFacultad btn btn-warning' data-toggle='modal' data-target='#myModal4'> ver detalles </button>"}
            ]
        });

    }
    e.preventDefault();
    
});

function optenerNombre(cadena){
    if(cadena !=null){
        let arreglo = cadena.split('/');
        //console.log(arreglo);
        let nom = arreglo[arreglo.length-1];
        //console.log(nom);
        return decodeURIComponent(nom);
    } 
    return "";
}