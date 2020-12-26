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
<body class="bg-dark">
    <header>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <h1 class="bg-white">Bienvenido <?php echo $_SESSION['nombreAuxDoc']; ?></h1>
            <div class="d-block">
                <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>
            </div>
        </nav>
    </header>
    <main class="bg-secondary">
        <form action="post" id="escogerClases">
            <input type="text" style="display: none;" name="idAuxDoc" id="idAuxDoc" value="<?php echo $_SESSION['idAuxDoc'];?>">
        </form>
        <br>
        <h2 class="text-primary text-center bg-dark">Formulario de Control de Avance en Clase Virtual</h2>
        <br>
        <div class="row">
            <div class="form-group col-md-2">
                <h5 class="text-primary bg-dark form-control">FACULTAD: </h5>
            </div>
            <div class="form-group col-md-6">
                <select class="text-primary bg-dark form-control" id="selectFacultad"></select>  
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-2">
                <h5 class="text-primary bg-dark form-control">DEPARTAMENTO: </h5>
            </div>
            <div class="form-group col-md-6">
                <select class="text-primary bg-dark form-control" id="selectDepartamento"></select>  
            </div>
        </div>
        <div id="divSeccionFormulario" style="display: none;">
            <h3 class="text-primary bg-dark text-center">INFORME SEMANAL</h3>
            <br>
            <button type="button" class="text-primary bg-dark btn btn-primary" id="btnAdjuntarDocumento">Adjuntar documento</button>
            <button type="button" class="text-primary bg-dark btn btn-primary float-right" id="btnEnviarFormulario">Enviar formulario</button>
            <br><br>
            <div class="table-responsive">
                <table id="tablaReporteAuxiliarDocente">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Grupo</th>
                            <th>Nombre Materia</th>
                            <th>Contenido de clase</th>
                            <th>Plataforma o medio utilizado</th>
                            <th>Observaciones</th>
                            <th>Llenar Registro</th>
                            <th>Enlaces, recursos, videos</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 id="modalTituloEnlacesRecursos">SisMateria NomMateria NumGrupo</h2>
                                <button type="button" id="btnCerrarVtnPass" class="close" data-dismiss="modal" >&times;</button>
                            </div>
        <!--modal body-->
            <div class="modal-body">
                <form action="" id="formEnlacesRecursos" method="post" class="was-validated">
                    <div id="codigo_clase" style="display: none;"></div>
                    <div class="form-group">
                        <h5>Enlaces: </h5>
                        <div id="contenedorEnlaces">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <p>Descripcion: enlace compartido para la clase de</p>
                                </div>
                                <div class="form-group col-md-4">
                                    <a href="http://www.ajaxf1.com/tutorial/ajax-file-upload-tutorial.html">http://www.ajaxf1.com/tutorial/ajax-file-upload-tutorial.html</a>
                                </div>
                                <div class="form-group col-md-2">
                                    <button class='btn btn-primary btn-sm btnEditarDirector'>
                                                <i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <textarea placeholder="Descripcion del enlace" id="textareaDescripcionEnlace"></textarea>
                            </div>
                            <div class="form-group col-md-1"></div>
                            <div class="input-group mb-3 form-group col-md-4">
                                <textarea placeholder="Direccion url" id="textareaDireccionEnlace"></textarea>
                            </div>
                            <div class="form-group col-md-2">
                                <button class="btn btn-primary btn-sm" type="button"><i class="fas fa-plus" id="btnAgregarEnlace"></i></button>
                            </div> 
                        </div> 
                    </div>
                    <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                    <div class="form-group">
                        <h5>Recursos: </h5>
                        <div id="contenedorRecursos">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <p>Descripcion: clase numero 15 de logica</p>
                                </div>
                                <div class="form-group col-md-4">
                                    <a href="http://www.ajaxf1.com/tutorial/ajax-file-upload-tutorial.html">Introduccion.avi</a>
                                </div>
                                <div class="form-group col-md-2">
                                    <button class='btn btn-primary btn-sm btnEditarDirector'><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <textarea placeholder="Descripcion del recurso/video" id="textareaDescripcionRecurso"></textarea>
                                    </div>
                            <div class="custom-file form-group col-md-5">
                                <input type="file" class="custom-file-input" id="inputFileRecurso" lang="es">
                                <label class="custom-file-label" for="inputFileRecurso">Subir archivo</label>
                            </div> 
                        </div>
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