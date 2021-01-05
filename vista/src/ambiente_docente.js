$(document).ready(function() {

	let id_departamento = $("#idCategoria").val();
    
    //ListarDocentesDepartamento
    listarTablaDocentesDepartamento = $("#tablaDocentesDep").DataTable({
        "ajax":{
            "method":"POST",
            "url":"../controlador/interprete.php",
            "data" : {'clase': 'DepartamentoDocente' , 'metodo':'listarDocentesDepartamento', 'id_departamento':id_departamento}
        },
        "columns":[
            {"data":"sis_docente"},
            {"data":"nombre_docente"},
            {"data":"correo_docente"},
            {"data":"telefono_docente"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-primary btn-sm btnEditarDocente'><i class='fas fa-user-edit'></i></button><button class='btn btn-danger btn-sm btnEliminarDocente'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });
    
    //ImportarDocentes
    $(document).on("change", "#inputFileDocente", function(e){ 
        //(eventoCapturado,nombreClase,nombreMetodo)  
        procesarArchivoCSV(e, 'Docente', 'importarDocentes');
    });

    //CrearDocente mostramos el modalCrearDocente
    $(document).on("click", "#btnCrearDocente", function(){   
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );
        $('#modalCrearDocente').modal('show');         
    });

    //Una vez que presione crear docente
    //recuperamos y mandamos los datos del modalCrearDocente
    $("#formInsertarDocente").submit(function (e) { 
        let datosDocente = {
        clase: "Docente",
        metodo: "insertarDocente_acoplado",
        nomDocente: $("#nomDocente").val(),
        ciDocente: $("#ciDocente").val(),
        correoDocente: $("#correoDocente").val(),
        telDocente: $("#telDocente").val(),
        sisDocente: $("#sisDocente").val(),
        passDocente: $("#passDocente").val(),
        id_departamento: $("#idCategoria").val()
        //Aqui se coloca el id que identifica a a la autoridad-Ambiente
        };
        $.post("../controlador/interprete.php",datosDocente,function(resp){
            if(resp == 1){
                $("#btnVentanaDocente").click();
                $("#formInsertarDocente")[0].reset();
                $("#exitoDocente").removeClass("d-none");
                listarTablaDocentesDepartamento.ajax.reload(null, false);
            }else{
                $("#errorDocente").removeClass("d-none");
            }
        });
        e.preventDefault();
    });

    //EditarDocente
    //Recuperar datos de la fila y mostrar en el modalEditarDocente
    $(document).on("click", ".btnEditarDocente", function(){               
        fila = $(this).closest("tr");  
        sis_docente = fila.find('td:eq(0)').text();                 
        nomDocente = fila.find('td:eq(1)').text();
        correoDocente = fila.find('td:eq(2)').text();
        telDocente = fila.find('td:eq(3)').text();
        $("#nomDocenteEdit").attr("name", sis_docente);
        $("#nomDocenteEdit").val(nomDocente);
        $("#correoDocenteEdit").val(correoDocente);
        $("#telDocenteEdit").val(telDocente);
        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white" );     
        $('#modalEditarDocente').modal('show');         
    });

    //Recuperamos los datos del modalEditarDocente
    //Mandamos a actualizar los datos del docente
    $('#formEditarDocente').submit(function(e){                         
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
        sisDocente = $("#nomDocenteEdit").attr("name");
        nomDocente = $.trim($("#nomDocenteEdit").val());
        correoDocente = $.trim($("#correoDocenteEdit").val());
        telDocente = $.trim($("#telDocenteEdit").val());   
        clase = 'Docente';
        metodo = 'editarDocente';                       
            $.ajax({
            url: "../controlador/interprete.php",
            type: "POST",
            datatype:"json",    
            data:  {clase:clase, metodo:metodo, sisDocente:sisDocente, nomDocente:nomDocente, correoDocente:correoDocente,telDocente:telDocente},    
            success: function(data) {
             listarTablaDocentesDepartamento.ajax.reload(null, false);
            }
            });                 
        $('#modalEditarDocente').modal('hide');                                                          
    });

    //EliminarDocente
    $(document).on("click", ".btnEliminarDocente", function(){
        let fila = $(this);               
        sis_docente = $(this).closest('tr').find('td:eq(0)').text();
        nom_docente = $(this).closest('tr').find('td:eq(1)').text(); 
        id_departamento = $("#idCategoria").val();
        Swal.fire({
            title: '¿Desea eliminar al docente: '+sis_docente+' '+nom_docente+'?',
            text: "¡Se borraran definitivamente los datos que lo relacionen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar",
            confirmButtonText: 'Si, eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                clase = 'Docente';
                metodo = 'eliminarDocente';            
                $.ajax({
                    url: "../controlador/interprete.php",
                    type: "POST",
                    datatype:"json",    
                    data:  {clase:clase, metodo:metodo, sis_docente:sis_docente, id_departamento:id_departamento},    
                    success: function() {
                        listarTablaDocentesDepartamento.row(fila.parents('tr')).remove().draw();           
                    }
                }); 
                Swal.fire(
                '¡Eliminado!',
                'El docente ha sido eliminado.',
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
