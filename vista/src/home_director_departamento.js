var tablaCarrera;
var tablaDirector;
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
    $('#fecAgregarCarrera').attr('max', year + "-" + month + "-" + date);
    $('#fecEditarCarrera').attr('max', year + "-" + month + "-" + date);

    $("#idCampo").change(function (e) {
        let tipoUnidad = $("#idCampo").val();
        console.log(tipoUnidad);
        switch (tipoUnidad) {
            case "Ninguno":
                if($("#idGrpAmbiente").hasClass("d-block")){
                    $("#idGrpAmbiente").removeClass("d-block");
                    $("#idGrpAmbiente").addClass("d-none");
                }
                break;
            case "Laboratorio":
                $("#idGrpAmbiente").removeClass("d-none");
                $("#idGrpAmbiente").addClass("d-block");
                obtenerListaLaboratorio();
                obtenerListaCorreosLaboratorio();
                break;
            default:
                break;
        }
        e.preventDefault();
    });

    $("#btnAbrirCorreo").removeClass("d-none");
    $("#btnAbrirCorreo").addClass("d-block");
    directoresDisponibles();
    listarTableDirectorCarrera();
    carrerasDisponibles();
    listarCarreras();

    $("#formEnviarCorreos").submit(function (e) {
        let valoresCheck = [];
        $(".misChecked:checked").each(function(){
            valoresCheck.push(this.value);
        });
        if(valoresCheck.length > 0){
            let datosCorreo = {
                titulo: $("#idCorreoAsunto").val(),
                descripcion: $("#idCorreoDes").val(),
                correos: valoresCheck
            }
            $.ajax({
                type: "POST",
                url: "../controlador/formCorreosMasivos.php",
                data: datosCorreo,
                success: function (response) {
                    console.log(response);
                    if(response){
                        swal("Exito","Se ha enviado mensaje a todos los correos selecionados","success");
                    }else{
                        swal("Problema",response,"warning");
                    }
                }
            });
        }else{
            alert("No se puede procesar");
        }
        e.preventDefault();
        
    });

    $("#formEliminarCarrera").submit(function (e) { 
        // if($("#idDeletCarreraDirector").val() !== null){
        //     console.log($("#idDeletCarreraDirector").val());
        // }
        $("#myModalEliminarCarrera").hide();
        $("#btnCerrarVtnCarrera").click();
        if($("#idDeletCarreraDirector").val() !== ""){
            let datosDirector = {
                clase:"Director",
                metodo: "quitarCargo",
                idDirector: $("#idDeletCarreraDirector").val()
            };
            $.ajax({
                type: "POST",
                url: "../controlador/interprete.php",
                data: datosDirector,
                success: function (response) {
                    if(response == 1){
                        listarTableDirectorCarrera();
                        let datosCarrera = {
                            clase: "Carrera",
                            metodo: "eliminarCarrera",
                            idCarrera: $("#idDeletCarrera").val()
                        };
                        $.post("../controlador/interprete.php",datosCarrera,function(resp){
                            $("#btnCerrarVtnCarrera").click();
                            if(resp == 1){
                                // $("#exito").removeClass("d-none");
                                $('#tablaCarrera').dataTable().fnDestroy();
                                swal("Se ha Eliminado la carrera", $("#nomDeletCarrera").html(), "success");
                                $("#formEliminarCarrera")[0].reset();
                                listarCarreras();
                            }else{
                                swal("No se pudo realizar la operacion", resp, "warning");
                                //$("#error").removeClass("d-none");
                            }
                        });
                    }else{
                        swal("No se pudo realizar la operacion", response, "warning");
                    }
                }
            });

        }else{
            let datosCarrera = {
                clase: "Carrera",
                metodo: "eliminarCarrera",
                idCarrera: $("#idDeletCarrera").val()
            };
            $.post("../controlador/interprete.php",datosCarrera,function(resp){
                $("#btnCerrarVtnCarrera").click();
                if(resp == 1){
                    // $("#exito").removeClass("d-none");
                    $('#tablaCarrera').dataTable().fnDestroy();
                    swal("Se ha Eliminado la carrera", $("#nomDeletCarrera").html(), "success");
                    $("#formEliminarCarrera")[0].reset();
                    listarCarreras();
                }else{
                    swal("No se pudo realizar la operacion", resp, "warning");
                    //$("#error").removeClass("d-none");
                }
            });
        }
        e.preventDefault();
    });

    $("#formEditarCarrera").submit(function (e) {
        $("#myModalEditarCarrera").hide();
        $("#btnCerrarVtnEditarCarrera").click();
        let datosCarrera = {
            clase: "Carrera",
            metodo: "editarCarreraDepartamento",
            idCarrera: $("#idEditarCarrera").val(),
            nomCarrera: $("#nomEditarCarrera").val(),
            codCarrera: $("#codEditarCarrera").val(),
            fecCarrera: $("#fecEditarCarrera").val(),
        };
        $.post("../controlador/interprete.php",datosCarrera,function(resp){
            $("#btnCerrarVtnEditarCarrera").click();
            if(resp == 1){
                if( "Ninguno" != $("#dirEditarCarrera").val()){
                    let datosDirector = {
                        clase: "Director",
                        metodo: "actualizarAsignacionDirector",
                        idDirector: $("#idEditDirectorCarrera").val(),
                        carDirector: datosCarrera.nomCarrera
                    };
                    $.ajax({
                        type: "POST",
                        url: "../controlador/interprete.php",
                        data: datosDirector,
                        success: function (response) {
                            // console.log(response);
                            if(response == 1){
                                $('#tablaDirector').dataTable().fnDestroy();
                                listarTableDirectorCarrera();
                                $('#tablaCarrera').dataTable().fnDestroy();
                                swal("Se ha Editado la carrera", $("#nomEditarCarrera").html(), "success");
                                $("#formEliminarCarrera")[0].reset();
                                listarCarreras();
                            }else{
                                swal("No se pudo realizar la operacion", response, "warning");
                            }
                        },
                        error : function(jqXHR, status, error) {
                            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
                        }
                    });
                }else{
                    $('#tablaCarrera').dataTable().fnDestroy();
                    swal("Se ha Editado la carrera", $("#nomEditarCarrera").html(), "success");
                    $("#formEliminarCarrera")[0].reset();
                    listarCarreras();
                }

                // $('#tablaCarrera').dataTable().fnDestroy();
                // swal("Se ha Editado la carrera", $("#nomEditarCarrera").html(), "success");
                // $("#formEliminarCarrera")[0].reset();
                // listarCarreras();
            }else{
                swal("No se pudo realizar la operacion", resp, "warning");
                $("#formEliminarCarrera")[0].reset();
                //$("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    $("#formInsertarDocente").submit(function (e) { 
        $("#myModal").hide();
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
            $("#btnVentanaDocente").click();
            if(resp == 1){
                $("#formInsertarDocente")[0].reset();
                $("#exitoDocente").removeClass("d-none");
                $('#tablaDocente').dataTable().fnDestroy();
                listarTableDocente();
                carrerasDisponibles();
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
                carrerasDisponibles();
            }else{
                $("#errorAuxiliarDocente").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    $("#formCrearCarrera").submit(function (e) { 
        $("#myModal2").hide();
        let datosCarrera = {
            clase: "Carrera",
            metodo: "agregarCarrera",
            depAgregarCarrera: $("#idAgregarDepartamento").val(),
            nomAgregarCarrera: $("#nomAgregarCarrera").val(),
            codAgregarCarrera: $("#codAgregarCarrera").val(),
            fecAgregarCarrera: $("#fecAgregarCarrera").val()
        }
        console.log(datosCarrera);
        $.post("../controlador/interprete.php",datosCarrera,function(resp){
            if(resp == 1){
                $("#btnCerrarVtnCrearCarrera").click();
                swal("Exito!!","Se creo la carrera "+$("#nomAgregarCarrera").val(),"success");
                $("#formCrearCarrera")[0].reset();
                $('#tablaCarrera').dataTable().fnDestroy();
                listarCarreras();
                carrerasDisponibles()
            }else{
                //$("#btnCerrarAutoridad").click();
                swal("Error al crear la carrera",resp,"info");
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
                // $("#exito").removeClass("d-none");
                $('#tablaDirector').dataTable().fnDestroy();
                $('#tablaCarrera').dataTable().fnDestroy();
                swal("Exito!!","Se creo usuario como director"+$("#nomDirector").val(),"success");
                listarCarreras();
                listarTableDirectorCarrera();
                carrerasDisponibles();
                directoresDisponibles();
            }else{
                // $("#error").removeClass("d-none");
                swal("Problemas", "Problemas al crear al usuario" ,"info");
            }
        });
        e.preventDefault();
    });



    $("#formEliminarDirectorCarrera").submit(function (e) { 
        let datosDirector = {
        clase: "Director",
        metodo: "eliminarDirector",
        clavePrimaria: $("#idEliminarDirector").val()
        };
        console.log(datosDirector);
        $.post("../controlador/interprete.php",datosDirector,function(resp){
            console.log(resp);
            if(resp == 1){
                let datosCarrera = {
                    clase: "Carrera",
                    metodo: "actualizarDirectorCarrera", 
                    // idCarrera = $("#idActualizarCarreraDirector").val(),
                    nomDirector: $("#nomDirectorDel").html()
                }
                $.post("../controlador/interprete.php", datosCarrera,function (data, textStatus, jqXHR) {
                        console.log(data);
                        let respuesta = parseInt(data);
                        if(respuesta == 1){
                            // swal("Exito!!","Se Eliminino el usuario: "+$("#nomDirectorDel").html(),"warning");
                            // $('#tablaDirector').dataTable().fnDestroy();
                            $('#tablaCarrera').dataTable().fnDestroy();
                            listarCarreras();
                            // listarTableDirectorCarrera();
                            carrerasDisponibles();
                        }else{
                            swal("Problema!!",data,"info");
                        }
                    }
                );
                $("#formEliminarDirectorCarrera")[0].reset();
                $("#btnEliminarVtnDirector").click();
                swal("Exito!!","Se Eliminino el usuario: "+$("#nomDirectorDel").html(),"success");
                $('#tablaDirector').dataTable().fnDestroy();
                listarTableDirectorCarrera();
                carrerasDisponibles();
            }else{
                $("#formEliminarDirectorCarrera")[0].reset();
                swal("Problema!!",resp,"warning");
                $("#btnEliminarVtnDirector").click();
            }
        });
        e.preventDefault();
    });

    $("#formEditarDirectorCarrera").submit(function (e) { 
        $("#myModalEditarDirector").hide();
        let datosDirector = {
            clase: "Director",
            metodo: "actualizarDirectorCarrera",
            nomDirector: $("#nomEditDirector").val(),
            ciDirector: $("#ciEditDirector").val(),
            correoDirector: $("#correoEditDirector").val(),
            telDirector: $("#telEditDirector").val(),
            clavePrimaria: $("#idEditarDirector").val(),
            carrera: $("#matEditDirector option:selected").text()
        };
        // console.log(datosDirector);
        $.post("../controlador/interprete.php",datosDirector,function(resp){
            $("#btnVentanaEditDirector").click();
            if(resp == 1){
                console.log(datosDirector.nomDirector);
                console.log($("#nomEditAntiguoDirector").val());
                if(datosDirector.nomDirector != $("#nomEditAntiguoDirector").val()){
                    let datosCarrera = {
                        clase: "Carrera",
                        metodo: "actualizarNombreDirectorCarrera",
                        nomDirectorAnterior: $("#nomEditAntiguoDirector").val(),
                        nomDirectorNuevo: datosDirector.nomDirector,
                    }
                    $.post("../controlador/interprete.php", datosCarrera, function (data, textStatus, jqXHR) {
                            console.log(data);
                            let valor = parseInt(data);
                            if(valor == 1){
                                listarCarreras();
                                $("#formEditarDirectorCarrera")[0].reset();
                                swal("Exito!!","Se ha actualizado los daros de :"+datosDirector.nomDirector,"success");
                                listarTableDirectorCarrera();
                            }else{
                                swal("Problemas!!",data,"warning");
                                $("#formEditarDirectorCarrera")[0].reset();
                            }
                        }
                    );
                }else{
                    $("#formEditarDirectorCarrera")[0].reset();
                    swal("Exito!!","Se ha actualizado los daros de :"+datosDirector.nomDirector,"success");
                    $('#tablaDirector').dataTable().fnDestroy();
                    listarTableDirectorCarrera();
                }
            }else{
                swal("Problemas!!",resp,"warning");
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

    $("#tablaCarrera tbody").on('click','button.eliminarCarrera',function () {
        let dataDeleteCarrera = tablaCarrera.row( $(this).parents('tr') ).data();
        console.log(dataDeleteCarrera);
        $("#nomDeletCarrera").html(dataDeleteCarrera.nombre_carrera);
        $("#codDeletCarrera").html(dataDeleteCarrera.codigo_carrera);
        $("#idDeletCarrera").val(dataDeleteCarrera.id_carrera);
        console.log(dataDeleteCarrera.id_ditector);
        $("#idDeletCarreraDirector").val(dataDeleteCarrera.id_ditector);
    });

    $("#tablaCarrera tbody").on('click','button.editarCarrera',function () {
        let dataEditarCarrera = tablaCarrera.row($(this).parents('tr')).data();
        console.log(dataEditarCarrera);
        $("#dirAntiguoEditarCarrera").html(dataEditarCarrera.director_carrera);
        $("#idEditarCarrera").val(dataEditarCarrera.id_carrera);
        $("#nomEditarCarrera").val(dataEditarCarrera.nombre_carrera);
        $("#codEditarCarrera").val(dataEditarCarrera.codigo_carrera);
        $("#fecEditarCarrera").val(dataEditarCarrera.fecha_creacion_carrera);
        $("#dirEditarCarrera").val(dataEditarCarrera.director_carrera);
        $("#idEditDirectorCarrera").val(dataEditarCarrera.id_ditector);
    });

    $("#tablaDirector tbody").on('click','button.eliminarDirector',function () {
        let dataEliminarDirector = tablaDirector.row( $(this).parents('tr') ).data();
        console.log(dataEliminarDirector);
        $("#nomDirectorDel").html(dataEliminarDirector.nombre_director);
        $("#ciDirectorDel").html(dataEliminarDirector.codigo_sis_director);
        $("#idEliminarDirector").val(dataEliminarDirector.id_ditector);
        $("#idActualizarCarreraDirector").val(dataEliminarDirector.id_carrera);
    });

    $("#tablaDirector tbody").on('click','button.editarDirector',function () {
        let dataEditarDirector = tablaDirector.row( $(this).parents('tr') ).data();
        console.log(dataEditarDirector);
        $("#idEditarDirector").val(dataEditarDirector.id_ditector);
        $("#nomEditAntiguoDirector").val(dataEditarDirector.nombre_director);
        $("#nomEditDirector").val(dataEditarDirector.nombre_director);
        $("#ciEditDirector").val(dataEditarDirector.carnet_director);
        $("#telEditDirector").val(dataEditarDirector.telefono_director);
        $("#correoEditDirector").val(dataEditarDirector.correo_electronico_director); 
        $('#matEditDirector').empty();
        $("#matEditDirector").append("<option value="+dataEditarDirector.id_carrera+">"+dataEditarDirector.director_actual+"</option>"); 
        console.log(dataEditarDirector.id_carrera);
        $("#matEditDirector").val(dataEditarDirector.id_carrera); 
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
                //$('#asigDirector').children('option:not(:first)').remove();
                let obj= JSON.parse(response);
                obj.forEach(element => {
                    $('#matEditDirector').append("<option value="+element.id_carrera+">"+element.nombre_carrera+"</option>");
                });
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
        });      
    });
    
});

function listarCarreras(){
    $('#tablaCarrera').dataTable().fnDestroy();
    tablaCarrera = $("#tablaCarrera").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Carrera' , 'metodo':'listarCarrera'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"codigo_carrera"},
            {"data":"nombre_carrera"},
            {"data":"fecha_creacion_carrera"},
            {"data":"director_carrera"},
            {"data": null, "defaultContent":"<button type='button' class='editarCarrera btn btn-warning' data-toggle='modal' data-target='#myModalEditarCarrera'>"
            +"<i class='far fa-edit'></i></button>  <button type='button' class='eliminarCarrera btn btn-danger' data-toggle='modal' data-target='#myModalEliminarCarrera' ><i class='fas fa-trash-alt'></i></button>"}
        ]
    });
}

function listarTableDirectorCarrera(){
    $('#tablaDirector').dataTable().fnDestroy();
    tablaDirector = $("#tablaDirector").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Director' , 'metodo':'listarTableDirectorCarrera'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_director"},
            {"data":"director_actual"},
            {"data":"correo_electronico_director"},
            {"data":"telefono_director"},
            {"data": null, "defaultContent":"<button type='button' class='editarDirector btn btn-warning' data-toggle='modal' data-target='#myModalEditarDirector'>"+
            "<i class='far fa-edit'></i></button>  <button type='button' class='eliminarDirector btn btn-danger'  data-toggle='modal' data-target='#myModalELiminarDirector'><i class='fas fa-trash-alt'></i></button>"}
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
            //$('#asigDirector').children('option:not(:first)').remove();
            $('#asigDirector').empty();
            $('#asigDirector').append('<option value="">Selecione una opcion</option>');
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
    $('#tablaPersonalLaboratorio').dataTable().fnDestroy();
    var personalLaboratorio = $("#tablaPersonalLaboratorio").DataTable({
        "destroy":true,
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'AuxiliarLaboratorio' , 'metodo':'listarTableAuxiliarLaboratorio'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_auxiliar_lab"},
            {"data":"activo_auxiliar_lab"},
            {"data":"correo_auxiliar_lab"},
            {"data":"telefono_auxiliar_lab"},
            {"data": null,"defaultContent":"<button type='button' class='editarPersonalLab btn btn-warning'><i class='far fa-edit'></i></button>	<button type='button' class='eliminarPersonalLab btn btn-danger'><i class='fas fa-trash-alt'></i></button>"}
        ]
    });
    editarPersonalLab("#tablaPersonalLaboratorio tbody",personalLaboratorio);
    eliminarPersonalLab("#tablaPersonalLaboratorio tbody",personalLaboratorio);
    // return personalLaboratorio;
}


var editarPersonalLab = function(tbody,table){
    $(tbody).on("click","button.editarPersonalLab",function () {
        let perLab = table.row($(this).parents("tr")).data();
        console.log(perLab);
        $(".editarPersLabor").click();
        $("#nomEditPersLabor").val(perLab.nombre_auxiliar_lab);
        $("#ciEditPersLabor").val(perLab.ci_auxiliar_lab);
        $("#telEditPersLabor").val(perLab.telefono_auxiliar_lab);
        $("#correoEditPersLabor").val(perLab.correo_auxiliar_lab);

        $("#formEditarPersLab").submit(function (e) { 
            e.preventDefault();
            let datosDirector = {
            clase: "AuxiliarLaboratorio",
            metodo: "actualizarAuxiliarLaboratorio",
            nomPersLabor: $("#nomEditPersLabor").val(),
            ciPersLabor: $("#ciEditPersLabor").val(),
            correoPersLabor: $("#correoEditPersLabor").val(),
            telPersLabor: $("#telEditPersLabor").val(),
            clavePrimaria: perLab.id_aux_laboratorio
            };
            // console.log(datosDirector);
            $.post("../controlador/interprete.php",datosDirector,function(resp){
                if(resp == 1){
                    $("#btnVentanaEditPersLab").click();
                    $("#formEditarPersLab")[0].reset();
                    $("#VtnEditarPersLab").removeClass("d-none");
                    $('#tablaPersonalLaboratorio').dataTable().fnDestroy();
                    listarPersonalLaboratorio();
                }else{
                    $("#errorPersLab").removeClass("d-none");
                }
            });
        });
    });
}

var eliminarPersonalLab = function(tbody,table){
    $(tbody).on("click","button.eliminarPersonalLab",function (e) {
        e.preventDefault();
        let persLab = table.row($(this).parents("tr")).data();
        console.log(persLab);
        $(".eliminarPersonalLaboratorio").click();
        $("#nomPersonaldelLab").html(persLab.nombre_auxiliar_lab);

        $("#formEliminarPersonalLaboratorio").submit(function (e) { 
            let datosAuxLaboratorio = {
            clase: "AuxiliarLaboratorio",
            metodo: "eliminarAuxiliarLaboratorio",
            clavePrimaria: persLab.id_aux_laboratorio
            };
            $.post("../controlador/interprete.php",datosAuxLaboratorio,function(resp){
                if(resp == 1){
                    $("#btnVentanaEliminarPerLab").click();
                    $("#VtnEliminarPersLab").removeClass("d-none");
                    $('#tablaPersonalLaboratorio').dataTable().fnDestroy();
                    listarPersonalLaboratorio();
                    perLab = {};
                }else{
                    $("#btnVentanaEliminarPerLab").click();
                    $("#errorPersLab").removeClass("d-none");
                }
            });
        });
    });
}


function listarTableDocente(){
    $('#tablaDocente').dataTable().fnDestroy();
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
    $('#tablaAuxiliar').dataTable().fnDestroy();
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

function directoresDisponibles(){
    let datosDirector = {
        clase: "Director",
        metodo: "directoresCarreraDisponibles",
        categoria: $("#idCategoria").val()
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosDirector,
        success: function (response) {
            let obj= JSON.parse(response);
            //console.log(response);
            obj.forEach(element => {
                //console.log(element.nombre_director);
                $('#dirAgregarCarrera').append("<option value='"+element.id_ditector+"'>"+element.nombre_director+"</option>");
                $('#dirEditarCarrera').append("<option value='"+element.id_ditector+"'>"+element.nombre_director+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function  obtenerListaLaboratorio(){
    $('#idAmbiente option').each(function() {
        if ( $(this).val() != 'Ninguno' ) {
            $(this).remove();
        }
    });
    let datosLaboratorio = {
        clase: "Laboratorio",
        metodo: "laboratoriosDisponibles",
        idDepartamento: $("#idDepartamento").val()
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosLaboratorio,
        success: function (response) {
            //console.log(response);
            let listaLaboratorios= JSON.parse(response);
            listaLaboratorios.forEach(element => {
                //console.log(element.nombre_director);
                $('#idAmbiente').append("<option value='"+element.id_laboratorio+"'>"+element.nombre_laboratorio+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function  obtenerListaCorreosLaboratorio(){

    let datosAuxLaboratorio = {
        clase: "AuxiliarLaboratorio",
        metodo: "listaCorreosAuxiliarLab",
        idDepartamento: $("#idDepartamento").val()
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosAuxLaboratorio,
        success: function (response) {
            //console.log(response);
            let listaAuxiliarLab= JSON.parse(response);
            listaAuxiliarLab.forEach(element => {
                //console.log(element.nombre_director);
                $('#contCorreos').prepend("<label><input type='checkbox' class='misChecked' checked value='"+element.correo_auxiliar_lab+"'> Nombre: "+element.nombre_auxiliar_lab+"("+element.correo_auxiliar_lab+")</label>");
                // $('#idAmbiente').append("<option value='"+element.id_laboratorio+"'>"+element.nombre_laboratorio+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}