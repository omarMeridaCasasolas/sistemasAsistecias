var tablaReporteDocente;
var map_codigo_clase;
var map_enlaces_recursos_clase;

$(document).ready(function () {

    //Cargar las facultades donde dicta clases el docente
    cargarSelectFacultad($("#idDocente").val());

    //Una vez que seleccione la facultad
    //Se debera cargar los departamentos donde dicta clases el docente
    $(document).on("change", "#selectFacultad", function(e){   
        let id_facultad = $("#selectFacultad option:selected").val();
        if(id_facultad != "Ninguno"){
            cargarSelectDepartamento(id_facultad, $("#idDocente").val());
            //Ocultamos la seccion del formulario
            document.getElementById("divSeccionFormulario").style.display = "none";
        }
    });

    //Una vez que seleccione el departamento
    //Se debera cargar el formulario de control de avance correspondiente a la semana
    $(document).on("change", "#selectDepartamento", function(e){   
        let id_departamento = $("#selectDepartamento option:selected").val();
        if(id_departamento != "Ninguno"){
            cargarReporteDocente(id_departamento, $("#idDocente").val());
            //Mostramos la seccion del formulario
            document.getElementById("divSeccionFormulario").style.display = "";
        }
    });

    //Mostrar modalFormularioAvance  
    $(document).on("click", ".btnEditarRegistro", function(){
        //Establecemos la pestaña contenido como predeterminada
        $("#pills-contenido-tab").attr("class",'nav-link active');
        $("#pills-contenido").attr("class",'tab-pane fade show active');
        $("#pills-plataforma-tab").attr("class",'nav-link');
        $("#pills-plataforma").attr("class",'tab-pane fade');
        $("#pills-observaciones-tab").attr("class",'nav-link');
        $("#pills-observaciones").attr("class",'tab-pane fade');
        //Recuperamos los datos de la fila
        let fila = $(this).closest("tr");
        let fecha_clase = fila.find('td:eq(0)').text();   
        let periodo_hora_clase = fila.find('td:eq(1)').text();    
        let numero_grupo = fila.find('td:eq(2)').text();
        let nombre_materia = fila.find('td:eq(3)').text();
        let contenido_clase = fila.find('td:eq(4)').text(); 
        let plataforma_clase = fila.find('td:eq(5)').text();
        let observaciones_clase = fila.find('td:eq(6)').text();
        //Establecemos el valor del div oculto con el codigo de clase
        //El codigo clase lo obtenemos del map usando como key la fecha y el periodo de clase 
        $("#codigo_clase").val(map_codigo_clase.get(fecha_clase+periodo_hora_clase));
        //Agregamos el titulo al modal
        $("#modalTituloFormularioAvance").text(nombre_materia+" GRUPO "+numero_grupo);
        //Agregamos la informacion de la fila en los campos correspondientes del modal
        $("#textareaContenido").val(contenido_clase);
        $("#textareaPlataforma").val(plataforma_clase);
        $("#textareaObservaciones").val(observaciones_clase);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalFormularioAvance').modal('show');         
    });

    //Guardar cambios del formulario de avance
    $('#formControlAvance').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        //Recuperamos el codigo de clase almacenado en el div no visible del modal
        let codigo_clase = $("#codigo_clase").val();

        let contenido_clase = $.trim($("#textareaContenido").val());
        let plataforma_clase = $.trim($("#textareaPlataforma").val());
        let observaciones_clase = $.trim($("#textareaObservaciones").val());
        let clase = 'Clase';
        let metodo = 'actualizarClase';                       
            $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:clase, metodo:metodo, codigo_clase:codigo_clase, contenido_clase:contenido_clase,plataforma_clase:plataforma_clase,observaciones_clase:observaciones_clase},    
            success: function(data) {
             tablaReporteDocente.ajax.reload(null, false);
            }
            });                 
        $('#modalFormularioAvance').modal('hide');                                                       
    });

    //Mostrar modalEnlacesRecursos 
    $(document).on("click", ".btnSubirRecurso", function(){
        //Eliminamos los enlaces y recursos del modal, no se hacen cambios en la base de datos
        borrarContenidoPrevio(document.getElementById('contenedorEnlaces'));
        borrarContenidoPrevio(document.getElementById('contenedorRecursos'));
        //Recuperamos los datos que identifican a la fila
        let fila = $(this).closest("tr");
        let fecha_clase = fila.find('td:eq(0)').text();   
        let periodo_hora_clase = fila.find('td:eq(1)').text();    
        let numero_grupo = fila.find('td:eq(2)').text();
        let nombre_materia = fila.find('td:eq(3)').text();
        //Establecemos el valor del div oculto con el codigo de clase
        //El codigo clase lo obtenemos del map usando como key la fecha y el periodo de clase 
        $("#codigo_clase").val(map_codigo_clase.get(fecha_clase+periodo_hora_clase));
        //Identificamos la fila con un titulo
        $("#modalTituloEnlacesRecursos").text(nombre_materia+" GRUPO "+numero_grupo);
        //Cargamos los enlaces y recursos correspondientes a la fila
        //Ademas de guardar el sus ids en map_enlaces_recursos_clase teniendo codido de clase como key
        cargarEnlacesRecursos($("#codigo_clase").val());
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalEnlacesRecursos').modal('show');         
    });

    //Quitar enlace de la clase 
    $(document).on("click", ".btnQuitarEnlace", function(e){
        //evitamos que recargue la pagina
        e.preventDefault();
        //obtenemos el id del enlace
        let id_enlace_recurso_clase = (this.id).substring(3);
        let clase = 'EnlaceRecursoClase';
        let metodo = 'quitarEnlaceRecurso';
        $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:clase, metodo:metodo, id_enlace_recurso_clase:id_enlace_recurso_clase},    
            success: function(data) {
                if(data == 1){
                    let contenedorEnlaces = document.getElementById('contenedorEnlaces');
                    let row = document.getElementById(id_enlace_recurso_clase);
                    contenedorEnlaces.removeChild(row);
                    //obtenemos el array que correspondiente al codigo clase
                    let array = map_enlaces_recursos_clase.get($("#codigo_clase").val());
                    //retiramos el id_enlace_recurso_clase del array
                    console.log(id_enlace_recurso_clase);
                    console.log(array.splice(array.indexOf(id_enlace_recurso_clase), 1));//CorregirEliminacion
                }
            }
        });         
    });

    //Quitar recurso de la clase 
    $(document).on("click", ".btnQuitarRecurso", function(e){
        //evitamos que recargue la pagina
        e.preventDefault();
        //obtenemos el id del recurso
        let id_enlace_recurso_clase = (this.id).substring(3);
        let clase = 'EnlaceRecursoClase';
        let metodo = 'quitarEnlaceRecurso';
        //Si el recurso se elimino del servidor de amazon
        //Entonces quitamos la direccion url del recurso de la base de datos 
        if(true){
            $.ajax({
                url: "../controlador/interprete.php",
                type: "POST",
                datatype:"json",    
                data:  {clase:clase, metodo:metodo, id_enlace_recurso_clase:id_enlace_recurso_clase},    
                success: function(data) {
                    if(data == 1){
                        let contenedorRecursos = document.getElementById('contenedorRecursos');
                        let row = document.getElementById(id_enlace_recurso_clase);
                        contenedorRecursos.removeChild(row);
                        //obtenemos el array que correspondiente al codigo clase
                        let array = map_enlaces_recursos_clase.get($("#codigo_clase").val());
                        //retiramos el id_enlace_recurso_clase del array
                        array.splice(array.indexOf(id_enlace_recurso_clase), 1);//CorregirEliminacion
                    }
                }
            }); 
        }        
    });

    //Agregar nuevo enlace a la clase 
    $(document).on("click", "#btnAgregarEnlace", function(e){
        //evitamos que recargue la pagina
        e.preventDefault();
        //obtenemos la direccion del enlace
        let direccion_enlace_recurso = $.trim($("#textareaDireccionEnlace").val());
        //comprobamos que no sea una cadena vacia
        if(direccion_enlace_recurso != ''){
            //obtenemos la descripcion del enlace
            let descripcion_enlace_recurso = $.trim($("#textareaDescripcionEnlace").val());
            let es_enlace = 't';
            //Definimos los datos necesarios para la consulta
            let codigo_clase = $("#codigo_clase").val();
            let arrayEnlacesRecursos = map_enlaces_recursos_clase.get(codigo_clase);
            let clase = 'EnlaceRecursoClase';
            let metodo = 'obtenerIdEnlaceRecursoInsertado';
            $.ajax({
                url: "../controlador/interprete.php",
                type: "POST",
                datatype:"json",    
                data:  {clase:clase,metodo:metodo,codigo_clase:codigo_clase,arrayEnlacesRecursos:arrayEnlacesRecursos,descripcion_enlace_recurso:descripcion_enlace_recurso,direccion_enlace_recurso:direccion_enlace_recurso,es_enlace:es_enlace},    
                success: function (response) {
                    let obj= JSON.parse(response);
                    obj.forEach(element => {
                        console.log(element.id_enlace_recurso_clase);
                        let array = map_enlaces_recursos_clase.get(codigo_clase);
                        array.push(element.id_enlace_recurso_clase);
                        cargarContenidoEnlacesRecursos(element.id_enlace_recurso_clase, descripcion_enlace_recurso, direccion_enlace_recurso, true);
                        $("#textareaDescripcionEnlace").val("");
                        $("#textareaDireccionEnlace").val("");
                    });
                },
                error : function(jqXHR, status, error) {
                    console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
                }
            });
        }

    });

    //Agregar nuevo recurso a la clase 
    $(document).on("change", "#inputFileRecurso", function(e){
        //evitamos que recargue la pagina
        e.preventDefault();

        let enlaceCapturado = "sdsdsd";
        //enlaceCapturado = subirArchivo(e);
        if(enlaceCapturado != null){
            //obtenemos la descripcion del recurso
            let descripcion_enlace_recurso = $.trim($("#textareaDescripcionRecurso").val());
            //obtenemos la direccion del enlace
            let direccion_enlace_recurso = enlaceCapturado;
            let es_enlace = 'f';
            //Definimos los datos necesarios para la consulta
            let codigo_clase = $("#codigo_clase").val();
            console.log(codigo_clase);
            let arrayEnlacesRecursos = map_enlaces_recursos_clase.get(codigo_clase);
            let clase = 'EnlaceRecursoClase';
            let metodo = 'obtenerIdEnlaceRecursoInsertado';
            $.ajax({
                url: "../controlador/interprete.php",
                type: "POST",
                datatype:"json",    
                data:  {clase:clase,metodo:metodo,codigo_clase:codigo_clase,arrayEnlacesRecursos:arrayEnlacesRecursos,descripcion_enlace_recurso:descripcion_enlace_recurso,direccion_enlace_recurso:direccion_enlace_recurso,es_enlace:es_enlace},    
                success: function (response) {
                    let obj= JSON.parse(response);
                    obj.forEach(element => {
                        let array = map_enlaces_recursos_clase.get(codigo_clase);
                        array.push(element.id_enlace_recurso_clase);
                        cargarContenidoEnlacesRecursos(element.id_enlace_recurso_clase, descripcion_enlace_recurso, direccion_enlace_recurso, false);
                        $("#textareaDescripcionRecurso").val("");
                    });
                },
                error : function(jqXHR, status, error) {
                    console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
                }
            });
        }

    }); 

    //Enviar formulario de control de avance
    $(document).on("click", "#btnEnviarFormulario", function(e){
        //Evitamos que se recargue la pagina
        e.preventDefault();   
        //Comprobamos que los campos requeridos no esten vacios
        let numeroFilas = tablaReporteDocente.data().count();
        let existeCampoVacio = false;
        let row;
        let mensaje;
        for(let i=0; i<numeroFilas&&!existeCampoVacio; i++){
            row = tablaReporteDocente.rows().data()[i];
            if(row.contenido_clase == "" ){
                existeCampoVacio = true;
                mensaje = " tiene vacio el contenido de clase.";
            }else if(row.plataforma_clase == ""){
                existeCampoVacio = true;
                mensaje = " tiene vacio la plataforma o medio utilizado.";
            }
        }
        if(existeCampoVacio){
            Swal.fire({
                icon: 'error',
                title: 'Todos los datos requeridos deben ser llenados',
                text: 'Contenio de clase y Plataforma o medio de utilizacion, no pueden estar vacios'
            })
        }else{
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'El formulario de control de avance fue enviado.',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });


});

