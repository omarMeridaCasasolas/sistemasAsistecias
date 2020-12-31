<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <form action="" id="formBusquedaReportes" class="mx-auto col-lg-5 col-md-7">
            <h2 class="text-center text-primary">HISTORIAL LABORATORIO </h2>
            <input type="text" class="d-none" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
            <!-- <div class="form-group">
                <label for="tipoUnidad">Tipo</label>
                <select name="tipoUnidad" id="tipoUnidad" class="form-control">
                    <option value="Ninguno">Ninguno</option>
                    <option value="Laboratorios">Laboratorios</option>
                    <option value="Docente">Docente</option>
                    <option value="Auxiliar de docencia">Auxiliar de docencia</option>
                </select>
            </div> -->
            <div id="elemGrupo" class="form-group">
                <label for="tipoGrupo" id="labNombre">Selecione Laboratorio</label>
                <select name="tipoGrupo" id="tipoGrupo" class="form-control">
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div id="elemNombre" class="form-group d-none">
                <label for="TipoNombre" id="labNombre">Nombre </label>
                <select name="TipoNombre" id="TipoNombre" class="form-control">
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div class="text-center my-3">
                <input type="submit" value="Buscar" class="btn btn-secondary">
            </div>
        </form>

        <div class="table-responsive">
            <table id="tablaHistorialReporte" class="display nowrap cell-border" style="width:100%">
                <thead>
                    <tr class="bg-info">
                        <th>Fecha</th>
                        <th>Materia-Laboratorio</th>
                        <th>Asignado</th>
                        <th>Trabajo relizado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    <!-- ver detalles de reportes_departamento  -->
    <div class="modal fade" id="myModal4">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Detalles de reporte de asistencia</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                        <h6><strong>Fecha:</strong> <span id="fechaReporte"></span></h6>
                        <h6><strong>Nombre del laboratorio:</strong> <span id="laboratorioReporte"></span></h6>
                        <h6><strong>Responsable:</strong> <span id="responsableReporte"></span></h6>
                        <h6><strong>Trabajo hecho:</strong> <span id="trabajoReporte"></span></h6>
                        <p><strong>Observacion: </strong><span id="obsReporte">-.-</span></p>
                        <p>Enlace: <a href="#" id="enlaceReporte" target="_blank" rel="noopener noreferrer">Sin enlace</a></p>
                        <div id="contLicencia">
                            <h4 class="text-center">Licencia</h4>
                            <h6><strong>Motivo :</strong><span id="motivoLicencia"></span></h6>
                            <p>Enlace: <a href="#" id="enlaceLicencia" target="_blank" rel="noopener noreferrer">Sin elncae</a></p>
                        </div>
                        <div class="form-group">
                            <label for="reporteAsistencia"> Asistencia :</label>
                            <select name="reporteAsistencia" id="reporteAsistencia" disabled="disabled">
                                <option value="undefined" selected>No revisado</option>
                                <option value="true">Si</option>
                                <option value="false">No</option>
                            </select>
                        </div>
                        <form action="" method="post">
                            <div class="text-center my-2">
                                <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEditarFacultad">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/reportes_departamento.js"></script>
</body>
</html>
