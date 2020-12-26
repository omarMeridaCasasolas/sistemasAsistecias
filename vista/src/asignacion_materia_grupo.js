$(document).ready(function() {
	
	let id_departamento = $("#idCategoria").val();

	//ListarMateriasDepartamento
    listarTablaMateriasDepartamento = $("#tablaMateriasDep").DataTable({
        "ajax":{
            "method":"POST",
            "url":"../controlador/interprete.php",
            "data" : {'clase': 'Materia' , 'metodo':'listarMateriasDepartamento', 'id_departamento':id_departamento}
        },
        "columns":[
            {"data":"codigo_materia"},
            {"data":"nombre_materia"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditarMateria'><i class='fas fa-user-edit'></i></button><button class='btn btn-danger btn-sm btnEliminarMateria'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

    //importamos materias
    $(document).on("change", "#inputFileMateria", function(e){ 
        //(eventoCapturado,nombreClase,nombreMetodo)  
        procesarArchivoCSV(e, 'Materia', 'importarMaterias');
    });

    //CrearMateria
    $(document).on("click", "#btnCrearMateria", function(){   
        
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalCrearMateria').modal('show');         
    });

    $("#formInsertarMateria").submit(function (e) { 
        let datosMateria = {
        clase: "Materia",
        metodo: "insertarMateria",
        nomMateria: $("#nomMateria").val(),
        sisMateria: $("#sisMateria").val(),
        id_departamento: $("#idCategoria").val()
        //Aqui se coloca el id que identifica a a la autoridad-Ambiente
        };
        $.post("../controlador/interprete.php",datosMateria,function(resp){
            if(resp == 1){
                $("#btnVentanaMateria").click();
                $("#formInsertarMateria")[0].reset();
                $("#exitoMateria").removeClass("d-none");
                listarTablaMateriasDepartamento.ajax.reload(null, false);
            }else{
                $("#errorMateria").removeClass("d-none");
            }
        });
        e.preventDefault();
    });


    //EditarMateria
    //Recuperar datos de la fila y mostrar en el modalEditarMateria
    $(document).on("click", ".btnEditarMateria", function(){               
        fila = $(this).closest("tr");  
        codigo_materia = fila.find('td:eq(0)').text();
        nombre_materia = fila.find('td:eq(1)').text();                 
        //id_departamento = fila.find('td:eq(2)').text();
        $("#nomMateriaEdit").attr("name", codigo_materia);
        $("#nomMateriaEdit").val(nombre_materia);
        $("#codigoEdit").val(codigo_materia);
        //$("#departamentoEdit").val(id_departamento);
        //$("#telDocenteEdit").val(telDocente);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );     
        $('#modalEditarMateria').modal('show');         
    });

    //Recuperamos los datos del modalEditarMateria
    //Mandamos a actualizar los datos de materia
    $('#formEditarMateria').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        codigo = $("#nomMateriaEdit").attr("name");
        nomMateria = $.trim($("#nomMateriaEdit").val());
        nuevo_codigo = $.trim($("#codigoEdit").val());
        //departamento = $.trim($("#departamentoEdit").val());
        //telDocente = $.trim($("#telDocenteEdit").val());   
        clase = 'Materia';
        metodo = 'editarMateria';                       
            $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:clase, metodo:metodo, nomMateria:nomMateria, codigo:codigo, nuevo_codigo:nuevo_codigo},    
            success: function(data) {
             listarTablaMateriasDepartamento.ajax.reload(null, false);
            }
            });                 
        $('#modalEditarMateria').modal('hide');                                                          
    });

    //EliminarMateria
    $(document).on("click", ".btnEliminarMateria", function(){
        let fila = $(this);    
        sis_materia = $(this).closest('tr').find('td:eq(0)').text();            
        nom_materia = $(this).closest('tr').find('td:eq(1)').text();
        id_departamento = $("#idCategoria").val();
        Swal.fire({
            title: '¿Desea eliminar la materia: '+sis_materia+' '+nom_materia+'?',
            text: "¡Se borraran definitivamente los datos que lo relacionen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                clase = 'Materia';
                metodo = 'eliminarMateria';            
                $.ajax({
                    url: "../controlador/interprete.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {clase:clase, metodo:metodo, sis_materia:sis_materia, id_departamento:id_departamento},    
                    success: function() {
                        listarTablaMateriasDepartamento.row(fila.parents('tr')).remove().draw();           
                    }
                }); 
                Swal.fire(
                '¡Eliminado!',
                'La materia ha sido eliminado.',
                'success'
                )
            }
        });             
        
    });

    //ListarGruposDepartamento
    listarTablaGruposDepartamento = $("#tablaGruposDep").DataTable({
        "ajax":{
            "method":"POST",
            "url":"../controlador/interprete.php",
            "data" : {'clase': 'Grupo' , 'metodo':'listarGruposDepartamento', 'id_departamento':id_departamento}
        },
        "columns":[
            {"data":"codigo_materia"},
            {"data":"nombre_materia"},
            {"data":"nombre_grupo"},
            {"data":"sis_docente"},
            {"data":"nombre_docente"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnInfoGrupo'><i class='fas fa-info-circle'></i></button><div class='btn-group'><button class='btn btn-primary btn-sm btnEditarGrupo'><i class='far fa-edit'></i></i></button><button class='btn btn-danger btn-sm btnEliminarGrupo'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

    //ImportarGrupos
    $(document).on("change", "#inputFileGrupo", function(e){   
        procesarArchivoCSV(e,'Grupo', 'importarGrupos');
    });

    //CrearGrupo
    $(document).on("click", "#btnCrearGrupo", function(){   
        cargarMateriasDepartamento('selectMateriasDep', id_departamento);
        limpiarInputNombreGrupo('nomGrupo');
        limpiarSelectDocenteAuxiliarAsignado();
        limpiarCabeceraGrupos('divGruposMateria');
        limpiarCabeceraCarreras('divCarrerasAsignadasMateria');
        quitarCamposHorariosTemporales('horariosGrupo');//AQUI NOS QUEDAMOS
        cambiarEstadoElementoBloqueado('nomGrupo', true);
        cambiarEstadoElementoBloqueado('selectDocenteAsignado', true);
        cambiarEstadoElementoBloqueado('selectAuxiliarAsignado', true);
        cambiarEstadosCamposHorarios('horarioGrp', true);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalCrearGrupo').modal('show');         
    });

    //CargarGruposCarrerasMateria
    $(document).on("change", "#selectMateriasDep", function(e){   
        let sis_materia = $("#selectMateriasDep option:selected").val();
        cargarGruposMateria("divGruposMateria", sis_materia);
        if(sis_materia == "Ninguno"){
            cambiarEstadoElementoBloqueado('nomGrupo', true);
            cambiarEstadoElementoBloqueado('selectDocenteAsignado', true);
            cambiarEstadoElementoBloqueado('selectAuxiliarAsignado', true);
            cambiarEstadosCamposHorarios('horarioGrp', true);
        }else{
            cambiarEstadoElementoBloqueado('nomGrupo', false);
            cambiarEstadoElementoBloqueado('selectDocenteAsignado', false);
            cambiarEstadoElementoBloqueado('selectAuxiliarAsignado', false);
            cambiarEstadosCamposHorarios('horarioGrp', false);
            cargarDocentesAsignadosMateria(sis_materia, 'selectDocenteAsignado');
            cargarAuxiliaresAsignadosMateria(sis_materia, 'selectAuxiliarAsignado');
        }
        cargarCarrerasAsignadasMateria('divCarrerasAsignadasMateria',sis_materia);
    });

    //AgregarSiguienteFilaHorarioGrupo
    $(document).on("click", "#btnAgregarHorarioGrp", function(e){   
        if($("#selectMateriasDep option:selected").val() != "Ninguno"){
            agregarFilaHorarioGrp('horariosGrupo',"selectDias_","horarioGrupo_","selectAsignacionHorarioGrupo_");
        }else{
            e.preventDefault();//evita el comportambiento normal del submit, es decir, recarga total de la página
        }        
    });

    //QuitarAnteriorFilaHorarioGrupo
    $(document).on("click", "#btnQuitarHorarioGrp", function(e){   
        if($("#selectMateriasDep option:selected").val() != "Ninguno"){
            quitarFilaHorarioGrp('horariosGrupo', e);
        }else{
            e.preventDefault();//evita el comportambiento normal del submit, es decir, recarga total de la página
        }        
    });

    //RegistrarGrupo
    $('#formInsertarGrupo').submit(function(e){   
        e.preventDefault();
        let sis_materia = $("#selectMateriasDep option:selected").val();
        let nombreGrupo =  $.trim($("#nomGrupo").val());
        if(sis_materia == 'Ninguno'){
           Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No es posible registrar un grupo!',
                footer: 'Primero seleccione una materia'
            }); 
        }else if(esValidoNombreGrupo(nombreGrupo)){
            let arrayHorariosGrupo = obtenerHorariosGrupo('horariosGrupo',"selectDias_","horarioGrupo_","selectAsignacionHorarioGrupo_");
            if(esValidoHorarioGrupo(arrayHorariosGrupo)){
                let arrayCarrerasAsignadasGrupo = obtenerCarrerasAsignadasGrupo('checkBoxCarrerasAsignadasGrupo');
                let sis_docente_asignado = $("#selectDocenteAsignado option:selected").val();
                let sis_auxiliar_asignado = $("#selectAuxiliarAsignado option:selected").val();
                let datosGrupo = {
                    clase: "Grupo",
                    metodo: "insertarGrupo",
                    sis_mat: sis_materia,
                    nom_grupo: nombreGrupo,
                    horarios: arrayHorariosGrupo,
                    carrerasAsignadas: arrayCarrerasAsignadasGrupo,
                    sis_docente_asignado: sis_docente_asignado,
                    sis_auxiliar_asignado: sis_auxiliar_asignado
                };
                $.post("../controlador/interprete.php",datosGrupo,function(resp){
                    if(resp == 1){
                        $("#btnCancelarNuevoGrupo").click();
                        listarTablaGruposDepartamento.ajax.reload(null, false);   
                    }else{
                        $("#error").removeClass("d-none");
                    }
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Esta registrando dos horarios identicos!',
                    footer: 'Verifique que los horarios sean unicos'
                });
            }
        }else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El numero de grupo ya esta registrado!',
                footer: 'Use otro numero para tener exito'
            });
        }                                                             
    });

    //InformacionGrupo
    $(document).on("click", ".btnInfoGrupo", function(){   
        let fila = $(this).closest("tr");           
        sis_materia = fila.find('td:eq(0)').text();
        nom_materia = fila.find('td:eq(1)').text();
        num_grupo = fila.find('td:eq(2)').text();
        sis_docente_asignado = fila.find('td:eq(3)').text();
        nombre_docente_asignado = fila.find('td:eq(4)').text();
        remplazarContenidoInput('infoSisNomMat',sis_materia+"  "+nom_materia);
        remplazarContenidoInput('infoNumeroGrupo', num_grupo);
        remplazarContenidoInput('infoDocenteAsignado', sis_docente_asignado+" "+nombre_docente_asignado);
        cargarAuxiliarAsignado('infoAuxiliarAsignado', sis_materia, num_grupo);
        cargarCarrerasAsignadas('divInfoCarrerasAsignadas', sis_materia, num_grupo);
        cargarHorariosGrupo('divInfoHorariosGrupo', sis_materia, num_grupo);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalInformacionGrupo').modal('show');         
    });

    //EditarGrupo
    $(document).on("click", ".btnEditarGrupo", function(){   
        let fila = $(this).closest("tr");           
        sis_materia = fila.find('td:eq(0)').text();
        nom_materia = fila.find('td:eq(1)').text();
        num_grupo = fila.find('td:eq(2)').text();
        docente_asignado = fila.find('td:eq(4)').text();
        remplazarContenidoInput('infoSisNomMatEdit',sis_materia+"  "+nom_materia);
        remplazarContenidoInput('infoNumeroGrupoEdit', num_grupo);
        cargarElemSelectInstructoresAsignados('selectDocenteAsignadoEdit', sis_materia, num_grupo, 'MateriaDocente', 'obtenerDocentesAsignadosMateriaDocenteAsignadoGrupo','sis_docente','nombre_docente');
        cargarElemSelectInstructoresAsignados('selectAuxiliarAsignadoEdit', sis_materia, num_grupo, 'MateriaAuxiliarDocente', 'obtenerAuxiliaresAsignadosMateriaAuxiliarAsignadoGrupo','sis_auxiliar','nombre_aux_docente');
        cargarCarrerasGrupoMateria('divInfoCarrerasAsignadasEdit', sis_materia, num_grupo);
        cargarHorariosGrupoEdit('divInfoHorariosGrupoEdit', sis_materia, num_grupo);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalEditarGrupo').modal('show');         
    });

    //RegistrarCambiosGrupo
    $('#formEditarGrupo').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página         
        let sis_materia = $.trim($('#infoSisNomMatEdit').val());
        sis_materia = (sis_materia.split(" "))[0];
        let num_grupo = $.trim($('#infoNumeroGrupoEdit').val());
        let arrayHorariosGrupo = obtenerHorariosGrupo('divInfoHorariosGrupoEdit',"selectDiasEdit_","horarioGrupoEdit_","selectAsignacionHorarioGrupoEdit_");
        if(esValidoHorarioGrupo(arrayHorariosGrupo)){
            let sis_docente = $("#selectDocenteAsignadoEdit option:selected").val();
            let sis_auxiliar = $("#selectAuxiliarAsignadoEdit option:selected").val();
            let arrayCarrerasAsignadasGrupo = obtenerCarrerasAsignadasGrupo('checkBoxCarrerasAsignadasGrupo');
            let datosGrupo = {
                clase: "Grupo",
                metodo: "insertarCambiosGrupo",
                sis_mat: sis_materia,
                nom_grupo: num_grupo,
                horarios: arrayHorariosGrupo,
                carrerasAsignadas: arrayCarrerasAsignadasGrupo,
                sis_docente: sis_docente,
                sis_auxiliar: sis_auxiliar
            };
            $.post("../controlador/interprete.php",datosGrupo,function(resp){
                if(resp == 1){
                    $("#btnCancelarGrupoEdit").click();
                    listarTablaGruposDepartamento.ajax.reload(null, false);   
                }else{
                    $("#error").removeClass("d-none");
                }
            });
        }else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Esta registrando dos horarios identicos!',
                footer: 'Verifique que los horarios sean unicos'
            });
        }
    });

    //AgregarSiguienteFilaHorarioGrupoEdit
    $(document).on("click", "#btnAgregarHorarioGrpEdit", function(e){   
       agregarFilaHorarioGrp('divInfoHorariosGrupoEdit',"selectDiasEdit_","horarioGrupoEdit_","selectAsignacionHorarioGrupoEdit_");        
    });

    //QuitarAnteriorFilaHorarioGrupoEdit
    $(document).on("click", "#btnQuitarHorarioGrpEdit", function(e){   
        quitarFilaHorarioGrp('divInfoHorariosGrupoEdit', e);      
    });

    //EliminarGrupo
    $(document).on("click", ".btnEliminarGrupo", function(){
        let fila = $(this);               
        sis_materia = $(this).closest('tr').find('td:eq(0)').text(); 
        nom_materia = $(this).closest('tr').find('td:eq(1)').text();    
        nom_grupo = $(this).closest('tr').find('td:eq(2)').text(); 
        Swal.fire({
            title: '¿Desea eliminar el grupo perteneciente a la materia: '+nom_materia+', con numero de grupo: '+nom_grupo+'?',
            text: "¡Se borraran definitivamente los datos que lo relacionen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                clase = 'Grupo';
                metodo = 'eliminarGrupo';            
                $.ajax({
                    url: "../controlador/interprete.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {clase:clase, metodo:metodo, sis_mat:sis_materia, nom_grupo:nom_grupo},    
                    success: function() {
                        listarTablaGruposDepartamento.row(fila.parents('tr')).remove().draw();           
                    }
                }); 
                Swal.fire(
                '¡Eliminado!',
                'El grupo ha sido eliminado.',
                'success'
                )
            }
        });             
        
    });

});

