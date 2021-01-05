var tablaReporte;
var tablaReporteDocente;
var tablaFormularioControlAvanceDocente;
var map_camposFormularioControlAvance;
var map_enlacesRecursosFormularioControlAvance;
$(document).ready(function () {

    listaDeFacultades();
    $("#idFacultades").change(function() {
        listaDepartamentos();
    });
    $("#idDepartamentos").change(function() {
        cargarTablaReportesPendientesDocente();
    });

    //Mostramos la tabla formulario de control de avance que corresponde al docente
    $(document).on("click", ".btnControlarAsistencia", function(){
        document.getElementById("seccionBusqueda").style.display = "none";
        //Recuperamos los datos de la fila
        let fila = $(this).closest("tr");
        let sis_docente = fila.find('td:eq(0)').text();   
        let nombre_docente = fila.find('td:eq(1)').text();    
        let array_periodo_reporte = (fila.find('td:eq(2)').text()).split("/");
        //Establecemos la informacion recuperada en el formulario
        $("#formNombreDocente").text("Docente: "+nombre_docente);
        $("#formSisDocente").text("Codigo SISS: "+sis_docente);
        $("#formPeriodoReporteDocente").text("Del: "+array_periodo_reporte[0]+" Al: "+array_periodo_reporte[1]);
        //Ocultamos la tabla de reportes pendientes
        document.getElementById("divReportesDocente").style.display = "none";
        //Mostramos el formulario de avance del docente
        document.getElementById("divFormularioControlAvanceDocente").style.display = "";
        //Cargamos la tabla del formulario de control de avance del docente
        cargarTablaFormularioControlAvanceDocente(sis_docente, array_periodo_reporte);
        //Cargamos la variable map_camposFormularioControlAvance con la informacion correspondiente
        cargarMapCamposFormularioControlAvanceDocente(sis_docente, array_periodo_reporte);
        //Cargamos la variable map_enlacesRecursosFormularioControlAvance con la informacion correspondiente
        cargarMapEnlacesRecursosFormularioControlAvanceDocente(sis_docente, array_periodo_reporte);
    });

    //Mostrar la informacion detallada del reporte de una clase en un modal
    $(document).on("click", ".btnRevisarReporte", function(){   
        //Recuperamos los datos de la fila
        let fila = $(this).closest("tr");
        let fecha_clase = fila.find('td:eq(0)').text();   
        let periodo_hora_clase = fila.find('td:eq(1)').text();
        let numero_grupo = fila.find('td:eq(2)').text();
        let nombre_materia = fila.find('td:eq(3)').text();
        //Establecemos el titulo para el modal
        $("#tituloModalFormularioControlAvance").text(nombre_materia+" GRUPO "+numero_grupo);
        //Establecemos la key usada para obtener los arrays de los maps
        let key = fecha_clase+periodo_hora_clase;
        //Guardamos el codigo de clase en el div oculta dentro del modal
        $("#key_map_clase").val(key);
        //Obtenemos el array con la informacion de los campos de la clase
        let arrayCampos = map_camposFormularioControlAvance.get(key);
        //Guardamos la referencia de la fila en el array de campos, solo la primera vez
        guardarReferenciaFilaArrayCampos(fila, arrayCampos);
        //Cargamos los campos del modal
        cargarInformacionCamposModalFormularioControlAvance(arrayCampos);
        //Obtenemos el array con los enlaces y recursos de la clase
        let arrayEnlacesRecursos = map_enlacesRecursosFormularioControlAvance.get(key);
        //Cargamos los enlaces y recursos al modal
        cargarEnlacesRecursosModalFormularioControlAvance(arrayEnlacesRecursos);
        //Mostramos el modal con los detalles del formulario de la clase
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $("#modalFormularioControlAvance").modal("show");
    });

    //Registrar asistencia 
    $('#formControlAvance').submit(function(e){                         
        //evita el comportambiento normal del submit, es decir, recarga total de la página
        e.preventDefault();
        //Recuperamos el key map de la clase almacenado en el div no visible del modal
        let key = $("#key_map_clase").val();
        //Recuperamos el array con los campos de la clase
        let arrayCampos = map_camposFormularioControlAvance.get(key);
        //Obtenemos el codigo_clase
        let codigo_clase = arrayCampos[0];
        //Establecemos el valor si la clase se marco como asistida
        let falto_clases = 'f';
        //Verificamos si la clase se marco como falta
        if($("#inlineRadioNo").prop("checked")){
            falto_clases = 't';
        }
        let clase = 'Clase';
        let metodo = 'actualizarAsistenciaClase';                       
            $.ajax({
                url: "../controlador/interprete.php",
                type: "POST",
                datatype:"json",    
                data:  {clase:clase, metodo:metodo, codigo_clase:codigo_clase, asistencia:falto_clases},    
                success: function(data) {
                    //Registramos como reporte revisado en el array
                    arrayCampos[11] = "Si";
                    //Registramos si la clase se marco como falta en el array
                    if(falto_clases == 't'){
                        arrayCampos[10] = true;
                    }
                    //Obtenemos la referencia de la fila, almacenada en el array
                    let fila = arrayCampos[12];
                    //Establecemos en el table la fila revisada con la cadena "Si"
                    fila.find('td:eq(4)').text("Si");
                }
            });                 
        $('#modalFormularioControlAvance').modal('hide');                                                    
    });

    //Mostramos la tabla de reportes pendientes y ocultamos la tabla de formulario de control de asistencia
    $(document).on("click", "#btnVolverReportesPendientes", function(){  
         //Mostramos el menu de busqueda
        document.getElementById("seccionBusqueda").style.display = "";
        document.getElementById("divFormularioControlAvanceDocente").style.display = "none";
        document.getElementById("divReportesDocente").style.display = "";
        tablaReporteDocente.ajax.reload(null, false);
    });

    //Enviar reporte de control de avance del docente
    $(document).on("click", "#btnEnviarReporte", function(){  
        //Obtenemos el numero de arrays almacenados 
        let numeroArrays = map_camposFormularioControlAvance.size;
        //Obtenemos un iterador de los valores almacenados en el map
        let iterador = map_camposFormularioControlAvance.values();
        //El valor se mantendra como true si todas las clases de la tabla fueron revisadas
        let revisionCompleta = true;
        //Verificamos si las clases fueron revisadas
        for (let i = 0; i < numeroArrays && revisionCompleta; i++) {
            let arrayCampos = iterador.next().value; 
            if(arrayCampos[11] == 'No'){
                revisionCompleta = false;
            }
        }
        //Desplegamos el mensaje correspondiente
        if(revisionCompleta){
            Swal.fire({
                title: '¿Esta seguro de enviar el reporte?',
                text: "Una vez enviado a DPA, no podra hacer ninguna modificacion",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, enviar reporte',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let array_codigo_clase = obtenerCodigosClaseFormulario();
                    let datos = {
                        clase: "Clase",
                        metodo: "actualizarRevisionUTI",
                        array_codigo_clase: array_codigo_clase
                    }
                    $.ajax({
                        type: "POST",
                        url: "../controlador/interprete.php",
                        data: datos,
                        success: function (response) {
                            //Recargamos la visualizacion de reportes pendientes
                            tablaReporteDocente.ajax.reload(null,false);
                            //Desplegamos el mensaje de confirmacion de envio
                            Swal.fire(
                                '¡Enviado!',
                                'El formulario de control de avance fue enviado.',
                                'success'
                            )
                            //Volvemos a la tabla de reportes pendientes
                            $("#btnVolverReportesPendientes").click();
                        },
                        error : function(jqXHR, status, error) {
                            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
                        }
                    });  
                }
            })
        }else{
            Swal.fire({
                icon: 'error',
                title: 'No es posible enviar el formulario de control de avance',
                text: 'Todas las clases deben ser revisadas'
            })
        }
    });

    //Mostrar y ocultar seccion de filtros de busqueda
    $(document).on("change", "#selectListarReportes", function(){
        if($("#selectListarReportes option:selected").val() == "ReportesPendientes"){
            document.getElementById("seccionFiltrosBusquedaReportesRevisados").style.display = "none";
        }else{
            document.getElementById("seccionFiltrosBusquedaReportesRevisados").style.display = "";
        }
        //ocultamos la tabla 
        document.getElementById("divReportesDocente").style.display = "none";
    });

    //Cargar selectMes
    $(document).on("change", "#selectGestion", function(){
        cargarSelectMes($("#selectGestion option:selected").val());
    });

    //Mostramos la tabla formulario de control de avance que ya fue revisado
    $(document).on("click", ".btnVerFormularioControlAvance", function(){   
        //Ocultamos el menu de busqueda
        document.getElementById("divSeccionMenuBusqueda").style.display = "none";   
        //Recuperamos los datos de la fila
        let fila = $(this).closest("tr");
        let sis_docente = fila.find('td:eq(0)').text();   
        let nombre_docente = fila.find('td:eq(1)').text();    
        let array_periodo_reporte = (fila.find('td:eq(2)').text()).split("/");
        //Establecemos la informacion recuperada en el formulario
        $("#formNombreDocenteRevisado").text("Docente: "+nombre_docente);
        $("#formSisDocenteRevisado").text("Codigo SISS: "+sis_docente);
        $("#formPeriodoReporteDocenteRevisado").text("Del: "+array_periodo_reporte[0]+" Al: "+array_periodo_reporte[1]);
        //Ocultamos la tabla de reportes 
        document.getElementById("divReportesDocente").style.display = "none";
        //Mostramos el formulario de avance del docente
        document.getElementById("divFormularioControlAvanceDocenteRevisado").style.display = "";
        //Cargamos la tabla del formulario de control de avance del docente
        cargarTablaFormularioControlAvanceDocenteRevisado(sis_docente, array_periodo_reporte);
        //Cargamos la variable map_camposFormularioControlAvance con la informacion correspondiente
        cargarMapCamposFormularioControlAvanceDocente(sis_docente, array_periodo_reporte);
        //Cargamos la variable map_enlacesRecursosFormularioControlAvance con la informacion correspondiente
        cargarMapEnlacesRecursosFormularioControlAvanceDocente(sis_docente, array_periodo_reporte);
    });

    //Mostramos la tabla de reportes revisados y ocultamos la tabla de formulario de control de asistencia
    $(document).on("click", "#btnVolverReportesRevisados", function(){   
        document.getElementById("divSeccionMenuBusqueda").style.display = "";   
        document.getElementById("divFormularioControlAvanceDocenteRevisado").style.display = "none";
        document.getElementById("divReportesDocente").style.display = "";
        tablaReporteDocente.ajax.reload(null, false);
    });

});