function cargarSelectFacultad(id_docente){
    let elemSelect = document.getElementById('selectFacultad');
    borrarContenidoPrevio(elemSelect);
    let datos = {
        clase: "Facultad",
        metodo: "obtenerFacultadDocente",
        id_docente: id_docente
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let option = document.createElement("option");
            option.value = 'Ninguno';
            option.innerHTML = '--Seleccione facultad--';
            elemSelect.appendChild(option);
            obj.forEach(element => {
                    option = document.createElement("option");
                    option.value = element.id_facultad;
                    option.innerHTML = element.nombre_facultad;
                    elemSelect.appendChild(option);
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

function cargarSelectDepartamento(id_facultad, id_docente){
    let elemSelect = document.getElementById('selectDepartamento');
    borrarContenidoPrevio(elemSelect);
    let datos = {
        clase: "Departamento",
        metodo: "obtenerDepartamentoDocente",
        id_facultad: id_facultad,
        id_docente: id_docente
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let option = document.createElement("option");
            option.value = 'Ninguno';
            option.innerHTML = '--Seleccione departamento--';
            elemSelect.appendChild(option);
            obj.forEach(element => {
                    option = document.createElement("option");
                    option.value = element.id_departamento;
                    option.innerHTML = element.nombre_departamento;
                    elemSelect.appendChild(option);
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function cargarReporteDocente(id_departamento, id_docente){
    let datosCodigoClase = {
        clase: "Clase",
        metodo: "obtenerCodigoClase",
        id_departamento : id_departamento,
        id_docente : id_docente
    };
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datosCodigoClase,
        success: function (response) {
            let obj= JSON.parse(response);
            map_codigo_clase = new Map();
            obj.forEach(element => {
                    map_codigo_clase.set(element.fecha_clase+element.periodo_hora_clase, element.codigo_clase);
            });
            cargarTablaReporteDocente(id_departamento, id_docente);
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
    console.log("cargando el map");
    map_enlaces_recursos_clase = new Map();
}

function cargarTablaReporteDocente(id_departamento, id_docente){
    let datosDocente = {
        clase: "Clase",
        metodo: "obtenerClaseDocente",
        id_departamento: id_departamento,
        id_docente: id_docente
    };
    //Eliminamos la antigua tabla
    $('#tablaReporteDocente').dataTable().fnDestroy();
    tablaReporteDocente = $("#tablaReporteDocente").DataTable({
        responsive: true,
        "ajax":{
            "method":"POST",
            "data" : datosDocente,
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"fecha_clase"},
            {"data":"periodo_hora_clase"},
            {"data":"nombre_grupo"},
            {"data":"nombre_materia"},
            {"data":"contenido_clase"},
            {"data":"plataforma_clase"},
            {"data":"observaciones_clase"},
            {"data": null,"defaultContent":"<button type='button' class='btnEditarRegistro btn btn-warning'><i class='far fa-edit'></i></button>"},
            {"data": null,"defaultContent":"<button type='button' class='btnSubirRecurso btn btn-warning'><i class='fas fa-cloud-upload-alt'></i></button>"}
        ]
    })
}

function cargarEnlacesRecursos(codigo_clase){
    let datos = {
        clase: "EnlaceRecursoClase",
        metodo: "obtenerEnlaceRecursoClase",
        codigo_clase: codigo_clase
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let arrayEnlacesRecursos;
            let registrarEnlacesRecursos = false;
            if(!map_enlaces_recursos_clase.has(codigo_clase)){
                arrayEnlacesRecursos = new Array();
                map_enlaces_recursos_clase.set(codigo_clase,arrayEnlacesRecursos);
                registrarEnlacesRecursos = true; 
            }
            obj.forEach(element => {
                if(registrarEnlacesRecursos){
                    arrayEnlacesRecursos.push(element.id_enlace_recurso_clase);
                }
                cargarContenidoEnlacesRecursos(element.id_enlace_recurso_clase, element.descripcion_enlace_recurso, element.direccion_enlace_recurso, element.es_enlace);
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function cargarContenidoEnlacesRecursos(id_enlace_recurso, descripcion_enlace_recurso, direccion_enlace_recurso, es_enlace){
    let row = document.createElement("div");
    row.id = id_enlace_recurso;
    row.className = "row";

    let divDescripcion = document.createElement("div");
    divDescripcion.className = "form-group col-md-5";
    let pDescripcion = document.createElement("p");
    pDescripcion.innerHTML = descripcion_enlace_recurso;
    divDescripcion.appendChild(pDescripcion);

    row.appendChild(divDescripcion);

    let divDireccion = document.createElement("div");
    divDireccion.className = "form-group col-md-5";
    let aDireccion = document.createElement("a");
    aDireccion.href = direccion_enlace_recurso;
    aDireccion.target = "_blank";
    aDireccion.innerHTML = direccion_enlace_recurso;
    divDireccion.appendChild(aDireccion);

    row.appendChild(divDireccion);

    let divButton = document.createElement("div");
    divButton.className = "form-group col-md-2";
    let button = document.createElement("button");
    button.id = "ID_"+id_enlace_recurso;
    let contenedorEnlacesRecursos;
    if(es_enlace){
        button.className = "btn btn-primary btn-sm btnQuitarEnlace";
        contenedorEnlacesRecursos = document.getElementById('contenedorEnlaces');
    }else{
        button.className = "btn btn-primary btn-sm btnQuitarRecurso";
        contenedorEnlacesRecursos = document.getElementById('contenedorRecursos');
    }
    let i = document.createElement("i");
    i.className = "fas fa-minus";
    button.appendChild(i);
    divButton.appendChild(button);

    row.appendChild(divButton);

    contenedorEnlacesRecursos.appendChild(row);
}