////////////////////////Funciones///////////////////////////////////////
function procesarArchivoCSV(evento, nombreClase, nombreMetodo){
    let archivos = evento.target.files;
    let archivo = archivos[0];
    let lector = new FileReader();
    lector.addEventListener("load", function(e){
        parseData(e.target.result, nombreClase, nombreMetodo);
    });
    lector.readAsBinaryString(archivo);
}

//Para cada linea del archivo
//Almacenamos en un arreglo, cada uno de los datos separados por comas
//Luego ese arreglo es almacenado dentro del arreglo csvData 
//Una vez que se terminado
//Se manda el arreglo csvData para cargar la informacion a la base de datos
function parseData(data, nombreClase, nombreMetodo){
    let csvData = [];
    let lbreak = data.split(/\r?\n|\r/);
    lbreak.forEach(res => {
        csvData.push(res.split(";"));
    });
    enviarCSVData(csvData, nombreClase, nombreMetodo);
}

//Mediante ajax mandamos el arreglo y los datos necesarios
//Una vez que termine, se volvera a cargar la tabla de docentes
function enviarCSVData(csvData, nombreClase, nombreMetodo){
    let id_departamento = $("#idCategoria").val();
    $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:nombreClase, metodo:nombreMetodo, id_departamento:id_departamento, csvData:csvData},    
            success: function(response) {
                if(nombreClase == 'Materia'){
                    listarTablaMateriasDepartamento.ajax.reload(null,false);
                }else {
                    listarTablaGruposDepartamento.ajax.reload(null, false);
                }
            }
    }); 
}

