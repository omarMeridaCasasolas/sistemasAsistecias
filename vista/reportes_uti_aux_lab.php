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
                <a class="dropdown-item" href="historial_labo_uti_dpa.php">Aux. Laboratorio</a>
            </div>
            </li>
        </ul>
    </nav>
    <main class="container bg-white py-4">
    <main class="container bg-white p-2">
        <form action="" id="formObtenerReporte">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="idFacultadaes">Facultad:</label>
                    <select name="idFacultadaes" id="idFacultadaes" class="form-control" required>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="idDepartamentos">Departamento:</label>
                    <select name="idDepartamentos" id="idDepartamentos" class="form-control" required>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="idAuxPizarra">Auxiliar de pizarra:</label>
                    <select name="idAuxPizarra" id="idAuxPizarra" class="form-control" required>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="idMateria">Materia:</label>
                    <select name="idMateria" id="idMateria" class="form-control" required>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <h6 id="descResultado"></h6>
                <input type="submit" class="btn btn-primary" value="Obtener" required>
            </div>
        </form>

        <h5>Reporte del mes de : <strong>Noviembre</strong></span></h5>
            <table id="tablaMateriaAuxiliares" class="display nowrap cell-border" style="width:100%">
                <thead class="bg-info">
                    <tr>
                        <th>Fecha</th>
                        <th>Materia</th>
                        <th>Codigo materia</th>
                        <th>Plataforma</th>
                        <th>Asistencia</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div> 

        <!-- Modal Editar Facultad ventana -->
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
                            <input type="submit" class="btn  btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEditarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <form action="">
            <div class="text-center">
                <input type="submit" class="btn btn-secondary" value="Enviar Datos">
            </div>
        </form>
    </main>
    </main>
</body>
</html>