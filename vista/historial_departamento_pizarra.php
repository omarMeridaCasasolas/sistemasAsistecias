<?php include_once("parts/cabezera_jefe_departamento.php");?>
<body class="bg-secondary">
<input type="text" class="d-none" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
    <main class="bg-white p-4 mx-auto rounded col-lg-9 col-md-12 min-vh-100">
        <h2 class="text-center">Historial de reportes Aux de pizarra</h2>
        <form action="" id="formBuscarReportes">
            <div class="form-group mx-auto col-lg-5 col-md-8">
                <label for="idMateria">Selecione Materia</label>
                <select name="idMateria" id="idMateria" class="form-control" required>
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div class="text-center my-2">
                <input type="submit" class="btn btn-primary" value="Buscar" disabled id="btnBuscar">
            </div>
        </form>
        <hr>

        <div class="responsive">
            <table id="tablaHistorialReporte" class="display nowrap cell-border" style="width:100%">
                <thead class="bg-info">
                    <tr>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Materia</th>
                        <th>Responsable</th>
                        <th>Avance</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    <!-- Modal Email-->
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

    <!-- Historial de reportes-->
        <div class="modal fade" id="myModal4">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Reporte Historial</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                        <h6><strong>Fecha y hora: </strong><span id="fechaClase"></span></h6>
                        <h6><strong>Materia: </strong><span id="nomMateria"></span></h6>
                        <h6><strong>Responsable: </strong><span id="nomResponsable"></span></h6>
                        <h6><strong>Avance: </strong><span id="idAvance"></span></h6>
                        <h6><strong>Plataforma: </strong><span id="idPlataforma"></span></h6>
                        <h6><strong>Observacion: </strong><span id="idObservacion"></span></h6>
                        <div id="claseRecuperacion">
                            <h4 class="text-center">Clase de recuperacion</h4>
                            <h6><strong>Fecha reposicion: </strong><span id='fechaRecuperacion'></span></h6>
                            <h6><strong>Avanze: </strong><span id='avanzeRecuperacion'></span></h6>
                            <h6><strong>pataforma: </strong><span id='plataformaRecuperacion'></span></h6>
                        </div>
                        <div id="enlacesRecursos">
                        </div>
                        <div id="claseLicencia">
                            <h4 class="text-center">Licencia</h4>
                            <h6><strong>Asunto licencia: </strong><span id="asuntoLicencia">Sin licencia</span></h6>
                            <a href="#" target="_blank" rel="noopener noreferrer" id="enlaceLicencia">Enlace</a>
                        </div>
                        <div class="form-group">
                            <label for="idAsistencia">Asistencia :</label>
                            <select name="idAsistencia" id="idAsistencia" disabled class="form-control">
                                <option value="true">Si</option>
                                <option value="false">No</option>
                            </select>
                        </div>
                        <div class="text-center">
                            <button data-dismiss="modal" class="btn btn-danger">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/historial_departamento_pizarra.js"></script>
</body>
</html>