function listaDeFacultades(){
    let datosFacultad = {
        clase: "Facultad",
        metodo: "mostrarFacultades"
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosFacultad,
        success: function (response) {
            // console.log(response);
            listaFacultades = JSON.parse(response);
            $("#idFacultades").empty();
            listaFacultades.forEach(element => {
                $('#idFacultades').append("<option value='"+element.id_facultad+"'>"+element.nombre_facultad+"</option>");
            });
            listaDepartamentos();
        }
    });
}
function listaDepartamentos(){
    let datosDepartamento = {
        clase: "Departamento",
        metodo: "mostrarDepartamentos",
        idFacultad: $("#idFacultades").val(),
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosDepartamento,
        success: function (response) {
            // console.log(response);
            let listaDepartmentos = JSON.parse(response);
            $("#idDepartamentos").empty();
            if(listaDepartmentos.length == 0){
                $('#idDepartamentos').append("<option value='Ninguno'>No existe datos</option>");
            }else{
                listaDepartmentos.forEach(element => {
                    $('#idDepartamentos').append("<option value='"+element.id_departamento+"'>"+element.nombre_departamento+"</option>");
                });
            }
            cargarTablaReportesPendientesDocente();
        }
    });
}

function cargarTablaReportesPendientesDocente(){
    let idDepartamento = $("#idDepartamentos option:selected").val();
    if(idDepartamento != 'Ninguno'){
        let datos = {
            clase: "Clase",
            metodo: "obtenerReportesJefeDepartamento",
            id_departamento: idDepartamento
        };
        $('#tablaReporteDocente').dataTable().fnDestroy();
        tablaReporteDocente = $("#tablaReporteDocente").DataTable({
        responsive: true,
            "ajax":{
                "method":"POST",
                "data" : datos,
                "url":"../controlador/interprete.php"
            },
            "columns":[
                {"data":"sis_docente"},
                {"data":"nombre_docente"},
                {"data":"periodo_reporte"},
                {"data": null,"defaultContent":"<button type='button' class='btnControlarAsistencia btn btn-warning'><i class='fas fa-clipboard-list'></i></button>"}
            ]
        })
    }else {
         $('#tablaReporteDocente').dataTable().fnClearTable();
    }
}

