<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <form action="" id="formBusquedaReportes" class="mx-auto col-lg-5 col-md-7">
            <div id="divSeccionMenuBusqueda">
                <h2 class="text-center text-primary">Busqueda de reportes por: </h2>
                <input type="text" class="d-none" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
                <div class="form-group">
                    <label for="tipoUnidad">Tipo</label>
                    <select name="tipoUnidad" id="tipoUnidad" class="form-control">
                        <option value="Ninguno">Ninguno</option>
                        <option value="Laboratorios">Laboratorios</option>
                        <option value="Docente">Docente</option>
                        <option value="Auxiliar de docencia">Auxiliar de docencia</option>
                    </select>
                </div>
                <div id="elemGrupo" class="form-group d-none">
                    <label for="tipoGrupo" id="labNombre">Materia _ Laboratorio</label>
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
                <div id="seccionFiltrosBusqueda" style="display: none;">
                    <div class="form-group">
                        <label for="selectListarReportes">Listar como</label>
                        <select id="selectListarReportes" class="form-control">
                            <option value="ReportesPendientes">Reportes pendientes</option>
                            <option value="ReportesRevisado">Reportes revisados</option>
                        </select>
                    </div>
                    <div id="seccionFiltrosBusquedaReportesRevisados" style="display: none;">
                        <div class="form-group">
                            <label for="selectGestion">Gestion</label>
                            <select id="selectGestion" class="form-control">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selectMes">Mes:</label>
                            <select id="selectMes" class="form-control"></select>
                        </div>
                    </div>
                </div>
                <div class="text-center my-3">
                    <input type="submit" value="Buscar" class="btn btn-secondary">
                </div>
            </div>
        </form>

        <div class="table-responsive" id="seccionAuxiliaresLaboratorio">
            <table id="tablaHistorialReporte" class="display nowrap cell-border" style="width:100%">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Materia-Laboratorio</th>
                        <th>Asignado</th>
                        <th>Trabajo relizado</th>
                        <th>Observacion</th>
                        <th>Documentos entregados</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="divReportesDocente" style="display: none;">
            <br><br><br>
            <div class="table-responsive">
                <table id="tablaReporteDocente">
                    <thead>
                        <tr>
                            <th>Codigo SIS</th>
                            <th>Nombre</th>
                            <th>Periodo reporte</th>
                            <th>Controlar asistencia</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div id="divFormularioControlAvanceDocente" style="display: none;">
            <br><br>
            <h3 class="text-primary" id="formNombreDocente">Docente</h3>
            <h3 class="text-primary" id="formSisDocente">Codigo SIS</h3>
            <h3 class="text-primary text-center" id="formPeriodoReporteDocente">Fecha</h3>
            <br>
            <button type="button" class="btn btn-primary" id="btnVolverReportesPendientes">Volver a reportes pendientes</button>
            <button type="button" class="btn btn-primary float-right" id="btnEnviarReporte">Enviar reporte</button>
            <br><br>
            <div class="table-responsive">
                <table id="tablaFormularioControlAvanceDocente">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Grupo</th>
                            <th>Materia</th>
                            <th>Revisado</th>
                            <th>Revisar clase</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


<div class="modal fade" id="modalFormularioControlAvance">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="modal-title text-center" id="tituloModalFormularioControlAvance"></h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <form id="formControlAvance">    
            <div class="modal-body">
                <div id="key_map_clase" style="display: none;"></div>
                <div class="form-group">
                    <label for="">Contenido</label>
                    <textarea class="form-control" disabled="true" id="textareaContenido"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Plataforma o medio utilizado</label>
                    <textarea class="form-control" disabled="true" id="textareaPlataforma"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Observaciones</label>
                    <textarea class="form-control" disabled="true" id="textareaObservaciones"></textarea>
                </div>
                <div class="form-group" id="divClaseReposicion" style="display: none;">
                    <h3>Clase de Reposicion</h3>
                    <div class="form-group">
                        <label for="">Asunto de reposicion:</label>
                        <textarea class="form-control" disabled="true" id="asuntoClaseReposicion"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Fecha reposicion</label>
                        <input type="text" name="" class="form-control" disabled="" value="2020-12-05" id="fechaClaseReposicion">
                    </div>
                    <div class="form-group">
                        <label>Hora reposicion</label>
                        <input type="text" name="" class="form-control" disabled="" value="815-945" id="horaClaseReposicion">
                    </div>
                    <div class="form-group">
                        <label>Plataforma</label>
                        <input type="text" name="" class="form-control" disabled="" value="Meet" id="plataformaClaseReposicion">
                    </div>
                    <div class="form-group">
                        <label>Contenido</label>
                        <textarea class="form-control" disabled="true" id="textareaContenido" id="contenidoClaseReposicion"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label id="tituloEnlaces">Enlaces:</label>
                    <div id="divContenedorEnlaces"></div>
                </div>
                <div class="form-group">
                    <label id="tituloRecursos">Recursos:</label>
                    <div id="divContenedorRecursos"></div>
                </div>
                <div class="form-group" id="seccionOpcionAsistencia">
                    <label>¿Marcar como asistencia?</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioSi" value="Si" required="">
                        <label class="form-check-label" for="inlineRadioSi">Si</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadioNo" value="No" required="">
                        <label class="form-check-label" for="inlineRadioNo">No</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="seccionBotonesModal">
                <button type="submit" id="btnRegistrarAsistencia" class="btn btn-primary">Registrar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnCancelarAsistencia">Cancelar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  

    <div id="divFormularioControlAvanceDocenteRevisado" style="display: none;">
            <br><br>
            <h3 class="text-primary" id="formNombreDocenteRevisado">Docente</h3>
            <h3 class="text-primary" id="formSisDocenteRevisado">Codigo SIS</h3>
            <h3 class="text-primary text-center" id="formPeriodoReporteDocenteRevisado">Fecha</h3>
            <br>
            <button type="button" class="btn btn-primary" id="btnVolverReportesRevisados">Volver a reportes revisados</button>
            <br><br>
            <div class="table-responsive">
                <table id="tablaFormularioControlAvanceDocenteRevisado">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Grupo</th>
                            <th>Materia</th>
                            <th>Falto a clase</th>
                            <th>Ver clase</th>
                        </tr>
                    </thead>
                </table>
            </div>
    </div>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/reportes_departamento.js"></script>
</body>
</html>
