<?php
    session_start();
    if(isset($_SESSION['nombreAuxDoc'])){

    }else{
        header("Location:../index.php?error=auntentificacion&tipo=auxiliar_docente");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido auxiliar de docente</title>
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
        <img src="<?php echo $_SESSION['foto_user'];?>" class="rounded" width="75" height="75">
        <h4 class="text-white d-inline-block">Auxiliar: <?php echo $_SESSION['nombreAuxDoc'];;?></h4>
        <div class="float-right py-3">
            <a href="licencias_aux_docentes.php" class="btn btn-primary" title="historial de licencias"><i class="far fa-id-badge"></i></a>
            <button class="btn btn-primary" data-toggle="modal" id="btnEditSelf" data-target="#myModalEditarDatos" title="Editar datos"><i class="fas fa-user-edit"></i></button>
            <a href="historial_reportes_pizarra.php" class="btn btn-primary" title="historial de asistencia"><i class="far fa-clipboard"></i></a>
            <a href="../controlador/formCerrarSession.php" class="btn btn-primary" title="Cerrar Session"><i class="fas fa-sign-out-alt"></i></a>
            <br>
            <h6 class="text-white my-1">Bolivia <span id="div_date_time"></span></h6>
        </div>
    </nav>
    <!-- <header>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <h1 class="bg-white">Bienvenido <?php //echo $_SESSION['nombreAuxDoc']; ?></h1>
            <div class="d-block">
                <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>
            </div>
        </nav>
    </header> -->
    <main class="bg-secondary container bg-white min-vh-100">
        <form action="post" id="escogerClases">
            <input type="text" style="display: none;" name="idAuxDoc" id="idAuxDoc" value="<?php echo $_SESSION['idAuxDoc'];?>">
        </form>
        <br>
        <h2 class="text-center text-primary">Control de Avance de pizarra Clase Virtual</h2>
        <br>
        <div class="row">
            <div class="form-group col-md-2">
                <h5 class="">FACULTAD: </h5>
            </div>
            <div class="form-group col-md-6">
                <select class="form-control" id="selectFacultad"></select>  
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <h5 class="">DEPARTAMENTO: </h5>
            </div>
            <div class="form-group col-md-6">
                <select class="form-control" id="selectDepartamento"></select>  
            </div>
        </div>
        <div id="divSeccionFormulario" style="display: none;">
            <h3 class="text-primary text-center">INFORME SEMANAL</h3>
            <br>
            <hr>
            <!-- Codigo Omar  -->
            <button type="button" class="text-primary bg-dark btn btn-primary" id="btnLicencia" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Soliciatar Licencia</button>
            <!-- The Modal -->
            <div class="modal fade" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header bg-info">
                            <h4 class="modal-title">Solicitar Permiso</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <form action="" id="formGetFecha">
                                <div class="row">
                                    <div class="form-group col-8">
                                        <select name="tipoLicencia" id="tipoLicencia" class="form-control">
                                            <option value="dia">Clase</option>
                                            <option value="clase">Dia</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <input type="submit" value="Obtener" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                            <form action="../controlador/licenciaAuxiliar.php" method ="POST" id="formFechas">
                                <input type="text" style="display: none;" name="ident" id="ident" value="<?php echo $_SESSION['idAuxDoc'];?>">
                                <h5 id="checkHTML" class="text-danger"></h5>
                                <div id="contFechas" class="bg-light p-1">                            
                                </div>
                                <h5>Descripcion de la licencia</h5>
                                <textarea name="descLicencia" id="descLicencia" class="form-control" required></textarea>
                                <div class="form-group">
                                    <label for="miFilePermiso">Selecione el documento</label>
                                    <input type="file" name="miFilePermiso" id="miFilePermiso" class="form-control">
                                </div>
                                <div class="text-center my-3">
                                    <input type="submit" value="Enviar" class="btn btn-secondary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin de codigo Omar -->

            <button type="button" class="text-primary bg-dark btn btn-primary float-right" id="btnEnviarFormulario">Enviar formulario</button>
            <br><br>
            <div class="table-responsive">
                <table id="tablaReporteAuxiliarDocente" class="hover cell-border">
                    <thead class="bg-info">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Grupo</th>
                            <th>Nombre Materia</th>
                            <th>Contenido de clase</th>
                            <th>Llenar Registro</th>
                            <th>Enlaces, recursos</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
<div class="modal fade" id="modalFormularioAvance">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 id="modalTituloFormularioAvance">SisMateria NomMateria NumGrupo</h2>
                                <button type="button" id="btnCerrarVtnPass" class="close" data-dismiss="modal" >&times;</button>
                            </div>
        <!--modal body-->
            <div class="modal-body">
                <form action="" id="formControlAvance" method="post" class="was-validated">
                    <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-contenido-tab" data-toggle="pill" href="#pills-contenido" role="tab" aria-controls="pills-contenido" aria-selected="true">Contenido de clase</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-plataforma-tab" data-toggle="pill" href="#pills-plataforma" role="tab" aria-controls="pills-plataforma" aria-selected="false">Plataforma o medio utilizado</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-observaciones-tab" data-toggle="pill" href="#pills-observaciones" role="tab" aria-controls="pills-observaciones" aria-selected="false">Observaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-reposicion-tab" data-toggle="pill" href="#pills-reposicion" role="tab" aria-controls="pills-reposicion" aria-selected="false">Clase de reposicion</a>
                        </li>
                    </ul>
                     <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-contenido" role="tabpanel" aria-labelledby="pills-contenido-tab">
                            <textarea class="form-control" id="textareaContenido"></textarea>
                        </div>
                        <div class="tab-pane fade" id="pills-plataforma" role="tabpanel" aria-labelledby="pills-plataforma-tab">
                            <textarea class="form-control" id="textareaPlataforma"></textarea>
                        </div>
                        <div class="tab-pane fade" id="pills-observaciones" role="tabpanel" aria-labelledby="pills-observaciones-tab">
                            <textarea class="form-control" id="textareaObservaciones"></textarea>
                        </div>
                        <div class="tab-pane fade" id="pills-reposicion" role="tabpanel" aria-labelledby="pills-reposicion-tab">
                            <div class="form-group">
                                <label>Asunto:</label>
                                <textarea class="form-control" id="textareaAsuntoReposicion"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Fecha:</label>
                                <input type="date" name="fechaReposicion" id="fechaReposicion">
                            </div>
                            <div class="form-group">
                                <label>Hora:</label>
                                <input type="time" name="horaReposicion" id="horaReposicion">
                            </div>
                            <div class="form-group">
                                <label>Plataforma:</label>
                                <textarea class="form-control" id="plataformaReposicion"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Avance:</label>
                                <textarea class="form-control" id="avanceReposicion"></textarea>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Guardar cambios">    
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCerrarModalFormularioAvance">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEnlacesRecursos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 id="modalTituloEnlacesRecursos">SisMateria NomMateria NumGrupo</h2>
                                <button type="button" id="btnCerrarVtnPass" class="close" data-dismiss="modal" >&times;</button>
                            </div>
        <!--modal body-->
            <div class="modal-body">
                <form action="" id="formEnlacesRecursos" method="post" class="was-validated">
                    <div class="form-group">
                        <h5>Enlaces: </h5>
                        <div id="contenedorEnlaces">
                            
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <textarea placeholder="Descripcion del enlace" id="textareaDescripcionEnlace" class="form-control"></textarea>
                            </div>
                            <div class="input-group mb-3 form-group col-md-6">
                                <textarea placeholder="Direccion url" id="textareaDireccionEnlace" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-secondary" type="button" id="btnAgregarEnlace">Guardar enlace</button>
                        </div> 
                    </div>
                </form>
                <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                <form action="../controlador/formInsertarRecursoClaseAuxiliar.php" id="" method="POST" enctype="multipart/form-data">
                    <div name="codigo_clase" id="codigo_clase" style="display: none;"></div>
                    <input type="text" name="codClaseReporte" id="codClaseReporte" class="d-none">
                        <div class="form-group">
                            <h5>Recursos: </h5>
                            <div id="contenedorRecursos">                            
                        </div>
                        <textarea placeholder="Descripcion del recurso/video" class="form-control" id="textareaDescripcionRecurso" name="textareaDescripcionRecurso" required ></textarea>
                        <div class="form-group">
                            <label for="inputFileRecurso">Documentos e imagenes</label>
                            <input type="file" class="form-control" id="inputFileRecurso" name="inputFileRecurso" lang="es">
                        </div> 
                    </div> 
                    <div class="text-center">
                        <input type="submit" class="btn btn-secondary" value="Subir archivo">
                    </div>   
                </form>
            </div>
        </div>
    </div>
</div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/home_auxiliar_docente.js"></script>
    
</body>
</html>