function cargarTablaFormularioControlAvanceDocente(sis_docente, array_periodo_reporte){
    let idDepartamento = $("#idDepartamentos option:selected").val();
    let datos = {
        clase: "Clase",
        metodo: "obtenerFormularioControlAvanceDocenteJefeDepartamento",
        id_departamento: idDepartamento,
        sis_docente: sis_docente, 
        array_periodo_reporte: array_periodo_reporte
    };
    //Eliminamos la antigua tabla
    $('#tablaFormularioControlAvanceDocente').dataTable().fnDestroy();
    //Cargamos la tabla con nueva informacion
    tablaFormularioControlAvanceDocente = $("#tablaFormularioControlAvanceDocente").DataTable({
        responsive: true,
        "ajax":{
            "method":"POST",
            "data" : datos,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_clase"},
            {"data":"periodo_hora_clase"},
            {"data":"nombre_grupo"},
            {"data":"nombre_materia"},
            {"data":"asistencia_revisada"},
            {"data": null,"defaultContent":"<button type='button' class='btnRevisarReporte btn btn-warning'><i class='fas fa-file-alt'></i></i></button>"}
        ]
    })
}

function cargarMapCamposFormularioControlAvanceDocente(sis_docente, array_periodo_reporte){
    //Obtenemos el codigo de clase 
    //Obtenemos los campos contenido, plataforma, observaciones 
    //Obtenemos los datos de la clase de reposicion si existiera
    //Almacenamos esos datos en un map y usamos como key la concatenacion de la fecha y la hora de clases
    let idDepartamento = $("#idDepartamentos option:selected").val();
    let datosCodigoClase = {
        clase: "Clase",
        metodo: "obtenerCamposRestantesFormularioControlAvanceDocente",
        id_departamento: idDepartamento,
        sis_docente: sis_docente, 
        array_periodo_reporte: array_periodo_reporte
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosCodigoClase,
        success: function (response) {
            let obj= JSON.parse(response);
            map_camposFormularioControlAvance = new Map();
            obj.forEach(element => {
                    //Almacenamos los campos del formulario de control de avance de la clase
                    let array = new Array();
                    array.push(element.codigo_clase);
                    array.push(element.contenido_clase);
                    array.push(element.plataforma_clase);
                    array.push(element.observaciones_clase);
                    array.push(element.clase_recuperacion);
                    array.push(element.asunto_reposicion);
                    array.push(element.fecha_reposicion);
                    array.push(element.hora_reposicion);
                    array.push(element.plataforma_reposicion);
                    array.push(element.avanze_posicion);
                    array.push(element.existe_falta_clase);
                    array.push(element.asistencia_revisada);
                    array.push(element.clase_con_licencia);
                    array.push(element.descripcion_licencia);
                    array.push(element.enlace_licencia);
                    map_camposFormularioControlAvance.set(element.fecha_clase+element.periodo_hora_clase, array);
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function cargarMapEnlacesRecursosFormularioControlAvanceDocente(sis_docente, array_periodo_reporte){
    //Obtenemos los enlaces y recursos con su respectiva descripcion
    //Almacenamos esos datos en un map y usamos como key la concatenacion de la fecha y la hora de clases
    let idDepartamento = $("#idDepartamentos option:selected").val();
    let datosCodigoClase = {
        clase: "Clase",
        metodo: "obtenerEnlacesRecursosFormularioControlAvanceDocente",
        id_departamento: idDepartamento,
        sis_docente: sis_docente, 
        array_periodo_reporte: array_periodo_reporte
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosCodigoClase,
        success: function (response) {
            let obj= JSON.parse(response);
            map_enlacesRecursosFormularioControlAvance = new Map();
            obj.forEach(element => {
                    //Almacenamos los enlaces y recursos del formulario de control de avance de la clase
                    let key = element.fecha_clase+element.periodo_hora_clase;
                    let arrayEnlacesRecursos = map_enlacesRecursosFormularioControlAvance.get(key)
                    if(arrayEnlacesRecursos === undefined){
                        arrayEnlacesRecursos = new Array();
                        map_enlacesRecursosFormularioControlAvance.set(key, arrayEnlacesRecursos);
                    }
                    let array = new Array();
                    array.push(element.descripcion_enlace_recurso);
                    array.push(element.direccion_enlace_recurso);
                    array.push(element.es_enlace);
                    arrayEnlacesRecursos.push(array);
                    
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function guardarReferenciaFilaArrayCampos(fila, arrayCampos){
    if(arrayCampos.length == 12){
        arrayCampos.push(fila);
    }
}

function cargarInformacionCamposModalFormularioControlAvance(arrayCampos){
    $("#textareaContenido").text(arrayCampos[1]);
    $("#textareaPlataforma").text(arrayCampos[2]);
    $("#textareaObservaciones").text(arrayCampos[3]);
    //Verificamos si existe una clase de reposicion asociada
    if(arrayCampos[4]){
        document.getElementById("divClaseReposicion").style.display = "";
        $("#asuntoClaseReposicion").text(arrayCampos[5]);
        $("#fechaClaseReposicion").val(arrayCampos[6]);
        $("#horaClaseReposicion").val(arrayCampos[7]);
        $("#plataformaClaseReposicion").val(arrayCampos[8]);
        $("#contenidoClaseReposicion").text(arrayCampos[9]);
    }else{
        document.getElementById("divClaseReposicion").style.display = "none";
    }
    //Establecemos la opcion escogida de asistencia, si el reporte ya fue revisado
    if(arrayCampos[11] == "Si"){
        //Verificamos si se registro una falta
        if(arrayCampos[10]){
            document.getElementById("inlineRadioNo").checked = true;
        }else{
            document.getElementById("inlineRadioSi").checked = true;
        }
    }else{
        //Establecemos el valor por defeault de los radios
        document.getElementById("inlineRadioSi").checked = false;
        document.getElementById("inlineRadioNo").checked = false;
    }

    document.getElementById("divClaseLicencia").style.display = "none";
    if(arrayCampos[12] != null){
        if(arrayCampos[12]){
            document.getElementById("divClaseLicencia").style.display = "";
            document.getElementById("textareaDescripcionLicencia").innerHTML = arrayCampos[13];
            let a = document.getElementById("aEnlaceLicencia");
            a.setAttribute("href",arrayCampos[14]);
            a.innerHTML = arrayCampos[14];
        }
    }
}

function cargarEnlacesRecursosModalFormularioControlAvance(arrayEnlacesRecursos){
    let tituloEnlaces = document.getElementById("tituloEnlaces");
    let divContenedorEnlaces = document.getElementById("divContenedorEnlaces");
    let tituloRecursos = document.getElementById("tituloRecursos");
    let divContenedorRecursos = document.getElementById("divContenedorRecursos");
    //Establecemos los titulos por defecto cuando no existen enlaces o recursos asociados a la clase
    tituloEnlaces.innerHTML = "";
    tituloRecursos.innerHTML = "";
    //Borramos el contenido anterior
    borrarContenidoPrevio(divContenedorEnlaces);
    borrarContenidoPrevio(divContenedorRecursos);
    if(arrayEnlacesRecursos !== undefined){
        //Cargamos los enlaces y recursos en su contenedor correspondiente
        for (let i = 0; i < arrayEnlacesRecursos.length; i++) {
            let array = arrayEnlacesRecursos[i];
            let p = document.createElement("p");
            p.innerHTML = array[0]+" ";
            let a = document.createElement("a");
            a.setAttribute('href',array[1]);
            a.setAttribute('target', '_blank');
            a.innerHTML = array[1];
            p.appendChild(a);
            if(array[2]){
                divContenedorEnlaces.appendChild(p);
            }else{
                divContenedorRecursos.appendChild(p);
            }
        }
        if(divContenedorEnlaces.firstChild != null){
            tituloEnlaces.innerHTML = "Enlaces:";
        }
        if(divContenedorRecursos.firstChild != null){
            tituloRecursos.innerHTML = "Recursos:";
        }
    }
}

function borrarContenidoPrevio(elem){
  while (elem.hasChildNodes()) {
    elem.removeChild(elem.firstChild);
  }
}

function obtenerCodigosClaseFormulario(){
    let array = new Array();
    map_camposFormularioControlAvance.forEach(function(value, key) {
        array.push(value[0]);
    })
    return array;
}

function cargarSelectGestion(){
    let idDepartamento = $("#idDepartamentos option:selected").val();
    let datos = {
        clase: "Clase",
        metodo: "obtenerGestionesClasesRegistradasDepartamento",
        id_departamento: idDepartamento
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let elemSelect = document.getElementById("selectGestion");
            borrarContenidoPrevio(elemSelect);
            obj.forEach(element => {
                //Creamos elementos option y los agregamos al elemSelect
                let option = document.createElement("option");
                option.value = element.gestion;
                option.innerHTML = element.gestion;
                elemSelect.appendChild(option);
            });
            //Verificamos en caso de que no exista ninguna clase registrada
            if(elemSelect.length == 0){
                //Agregamos un option indicando de que no existe una clase registrada
                let optionDefault = document.createElement("option");
                optionDefault.value = "Ninguno"
                optionDefault.innerHTML = "No existen clases registradas"
                elemSelect.appendChild(optionDefault);
            }
            cargarSelectMes(elemSelect.firstChild.value);
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function cargarSelectMes(gestion){
    if(gestion != "Ninguno"){
        let idDepartamento = $("#idDepartamentos option:selected").val();
        let datos = {
            clase: "Clase",
            metodo: "obtenerMesClasesRegistradasDepartamento",
            gestion: gestion,
            id_departamento: idDepartamento
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                let obj= JSON.parse(response);
                let elemSelect = document.getElementById("selectMes");
                borrarContenidoPrevio(elemSelect);
                obj.forEach(element => {
                    //Creamos elementos option y los agregamos al elemSelect
                    let option = document.createElement("option");
                    option.value = element.mes;
                    switch(element.mes){
                        case '12':
                            option.innerHTML = "Diciembre";
                            break;
                        case '11':
                            option.innerHTML = "Noviembre";
                            break;
                        case '10':
                            option.innerHTML = "Octubre";
                            break;
                        case '09':
                            option.innerHTML = "Septiembre";
                            break;
                        case '08':
                            option.innerHTML = "Agosto";
                            break;
                        case '07':
                            option.innerHTML = "Julio";
                            break;
                        case '06':
                            option.innerHTML = "Junio";
                            break;
                        case '05':
                            option.innerHTML = "Mayo";
                            break;
                        case '04':
                            option.innerHTML = "Abril";
                            break;
                        case '03':
                            option.innerHTML = "Marzo";
                            break;
                        case '02':
                            option.innerHTML = "Febrero";
                            break;
                        case '01':
                            option.innerHTML = "Enero";
                            break;
                    }
                    elemSelect.appendChild(option);
                });
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
        });
    }
}

function cargarTablaReportesRevisadosDocente(){
    let gestion = $("#selectGestion option:selected").val();
    if(gestion != 'Ninguno'){
        let mes = $("#selectMes option:selected").val();
        let idDepartamento = $("#idDepartamentos option:selected").val();
        let datos = {
            clase: "Clase",
            metodo: "obtenerReportesRevisadosDocente",
            id_departamento: idDepartamento,
            gestion: gestion,
            mes: mes
        };
        $('#tablaReporteDocente').dataTable().fnDestroy();
        tablaReporteDocente = $("#tablaReporteDocente").DataTable({
            responsive: true,
            "ajax":{
                "method":"POST",
                "data" : datos,
                "url":"../controlador/interprete.php"
            },
            "columns":[
                {"data":"sis_docente"},
                {"data":"nombre_docente"},
                {"data":"periodo_reporte"},
                {"data": null,"defaultContent":"<button type='button' class='btnVerFormularioControlAvance btn btn-warning'><i class='fas fa-clipboard-check'></i></button>"}
            ]
        })
    }
}

function cargarTablaFormularioControlAvanceDocenteRevisado(sis_docente, array_periodo_reporte){
    let idDepartamento = $("#idDepartamentos option:selected").val();
    let datos = {
        clase: "Clase",
        metodo: "obtenerFormularioControlAvanceDocenteRevisado",
        id_departamento: idDepartamento,
        sis_docente: sis_docente, 
        array_periodo_reporte: array_periodo_reporte
    };
    //Eliminamos la antigua tabla
    $('#tablaFormularioControlAvanceDocenteRevisado').dataTable().fnDestroy();
    //Cargamos la tabla con nueva informacion
    tablaFormularioControlAvanceDocente = $("#tablaFormularioControlAvanceDocenteRevisado").DataTable({
        responsive: true,
        "ajax":{
            "method":"POST",
            "data" : datos,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_clase"},
            {"data":"periodo_hora_clase"},
            {"data":"nombre_grupo"},
            {"data":"nombre_materia"},
            {"data":"falta_clase"},
            {"data": null,"defaultContent":"<button type='button' class='btnRevisarReporte btn btn-warning'><i class='fas fa-file-alt'></i></i></button>"}
        ]
    })
}

function restaurarTipoNoDocente(){
    document.getElementById("seccionAuxiliaresLaboratorio").style.display = "";
    document.getElementById("seccionFiltrosBusqueda").style.display = "none";
    document.getElementById("divReportesDocente").style.display = "none";
}