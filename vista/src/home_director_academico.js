$(document).ready(function() {
    let categoria = $("#idCategoria").val();
    listarTableDepartamentos = $("#tableDepartamentos").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Departamento' , 'metodo':'listarDepartamentos', 'categoria':categoria},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"codigo_departamento"},
            {"data":"nombre_departamento"},
            {"data":"fecha_creacion_departamento"},
            {"data":"director_departamento"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditarDep'><i class='fas fa-user-edit'></i></button><button class='btn btn-danger btn-sm btnEliminarDep'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

    listarTableDirectorDepartamental = $("#tablaDirector").DataTable({
        "ajax":{
            "method":"POST",
            "data" : {'clase': 'Director' , 'metodo':'listarDirectoresDepartamentales', 'categoria':categoria},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"codigo_sis_director"},
            {"data":"nombre_director"},
            {"data":"director_actual"},
            {"data":"correo_electronico_director"},
            {"data":"telefono_director"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditarDirectorDep'><i class='fas fa-user-edit'></i></button><button class='btn btn-danger btn-sm btnEliminarDirectorDep'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

//CrearDepartamento
     $("#formCrearDepartamento").submit(function (e) { 
        let datosDirector = {
        clase: "Departamento",
        metodo: "insertarNuevoDepartamento",
        nomDep: $("#nomDep").val(),
        depCod: $("#depCod").val(),
        depFechaCrea: $("#depFechaCrea").val(),
        categoria: $("#idCategoria").val()

        //Aqui se coloca el id que identifica a a la autoridad-Ambiente
        };
        $.post("../controlador/interprete.php",datosDirector,function(resp){
            if(resp == 1){
                $("#btnCancelar").click();
                $("#formCrearDepartamento")[0].reset();
                //$("#exito").removeClass("d-none");
                Swal.fire("Exito","Se ha creado el departamento de "+datosDirector.nomDep,"success");
                listarTableDepartamentos.ajax.reload(null, false);
            }else{
                Swal.fire("ERROR",resp,"warning");
                //$("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    //EditarDepartamento        
    $(document).on("click", ".btnEditarDep", function(){   
        let fila = $(this).closest("tr");    
        codigo_dep = fila.find('td:eq(0)').text();       
        nombre_dep = fila.find('td:eq(1)').text();  
        fecha_creacion_departamento = fila.find('td:eq(2)').text();
        jefe_dep = fila.find('td:eq(3)').text();
        $("#formEditarNomDep").val(nombre_dep);
        $("#formEditarCodDep").val(codigo_dep);
        $("#formEditarCodDep").attr("name", codigo_dep);
        $("#formEditarFechaCreaDep").val(fecha_creacion_departamento);
        let elemSelect = document.getElementById("formEditarJefeDep");
        borrarContenidoPrevio(elemSelect);
        let option = document.createElement("option");
        option.innerHTML = 'Ninguno';
        elemSelect.appendChild(option);
        option = document.createElement("option");
        option.innerHTML = jefe_dep;
        option.selected = "true";
        elemSelect.appendChild(option);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $(".modal-title").text("Editar departamento");
        $('#modalEditarDep').modal('show');         
    });

    $('#formEditarDep').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        codigo_dep = $.trim($('#formEditarCodDep').val());
        codigo_dep_noModificado = $("#formEditarCodDep").attr("name");
        nombre_dep = $.trim($('#formEditarNomDep').val());    
        fecha_creacion_departamento = $('#formEditarFechaCreaDep').val();
        jefe_dep = $.trim($('#formEditarJefeDep').val());   
        clase = 'Departamento';
        metodo = 'editarDepartamento';                       
            $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:clase, metodo:metodo, codigo_dep:codigo_dep, codigo_dep_noModificado:codigo_dep_noModificado,nombre_dep:nombre_dep, fecha_creacion_departamento:fecha_creacion_departamento, jefe_dep:jefe_dep},    
            success: function(data) {
             listarTableDepartamentos.ajax.reload(null, false);
             listarTableDirectorDepartamental.ajax.reload(null, false);
            }
            });                 
        $('#modalEditarDep').modal('hide');                                                          
    });

    //EliminarDepartamento
    $(document).on("click", ".btnEliminarDep", function(){
        let fila = $(this);           
        codigo_dep = $(this).closest('tr').find('td:eq(0)').text();         
        Swal.fire({
            title: '¿Desea eliminar el departamento con codigo departamento: '+codigo_dep+'?',
            text: "¡Se borraran definitivamente los datos que lo relacionen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                clase = 'Departamento';
                metodo = 'eliminarDepartamento';            
                $.ajax({
                    url: "../controlador/interprete.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {clase:clase, metodo:metodo, codigo_dep:codigo_dep},    
                    success: function() {
                        listarTableDepartamentos.row(fila.parents('tr')).remove().draw();     
                        listarTableDirectorDepartamental.ajax.reload(null, false);             
                    }
                }); 
                Swal.fire(
                '¡Eliminado!',
                'El departamento ha sido eliminado.',
                'success'
                )
            }
        });             
        
    });

    //CrearJefeDepartamento
    $(document).on("click", "#btnCrearJefe", function(){   
        cargarDepartamentosDisponibles("asigDirector");
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $(".modal-title").text("Crear jefe de departamento");
        $('#myModal').modal('show');         
    });

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
                $("#btnCancelarJefe").click();
                $("#formInsertarDirector")[0].reset();
                $("#exito").removeClass("d-none");
                listarTableDepartamentos.ajax.reload(null, false);
                listarTableDirectorDepartamental.ajax.reload(null, false);    
            }else{
                $("#error").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    //EditarDirectorDepartamento        
    $(document).on("click", ".btnEditarDirectorDep", function(){   
        let fila = $(this).closest("tr");           
        codigo_sis_director = fila.find('td:eq(0)').text();
        nombre_director = fila.find('td:eq(1)').text();  
        director_actual = fila.find('td:eq(2)').text();
        correo_electronico_director = fila.find('td:eq(3)').text();
        telefono_director = fila.find('td:eq(4)').text();
        $("#formEditarNomDirDep").val(nombre_director);
        $("#formEditarCodSisDirDep").val(codigo_sis_director);
        $("#formEditarCodSisDirDep").attr("name", codigo_sis_director);
        cargarDepartamentosDisponibles("formEditarFacAsiDirDep");
        let option = document.createElement("option");
        option.innerHTML = director_actual;
        option.selected = "true";
        document.getElementById("formEditarFacAsiDirDep").appendChild(option);
        $("#formEditarTelDirDep").val(telefono_director);
        $("#formEditarCorDirDep").val(correo_electronico_director);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $(".modal-title").text("Editar director de departamento");
        $('#modalEditarDirectorDep').modal('show');         
    });

    $('#formEditarDirectorDep').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        nombre_director = $.trim($('#formEditarNomDirDep').val());
        codigo_sis_director = $.trim($('#formEditarCodSisDirDep').val());    
        director_actual = $('#formEditarFacAsiDirDep option:selected').text();
        telefono_director = $.trim($('#formEditarTelDirDep').val());
        correo_director = $.trim($('#formEditarCorDirDep').val());   
        let codigo_sis_noModificado = $("#formEditarCodSisDirDep").attr("name");
        clase = 'Director';
        metodo = 'editarDirectorDepartamento';                       
            $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:clase, metodo:metodo, nombre_director:nombre_director, codigo_sis_director:codigo_sis_director, director_actual:director_actual, telefono_director:telefono_director, correo_director:correo_director, codigo_sis_noModificado:codigo_sis_noModificado},    
            success: function(data) {
                listarTableDirectorDepartamental.ajax.reload(null, false);
                listarTableDepartamentos.ajax.reload(null, false);
            }
            });                 
        $('#modalEditarDirectorDep').modal('hide');                                                          
    });

    //EliminarDirectorDepartamento
    $(document).on("click", ".btnEliminarDirectorDep", function(){
        let fila = $(this);           
        codigo_sis_director = $(this).closest('tr').find('td:eq(0)').text();         
        Swal.fire({
            title: '¿Desea eliminar al director de departamento con codigo sis: '+codigo_sis_director+'?',
            text: "¡Se borraran definitivamente los datos que lo relacionen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                clase = 'Director';
                metodo = 'eliminarDirectorDepartamento';            
                $.ajax({
                    url: "../controlador/interprete.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {clase:clase, metodo:metodo, codigo_sis_director:codigo_sis_director},    
                    success: function() {
                        listarTableDirectorDepartamental.row(fila.parents('tr')).remove().draw(); 
                        listarTableDepartamentos.ajax.reload(null, false);                 
                    }
                }); 
                Swal.fire(
                '¡Eliminado!',
                'El director de departamento ha sido eliminado.',
                'success'
                )
            }
        });             
        
    });

    
});

function cargarDepartamentosDisponibles(idElemSelect){
    let elemSelect = document.getElementById(idElemSelect);
    borrarContenidoPrevio(elemSelect);
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
            //$('#asigDirector').children('option:not(:first)').remove();
            //console.log(response);
            let obj= JSON.parse(response);
            obj.forEach(element => {
                //$('#asigDirector').append("<option value="+element.id_departamento+">"+element.nombre_departamento+"</option>");
                let option = document.createElement("option");
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

function borrarContenidoPrevio(elemSelect){
  while (elemSelect.hasChildNodes()) {
    elemSelect.removeChild(elemSelect.firstChild);
  }
}