function cargarMateriasDepartamento(idElemSelect, id_departamento){
    let elemSelect = document.getElementById(idElemSelect);
    borrarContenidoPrevio(elemSelect);
    let datos = {
        clase: "Materia",
        metodo: "obtenerMateriasDepartamento",
        id_departamento: id_departamento
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let option = document.createElement("option");
            option.value = 'Ninguno';
            option.innerHTML = '--Ninguno--';
            elemSelect.appendChild(option);
            obj.forEach(element => {
                    option = document.createElement("option");
                    option.value = element.codigo_materia;
                    option.innerHTML = element.codigo_materia+" "+element.nombre_materia;
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

function cargarGruposMateria(idElemDiv, sis_materia){
    let elemDiv = document.getElementById(idElemDiv);
    if(sis_materia == 'Ninguno'){
        borrarContenidoPrevio(elemDiv);
        mostrarCabeceraGruposRegistrados(false, elemDiv);
    }else{
        let datos = {
        clase: "Grupo",
        metodo: "obtenerGruposMateria",
        codigo_materia: sis_materia
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                borrarContenidoPrevio(elemDiv);
                let obj= JSON.parse(response);
                let existenGrupos = false;
                obj.forEach(element => {
                    if(!existenGrupos){
                        existenGrupos = true;
                        mostrarCabeceraGruposRegistrados(existenGrupos, elemDiv);
                    }
                    let label = document.createElement("label");
                    label.className = "nombresGruposRegistrados";
                    label.innerHTML = element.nombre_grupo;
                    elemDiv.appendChild(label);
                    let br = document.createElement("br");
                    elemDiv.appendChild(br);
                });
                if(!existenGrupos){
                    mostrarCabeceraGruposRegistrados(existenGrupos, elemDiv);
                }
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
        });
    }
}

function mostrarCabeceraGruposRegistrados(existenGrupos, elemDiv){
    let h5 = document.createElement("h5");
    if(existenGrupos){
        h5.innerHTML = "Estos son los grupos registrados: ";
    }else{
        h5.innerHTML = "No existen grupos registrados";
    }
    elemDiv.appendChild(h5);
}

function limpiarInputNombreGrupo(idElemInput){
    let elemInput = document.getElementById(idElemInput);
    elemInput.value = ""; 
}

function limpiarCabeceraGrupos(idElemDiv){
    let elemDiv = document.getElementById(idElemDiv);
    borrarContenidoPrevio(elemDiv);
    mostrarCabeceraGruposRegistrados(false, elemDiv);
}

function cambiarEstadoElementoBloqueado(idElemInput, estadoBloqueado){
    let inputNomGrupo = document.getElementById(idElemInput);
    inputNomGrupo.disabled = estadoBloqueado;
}

function cambiarEstadosCamposHorarios(className, estadoBloqueado){
    let camposHorarios = document.getElementsByClassName(className);
    let totalElementos = camposHorarios.length;
    for(let i=0; i<totalElementos; i++){
        let elem = camposHorarios[i];
        elem.disabled = estadoBloqueado;
    }
}

function agregarFilaHorarioGrp(idElemDiv, idSelectDias, idInputHorario, idSelectDocenteAuxiliar){
    let elemDiv = document.getElementById(idElemDiv);
    let numeroFila = elemDiv.childElementCount;
    numeroFila += 1;

    let divRow = document.createElement("div");
    divRow.className = "row";
    divRow.id = "horario_"+numeroFila;

    let divCampo1 = document.createElement("div");
    divCampo1.className = "form-group col-md-4";
    let labelCampo1 = document.createElement("label");
    labelCampo1.innerHTML = "Seleccione dia:";
    divCampo1.appendChild(labelCampo1);
    let selectCampo1 = document.createElement("select");
    selectCampo1.className = "form-control horarioGrp";
    selectCampo1.id = idSelectDias+numeroFila;
    let option = document.createElement("option");
    option.value = "LU";
    option.innerHTML = "LUNES";
    selectCampo1.appendChild(option);
    option = document.createElement("option");
    option.value = "MA";
    option.innerHTML = "MARTES";
    selectCampo1.appendChild(option);
    option = document.createElement("option");
    option.value = "MI";
    option.innerHTML = "MIERCOLES";
    selectCampo1.appendChild(option);
    option = document.createElement("option");
    option.value = "JU";
    option.innerHTML = "JUEVES";
    selectCampo1.appendChild(option);
    option = document.createElement("option");
    option.value = "VI";
    option.innerHTML = "VIERNES";
    selectCampo1.appendChild(option);
    option = document.createElement("option");
    option.value = "SA";
    option.innerHTML = "SABADO";
    selectCampo1.appendChild(option);
    divCampo1.appendChild(selectCampo1);

    divRow.appendChild(divCampo1);

    let divCamp2 = document.createElement("div");
    divCamp2.className = "form-group col-md-4";
    let labelCampo2 = document.createElement("label");
    labelCampo2.innerHTML = "Ingrese horario:"
    divCamp2.appendChild(labelCampo2);
    let inputCampo2 = document.createElement("input");
    inputCampo2.setAttribute("type", "text");
    inputCampo2.id = idInputHorario+numeroFila;
    inputCampo2.className = "form-control horarioGrp";
    inputCampo2.placeholder = "Ej: 815-945";
    inputCampo2.required = true;
    divCamp2.appendChild(inputCampo2);
    let divInvalid = document.createElement("div");
    divInvalid.className = "invalid-feedback";
    divInvalid.innerHTML = "llene el campo";
    divCamp2.appendChild(divInvalid);

    divRow.appendChild(divCamp2);

    let divCampo3 = document.createElement("div");
    divCampo3.className = "form-group col-md-4";
    let labelCampo3 = document.createElement("label");
    labelCampo3.innerHTML = "Asignar a:";
    divCampo3.appendChild(labelCampo3);
    let selectCampo3 = document.createElement("select");
    selectCampo3.className = "form-control horarioGrp";
    selectCampo3.id = idSelectDocenteAuxiliar+numeroFila;
    let option2 = document.createElement("option");
    option2.value = "f";
    option2.innerHTML = "DOCENTE";
    selectCampo3.appendChild(option2);
    option2 = document.createElement("option");
    option2.value = "t";
    option2.innerHTML = "AUXILIAR";
    selectCampo3.appendChild(option2);
    divCampo3.appendChild(selectCampo3);

    divRow.appendChild(divCampo3);

    elemDiv.appendChild(divRow);
}

function quitarCamposHorariosTemporales(idElemDiv){
    let elemDiv = document.getElementById(idElemDiv);
    borrarContenidoPrevio(elemDiv);
    agregarFilaHorarioGrp(idElemDiv,"selectDias_","horarioGrupo_","selectAsignacionHorarioGrupo_");
}

function quitarFilaHorarioGrp(idElemDiv, e){
    let elemDiv = document.getElementById(idElemDiv);
    if(elemDiv.childElementCount > 1){
        elemDiv.removeChild(elemDiv.lastChild);
    }
    e.preventDefault();
}

function esValidoNombreGrupo(nomGrupo){
    let esValido = true;
    if(nomGrupo != ''){
        let elemLabels = document.getElementsByClassName("nombresGruposRegistrados");
        let numeroElementos = elemLabels.length;
        for(let i=0; i<numeroElementos && esValido; i++){
            let nomGrp = elemLabels[i].textContent;
            if(nomGrp == nomGrupo){
                esValido = false;
            }
        }
    }else {
        esValido = false;
    }
    return esValido;
}

function obtenerHorariosGrupo(idElemDiv, idSelectDias, idInputHorario, idSelectDocenteAuxiliar){
    let arrayHorarios = [];
    let elemDiv = document.getElementById(idElemDiv);
    let numeroFilas = elemDiv.childElementCount;
    for(let i=1; i<=numeroFilas; i++){
        let horario = [];
        let elem = document.getElementById(idSelectDias+i);
        horario.push(elem.value);
        elem = document.getElementById(idInputHorario+i);
        horario.push(elem.value);
        elem = document.getElementById(idSelectDocenteAuxiliar+i);
        horario.push(elem.value);
        arrayHorarios.push(horario);
    }
    return arrayHorarios;
}

function esValidoHorarioGrupo(arrayHorariosGrupo){
    let esValido = true;
    let numeroFilas = arrayHorariosGrupo.length;
    if(numeroFilas > 1){
        numeroFilas--;
        for(let i=0; i<numeroFilas && esValido;i++){
            for(let j=i+1; j<=numeroFilas && esValido;j++){
                let fila1 = arrayHorariosGrupo[i];
                let fila2 = arrayHorariosGrupo[j];
                if(fila1[0]==fila2[0] && fila1[1]==fila2[1]){
                    esValido = false;
                }
            }
        }
    }
    return esValido;
}

function remplazarContenidoInput(idElemInput, contenido){
    let elemInput = document.getElementById(idElemInput);
    elemInput.value = contenido;
}

function cargarCarrerasAsignadas(idElemDiv, sis_materia, nombre_grupo){
    let elemDiv = document.getElementById(idElemDiv);
    limpiarcheckboxModals();
    let datos = {
        clase: "GrupoCarrera",
        metodo: "obtenerNombresCarrerasGrupo",
        codigo_materia: sis_materia,
        nom_grupo: nombre_grupo
    }
    $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                let obj= JSON.parse(response);
                let carreraAsignada = false;
                obj.forEach(element => {
                    let input = document.createElement("input");
                    input.setAttribute("type", "text");
                    input.className = "form-control";
                    input.required = true;
                    input.disabled = true;
                    input.value = element.nombre_carrera;
                    elemDiv.appendChild(input);
                    let br = document.createElement("br");
                    elemDiv.appendChild(br);
                    if(!carreraAsignada){
                        carreraAsignada = true;
                    }
                });
                if(!carreraAsignada){
                    let input2 = document.createElement("input");
                    input2.setAttribute("type", "text");
                    input2.className = "form-control";
                    input2.required = true;
                    input2.disabled = true;
                    input2.value = "No se registro ninguna asignacion";
                    elemDiv.appendChild(input2);
                }else {
                    elemDiv.removeChild(elemDiv.lastChild);
                }
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
    });
}

function cargarHorariosGrupo(idElemDiv, sis_materia, nombre_grupo){
    let elemDiv = document.getElementById(idElemDiv);
    borrarContenidoPrevio(elemDiv);
    let datos = {
        clase: "GrupoHorario",
        metodo: "obtenerHorariosGrupo",
        codigo_materia: sis_materia,
        nom_grupo: nombre_grupo
    }
    $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                let obj= JSON.parse(response);
                obj.forEach(element => {
                    let divRow = document.createElement("div");
                    divRow.className = "row";
                    let div1 = document.createElement("div");
                    div1.className = "form-group col-md-4";
                    let label1 = document.createElement("label");
                    label1.innerHTML = "Dia:";
                    div1.appendChild(label1);
                    let input1 = document.createElement("input");
                    input1.setAttribute("type", "text");
                    input1.className = "form-control";
                    input1.disabled = true;
                    let dia = element.dia;
                    switch(dia){
                        case 'LU':
                            dia = 'LUNES';
                        break;
                        case 'MA':
                            dia = 'MARTES';
                        break;
                        case 'MI':
                            dia = 'MIERCOLES';
                        break;
                        case 'JU':
                            dia = 'JUEVES';
                        break;
                        case 'VI':
                            dia = 'VIERNES';
                        break;
                        case 'SA':
                            dia = 'SABADO';
                        break; 
                    }
                    input1.value = dia;
                    div1.appendChild(input1);
                    divRow.appendChild(div1);
                    
                    let div2 = document.createElement("div");
                    div2.className = "form-group col-md-4";
                    let label2 = document.createElement("label");
                    label2.innerHTML = "Hora:";
                    div2.appendChild(label2);
                    let input2 = document.createElement("input");
                    input2.setAttribute("type", "text");
                    input2.className = "form-control";
                    input2.disabled = true;
                    input2.value = element.hora;
                    div2.appendChild(input2);
                    divRow.appendChild(div2);

                    let div3 = document.createElement("div");
                    div3.className = "form-group col-md-4";
                    let label3 = document.createElement("label");
                    label3.innerHTML = "Asignado a:";
                    div3.appendChild(label3);
                    let input3 = document.createElement("input");
                    input3.setAttribute("type", "text");
                    input3.className = "form-control";
                    input3.disabled = true;
                    if(element.es_aux){
                       input3.value = "Auxiliar";
                    }else{
                        input3.value = "Docente";
                    }
                    div3.appendChild(input3);
                    divRow.appendChild(div3);
                    elemDiv.appendChild(divRow);
                });
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
    });
}

