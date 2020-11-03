$(document).ready(function () {
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
        $("#myModal").modal();
      });
});