var tablaRector,tablaDPA,tablaUti;
$(document).ready(function () {
    actualizarTablaRector();
    actualizarTablaUTI();
    actualizarTablaDPA();
    $("#tableRector tbody").on('click','button.editarRector',function () {
        let dataEdit = tablaRector.row( $(this).parents('tr') ).data();
        $("#editRectorCod").val(dataEdit.id_ditector);
        $("#editRectorNom").val(dataEdit.nombre_director);
        $("#editRectorCi").val(dataEdit.carnet_director);
        $("#EditRectorCorreo").val(dataEdit.correo_electronico_director);
        $("#EditRectorTel").val(dataEdit.telefono_director);
    });

    $("#tableRector tbody").on('click','button.eliminarRector',function () {
        let dataEdit = tablaRector.row( $(this).parents('tr') ).data();
        $("#delRectorCod").val(dataEdit.id_ditector);
        $("#delRectorNom").html(dataEdit.nombre_director);
    });

    //Eliminar y editar UTI
    $("#tableUTI tbody").on('click','button.editarUTI',function () {
        let dataEdit = tablaUTI.row( $(this).parents('tr') ).data();
        $("#editUTICod").val(dataEdit.id_personal_laboral);
        $("#editUTINom").val(dataEdit.nombre_trabador);
        $("#editUTICi").val(dataEdit.ci_trabajador);
        $("#EditUTICorreo").val(dataEdit.correo_trabajador);
        $("#EditUTITel").val(dataEdit.tel_trabajador);
    });

    $("#tableUTI tbody").on('click','button.eliminarUTI',function () {
        let dataEdit = tablaUTI.row( $(this).parents('tr') ).data();
        $("#delUTICod").val(dataEdit.id_personal_laboral);
        $("#delUTINom").html(dataEdit.nombre_trabador);
    });
    //

    //Editar y eliminar DPA
    $("#tableDPA tbody").on('click','button.editarDPA',function () {
        let dataEdit = tablaDPA.row( $(this).parents('tr') ).data();
        $("#editDPACod").val(dataEdit.id_personal_laboral);
        $("#editDPANom").val(dataEdit.nombre_trabador);
        $("#editDPACi").val(dataEdit.ci_trabajador);
        $("#EditDPACorreo").val(dataEdit.correo_trabajador);
        $("#EditDPATel").val(dataEdit.tel_trabajador);
    });

    $("#tableDPA tbody").on('click','button.eliminarDPA',function () {
        let dataEdit = tablaDPA.row( $(this).parents('tr') ).data();
        console.log(dataEdit);
        $("#delDPACod").val(dataEdit.id_personal_laboral);
        $("#delDPANom").html(dataEdit.nombre_trabador);
    });
    //

    $("#formEditarDirector").submit(function (e) { 
        let datos = {
            clase: "Director",
            metodo: "actualizarDirectorRector",
            codigo: $("#editRectorCod").val(),
            nombre: $("#editRectorNom").val(),
            ci: $("#editRectorCi").val(),
            correo: $("#EditRectorCorreo").val(),
            tel:$("#EditRectorTel").val()
        };
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                if(response == 1){
                    Swal.fire('Exito',"Se ha editado al usuario "+$("#EditRectorCorreo").val(),'success');
                    $('#myModal4').modal('hide');
                    actualizarTablaRector();
                }else{
                    $('#myModal4').modal('hide');
                    Swal.fire('Error',response,'warning');    
                }
            }
        });
        e.preventDefault();
    });

    $("#formEliminarDirector").submit(function (e) { 
        let datos = {
            clase: "Director",
            metodo: "eliminarDirector",
            clavePrimaria: $("#delRectorCod").val()
        };
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                if(response == 1){
                    Swal.fire('Exito',"Se ha eliminado al rector al usuario "+$("#delRectorNom").html(),'success');
                    $("#delRectorNom").html("");
                    $('#myModal5').modal('hide');
                    actualizarTablaRector();
                }else{
                    $("#delRectorNom").html("");
                    $('#myModal5').modal('hide');
                    Swal.fire('Error',response,'warning');    
                }
            }
        });
        e.preventDefault();
    });

    $("#formEditarUTI").submit(function (e) { 
        let datos = {
            clase: "PersonalLaboral",
            metodo: "editarPersonalUTI",
            codigo: $("#editUTICod").val(),
            nombre: $("#editUTINom").val(),
            ci: $("#editUTICi").val(),
            correo: $("#EditUTICorreo").val(),
            tel:$("#EditUTITel").val()
        };
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                console.log(response);
                if(response == 1){
                    Swal.fire('Exito',"Se ha editado al usuario de la DPA "+$("#editUTINom").val(),'success');
                    $('#myModal0').modal('hide');
                    actualizarTablaUTI();
                }else{
                    $('#myModal0').modal('hide'); 
                    Swal.fire('Error',response,'warning');   
                }
            }
        });
        e.preventDefault();
    });

    $("#formEliminarUTI").submit(function (e) { 
        let datos = {
            clase: "PersonalLaboral",
            metodo: "eliminarPersonalUTI",
            clavePrimaria: $("#delUTICod").val()
        };
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                if(response == 1){
                    actualizarTablaUTI();
                    $('#myModal1').modal('hide'); 
                    Swal.fire('Exito',"Se ha eliminado al usuario de la UTI"+$("#delUTINom").html(),'success');
                    $("#delUTINom").html("");
                }else{
                    $('#myModal1').modal('hide'); 
                    Swal.fire('Error',response,'warning');  
                    $("#delUTINom").html("");  
                }
            }
        });
        e.preventDefault();
    });

    //Editar DPA

    $("#formEditarDPA").submit(function (e) { 
        let datos = {
            clase: "PersonalLaboral",
            metodo: "editarPersonalDPA",
            codigo: $("#editDPACod").val(),
            nombre: $("#editDPANom").val(),
            ci: $("#editDPACi").val(),
            correo: $("#EditDPACorreo").val(),
            tel:$("#EditDPATel").val()
        };
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                console.log(response);
                if(response == 1){
                    Swal.fire('Exito',"Se ha editado al usuario de la DPA "+$("#EditDPACorreo").val(),'success');
                    $('#myModal2').modal('hide');
                    actualizarTablaDPA();
                }else{
                    $('#myModal2').modal('hide'); 
                    Swal.fire('Error',response,'warning');   
                }
            }
        });
        e.preventDefault();
    });

    $("#formEliminarDPA").submit(function (e) { 
        let datos = {
            clase: "PersonalLaboral",
            metodo: "eliminarPersonalDPA",
            clavePrimaria: $("#delDPACod").val()
        };
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                if(response == 1){
                    actualizarTablaDPA();
                    $('#myModal3').modal('hide');
                    Swal.fire('Exito',"Se ha eliminado al usuario de la DPA "+$("#delDPANom").html(),'success');
                    $("#delDPANom").html("");
                }else{
                    Swal.fire('Error',response,'warning');
                    $('#myModal3').modal('hide');  
                    $("#delDPANom").html("");  
                }
            }
        });
        e.preventDefault();
    });

    //agregar Rector UTI DPA 
    $("#formAddRector").submit(function (e) { 
        let datos = {
            clase: "Director",
            metodo: "AddRector",
            nombre: $("#addRectorNom").val(),
            ci: $("#addRectorCi").val(),
            correo: $("#addRectorCorreo").val(),
            tel: $("#addRectorTel").val(),
            pass: $("#addRectorPass").val()
        };
        //console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                if(response == 1){
                    Swal.fire('Exito',"Se ha creado rector "+$("#addRectorNom").val(),'success');
                    $('#myModal9').modal('hide');
                    actualizarTablaRector();
                    $('#formAddRector')[0].reset();
                }else{
                    Swal.fire('Error',response,'warning');  
                    $('#myModal9').modal('hide'); 
                }
            }
        });
        e.preventDefault();
    });

    $("#formAddUTI").submit(function (e) { 
        let datos = {
            clase: "PersonalLaboral",
            metodo: "AddPersonalUTI",
            nombre: $("#addUTINom").val(),
            ci: $("#addUTICi").val(),
            correo: $("#addUTICorreo").val(),
            tel: $("#addUTITel").val(),
            pass: $("#addUTIPass").val()
        };
        console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                if(response == 1){
                    Swal.fire('Exito',"Se ha creado rpersona UTI "+$("#addUTINom").val(),'success');
                    $('#myModal7').modal('hide');
                    actualizarTablaUTI();
                    $('#formAddUTI')[0].reset();
                }else{
                    Swal.fire('Error',response,'warning');  
                    $('#myModal7').modal('hide'); 
                }
            }
        });
        e.preventDefault();
    });

    $("#formAddDPA").submit(function (e) { 
        let datos = {
            clase: "PersonalLaboral",
            metodo: "AddPersonalDPA",
            nombre: $("#addDPANom").val(),
            ci: $("#addDPACi").val(),
            correo: $("#addDPACorreo").val(),
            tel: $("#addDPATel").val(),
            pass: $("#addDPAPass").val()
        };
        console.log(datos);
        $.ajax({
            type: "POST",
            url: "../controlador/interprete.php",
            data: datos,
            success: function (response) {
                if(response == 1){
                    Swal.fire('Exito',"Se ha creado rpersona UTI "+$("#addUTINom").val(),'success');
                    $('#myModal8').modal('hide');
                    actualizarTablaDPA();
                    $('#formAddDPA')[0].reset();
                }else{
                    Swal.fire('Error',response,'warning');  
                    $('#myModal8').modal('hide'); 
                }
            }
        });
        e.preventDefault();
    });
});

