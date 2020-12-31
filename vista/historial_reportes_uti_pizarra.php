<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historila de Auxliar de laboratorio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
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
<body class="bg-secondary">
    <main class="bg-white p-4 mx-auto rounded col-lg-8 col-md-12 min-vh-100">
        <!-- Formulario para Docentes -->
        <h2 class="text-center">Historial de reportes</h2>
        <form action="" id="buscarReportesDocentes">
            <div class="form-group mx-auto col-lg-4 col-md-7">
                <label for="idFacultadaes">Seleccione Facultadad</label>
                <select name="idFacultadaes" id="idFacultadaes" class="form-control" required>
                </select>
            </div>
            <div class="form-group mx-auto col-lg-4 col-md-7">
                <label for="idDepartamentos">Selecione Departamento</label>
                <select name="idDepartamentos" id="idDepartamentos" class="form-control" required>
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

    </main>    
    <!-- Modal Editar Facultad ventana -->
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
                        <div class="text-center">
                            <button data-dismiss="modal" class="btn btn-danger">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script src="src/historial_reportes_uti_docentes.js"></script>
</body>
</html>
