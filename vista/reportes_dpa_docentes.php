<?php 
session_start();
if(isset($_SESSION['nombreTrabajador'])){
}else{
    header("Location:../index.php?error=auntentificacion");
}
function asignarMes($num){
    $mes = '';
    switch ($num) {
        case '01':
            $mes = "Enero";
            break;
        case '02':
            $mes = "Febrero";
            break;
        case '03':
            $mes = "Marzo";
            break;
        case '04':
            $mes = "Abril";
            break;
        case '05':
            $mes = "Mayo";
            break;
        case '06':
            $mes = "Junio";
            break;
        case '07':
            $mes = "Julio";
            break;
        case '08':
            $mes = "Agosto";
            break;
        case '09':
            $mes = "Septiembre";
            break;
        case '10':
            $mes = "Octubre";
            break;
        case '11':
            $mes = "Noviembre";
            break;
        default:
            $mes = "Diciembre";
            # code...
            break;
    }
    return $mes;
}
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
    <img src="<?php echo $_SESSION['foto_trabajador']; ?>" class="rounded" width="75" height="75">
    <h4 class="text-white d-inline-block"><?php echo $_SESSION['cargoTrabajador'].": ".$_SESSION['nombreTrabajador'];?></h4>
    <div class="float-right py-3">
        <a href="home_dpa.php" class="btn btn-primary"><i class="fas fa-home"></i></a>
        <button class="btn btn-primary" data-toggle='modal' data-target='#abrirVtnCorreo'><i class="fas fa-envelope"></i></button>
        <a href="../controlador/formCerrarSession.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
        <br><h6 class="text-white my-1">Bolivia <span id="div_date_time"></span></h6>
        </div>
    <ul class="navbar-nav">
        <!-- Dropdown -->
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Reportes:
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="reportes_dpa_docentes.php">Docentes</a>
            <a class="dropdown-item" href="reportes_dpa_pizarra.php">Aux. pizarra</a>
            <a class="dropdown-item" href="reportes_dpa_laboratorio.php">Aux. Laboratorio</a>
        </div>
        </li>

        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Historial:
        </a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="historial_dpa_docentes.php">Docentes</a>
            <a class="dropdown-item" href="historial_dpa_pizarra.php">Aux. pizarra</a>
            <a class="dropdown-item" href="historial_dpa_laboratorio.php">Aux. Laboratorio</a>
        </div>
        </li>
    </ul>
</nav>
<body class="bg-secondary">
    <main class="container bg-white p-3 min-vh-100">
        <h2 class="text-center text-primary my-2">Mostrar reporte docentes</h2>
        <form action="../controlador/obtenerReportesDocDepartamento.php" id="" method="POST">
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
            </div>
            <input type="text" name="fechaInicio" id="fechaInicio" class="d-none">
            <input type="text" name="fechaFinal" id="fechaFinal" class="d-none">
            <div class="text-center">
                <h6 id="descResultado"></h6>
                <input type="submit" class="btn btn-primary" value="Obtener" disabled="disabled" id="btnSubmit">
            </div>
        </form>
        <br>
        <h5>Reporte del mes de : <strong><?php $fecha = date("m"); $tmp = intval($fecha) -1; echo asignarMes($tmp);?> - 2020</strong></span></h5>
            <div id="cajaTabla">
            <table id="tablaMateriaAuxiliares" class="table table-hover table-bordered" style="width:100%">
                <thead class="bg-info">
                    <tr>
                        <th>Docente</th>
                        <th>Materia</th>
                        <th>Total hrs</th>
                        <th>Cant. faltas</th>
                        <th>Hrs. Licencia </th>
                        <th>Hrs. baja</th>
                        <th>Horas pagable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $horasPagablesDeparamento = 0;
                        $horasNoPagablesDeparamento = 0;
                        if(isset($_SESSION['datosReporteDocente'])){
                            $listaDeAuxiliares = $_SESSION['datosReporteDocente'];
                            if(sizeof($listaDeAuxiliares)==0){
                                echo "<tr>
                                    <td>No tiene datos</td>
                                    <td>No tiene datos</td>
                                    <td>No tiene datos</td>
                                    <td>No tiene datos</td>
                                    <td>No tiene datos</td>
                                    <td>No tiene datos</td>
                                    <td>No tiene datos</td>
                              </tr>";
                            }else{
                                foreach ($listaDeAuxiliares as $x) {
                                    $llave = key($x);
                                    echo "<tr>
                                        <td>".$x['nombreDocente']."</td>
                                        <td>".$x['nombreMateria']."</td>
                                        <td>".$x['horasTotal']." Hrs</td>
                                        <td>".$x['faltas']."</td>
                                        <td>".$x['horasDeLicencia']." Hrs</td>
                                        <td>".$x['licenciaPedidas']." Hrs</td>
                                        <td>".$x['horasPagables']." Hrs</td>
                                      </tr>";
                                      $horasPagablesDeparamento = $horasPagablesDeparamento + $x['horasPagables'];
                                      $horasNoPagablesDeparamento = $horasNoPagablesDeparamento + $x['licenciaPedidas'];
                                }
                            }
                            
                        }else{
                            echo "<tr>
                                    <td>Selecione departamento</td>
                                    <td>Selecione departamento</td>
                                    <td>Selecione departamento</td>
                                    <td>Selecione departamento</td>
                                    <td>Selecione departamento</td>
                                    <td>Selecione departamento</td>
                                    <td>Selecione departamento</td>
                                  </tr>";
                        }
                    ?>
                </tbody>
            </table>
            </div>
        </div> 
        <hr>
        <?php 
            if(isset($_SESSION['datosReporteDocente'])){
                echo "<h6><strong>Total de horas pagables por departamento/mes : </strong>". $horasPagablesDeparamento ." Hrs/mes</h6> ";
                echo "<h6><strong>Total de horas no pagables por departamento/mes : </strong>".$horasNoPagablesDeparamento," Hrs/mes</h6> ";
            }
        ?>
        <hr>
        <form action="getHTMLPDFDocentes.php" method="POST" target="_blank">
            <div class="text-center">
                <input type="text" name="gestionPlanilla" id="gestionPlanilla" class="d-none">
                <input type="text" name="nomFacultad" id="nomFacultad" class="d-none">
                <input type="text" name="nomDepartamento" id="nomDepartamento" class="d-none">
                <a href="vista_previa_reporte_auxiliar.php" class="btn btn-primary m-2" id="enlaceVistaPrevia">Vista previa</a>
                <input type="submit" class="btn btn-secondary m-2" value="Generar PDF" id="btnSubForm" disabled>
            </div>
        </form>

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
                        <br>
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

                        <div class="text-center my-3">
                            <input type="submit" class="btn  btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEditarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
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
                            <div class="form-group col-4">
                                <label for="fromMail">Asunto: </label>
                                <input type="text" disabled name="fromMail" id="fromMail" class="form-control" value="<?php echo $_SESSION["cargoTrabajador"];?>">
                            </div>
                            <div class="form-group col-8">
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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <!-- <script src="/bower_components/moment/locale/es.js"></script> -->
    <script src="src/reportes_dpa_docentes.js"></script>
</body>
</html>
