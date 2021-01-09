var tablaLicencias;
$(document).ready(function () {
    let res = $("#idDocente").val();
    console.log(res);
    mostarLicencias();
});

function mostarLicencias(){
    $('#tablaLicencias').dataTable().fnDestroy();
    tablaFacultad =$("#tablaLicencias").DataTable({
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
            "data" : {'clase': 'Clase' , 'metodo':'listarLicenciasDocente' ,'idUsuario': $("#idDocente").val()},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_clase"},
            {"data":"periodo_hora_clase"},
            {"data":"nombre_materia"}, 
            {"data":"descripcion_licencia"},
            {"data": "enlace_licencia",
                "fnCreatedCell": function (nTd, sData, oData, iRow, iCol) {
                    console.log(oData);
                    if(oData.enlace_licencia == null){
                        $(nTd).html("<h5>Sin recurso</h5>");
                    }else{
                        $(nTd).html("<a href='"+oData.enlace_licencia+"'>"+(oData.enlace_licencia).substr(52)+"</a>");
                    }
                }
            }
        ]
    });
}