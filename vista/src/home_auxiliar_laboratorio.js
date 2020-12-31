$(document).ready(function () {
    obtenerDiasPermiso();

    $("#cerrarModal").click(function (e) { 
        $("#btnCerrarModal").click();       
    });
    $(document).on('click', 'button.generarReporte', function(event) {
        let id = this.id;
        console.log("Se presionó el Boton con Id :"+ id);
        let idReporte = id.split('/');
        //console.log(idReporte[1]);
        if(idReporte[1] != null){
            let descripcion = $("#txt_des_"+idReporte[1]).val();
            let observacion = $("#txt_obs_"+idReporte[1]).val();
            //console.log(descripcion);
            $("#txtDescripcion").val(descripcion);
            $("#txtObservacion").val(observacion);
            let urlRecurso = $("#url_"+idReporte[1]).attr("href");
            $("#linkFile").attr("href", urlRecurso);
            let claveP = idReporte[1].split("_");
            console.log(claveP[0]);
            $("#idRegistro").val(claveP[0]);
        }
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
         });
      });
    
});

function obtenerDiasPermiso(){
    // let fecga = new Date; // get current date
    // let first = curr.getDate() - curr.getDay() +1 ; // First day is the day of the month - the day of the week
    // let last = first + 6; // last day is the first day + 6
    // console.log(first);
    // console.log(last);
    var days = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes","Sabado", "Domingo"];
    
    $('table>tbody tr').each(function(){
        $(this).find('td:first').each(function(){
            console.log($(this).html());
            let fecha = new Date($(this).html());
            let diaFecha = days[fecha.getDay()]
            $("#contFechasLicencia").append("<div class='form-check'>"+
            "<label class='form-check-label'><input type='checkbox' name='fechas[]' class='form-check-input' value='"+$(this).html()+"'>"+$(this).html()+" ("+diaFecha+")</label></div>");
        })
    })

}