$(document).ready(function() {
    $('#example').DataTable();
    //$('#tablaDirAcademico').DataTable();
    listarTableDirectorAcademico();
    facultadesDisponibles();
    $("#formAgregarDirectorAcademico").submit(function (e) { 
        let datosDirectorAcademico = {
        clase: "Director",
        metodo: "insertarDirectorAcademico",
        nomDirAcad: $("#nomDirAcad").val(),
        ciDirAcad: $("#ciDirAcad").val(),
        correoDirAcad: $("#correoDirAcad").val(),
        telDirAcad: $("#telDirAcad").val(),
        facDirAcad: $("#facDirAcad").val(),
        sisDirAcad: $("#sisDirAcad").val(),
        passDirAcad: $("#passDirAcad").val()
        };
        $.post("../controlador/interprete.php",datosDirectorAcademico,function(resp){
            if(resp == 1){
                $("#btnCerrarAutoridad").click();
                $("#formAgregarDirectorAcademico")[0].reset();
                $("#exito").removeClass("d-none");
                $('#tablaDirAcademico').dataTable().fnDestroy();
                listarTableDirectorAcademico();
            }else{
                $("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });
});

function listarTableDirectorAcademico(){
    $("#tablaDirAcademico").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Director' , 'metodo':'listarDirectoresAcademicos'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_director"},
            {"data":"director_actual"},
            {"data":"correo_electronico_director"},
            {"data":"telefono_director"}
        ]
    });
}
function facultadesDisponibles(){
    let datosFacultad = {
        clase: "Facultad",
        metodo: "facultadesDisponibles"
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosFacultad,
        success: function (response) {
            console.log(response);
            let obj= JSON.parse(response);
            obj.forEach(element => {
                $('#facDirAcad').append("<option>"+element.nombre_facultad+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}