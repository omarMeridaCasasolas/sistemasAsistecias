<?php 
    session_start();
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
    <title>Reportes UTI</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <form action="../controlador/obtenerReportesAuxDepartamento.php" id="" method="post">
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

        <h5>Reporte del mes de : <strong><?php $fecha = date("m"); $tmp = intval($fecha) -1; echo asignarMes($tmp);?> - 2020</strong></span></h5>
            <div id="cajaTabla">
            <table id="tablaMateriaAuxiliares" class="table table-hover" style="width:100%">
                <thead class="bg-info">
                    <tr>
                        <th>Nombre del Auxiliar</th>
                        <th>Total hrs</th>
                        <th>Cant. faltas</th>
                        <th>Hrs. Licencia </th>
                        <th>Hrs. baja</th>
                        <th>Horas pagable</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $horasPagablesDeparamento = 0;
                        $horasNoPagablesDeparamento = 0;
                        if(isset($_SESSION['datosReporte'])){
                            $listaDeAuxiliares = $_SESSION['datosReporte'];
                            foreach ($listaDeAuxiliares as $x) {
                                $llave = key($x);
                                echo "<tr>
                                    <td>$llave</td>
                                    <td>".$x[$llave]['horasTotal']." Hrs</td>
                                    <td>".$x[$llave]['faltas']."</td>
                                    <td>".$x[$llave]['horasDeLicencia']." Hrs</td>
                                    <td>".$x[$llave]['licenciaPedidas']." Hrs</td>
                                    <td>".$x[$llave]['horasPagables']." Hrs</td>
                                    <td><a href='reporte_asistencia.php?id=".$x[$llave]['id_auxiliar']."'>Ver detalles</a></td>
                                  </tr>";
                                  $horasPagablesDeparamento = $horasPagablesDeparamento + $x[$llave]['horasPagables'];
                                  $horasNoPagablesDeparamento = $horasNoPagablesDeparamento + $x[$llave]['licenciaPedidas'];
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
            if(isset($_SESSION['datosReporte'])){
                echo "<h6><strong>Total de horas pagables por departamento/mes : </strong>". $horasPagablesDeparamento ." Hrs/mes</h6> ";
                echo "<h6><strong>Total de horas no pagables por departamento/mes : </strong>".$horasNoPagablesDeparamento," Hrs/mes</h6> ";
            }
        ?>
        <hr>
        <form action="getHTMLPDF.php" method="post" target="_blank">
            <div class="text-center">
                <input type="text" name="gestionPlanilla" id="gestionPlanilla" class="d-none">
                <input type="text" name="nomFacultad" id="nomFacultad" class="d-none">
                <input type="text" name="nomDepartamento" id="nomDepartamento" class="d-none">
                <a href="vista_previa_reporte_auxiliar.php">Vista previa</a>
                <input type="submit" class="btn btn-secondary" value="Generar PDF">
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
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
    <!-- <script src="/bower_components/moment/locale/es.js"></script> -->
    <script src="src/reportes_auxiliar_dpa.js"></script>
</body>
</html>