function cargarCarrerasAsignadasMateria(idElemDiv, sis_materia){
    let elemDiv = document.getElementById(idElemDiv);
    if(sis_materia == 'Ninguno'){
        limpiarcheckboxModals();
        mostrarCabeceraCarrerasRegistradas(false, elemDiv);
    }else{
        let datos = {
        clase: "MateriaCarrera",
        metodo: "obtenerCarrerasMateria",
        codigo_materia: sis_materia
        }
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                limpiarcheckboxModals();
                let obj= JSON.parse(response);
                let existenCarreras = false;
                let numCheckBox = 1;
                obj.forEach(element => {
                    if(!existenCarreras){
                        existenCarreras = true;
                        mostrarCabeceraCarrerasRegistradas(existenCarreras, elemDiv);
                    }
                    let div = document.createElement("div");
                    div.className = "custom-control custom-checkbox";

                    let input = document.createElement("input");
                    input.setAttribute("type", "checkbox");
                    input.className = "custom-control-input checkBoxCarrerasAsignadasGrupo";
                    input.id = "checkbox_"+numCheckBox;
                    input.checked = true;
                    input.value = element.id_carrera;
                    div.appendChild(input);

                    let label = document.createElement("label");
                    label.className = "custom-control-label";
                    label.htmlFor = "checkbox_"+numCheckBox;
                    label.innerHTML = element.nombre_carrera;
                    div.appendChild(label);

                    numCheckBox += 1;

                    elemDiv.appendChild(div);

                });
                if(!existenCarreras){
                    mostrarCabeceraCarrerasRegistradas(existenCarreras, elemDiv);
                }
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
        });
    }
}

