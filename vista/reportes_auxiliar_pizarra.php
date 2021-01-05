<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <!-- Modal Editar Facultad ventana -->
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
                    <input type="text" class="d-none" name="idClase" id="idClase">
                        <span>Fecha de reporte : <strong id="fechaReporteView"></strong></span>
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="nomMateria">Nombre de la materia</label>
                                <input type="text" name="nomMateria" id="nomMateria" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="codMateria">Cod. Materia</label>
                                <input type="text" name="codMateria" id="codMateria" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="nomResponsable">Responsable</label>
                                <input type="text" name="nomResponsable" id="nomResponsable" class="form-control" disabled>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="plataforma">Plataforma</label>
                                <input type="text" name="plataforma" id="plataforma" class="form-control" disabled>
                            </div>
                        </div>
                        <div id="idAvanzado">
                            <h6>Avanzado</h6>
                            <textarea name="textAvanzado" id="textAvanzado" class="form-control" disabled></textarea>
                        </div>
                        <h6>Observacion</h6>
                        <textarea name="textObservacion" id="textObservacion" class="form-control" disabled></textarea>
                        <div id="enlacesClase">
                            <h6>Enlaces</h6>
                            <!-- <textarea name="textEnlaces" id="textEnlaces" class="form-control" disabled></textarea> -->
                            <div id="listaEnlacesDiv">
                            </div>
                        </div>
                            <div id="reposClass">
                                <!-- <div class="container">  -->
                                    <h2>Clase de Reposicion</h2>
                                    <!-- <p><strong>Nota:</strong> Se dio esta clase por razones de : <span id="repAsunto"></span>El dia: <span id="resFecha"></span> en horario de las: <span id="resHorario"></span></p> -->
                                    <p><strong>Nota:</strong> Se dio esta clase el dia: <span id="repFecha"></span> en horario de las: <span id="repHora"></span></p>
                                    <div id="accordion">
                                        <div class="card w-100">
                                            <div class="card-header">
                                                <a class="card-link" data-toggle="collapse" href="#collapseOne">
                                                    Detalles de reposicion
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="repPlataforma">Plataforma:</label>
                                                        <input type="text" name="repPlataforma" id="repPlataforma" class="form-control">
                                                    </div>
                                                    <h4>Contenido de la clase</h4>
                                                    <p><span id="repAvance"></span></p>
                                                    <div>
                                                        <h5>Enlaces: </h5>
                                                        <div id="enlacesReposicion">
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div> -->
                                <!-- </div> -->
                            </div>
                        </div>
                        <hr>
                        <h5>¿Marcar como asistencia?</h5>
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
        <h3 class="text-center my-3">Reportes de auxiliares de pizarra</h3>
        <div class="table-responsive">
        <h5>Fecha inicio: <span id="fechaInicio"></span>  al: <span id="fechaFinal"></span></h5>
            <table id="tablaMateriaAuxiliares" class="display nowrap cell-border" style="width:100%">
                <thead class="bg-info">
                    <tr>
                        <th>Fecha</th>
                        <th>Materia</th>
                        <th>Codigo materia</th>
                        <th>Plataforma</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div> 
        <!-- <div class="reporteSemanal">
            <h3 id="MateriaReporte"></h3>
            <h2 >Fecha inicio: <span id="fechaInicio"></span>  -  Fecha-Final: <span id="fechaFinal"></span></h2>
        </div> -->



    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <!-- <script src="/bower_components/moment/locale/es.js"></script> -->
    <script src="src/reportes_auxiliar_pizarra.js"></script>
</body>
</html>
