<?php include_once("parts/cabezera_jefe_departamento.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <!-- Modal informacion auxiliar laboratorio ventana -->
        <input type="text" class="d-none" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
        <div class="modal fade" id="myModal4">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Ver informe</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarFacultad">
                    <input type="text" class="d-none" name="idLaboratorio" id="idLaboratorio">
                        <h6><strong>Fecha de reporte: </strong> <span id="fechaReporteView"></span></h6>
                        <h6><strong>Nombre del laboratorio: </strong><span id="nombreLaboratorio"></span></h6>
                        <h6><strong>Responsable: </strong><span id="responsableLab"></span></h6>
                        <h6><strong>Correo Electronico: </strong><span id="correoLab"></span></h6>
                        <h6><strong>Trabajo realizado: </strong><span id="avanzadoLab"></span></h6>
                        <h6><strong>Observacions: </strong><span id="observacionLab"></span></h6>
                        <div id="enlacesClase">
                            <h6>Enlaces</h6>
                            <!-- <textarea name="textEnlaces" id="textEnlaces" class="form-control" disabled></textarea> -->
                            <div id="listaEnlacesDiv">
                            </div>
                        </div>

                        <div class="contLicencia">
                            <h5 class="text-center">Licencia</h5>
                            <h6><strong>Motivo: </strong><span id="descLicencia">Sin licencia</span></h6>
                            <a href="#" target="_blank" rel="noopener noreferrer" id="idEnlaceLicencia">Enlace licencia</a>
                        </div>
                        <hr>
                        <h5>¿Marcar como falta?</h5>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio1">
                                <input type="radio" class="form-check-input" id="radio1" name="optradio" value="true"> SI
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="radio2" name="optradio" value="false"> No
                            </label>
                        </div>

                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Enviar reporte">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEditarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="text-center my-3">Reportes de auxiliares de laboratorio</h3>
        <div class="table-responsive">
        <h5>Fecha inicio: <span id="fechaInicio"></span>  al: <span id="fechaFinal"></span></h5>
            <table id="tablaReporte" class="display nowrap cell-border" style="width:100%">
                <thead class="bg-info">
                    <tr>
                        <th>Fecha</th>
                        <th>Laboratorio</th>
                        <th>Responsable</th>
                        <th>Trabajo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div> 
        <!-- <div class="reporteSemanal">
            <h3 id="MateriaReporte"></h3>
            <h2 >Fecha inicio: <span id="fechaInicio"></span>  -  Fecha-Final: <span id="fechaFinal"></span></h2>
        </div> -->
    <!-- modal de correo -->
    <div class="modal fade" id="abrirVtnCorreo">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h2 class="modal-title text-white">Enviar @mail</h2>
                    <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnMail">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEnviarCorreos">
                        <div class="form-group">
                            <label for="destinoCorreo">Escribe destino</label>
                            <input type="email" name="destinoCorreo" id="destinoCorreo" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="form-group col-5">
                                <label for="fromMail">Asunto: </label>
                                <input type="text" disabled name="fromMail" id="fromMail" class="form-control" value="<?php echo $_SESSION["cargo"];?>">
                            </div>
                            <div class="form-group col-7">
                                <label for="idCorreoAsunto">_</label>
                                <input type="text" name="idCorreoAsunto" id="idCorreoAsunto" class="form-control" value="Reportes" required>
                            </div>
                        </div>
                        <span>remitente: <strong>"Asistencia_Virtual_UMSS@mail.com"</strong></span>
                        <h4>Descripcion</h4>
                        <textarea name="descCorreo" id="descCorreo" class="form-control" required>Ya esta disponible la lista de hacer reportes</textarea>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Enviar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>    
        </div>
    </div>

    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <!-- <script src="/bower_components/moment/locale/es.js"></script> -->
    <script src="src/reportes_departamento_laboratorio.js"></script>
</body>
</html>