function mostrarCabeceraCarrerasRegistradas(existenCarreras, elemDiv){
    let h5 = document.createElement("h5");
    if(existenCarreras){
        h5.innerHTML = "Seleccione las carreras asignadas al grupo: ";
    }else{
        h5.innerHTML = "No existen carreras asignadas";
    }
    elemDiv.appendChild(h5);
}

function limpiarCabeceraCarreras(idElemDiv){
    let elemDiv = document.getElementById(idElemDiv);
    borrarContenidoPrevio(elemDiv);
    mostrarCabeceraCarrerasRegistradas(false, elemDiv);
}

function obtenerCarrerasAsignadasGrupo(classNameInput){
    let idCarrerasSeleccionadas = [];
    let inputs = document.getElementsByClassName(classNameInput);
    let len = inputs.length;
    for(let i=0; i<len; i++){
        let input = inputs[i];
        if(input.checked == true){
            idCarrerasSeleccionadas.push(input.value);
        }
    }
    return idCarrerasSeleccionadas;
}

function cargarCarrerasGrupoMateria(idElemDiv, sis_materia, nombre_grupo){
    let elemDiv = document.getElementById(idElemDiv);
    limpiarcheckboxModals();
    let datos = {
        clase: "GrupoCarrera",
        metodo: "obtenerCarrerasGrupoMateria",
        codigo_materia: sis_materia,
        nom_grupo: nombre_grupo
    }
    $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                let obj= JSON.parse(response);
                let existenCarreras = false;
                let numCheckBox = 1;
                obj.forEach(element => {
                    if(!existenCarreras){
                        existenCarreras = true;
                        mostrarCabeceraCarrerasRegistradas(existenCarreras, elemDiv);
                    }
                    let div = document.createElement("div");
                    div.className = "custom-control custom-checkbox";

                    let input = document.createElement("input");
                    input.setAttribute("type", "checkbox");
                    input.className = "custom-control-input checkBoxCarrerasAsignadasGrupo";
                    input.id = "checkbox_"+numCheckBox;
                    if(element.exists){
                        input.checked = true;
                    }
                    input.value = element.id_carrera;
                    div.appendChild(input);

                    let label = document.createElement("label");
                    label.className = "custom-control-label";
                    label.htmlFor = "checkbox_"+numCheckBox;
                    label.innerHTML = element.nombre_carrera;
                    div.appendChild(label);

                    numCheckBox += 1;

                    elemDiv.appendChild(div);

                });
                if(!existenCarreras){
                    mostrarCabeceraCarrerasRegistradas(existenCarreras, elemDiv);
                }
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
    });
}

