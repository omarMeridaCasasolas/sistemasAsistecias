$(document).ready(function() {
    $('#example').DataTable();
    listarTableDirectorCarrera();
    carrerasDisponibles();

    listarPersonalLaboratorio();
    
    listarTableDocente();

    listarTableAuxiliarDocente();
    //carrerasDisponibles();
    $("#formInsertarDocente").submit(function (e) { 
        let datosDocente = {
        clase: "Docente",
        metodo: "insertarDocente",
        nomDocente: $("#nomDocente").val(),
        ciDocente: $("#ciDocente").val(),
        correoDocente: $("#correoDocente").val(),
        telDocente: $("#telDocente").val(),
        sisDocente: $("#sisDocente").val(),
        passDocente: $("#passDocente").val()
        //Aqui se coloca el id que identifica a a la autoridad-Ambiente
        };
        $.post("../controlador/interprete.php",datosDocente,function(resp){
            if(resp == 1){
                $("#btnVentanaDocente").click();
                $("#formInsertarDocente")[0].reset();
                $("#exitoDocente").removeClass("d-none");
                $('#tablaDocente').dataTable().fnDestroy();
                listarTableDocente();
                //carrerasDisponibles();
            }else{
                $("#errorDocente").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    $("#formInsertarAuxiliarDocente").submit(function (e) { 
        let datosAuxiliarDocente = {
        clase: "AuxiliarDocente",
        metodo: "insertarAuxiliarDocente",
        nomAuxiliarDocente: $("#nomAuxiliarDocente").val(),
        ciAuxiliarDocente: $("#ciAuxiliarDocente").val(),
        correoAuxiliarDocente: $("#correoAuxiliarDocente").val(),
        telAuxiliarDocente: $("#telAuxiliarDocente").val(),
        sisAuxiliarDocente: $("#sisAuxiliarDocente").val(),
        passAuxiliarDocente: $("#passAuxiliarDocente").val()
        };
        $.post("../controlador/interprete.php",datosAuxiliarDocente,function(resp){
            if(resp == 1){
                $("#btnVentanaAuxiliarDocente").click();
                $("#formInsertarAuxiliarDocente")[0].reset();
                $("#exitoAuxiliarDocente").removeClass("d-none");
                $('#tablaAuxiliar').dataTable().fnDestroy();
                listarTableAuxiliarDocente();
                //carrerasDisponibles();
            }else{
                $("#errorAuxiliarDocente").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

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

    $("#formInsertarPersonalLaboratorio").submit(function (e) { 
        let datosPersonalDirectorio = {
        clase: "AuxiliarLaboratorio",
        metodo: "insertarAuxiliarLaboratorio",
        nomPersLab: $("#nomPersLab").val(),
        ciPersLab: $("#ciPersLab").val(),
        correoPersLab: $("#correoPersLab").val(),
        telPersLab: $("#telPersLab").val(),
        sisPersLab: $("#sisPersLab").val(),
        passPersLab: $("#passPersLab").val()
        };
        $.post("../controlador/interprete.php",datosPersonalDirectorio,function(resp){
            if(resp == 1){
                $("#btnCerrarPersLab").click();
                $("#formInsertarPersonalLaboratorio")[0].reset();
                $("#exitoPersLab").removeClass("d-none");
                $('#tablaPersonalLaboratorio').dataTable().fnDestroy();
                listarPersonalLaboratorio();
            }else{
                $("#errorPersLab").removeClass("d-none");
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
            let obj= JSON.parse(response);
            obj.forEach(element => {
                $('#asigDirector').append("<option value="+element.id_carrera+">"+element.nombre_carrera+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function listarPersonalLaboratorio(){
    $("#tablaPersonalLaboratorio").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'AuxiliarLaboratorio' , 'metodo':'listarTableAuxiliarLaboratorio'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_auxiliar_lab"},
            {"data":"activo_auxiliar_lab"},
            {"data":"correo_auxiliar_lab"},
            {"data":"telefono_auxiliar_lab"}
        ]
    });
}

function listarTableDocente(){
    $("#tablaDocente").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Docente' , 'metodo':'listarTableDocente'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_docente"},
            {"data":"activo_docente"},
            {"data":"telefono_docente"},
            {"data":"correo_docente"}
        ]
    });
}


function listarTableAuxiliarDocente(){
    $("#tablaAuxiliar").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'AuxiliarDocente' , 'metodo':'listarTableAuxiliarDocente'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_aux_docente"},
            {"data":"activo_aux_docente"},
            {"data":"telefono_aux_docente"},
            {"data":"correo_aux_docente"}
        ]
    });
}