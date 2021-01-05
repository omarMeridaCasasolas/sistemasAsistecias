$(document).ready(function() {

	let id_departamento = $("#idCategoria").val();

    //ListarAuxiliarDocenteDepartamento
    listarTablaAuxiliarDocenteDepartamento = $("#tablaAuxiliarDocenteDep").DataTable({
        "ajax":{
            "method":"POST",
            "url":"../controlador/interprete.php",
            "data" : {'clase': 'DepartamentoAuxiliarDocente' , 'metodo':'listarAuxiliaresDocenciaDepartamento', 'id_departamento':id_departamento}
        },
        "columns":[
            {"data":"sis_auxiliar"},
            {"data":"nombre_aux_docente"},
            {"data":"correo_aux_docente"},
            {"data":"telefono_aux_docente"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditarAuxiliarDocente'><i class='fas fa-user-edit'></i></button><button class='btn btn-danger btn-sm btnEliminarAuxiliarDocente'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

    //ImportarAuxilarDocente
    $(document).on("change", "#inputFileAuxiliarDocente", function(e){ 
        //(eventoCapturado,nombreClase,nombreMetodo)  
        procesarArchivoCSV(e, 'AuxiliarDocente', 'importarAuxiliarDocente');
    });

    //CrearAuxiliarDocente mostramos el modalCrearAuxiliarDocente
    $(document).on("click", "#btnCrearAuxiliarDocente", function(){   
        
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalCrearAuxiliarDocente').modal('show');         
    });

    //Una vez que presione crear docente
    //recuperamos y mandamos los datos del modalCrearDocente
    $("#formInsertarAuxiliarDocente").submit(function (e) { 
        let datosDocente = {
        clase: "AuxiliarDocente",
        metodo: "insertarAuxiliarDocente_acoplado",
        nomAuxiliarDocente: $("#nomAuxiliarDocente").val(),
        ciAuxiliarDocente: $("#ciAuxiliarDocente").val(),
        correoAuxiliarDocente: $("#correoAuxiliarDocente").val(),
        telAuxiliarDocente: $("#telAuxiliarDocente").val(),
        sisAuxiliarDocente: $("#sisAuxiliarDocente").val(),
        passAuxiliarDocente: $("#passAuxiliarDocente").val(),
        id_departamento: $("#idCategoria").val()
        //Aqui se coloca el id que identifica a a la autoridad-Ambiente
        };
        $.post("../controlador/interprete.php",datosDocente,function(resp){
            if(resp == 1){
                $("#btnVentanaAuxiliarDocente").click();
                $("#formInsertarAuxiliarDocente")[0].reset();
                $("#exitoDocente").removeClass("d-none");
                listarTablaAuxiliarDocenteDepartamento.ajax.reload(null, false);
            }else{
                $("#errorDocente").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    //EditarAuxiliarDocente
    //Recuperar datos de la fila y mostrar en el modalEditarAuxiliarDocente
    $(document).on("click", ".btnEditarAuxiliarDocente", function(){               
        fila = $(this).closest("tr");  
        sis_auxiliar_docente = fila.find('td:eq(0)').text();                 
        nomAuxiliarDocente = fila.find('td:eq(1)').text();
        correoAuxiliarDocente = fila.find('td:eq(2)').text();
        telAuxiliarDocente = fila.find('td:eq(3)').text();
        $("#nomAuxiliarDocenteEdit").attr("name", sis_auxiliar_docente);
        $("#nomAuxiliarDocenteEdit").val(nomAuxiliarDocente);
        $("#correoAuxiliarDocenteEdit").val(correoAuxiliarDocente);
        $("#telAuxiliarDocenteEdit").val(telAuxiliarDocente);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );     
        $('#modalEditarAuxiliarDocente').modal('show');         
    });

    //Recuperamos los datos del modalEditarAuxiliarDocente
    //Mandamos a actualizar los datos del auxiliar docente
    $('#formEditarAuxiliarDocente').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        sisAuxiliarDocente = $("#nomAuxiliarDocenteEdit").attr("name");
        nomAuxiliarDocente = $.trim($("#nomAuxiliarDocenteEdit").val());
        correoAuxiliarDocente = $.trim($("#correoAuxiliarDocenteEdit").val());
        telAuxiliarDocente = $.trim($("#telAuxiliarDocenteEdit").val());   
        clase = 'AuxiliarDocente';
        metodo = 'editarAuxiliarDocente';                       
            $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:clase, metodo:metodo, sisAuxiliarDocente:sisAuxiliarDocente, nomAuxiliarDocente:nomAuxiliarDocente, correoAuxiliarDocente:correoAuxiliarDocente,telAuxiliarDocente:telAuxiliarDocente},    
            success: function(data) {
             listarTablaAuxiliarDocenteDepartamento.ajax.reload(null, false);
            }
            });                 
        $('#modalEditarAuxiliarDocente').modal('hide');                                                          
    });

    //EliminarAuxiliarDocente
    $(document).on("click", ".btnEliminarAuxiliarDocente", function(){
        let fila = $(this);               
        sis_auxiliar_docente = $(this).closest('tr').find('td:eq(0)').text();
        nom_auxiliar_docente = $(this).closest('tr').find('td:eq(1)').text(); 
        id_departamento = $("#idCategoria").val();
        Swal.fire({
            title: '¿Desea eliminar al auxiliar: '+sis_auxiliar_docente+' '+nom_auxiliar_docente+'?',
            text: "¡Se borraran definitivamente los datos que lo relacionen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                clase = 'AuxiliarDocente';
                metodo = 'eliminarAuxiliarDocente';            
                $.ajax({
                    url: "../controlador/interprete.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {clase:clase, metodo:metodo, sis_auxiliar_docente:sis_auxiliar_docente, id_departamento:id_departamento},    
                    success: function() {
                        listarTablaAuxiliarDocenteDepartamento.row(fila.parents('tr')).remove().draw();           
                    }
                }); 
                Swal.fire(
                '¡Eliminado!',
                'El auxiliar docente ha sido eliminado.',
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
                if(nombreClase == 'Docente'){
                    listarTablaDocentesDepartamento.ajax.reload(null, false);
                }else {
                    listarTablaAuxiliarDocenteDepartamento.ajax.reload(null, false);
                }
            }
    }); 
}