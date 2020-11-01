var tablaFacultad;
$(document).ready(function() {
    $('#example').DataTable();
    //$('#tablaDirAcademico').DataTable();
    listarTableDirectorAcademico();
    facultadesDisponibles();
    mostarFacultades();
    listarDirectoresDisponibles();
    $("#formCrearFacultad").submit(function (e) { 
        let datosFacultad = {
        clase: "Facultad",
        metodo: "insertarFacultad",
        nomFacultad: $("#nomFacultad").val(),
        facCodigo: $("#facCodigo").val(),
        fechaCreacion: $("#facFechaCrea").val(), 
        dirFac: $("#dirFac").val(),
        };
        $.post("../controlador/interprete.php",datosFacultad,function(resp){
            if(resp == 1){
                $("#btnCerrarFacultad").click();
                // $("#exito").removeClass("d-none");
                $('#tableFacultad').dataTable().fnDestroy();
                swal("Se ha creado la facultad correctamente", $("#nomFacultad").val(), "success");
                $("#formCrearFacultad")[0].reset();
                mostarFacultades();
            }else{
                swal("No se pudo realizar la operacion", resp, "info");
                //$("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    $("#formEliminarFacultad").submit(function (e) { 
        let datosFacultad = {
        clase: "Facultad",
        metodo: "EliminarFacultad",
        idFacultad: $("#idFacultadEliminar").val()
        };
        $.post("../controlador/interprete.php",datosFacultad,function(resp){
            $("#btnCloseEliminarFacultad").click();
            if(resp == 1){
                // $("#exito").removeClass("d-none");
                $('#tableFacultad').dataTable().fnDestroy();
                swal("Se ha Eliminado la facultad", $("#nomFacultadEliminar").html(), "success");
                $("#formEliminarFacultad")[0].reset();
                mostarFacultades();
            }else{
                swal("No se pudo realizar la operacion", resp, "warning");
                //$("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    $("#formEditarFacultad").submit(function (e) { 
        let datosFacultad = {
        clase: "Facultad",
        metodo: "EditarFacultad",
        idFacultad: $("#idFacultadEditar").val(),
        nomEditFacultad: $("#nomEditFacultad").val(),
        facEditCodigo: $("#facEditCodigo").val(),
        facEditFechaCrea: $("#facEditFechaCrea").val(),
        dirEditFac: $("#dirEditFac").val()
        };
        console.log(datosFacultad);
        $.post("../controlador/interprete.php",datosFacultad,function(resp){
            $("#btnCloseEditarFacultad").click();
            if(resp == 1){
                // $("#exito").removeClass("d-none");
                $('#tableFacultad').dataTable().fnDestroy();
                swal("Se ha Eliminado la facultad",  $("#nomEditFacultad").val(), "success");
                $("#formEditarFacultad")[0].reset();
                mostarFacultades();
            }else{
                swal("No se pudo realizar la operacion", resp, "warning");
                //$("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

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
            $("#btnCerrarAutoridad").click();
            if(resp == 1){
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

    $("#tableFacultad tbody").on('click','button.editarFacultad',function () {
        var dataEdit = tablaFacultad.row( $(this).parents('tr') ).data();
        $("#nomEditFacultad").val(dataEdit.nombre_facultad);
        $("#facEditCodigo").val(dataEdit.codigo_facultad);
        $("#facEditFechaCrea").val(dataEdit.fecha_creacion);
        $("#dirEditFac").val(dataEdit.director_academico);
        $("#idFacultadEditar").val(dataEdit.id_facultad);
        //console.log(dataEdit);
    });

    $("#tableFacultad tbody").on('click','button.eliminarFacultad',function () {
        var dataDelete = tablaFacultad.row( $(this).parents('tr') ).data();
        //console.log(dataDelete);
        $("#nomFacultadEliminar").html(dataDelete.nombre_facultad);
        $("#codFacultadEliminar").html(dataDelete.codigo_facultad);
        $("#idFacultadEliminar").val(dataDelete.id_facultad);
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

function mostarFacultades(){
    tablaFacultad =$("#tableFacultad").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Facultad' , 'metodo':'listarFacultades'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"codigo_facultad"},
            {"data":"nombre_facultad"},
            {"data":"fecha_creacion"}, 
            {"data":"director_academico"},
            {"data": null,"defaultContent":"<button type='button' class='editarFacultad btn btn-warning' data-toggle='modal' data-target='#myModal4'><i class='far fa-edit'></i></button>	<button type='button' class='eliminarFacultad btn btn-danger' data-toggle='modal' data-target='#myModal5'><i class='fas fa-trash-alt'></i></button>"}
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

function listarDirectoresDisponibles(){
    let datosDirector = {
        clase: "Director",
        metodo: "directoresAcademicosDisponibles"
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosDirector,
        success: function (response) {
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