function actualizarTablaRector(){
    $('#tableRector').dataTable().fnDestroy();
    tablaRector=$("#tableRector").DataTable({
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
            "data" : {'clase': 'Director' , 'metodo':'listaRector'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_director"},
            {"data":"correo_electronico_director"},
            {"data":"telefono_director"}, 
            {"data": null,"defaultContent":"<button type='button' class='editarRector btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal4'><i class='far fa-edit'></i></button>	<button type='button' class='eliminarRector btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal5'><i class='fas fa-trash-alt'></i></button>"}
        ]
    });
}


function actualizarTablaUTI(){
    $('#tableUTI').dataTable().fnDestroy();
    tablaUTI=$("#tableUTI").DataTable({
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
            "data" : {'clase': 'PersonalLaboral' , 'metodo':'listaUTI'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_trabador"},
            {"data":"correo_trabajador"},
            {"data":"tel_trabajador"}, 
            {"data": null,"defaultContent":"<button type='button' class='editarUTI btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal0'><i class='far fa-edit'></i></button>	<button type='button' class='eliminarUTI btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal1'><i class='fas fa-trash-alt'></i></button>"}
        ]
    });
}

function actualizarTablaDPA(){
    $('#tableDPA').dataTable().fnDestroy();
    tablaDPA=$("#tableDPA").DataTable({
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
            "data" : {'clase': 'PersonalLaboral' , 'metodo':'listaDPA'},
            "url":"../controlador/interprete.php"
        },
        "columns":[
            {"data":"nombre_trabador"},
            {"data":"correo_trabajador"},
            {"data":"tel_trabajador"}, 
            {"data": null,"defaultContent":"<button type='button' class='editarDPA btn btn-warning btn-sm' data-toggle='modal' data-target='#myModal2'><i class='far fa-edit'></i></button>	<button type='button' class='eliminarDPA btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal3'><i class='fas fa-trash-alt'></i></button>"}
        ]
    });
}

