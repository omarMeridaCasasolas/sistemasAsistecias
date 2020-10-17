$(document).ready(function() {
    $('#example').DataTable();
});



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
            $('#asigDirector').children('option:not(:first)').remove();
            console.log(response);
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