function cargarHorariosGrupoEdit(idElemDiv, sis_materia, nombre_grupo){
    let elemDiv = document.getElementById(idElemDiv);
    borrarContenidoPrevio(elemDiv);
    let datos = {
        clase: "GrupoHorario",
        metodo: "obtenerHorariosGrupo",
        codigo_materia: sis_materia,
        nom_grupo: nombre_grupo
    }
    $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                let obj= JSON.parse(response);
                let numeroFila = 1;
                obj.forEach(element => {
                    agregarFilaHorarioGrp(idElemDiv,"selectDiasEdit_","horarioGrupoEdit_","selectAsignacionHorarioGrupoEdit_");
                    establecerDiaSeleccionado(numeroFila, element.dia);
                    establecerHorarioAsignado(numeroFila, element.hora);
                    establecerAsignacionDocenteAuxiliar(numeroFila, element.es_aux);
                    numeroFila += 1;
                });
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
    });
}

function establecerDiaSeleccionado(numeroFila, diaSeleccionado){
    let elemSelect = document.getElementById("selectDiasEdit_"+numeroFila);
    let options = elemSelect.childNodes;
    switch(diaSeleccionado){
        case 'LU':
            options[0].selected = true;
        break;
        case 'MA':
            options[1].selected = true;
        break;
        case 'MI':
            options[2].selected = true;
        break;
        case 'JU':
            options[3].selected = true;
        break;
        case 'VI':
            options[4].selected = true;
        break;
        case 'SA':
            options[5].selected = true;
        break; 
    }
}

