$(document).ready(function() {
    $('#example').DataTable();
    listarTableDirectorDepartamental();
    departamentosDisponibles();
    $("#formInsertarDirector").submit(function (e) { 
        let datosDirector = {
        clase: "Director",
        metodo: "insertarDirectorDepartamental",
        nomDirector: $("#nomDirector").val(),
        ciDirector: $("#ciDirector").val(),
        correoDirector: $("#correoDirector").val(),
        telDirector: $("#telDirector").val(),
        asigDirector: $("#asigDirector").val(),
        textDirector: $("#asigDirector option:selected").text(),
        sisDirector: $("#sisDirector").val(),
        passDirector: $("#passDirector").val()
        //Aqui se coloca el id que identifica a a la autoridad-Ambiente
        };
        $.post("../controlador/interprete.php",datosDirector,function(resp){
            if(resp == 1){
                $("#btnCerrarAutoridad").click();
                $("#formInsertarDirector")[0].reset();
                $("#exito").removeClass("d-none");
                $('#tablaDirector').dataTable().fnDestroy();
                listarTableDirectorDepartamental();
                departamentosDisponibles();
            }else{
                $("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });
    
});

function listarTableDirectorDepartamental(){
    $("#tablaDirector").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Director' , 'metodo':'listarDirectoresDepartamentales'},
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

function departamentosDisponibles(){
    let datosAmbiente = {
        clase: "Departamento",
        metodo: "departamentosDisponibles",
        categoria: $("#idCategoria").val()
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosAmbiente,
        success: function (response) {
            $('#asigDirector').children('option:not(:first)').remove();
            console.log(response);
            let obj= JSON.parse(response);
            obj.forEach(element => {
                $('#asigDirector').append("<option value="+element.id_departamento+">"+element.nombre_departamento+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
    
}
