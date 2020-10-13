$(document).ready(function () {
    //listarTableFacultadad();
    ("#facultadTable").DataTable();
});

/*
function listarTableFacultadad(){
    $("#facultadTable").DataTable({
        "ajax":{
            "method":"POST",
            "url":"src/prueba.php"
        },
        "columns":[
            {"data":"codigo_facultad"},
            {"data":"nombre_facultad"},
            {"data":"fecha_creacion"},
            {"data":"director_academico"}
        ]
    });
}
*/