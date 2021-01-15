var nombresLaboratorioReservados = [];
var codigosLaboratorioREservados = [];
var tablaLaboratorio,tablaAuxiliarLaboratorio;
$(document).ready(function () {
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
    $('#fecAgregarLaboratorio').attr('max', year + "-" + month + "-" + date);
    $('#fecEditarLaboratorio').attr('max', year + "-" + month + "-" + date);

    listasLaboratorios();
    listasAuxLaboratorios();
    obtnerNombreSiglasDepartamento();
    //laboratoriosDisponibles();
    $("#formAgregarLaboratorio").submit(function (e) { 
        let valor = existeStringEnArreglo(nombresLaboratorioReservados,$("#nomAgregarLaboratorio").val().trim());
        console.log(valor);
        if(!valor){
            $("#idSpanNomLaboratorio").html("");
            let valorSiglasLab = existeStringEnArreglo(codigosLaboratorioREservados,$("#codAgregarLaboratorio").val().trim());
            if(!valorSiglasLab){
                $("#idSpanSiglasLab").html("");
                let datosLaboratorio = {
                    clase: "Laboratorio",
                    metodo: "agregarLaboratorio",
                    nomLaboratorio: $("#nomAgregarLaboratorio").val().trim(),
                    codLaboratorio: $("#codAgregarLaboratorio").val().trim(),
                    fecLaboratorio: $("#fecAgregarLaboratorio").val(),
                    desLaboratorio: $("#desAgregarLaboratorio").val(), 
                    mesLaboratorio: $("#mesAgregarLaboratorio").val(),
                    horLaboratorio: $("#horAgregarLaboratorio").val(), 
                    idDepartamento: $("#idDepartamento").val()
                }
                $.post("../controlador/interprete.php", datosLaboratorio,function (resp, textStatus, jqXHR) {
                        $("#btnCerrarVtnAgregarLab").click();
                        if(resp == 1){
                            swal("Exito!!","Se ha creado  el laboratorio :"+datosLaboratorio.nomLaboratorio,"success");
                            $("#formAgregarLaboratorio")[0].reset();
                            $('#tablaLaboratorio').dataTable().fnDestroy();
                            listasLaboratorios();
                            //laboratoriosDisponibles();
                        }else{
                            swal("Problema!!",resp,"warning");
                        }   
                    }
                );
            }else{
                $("#idSpanSiglasLab").html("Ya existe un laboratorio con la sigle "+ $("#codAgregarLaboratorio").val().trim());
            }
        }else{
            $("#idSpanNomLaboratorio").html("Ya existe un laboratorio con ese nombre "+ $("#nomAgregarLaboratorio").val());
        }
        e.preventDefault();
        
    });
    
    $("#formEditarLaboratorio").submit(function (e) { 
        let datosLaboratorio = {
            clase: "Laboratorio",
            metodo: "editarLaboratorio",
            nomLaboratorio: $("#nomEditarLaboratorio").val(),
            codLaboratorio: $("#codEditarLaboratorio").val(),
            fecLaboratorio: $("#fecEditarLaboratorio").val(),
            desLaboratorio: $("#desEditarLaboratorio").val(), 
            mesLaboratorio: $("#mesEditarLaboratorio").val(),
            horLaboratorio: $("#horEditarLaboratorio").val(), 
            idLaboratorio: $("#idEditarLaboratorio").val()
        }
        $.post("../controlador/interprete.php", datosLaboratorio,function (resp, textStatus, jqXHR) {
                console.log(resp);
                $("#btnCerrarVtnEditarLab").click();
                if(resp == 1){
                    swal("Exito!!","Se ha actualizado el laboratorio: "+datosLaboratorio.nomLaboratorio,"success");
                    $("#formEditarLaboratorio")[0].reset();
                    $('#tablaLaboratorio').dataTable().fnDestroy();
                    listasLaboratorios();
                    //laboratoriosDisponibles();
                }else{
                    swal("Problema!!",resp,"warning");
                }   
            }
        );
        e.preventDefault();
        
    });

    // Editar laboratorio 
    $("#tablaLaboratorio tbody").on('click','button.editarLaboratorio',function () {
        let dataEditarLaboratorio = tablaLaboratorio.row( $(this).parents('tr') ).data();
        console.log(dataEditarLaboratorio);
        $("#idEditarLaboratorio").val(dataEditarLaboratorio.id_laboratorio);
        $("#nomEditarLaboratorio").val(dataEditarLaboratorio.nombre_laboratorio);
        $("#codEditarLaboratorio").val(dataEditarLaboratorio.siglas_laboratorio);
        $("#fecEditarLaboratorio").val(dataEditarLaboratorio.fecha_creacion_lab);
        $("#desEditarLaboratorio").val(dataEditarLaboratorio.descripcion_laboratorio);
        $("#mesEditarLaboratorio").val(dataEditarLaboratorio.duracion_laboratorio);
        $("#horEditarLaboratorio").val(dataEditarLaboratorio.dias_trab_sem);
    });

    //eliminar Laboratorio
    $("#tablaLaboratorio tbody").on('click','button.eliminarLaboratorio',function () {
        let dataEliminarLaboratorio = tablaLaboratorio.row( $(this).parents('tr') ).data();
        console.log(dataEliminarLaboratorio);
        $("#idEliminarLaboratorio").val(dataEliminarLaboratorio.id_laboratorio);
        $("#nomEliminarLaboratorio").html(dataEliminarLaboratorio.nombre_laboratorio);
        $("#codEliminarLaboratorio").html(dataEliminarLaboratorio.siglas_laboratorio);
    });

    $("#formEliminarLaboratorio").submit(function (e) { 
        let datosLaboratorio = {
            clase: "Laboratorio",
            metodo: "elimarLaboratorio",
            idLaboratorio: $("#idEliminarLaboratorio").val()
        }
        $.post("../controlador/interprete.php", datosLaboratorio,function (resp, textStatus, jqXHR) {
                console.log(resp);
                $("#btnCerrarVtnEliminarLab").click();
                if(resp == 1){
                    swal("Exito!!","Se ha eliminado el laboratorio: "+$("#nomEliminarLaboratorio").html(),"success");
                    $("#formEliminarLaboratorio")[0].reset();
                    $('#tablaLaboratorio').dataTable().fnDestroy();
                    listasLaboratorios();
                }else{
                    swal("Problema!!",resp,"warning");
                }   
            }
        );
        e.preventDefault();
    });

    // Auxiliares de laboratorio
    $("#formAgregarAuxLaboratorio").submit(function (e) { 
            let datosAuxLaboratorio = {
                clase: "AuxiliarLaboratorio",
                metodo: "insertarAuxiliarLaboratorio",
                nomAuxLaboratorio: $("#nomAgregarAuxLaboratorio").val(),
                codAuxLaboratorio: $("#codAgregarAuxLaboratorio").val(),
                corAuxLaboratorio: $("#corAgregarAuxLaboratorio").val(),
                telAuxLaboratorio: $("#telAgregarAuxLaboratorio").val(), 
                pasAuxLaboratorio: $("#pasAgregarAuxLaboratorio").val(),
                dirAuxLaboratorio: $("#dirAgregarAuxLaboratorio").val(), 
                idDepartamento: $("#idDepartamento").val()
            };
            $.post("../controlador/interprete.php", datosAuxLaboratorio,function (resp, textStatus, jqXHR) {
                    //console.log(resp);
                    $("#btnCerrarVtnAgregarAuxLab").click(); 
                    let numero = parseInt(resp);
                    if(Number.isInteger(numero) && numero >= 1){
                        if(datosAuxLaboratorio.dirAuxLaboratorio != "Ninguno"){
                            let datosHorarioAuxLaboratorio = {
                                clase: "horarioAuxiliarLaboratorio",
                                metodo: "insertarHorarioLaboratorio",
                                idDepartamento: $("#idDepartamento").val(),
                                idAuxiliarLaboratorio: numero,
                                nombreLaboratorio: datosAuxLaboratorio.dirAuxLaboratorio
                            };
                            $.post("../controlador/interprete.php", datosHorarioAuxLaboratorio,function (data, textStatus, jqXHR) {
                                    console.log(data);
                                    let respuestaNumero = parseInt(data);
                                    if(Number.isInteger(respuestaNumero) && respuestaNumero >= 1){
                                        swal("Exito!!","Se ha creado  el auxiliar de laboratorio :"+datosAuxLaboratorio.nomAuxLaboratorio,"success");
                                    }else{
                                        swal("Problema!!",data,"warning");
                                    }                        
                                    $("#formAgregarAuxLaboratorio")[0].reset();
                                    $('#tablaAuxiliarLaboratorio').dataTable().fnDestroy();
                                    listasAuxLaboratorios();
                                }
                            );
                        }else{
                            swal("Exito!!","Se ha creado  el auxiliar de laboratorio :"+datosAuxLaboratorio.nomAuxLaboratorio,"success");
                            $("#formAgregarAuxLaboratorio")[0].reset();
                            $('#tablaAuxiliarLaboratorio').dataTable().fnDestroy();
                            listasAuxLaboratorios();
                        }
                    }else{
                        swal("Problema!!",resp,"warning");
                    }   
                }
            );
        e.preventDefault();
    });

    //eliminar Auxiliar de Laboratorio
    $("#tablaAuxiliarLaboratorio tbody").on('click','button.eliminarAuxLaboratorio',function () {
        let dataEliminarAuxLaboratorio = tablaAuxiliarLaboratorio.row( $(this).parents('tr') ).data();
        // console.log(dataEliminarAuxLaboratorio);
        $("#idEliminarAuxLaboratorio").val(dataEliminarAuxLaboratorio.id_aux_laboratorio);
        $("#nomEliminarAuxLaboratorio").html(dataEliminarAuxLaboratorio.nombre_auxiliar_lab);
        $("#codEliminarAuxLaboratorio").html(dataEliminarAuxLaboratorio.ci_auxiliar_lab);
    });

    $("#formEliminarAuxLaboratorio").submit(function (e) { 
        let datosAuxLaboratorio = {
            clase: "AuxiliarLaboratorio",
            metodo: "eliminarAuxiliarLaboratorio",
            idAuxLaboratorio: $("#idEliminarAuxLaboratorio").val()
        }
        $.post("../controlador/interprete.php", datosAuxLaboratorio,function (resp, textStatus, jqXHR) {
                // console.log(resp);
                $("#btnCerrarVtnEliminarAuxLab").click();
                if(resp == 1){
                    swal("Exito!!","Se ha eliminado el auxiliar de laboratorio: "+$("#nomEliminarAuxLaboratorio").html(),"success");
                    $("#formEliminarAuxLaboratorio")[0].reset();
                    $('#tablaAuxiliarLaboratorio').dataTable().fnDestroy();
                    listasAuxLaboratorios();
                }else{
                    swal("Problema!!",resp,"warning");
                }   
            }
        );
        e.preventDefault();
    });

    $("#tablaAuxiliarLaboratorio tbody").on('click','button.editarAuxLaboratorio',function () {
        let dataEditarAuxLaboratorio = tablaAuxiliarLaboratorio.row( $(this).parents('tr') ).data();
        $("#idEditarAuxLaboratorio").val(dataEditarAuxLaboratorio.id_aux_laboratorio);
        $("#nomEditarAuxLaboratorio").val(dataEditarAuxLaboratorio.nombre_auxiliar_lab);
        $("#codEditarAuxLaboratorio").val(dataEditarAuxLaboratorio.ci_auxiliar_lab);
        $("#corEditarAuxLaboratorio").val(dataEditarAuxLaboratorio.correo_auxiliar_lab);
        $("#telEditarAuxLaboratorio").val(dataEditarAuxLaboratorio.telefono_auxiliar_lab);
        $("#dirEditarAuxLaboratorio").val(dataEditarAuxLaboratorio.responsable_lab);
    });

    $("#formEditarAuxLaboratorio").submit(function (e) { 
        let datosAuxLaboratorio = {
            clase: "AuxiliarLaboratorio",
            metodo: "actualizarAuxiliarLaboratorio",
            nomAuxLaboratorio: $("#nomEditarAuxLaboratorio").val(),
            codAuxLaboratorio: $("#codEditarAuxLaboratorio").val(),
            corAuxLaboratorio: $("#corEditarAuxLaboratorio").val(),
            telAuxLaboratorio: $("#telEditarAuxLaboratorio").val(), 
            dirAuxLaboratorio: $("#dirEditarAuxLaboratorio").val(),
            idAuxLaboratorio: $("#idEditarAuxLaboratorio").val()
        }
        $.post("../controlador/interprete.php", datosAuxLaboratorio,function (resp, textStatus, jqXHR) {
                // console.log(resp);
                $("#btnCerrarVtnEditarAuxLab").click();
                if(resp == 1){
                    swal("Exito!!","Se ha actualizado el auxiliar de laboratorio: "+datosAuxLaboratorio.nomAuxLaboratorio,"success");
                    $("#formEditarAuxLaboratorio")[0].reset();
                    $('#tablaAuxiliarLaboratorio').dataTable().fnDestroy();
                    listasAuxLaboratorios();
                }else{
                    swal("Problema!!",resp,"warning");
                }   
            }
        );
        e.preventDefault();
        
    });
});
function listasLaboratorios(){
    laboratoriosDisponibles();
    let idDepartameto = $('#idDepartamento').val();
    tablaLaboratorio = $("#tablaLaboratorio").DataTable({
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
            "data" : {'clase': 'Laboratorio' , 'metodo':'listarLaboratorios', 'idDepartamento':idDepartameto},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"siglas_laboratorio"},
            {"data":"nombre_laboratorio"},
            {"data":"fecha_creacion_lab"},
            {"data":"dias_trab_sem"},
            {"data": null, "defaultContent":"<button type='button' class='editarLaboratorio btn btn-warning' data-toggle='modal' data-target='#myModalEditarLaboratorio'>"
            +"<i class='far fa-edit'></i></button>  <button type='button' class='eliminarLaboratorio btn btn-danger' data-toggle='modal' data-target='#myModalEliminarLaboratorio' ><i class='fas fa-trash-alt'></i></button>"}
        ]

    });
}

    

