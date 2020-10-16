$(document).ready(function() {
    $('#example').DataTable();
    listarTableDirectorCarrera();
    carrerasDisponibles();

    listarTablePersonalLaboratorio();

    $("#formInsertarDirector").submit(function (e) { 
        let datosDirector = {
        clase: "Director",
        metodo: "insertarDirectorCarrera",
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
                listarTableDirectorCarrera();
                carrerasDisponibles();
            }else{
                $("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });
    
});

function listarTableDirectorCarrera(){
    $("#tablaDirector").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Director' , 'metodo':'listarTableDirectorCarrera'},
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

function carrerasDisponibles(){
    let datosAmbiente = {
        clase: "Carrera",
        metodo: "carreraDisponibles",
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
                $('#asigDirector').append("<option value="+element.id_carrera+">"+element.nombre_carrera+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });


    function listarTablePersonalLaboratorio(){
        $("#tablaPersonalLaboratorio").DataTable({
            "ajax":{
                "method":"POST",
                "data" : {'clase': 'AuxiliarLaboratorio' , 'metodo':'listarTableAuxiliarLaboratorio'},
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
    
}
