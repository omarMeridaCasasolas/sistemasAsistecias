<?php
    session_start();
    if(isset($_SESSION['nombreTrabajador'])){
        
    }else{
        header("Location:../index.php?error=auntentificacion&tipo=docente");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTI-DPA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-secondary">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark d-inline-block w-100">
        <!-- Brand -->
        <img src="https://convocatoriaumss.s3.us-east-2.amazonaws.com/user.png" class="rounded" width="75" height="75">
        <h2 class="text-white d-inline-block"><?php echo $_SESSION['nombreTrabajador'];?></h2>
        <div class="float-right py-3">
            <button class="btn btn-primary"><i class="fas fa-envelope"></i></button>
            <button class="btn btn-primary"><i class="fas fa-user-edit"></i></button>
            <a href="" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        <ul class="navbar-nav">
            <!-- Dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Reportes:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="reportes_docentes.php">Docentes</a>
                <a class="dropdown-item" href="reportes_auxiliar_uti_dpa.php">Aux. pizarra</a>
                <a class="dropdown-item" href="reportes_uti_aux_lab.php">Aux. Laboratorio</a>
            </div>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Historial:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="historial_docentes_uti_dpa.php">Docentes</a>
                <a class="dropdown-item" href="historial_auxiliar_uti_dpa.php">Aux. pizarra</a>
                <a class="dropdown-item" href="historial_reportes_uti_laboratorio.php">Aux. Laboratorio</a>
            </div>
            </li>
        </ul>
    </nav>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <div class="row" id="seccionBusqueda">
                <div class="form-group col-md-6">
                    <label for="idFacultadaes">Facultad:</label>
                    <select name="idFacultadaes" id="idFacultades" class="form-control" required>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="idDepartamentos">Departamento:</label>
                    <select name="idDepartamentos" id="idDepartamentos" class="form-control" required>
                    </select>
                </div>
                <div class="form-group form-group col-md-6">
                    <label for="selectGestion">Gestion</label>
                    <select id="selectGestion" class="form-control">
                            </select>
                </div>
                <div class="form-group form-group col-md-6">
                    <label for="selectMes">Mes:</label>
                    <select id="selectMes" class="form-control"></select>
                </div>
        </div>
                
        <div id="divReportesDocente">
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
                <div class="form-group" id="divClaseLicencia" style="display: none;">
                    <h3>Licencia</h3>
                    <div class="form-group">
                        <label>Descripcion:</label>
                        <textarea class="form-control" id="textareaDescripcionLicencia" disabled="true"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Enlace:</label>
                        <a href="goo" id="aEnlaceLicencia" target="_blank">licencia.com</a>
                    </div>
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
                <div class="form-group" id="seccionOpcionAsistencia" style="display: none;">
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
    <script src="src/historial_docentes_uti_dpa.js"></script>
</body>
</html>