function listasAuxLaboratorios(){
    let idDepartamento = $('#idDepartamento').val();
    tablaAuxiliarLaboratorio = $("#tablaAuxiliarLaboratorio").DataTable({
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
            "data" : {'clase': 'AuxiliarLaboratorio' , 'metodo':'listarTableAuxiliarLaboratorio', 'idDepartamento':idDepartamento},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_auxiliar_lab"},
            {"data":"responsable_lab"},
            {"data":"correo_auxiliar_lab"},
            {"data":"telefono_auxiliar_lab"},
            {"data": null, "defaultContent":"<button type='button' class='editarAuxLaboratorio btn btn-warning' data-toggle='modal' data-target='#myModalEditarAuxLaboratorio'>"
            +"<i class='far fa-edit'></i></button>  <button type='button' class='eliminarAuxLaboratorio btn btn-danger' data-toggle='modal' data-target='#myModalEliminarAuxLaboratorio' ><i class='fas fa-trash-alt'></i></button>"}
        ]
    });
}

function laboratoriosDisponibles(){
    $('#dirAgregarAuxLaboratorio option').each(function() {
        if ( $(this).val() != 'Ninguno' ) {
            $(this).remove();
        }
    });

    $('#dirEditarAuxLaboratorio option').each(function() {
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
            let obj= JSON.parse(response);
            obj.forEach(element => {
                $('#dirAgregarAuxLaboratorio').append("<option value='"+element.nombre_laboratorio+"'>"+element.nombre_laboratorio+"</option>");
                $('#dirEditarAuxLaboratorio').append("<option value='"+element.nombre_laboratorio+"'>"+element.nombre_laboratorio+"</option>");
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function obtnerNombreSiglasDepartamento(){
    let datosLaboratorio = {
        clase: 'Laboratorio' ,
        metodo: 'listarLaboratorios',
        idDepartamento :$('#idDepartamento').val()
    };
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosLaboratorio,
        success: function (response) {
            objetoJson = JSON.parse(response);
            objetoJson.data.forEach(element => {
                nombresLaboratorioReservados.push(element.nombre_laboratorio);
                codigosLaboratorioREservados.push(element.siglas_laboratorio);
            });     
       }
    });
    // console.log(nombresLaboratorioReservados);
    // console.log(codigosLaboratorioREservados);
}

function existeStringEnArreglo(array,cadena){
    // array.forEach(element =>{
    //     if(element.toLowerCase() == cadena.toLowerCase()){
    //         return false;
    //     }
    // });
    for (let index = 0; index < array.length; index++) {
        // const element = array[index];
        if(array[index].toLowerCase() == cadena.toLowerCase()){
            return true;
        }
    }
    return false;
}
