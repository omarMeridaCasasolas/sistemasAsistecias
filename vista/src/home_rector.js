var tablaFacultad, tablaDirector,passwordActual;
$(document).ready(function() {

    let d = new Date();
    let date = d.getDate();
    let month = d.getMonth()+1;
    let year = d.getFullYear();
    if (month < 10) {
        month = '0' + month;
    }
    if (date < 10) {
        date = '0' + date;
    }
    $("#div_date_time").html(year + "-" + month + "-" + date);

    let URLActual = location.href;
    //console.log(URLActual);
    let listaValores = URLActual.split("?");
    if(listaValores.length>=2){
        let parametros = listaValores[listaValores.length-1].split("=");
        if(parametros[1] == "success"){
            Swal.fire('Exito',"Se ha actualizados sus datos personales",'success');
        }else{
            Swal.fire('Problema',"Problemas al actulizar sus datos",'info');
        }
    }

    $("#formEnviarCorreos").submit(function (e) { 
        datos = {
            clase: "Correo",
            metodo: "enviarCorreoSimple",
            to: $("#destinoCorreo").val(),
            asunto: $("#fromMail").val() +" || "+ $("#idCorreoAsunto").val(), 
            descripcion: $("#descCorreo").html()
        };
        console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                //console.log(response);
                let res = response.trim();
                if(res == "2021"){
                    Swal.fire("Exito","Se a enviado el correo a: "+datos.to,"success");
                }else{
                    Swal.fire("Problema",res,"info");
                }
            }
        });
        $("#btnCerrarVtnMail").click();
        e.preventDefault();
    });

    facultadesDisponibles();
    mostarFacultades();
    //listarDirectoresDisponibles();
    mostrarListaDirectoresAcademicos();
    mostrarFuncionalidades();
    
    obtnerDatosPropios(); 

    $("#editFormSelf").submit(function (e) { 
        let getPass= $("#editPass").val();
        console.log(getPass);
        if(passwordActual != getPass){
            $("#editUsurPassSelf").html("*Ingrese su contraseña vigente");
            e.preventDefault();
        }else{
            $("#editUsurPassSelf").html("");
            if($("#nuevoPass").val() != $("#repeatPAss").val()){
                $("#changePassUser").html("Las contraseña tienen que concidir!!");
                e.preventDefault();
            }
        }
    });

    $(document).on("click", "#crearDirectorAcademico", function(){   
        cargarFacultadesDisponibles("formCrearFacAsiDirAca");     ;
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $(".modal-title").text("Crear director academico");
        $('#modalCrearDirector').modal('show');     
    });

    $("#formCrearDirectorAcademico").submit(function (e) { 
        let asignacion = $("#formCrearFacAsiDirAca option:selected").text();
        console.log(asignacion);
        let datosDirectorAcademico = {
        clase: "Director",
        metodo: "insertarDirectorAcademico",
        nomDirAcad: $("#formCrearnomDirAca").val(),
        ciDirAcad: $("#formCrearCiDirAca").val(),
        correoDirAcad: $("#formCrearCorDirAca").val(),
        telDirAcad: $("#formCrearTelDirAca").val(),
        idfacDirAcad: $("#formCrearFacAsiDirAca").val(),
        facDirAcad: asignacion,
        sisDirAcad: $("#formCrearCodSisDirAca").val(),
        passDirAcad: $("#formCrearPasDirAca").val()
        };
        $.post("../controlador/interprete.php",datosDirectorAcademico,function(resp){
            console.log(resp);
            if(resp == 1){
                $("#btnCancelarNuevoDirector").click();
                if(asignacion == "Ninguno"){
                    Swal.fire('Exito',"Se ha creado el usuario :"+$("#formCrearnomDirAca").val(),'success');
                }else{
                    let dataFacultad = {
                        clase: 'Facultad',
                        metodo: 'AsignarDirectorFacultad',
                        idFacultad: $("#formCrearFacAsiDirAca").val(),
                        nomDirector:  $("#formCrearnomDirAca").val()
                    }
                    $.ajax({
                        type: "POST",
                        url: "../controlador/interprete.php",
                        data: dataFacultad,
                        success: function (response) {
                            console.log(response);
                            if(response == 1){
                                Swal.fire('Exito',"Se ha creado el usuario :"+$("#formCrearnomDirAca").val(),'success');
                            }else{
                                Swal.fire('Error',response,'warning');    
                            }
                        }
                    });
                }
                $("#formCrearDirectorAcademico")[0].reset();
                $('#tablaDirAcademico').dataTable().fnDestroy();
                mostrarListaDirectoresAcademicos();
                mostarFacultades();
            }else{
                Swal.fire('Error',res,'warning');
            }
        });
        e.preventDefault();
    });

    //EditarDirector        
    $("#tablaDirAcademico tbody").on('click','button.btnEditarDirector',function () {
        var dataEditDirector = tablaDirector.row( $(this).parents('tr') ).data();
        $("#idDirectorEdit").val(dataEditDirector.id_ditector);
        $("#formEditarNomDirAca").val(dataEditDirector.nombre_director);
        $("#formEditarCodSisDirAca").val(dataEditDirector.codigo_sis_director);
        $("#formEditarTelDirAca").val(dataEditDirector.telefono_director);
        $("#formEditarCorDirAca").val(dataEditDirector.correo_electronico_director);
        $("#nomDirectorEditFac").val(dataEditDirector.director_actual);
        $("#idFacultadActDir").val(dataEditDirector.id_facultad);
        //console.log(dataEditDirector);
        $("#formEditarFacAsiDirAca").empty();
        let datoFacultad = {
            clase: "Facultad",
            metodo: "facultadesDisponibles"
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datoFacultad,
            success: function (response) {
                let obj= JSON.parse(response);
                //$('#formEditarFacAsiDirAca').append("<option value='"+666+"'>Ninguno</option>");
                //$('#formEditarFacAsiDirAca').append("<option value='"+dataEditDirector.id_facultad+"'>"+dataEditDirector.director_actual+"</option>");
                $('#facDirAcad').append('<option value="">Selecione una opcion</option>');

                obj.forEach(element => {
                    $('#formEditarFacAsiDirAca').append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
                });
                if(dataEditDirector.director_actual == "Ninguno"){
                    $("#formEditarFacAsiDirAca").val(666);
                }else{
                    $("#formEditarFacAsiDirAca").val(dataEditDirector.id_facultad);
                }
            }
        });
    });
    
    $('#formEditarDirector').submit(function(e){
        let datosDirector={
            clase: "Director",
            metodo: "actualizarDirectorAcademico",
            idDirector: $("#idDirectorEdit").val(),
            nomDirector: $("#formEditarNomDirAca").val(),
            codSis: $("#formEditarCodSisDirAca").val(),
            telDirector: $("#formEditarTelDirAca").val(),
            correoDirector: $("#formEditarCorDirAca").val(),
            idFacultad: $("#formEditarFacAsiDirAca").val(),
            nomFacultadAsig: $("#formEditarFacAsiDirAca option:selected").text()
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datosDirector,
            success: function (response) {
                if(response == 1){
                    //console.log($("#formEditarFacAsiDirAca option:selected").text());
                    //console.log($("#nomDirectorEditFac").val());
                    if($("#formEditarFacAsiDirAca option:selected").text() == $("#nomDirectorEditFac").val()){
                        //mostrarListaDirectoresAcademicos();
                        Swal.fire("Exito","Se a actualizado el director Academico","success");
                    }else{ //Facultad existente a ninguno
                        if($("#formEditarFacAsiDirAca option:selected").text() == "Ninguno"){
                            let datosFacultad =  {
                                clase: "Facultad",
                                metodo: "cambiarDirectorNinguno",
                                idFacultad: $("#idFacultadActDir").val(),
                                }
                            console.log(datosFacultad);
                            $.ajax({
                                type: "POST",
                                url: "../controlador/interprete.php",
                                data: datosFacultad,
                                success: function (res) {
                                    console.log(res);
                                    if(res == 1){
                                        Swal.fire("Exito","Se a actualizado el director Academico","success");
                                    }else{
                                        Swal.fire("Problema",res,"info");
                                    }
                                    
                                }
                            });
                        }else{
                            //Asignar una facultad en general
                            if($("#nomDirectorEditFac").val() == "Ninguno"){
                                let datosFacultad =  {
                                    clase: "Facultad",
                                    metodo: "cambiarDirectorAcedemicoFacultad",
                                    idFacultad: $("#formEditarFacAsiDirAca").val(),
                                    nomDirector: $("#formEditarNomDirAca").val() 
                                }
                                //console.log(datosFacultad);
                                $.ajax({
                                    type: "POST",
                                    url: "../controlador/interprete.php",
                                    data: datosFacultad,
                                    success: function (res) {
                                        console.log(res);
                                        if(res == 1){
                                            // mostrarListaDirectoresAcademicos();
                                            // mostarFacultades();
                                            Swal.fire("Exito","Se a actualizado el director Academico","success");
                                        }else{
                                            Swal.fire("Problema",res,"info");
                                        }
                                    }
                                });
                            }else{
                                let datosFacultadAnterior =  {
                                    clase: "Facultad",
                                    metodo: "cambiarDirectorNinguno",
                                    idFacultad: $("#idFacultadActDir").val()
                                    };
                                //console.log(datosFacultadAnterior);
                                $.ajax({
                                    type: "POST",
                                    url: "../controlador/interprete.php",
                                    data: datosFacultadAnterior,
                                    success: function (respuesta) {
                                        console.log(respuesta);
                                        if(respuesta == 1){
                                            let datosFacultadPosterior =  {
                                                clase: "Facultad",
                                                metodo: "cambiarDirectorAcedemicoFacultad",
                                                idFacultad: datosDirector.idFacultad,
                                                nomDirector: datosDirector.nomDirector
                                            }
                                            console.log(datosFacultadPosterior);
                                            $.ajax({
                                                type: "POST",
                                                url: "../controlador/interprete.php",
                                                data: datosFacultadPosterior,
                                                success: function (res) {
                                                    console.log(res);
                                                    if(res == 1){
                                                        mostarFacultades();
                                                        Swal.fire("Exito","Se a actualizado el director Academico","success");
                                                    }else{
                                                        Swal.fire("Problema",res,"info");
                                                    }
                                                }
                                            });
                                        }else{
                                            Swal.fire("Problema",respuesta,"info");
                                        }
                                        
                                    }
                                });
                            }
                        }
                    }
                }else{
                    Swal.fire("Error",response,"info");
                }
                mostrarListaDirectoresAcademicos();
                mostarFacultades();
                $('#myModaEditDirector').modal('hide');
                $("#formEditarDirector")[0].reset();
            }
        });                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
                                                                 
    });
    
    $("#tablaDirAcademico tbody").on('click','button.btnEliminarDirector',function () {
        var dataDeleteDirector = tablaDirector.row( $(this).parents('tr') ).data();
        $("#nomDirectorEliminar").html(dataDeleteDirector.nombre_director);
        $("#codDirectorEliminar").html(dataDeleteDirector.codigo_sis_director);
        $("#nomFacEliminar").html(dataDeleteDirector.director_actual);
        $("#idDirectorEliminar").val(dataDeleteDirector.id_ditector);
        $("#idFacultadDirectorEliminar").val(dataDeleteDirector.id_facultad);
    });

    $("#formEliminarDirectorAcademico").submit(function (e) { 
        let datosDirector = {
            clase: "Director",
            metodo: "eliminarDirector",
            clavePrimaria: $("#idDirectorEliminar").val()
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datosDirector,
            success: function (response) {
                if(response == 1 ){
                    if($("#nomFacEliminar").html() == "Ninguno"){
                        Swal.fire("Exito","se ha elimnado al director Academico: "+$("#nomDirectorEliminar").html(),"success");
                    }else{
                        let datosFacultad = {
                            clase: "Facultad",
                            metodo: "cambiarDirectorNinguno",
                            idFacultad: $("#idFacultadDirectorEliminar").val()
                        }
                        $.ajax({
                            type: "POST",
                            url: "../controlador/interprete.php",
                            data: datosFacultad,
                            success: function (res) {
                                console.log(res);
                                if(res == 1){
                                    mostarFacultades();
                                    Swal.fire("Exito","se ha elimnado al director Academico: "+$("#nomDirectorEliminar").html(),"success");
                                }else{
                                    Swal.fire("Error",response,"info");
                                }
                            }
                        });
                        Swal.fire("Exito","Se debe actualizar facultad","success");
                    }
                }else{
                    Swal.fire("Error",response,"info");
                }
                $('#tablaDirAcademico').dataTable().fnDestroy();
                mostrarListaDirectoresAcademicos();
                $('#myModalDelDirector').modal('hide');
            }
        });
        e.preventDefault();
        
    });

    $("#formCrearAyudanteRector").submit(function (e) { 
        let datosTrabajadorLaboral = {
            clase: "PersonalLaboral",
            metodo: "ingresarPersonalLaboral",
            nombreTrabajador: $("#nomAyudanteRector").val(),
            ciTrabajador: $("#ciAyudanteRector").val(),
            telTrabajador: $("#telAyudanteRector").val(),
            correoTrabajador: $("#correoAyudanteRector").val(),
            cargoTrabajador: $("#nomCargoAyudanteRector").val(),
            passwordTrabajador: $("#correoAyudanteRector").val()
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datosTrabajadorLaboral,
            success: function (response) {
                //console.log(response);
                if(Number.isInteger(response)){
                    Swal.fire("Error",response,"warning");
                }else{
                    let listaFuncionesDadas = [];
                    $(".misChecked:checked").each(function(){
                        listaFuncionesDadas.push($(this).val());
                    });
                    let datosFunciones = {
                        clase: "TareasTrabajador",
                        metodo: "asignarTareasTrab",
                        idTrabajador: response,
                        funciones: listaFuncionesDadas
                    }
                    $.ajax({
                        type: "POST",
                        url: "../controlador/interprete.php",
                        data: datosFunciones,
                        success: function (res) {
                            console.log(res);
                            if(res != 1){
                                //swal("Error",res,"warning");
                                Swal.fire('Error',res,'success');
                            }else{
                                Swal.fire("Exito","Se ha definido las funciones para usuario :"+$("#nomAyudanteRector").val(),"success");
                            }
                        }
                    });
                }
            }
        });
        e.preventDefault();
        
    });
    //Fin agregar funcinalidad

    $("#formCrearFacultad").submit(function (e) { 
        let datosFacultad = {
        clase: "Facultad",
        metodo: "insertarFacultad",
        nomFacultad: $("#nomFacultad").val(),
        facCodigo: $("#facCodigo").val(),
        fechaCreacion: $("#facFechaCrea").val()
        };
        $.post("../controlador/interprete.php",datosFacultad,function(resp){
            if(resp == 1){
                $("#btnCerrarFacultad").click();
                // $("#exito").removeClass("d-none");
                $('#tableFacultad').dataTable().fnDestroy();
                Swal.fire("Se ha creado la facultad correctamente", $("#nomFacultad").val(), "success");
                $("#formCrearFacultad")[0].reset();
                mostarFacultades();
            }else{
                Swal.fire("No se pudo realizar la operacion", resp, "info");
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
                $('#tableFacultad').dataTable().fnDestroy();
                Swal.fire("Se ha Eliminado la facultad", $("#nomFacultadEliminar").html(), "success");
                $("#formEliminarFacultad")[0].reset();
                mostarFacultades();
            }else{
                Swal.fire("No se pudo realizar la operacion", resp, "warning");
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
        facEditFechaCrea: $("#facEditFechaCrea").val()
        };
        //console.log(datosFacultad);
        $.post("../controlador/interprete.php",datosFacultad,function(resp){
            $("#btnCloseEditarFacultad").click();
            if(resp == 1){
                // $("#exito").removeClass("d-none");
                $('#tableFacultad').dataTable().fnDestroy();
                Swal.fire("Se ha Editado la facultad",  $("#nomEditFacultad").val(), "success");
                $("#formEditarFacultad")[0].reset();
                mostarFacultades();
            }else{
                Swal.fire("No se pudo realizar la operacion", resp, "warning");
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
                mostarFacultades();
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
    });

    $("#tableFacultad tbody").on('click','button.eliminarFacultad',function () {
        var dataDelete = tablaFacultad.row( $(this).parents('tr') ).data();
        $("#nomFacultadEliminar").html(dataDelete.nombre_facultad);
        $("#codFacultadEliminar").html(dataDelete.codigo_facultad);
        $("#idFacultadEliminar").val(dataDelete.id_facultad);
    });

});


function mostarFacultades(){
    $('#tableFacultad').dataTable().fnDestroy();
    tablaFacultad =$("#tableFacultad").DataTable({
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
            "data" : {'clase': 'Facultad' , 'metodo':'listarFacultades'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"codigo_facultad"},
            {"data":"nombre_facultad"},
            {"data":"fecha_creacion"}, 
            {"data":"director_academico"},
            {"data": null,"defaultContent":"<button type='button' class='editarFacultad btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal4'><i class='far fa-edit'></i></button>	<button type='button' class='eliminarFacultad btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal5'><i class='fas fa-trash-alt'></i></button>"}
        ]
    });
}


function mostrarListaDirectoresAcademicos(){
    $('#tablaDirAcademico').dataTable().fnDestroy();
    tablaDirector = $("#tablaDirAcademico").DataTable({
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
            "url":"../controlador/interprete.php",
            "data" : {'clase': 'Director' , 'metodo':'listarDirectoresAcademicos'}
        },
        "columns":[
            //{"data":"codigo_sis_director"},
            {"data":"nombre_director"},
            {"data":"director_actual"},
            {"data":"correo_electronico_director"},
            {"data":"telefono_director"},
            {"data": null,"defaultContent":"<button type='button' class='btnEditarDirector btn btn-warning btn-sm' data-toggle='modal' data-target='#myModaEditDirector'><i class='fas fa-user-edit'></i></button>	<button type='button' class='btnEliminarDirector btn btn-danger btn-sm' data-toggle='modal' data-target='#myModalDelDirector'><i class='fas fa-trash-alt'></i></button>"}
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
            $('#facDirAcad').empty();
            $('#facDirAcad').append('<option value="">Selecione una opcion</option>');
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
            $('#facDirAcad').empty();
            $('#facDirAcad').append('<option value="">Selecione una opcion</option>');
            obj.forEach(element => {
                $('#facDirAcad').append("<option>"+element.nombre_facultad+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function mostrarFuncionalidades(){
    let datos = {
        clase: "Funcionalidad",
        metodo: "mostrarFunciones",
        cargo: "Rector"
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            //console.log(response);
            let listaFunciones = JSON.parse(response);
            listaFunciones.forEach(element => {
                $("#myDivFuncionesRector").prepend("<label><input type='checkbox' class='misChecked' value='"+element.nombre_funcionalidad+"'> "+element.nombre_funcionalidad+"</label><br>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

//codigo ruben

function cargarFacultadesDisponibles($idElemSelect){
    let elemSelect = document.getElementById($idElemSelect);
    borrarContenidoPrevio(elemSelect);
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
            //$('#formCrearFacAsiDirAca').append("<option value='"+666+"'>Ninguno</option>");
            $('#formCrearFacAsiDirAca').empty();
            $('#formCrearFacAsiDirAca').append('<option value="">Selecione una opcion</option>');
            obj.forEach(element => {
                $('#formCrearFacAsiDirAca').append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });

}

function borrarContenidoPrevio(elemSelect){
  while (elemSelect.hasChildNodes()) {
    elemSelect.removeChild(elemSelect.firstChild);
  }

}

function cargarFacultadAsignada(idElemSelect, nombreFacultadAsignada){
    let elemSelect = document.getElementById(idElemSelect);
    borrarContenidoPrevio(elemSelect);
    cargarFacultadesDisponibles(idElemSelect);
    let option = document.createElement("option");
    option.value = nombreFacultadAsignada;
    option.innerHTML = nombreFacultadAsignada
    option.selected = "true";
    elemSelect.appendChild(option);
}

function obtnerDatosPropios(){
    let cargo = $("#cargoActualUsuario").val();
    let nombre = $("#nomActualUsuario").val();
    let datosUsuario = {
        clase:"Director",
        metodo:"buscarUsuarioNomCargo",
        cargo: cargo,
        nombre: nombre
    };
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosUsuario,
        success: function (response) {
            //console.log(response);
            let usuario = JSON.parse(response)
            console.log(usuario);
            $("#editCorreo").val(usuario.correo_electronico_director);
            $("#editTel").val(usuario.telefono_director);
            passwordActual = usuario.password_director;
            $("#idUsuarioSync").val(usuario.id_ditector);
        }
    });
}