function establecerHorarioAsignado(numeroFila, horarioAsignado){
    let elemInput = document.getElementById("horarioGrupoEdit_"+numeroFila);
    elemInput.value = horarioAsignado;
}

function establecerAsignacionDocenteAuxiliar(numeroFila, esAsignadoAuxiliar){
    let elemSelect = document.getElementById("selectAsignacionHorarioGrupoEdit_"+numeroFila);
    let options = elemSelect.childNodes;
    if(esAsignadoAuxiliar){
        options[1].selected = true;
    }else{
        options[0].selected = true;
    }
}

function limpiarcheckboxModals(){
    let elemDiv = document.getElementById("divCarrerasAsignadasMateria"); 
    borrarContenidoPrevio(elemDiv);
    elemDiv = document.getElementById("divInfoCarrerasAsignadas");
    borrarContenidoPrevio(elemDiv);
    elemDiv = document.getElementById("divInfoCarrerasAsignadasEdit");
    borrarContenidoPrevio(elemDiv);
}

function cargarDocentesAsignadosMateria(sis_materia, idElemSelect){
    let elemSelect = document.getElementById(idElemSelect);
    borrarContenidoPrevio(elemSelect);
    let datos = {
        clase: "MateriaDocente",
        metodo: "obtenerDocentesAsignados",
        sis_materia: sis_materia
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let option = document.createElement("option");
            option.value = 'Ninguno';
            option.innerHTML = 'Sin Asignar';
            elemSelect.appendChild(option);
            obj.forEach(element => {
                    option = document.createElement("option");
                    option.value = element.sis_docente;
                    option.innerHTML = element.sis_docente+" "+element.nombre_docente;
                    elemSelect.appendChild(option);
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function cargarAuxiliaresAsignadosMateria(sis_materia, idElemSelect){
    let elemSelect = document.getElementById(idElemSelect);
    borrarContenidoPrevio(elemSelect);
    let datos = {
        clase: "MateriaAuxiliarDocente",
        metodo: "obtenerAuxiliaresAsignados",
        sis_materia: sis_materia
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let option = document.createElement("option");
            option.value = 'Ninguno';
            option.innerHTML = 'Sin Asignar';
            elemSelect.appendChild(option);
            obj.forEach(element => {
                    option = document.createElement("option");
                    option.value = element.sis_auxiliar;
                    option.innerHTML = element.sis_auxiliar+" "+element.nombre_aux_docente;
                    elemSelect.appendChild(option);
            });
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}

function cargarAuxiliarAsignado(idElemInput, sis_materia, nombre_grupo){
    let elemInput = document.getElementById(idElemInput);
    let datos = {
        clase: "AuxiliarDocenteGrupo",
        metodo: "obtenerAuxiliarAsignado",
        codigo_materia: sis_materia,
        nom_grupo: nombre_grupo
    }
    $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                let obj= JSON.parse(response);
                obj.forEach(element => {
                   elemInput.value = element.sis_auxiliar+" "+element.nombre_aux_docente; 
                });
            },
            error : function(jqXHR, status, error) {
                console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
            }
    });
}

function limpiarSelectDocenteAuxiliarAsignado(){
    let elemSelect = document.getElementById('selectDocenteAsignado');
    borrarContenidoPrevio(elemSelect);
    elemSelect = document.getElementById('selectAuxiliarAsignado');
    borrarContenidoPrevio(elemSelect);
}

function cargarElemSelectInstructoresAsignados(idElemSelect, sis_materia, nom_grupo, nom_clase, nom_metodo, nom_campo_sis, nom_campo_inst){
    let elemSelect = document.getElementById(idElemSelect);
    borrarContenidoPrevio(elemSelect);
    let datos = {
        clase: nom_clase,
        metodo: nom_metodo,
        sis_materia: sis_materia,
        nom_grupo: nom_grupo
    }
    $.ajax({
        type: "POST",
        url: "../controlador/interprete.php",
        data: datos,
        success: function (response) {
            let obj= JSON.parse(response);
            let existeInstructorAsignado = false;
            let option;
            obj.forEach(element => {
                option = document.createElement("option");
                option.value = element[nom_campo_sis];
                option.innerHTML = element[nom_campo_sis]+" "+element[nom_campo_inst];
                if(element.exists){
                    existeInstructorAsignado = true;
                    option.selected = true;
                }
                elemSelect.appendChild(option);
            });
            option = document.createElement("option");
            option.value = 'Ninguno';
            option.innerHTML = 'Sin Asignar';
            if(!existeInstructorAsignado){
                option.selected = true;
            }
            elemSelect.appendChild(option);
        },
        error : function(jqXHR, status, error) {
            console.log("status: "+status+" JqXHR "+jqXHR +" Error "+error);
        }
    });
}