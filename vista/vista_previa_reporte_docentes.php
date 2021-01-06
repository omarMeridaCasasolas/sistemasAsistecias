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
    <title>Vista previa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="src/vista_previa_reporte_auxiliar.css">
</head>
<body class="bg-secondary">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark d-inline-block w-100">
    <img src="<?php echo $_SESSION['foto_trabajador']; ?>" class="rounded" width="75" height="75">
    <h4 class="text-white d-inline-block"><?php echo $_SESSION['cargoTrabajador'].": ".$_SESSION['nombreTrabajador'];?></h4>
    <div class="float-right py-2">
        <a href="home_dpa.php" class="btn btn-primary"><i class="fas fa-home"></i></a>
        <button class="btn btn-primary" data-toggle='modal' data-target='#abrirVtnCorreo'><i class="fas fa-envelope"></i></button>
        <a href="../controlador/formCerrarSession.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
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
            <a class="dropdown-item" href="historial_reportes_uti_docentes.php">Docentes</a>
            <a class="dropdown-item" href="historial_reportes_uti_pizarra.php">Aux. pizarra</a>
            <a class="dropdown-item" href="historial_reportes_uti_laboratorio.php">Aux. Laboratorio</a>
        </div>
        </li>
    </ul>
</nav>
     <div id="contenedorDocuemnto" class="my-1 bg-white">
         <h2 class="text-center">Universidad Mayor de San Simon</h2>
         <h3 class="text-center">Planilla de pago por departamento <?php echo $_GET['fecha'];?></h3>
         <h5><?php echo $_GET['fac'];?></h5>
         <h5><?php echo $_GET['dep'];?></h5>  
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
        <hr>
        <?php 
            if(isset($_SESSION['datosReporteDocente'])){
                echo "<h6><strong>Total de horas pagables por departamento/mes : </strong>". $horasPagablesDeparamento ." Hrs/mes</h6> ";
                echo "<h6><strong>Total de horas no pagables por departamento/mes : </strong>".$horasNoPagablesDeparamento,"Hrs/mes</h6> ";
            }
        ?>
            <br>
            <br>
         <div class="text-center">
            <span>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</span>
            <br>
            <span><?php echo $_SESSION['nombreTrabajador'];?></span>
            <br>
            <span>Jefe del DPA</span>
            <h6>Cochabamba-Bolivia</h6>
         </div>       
     </div>
     <div class="text-center mt-2">
        <form action="getHTMLPDFDocentes.php" method="POST" target="_blank">
            <div class="text-center">
                <input type="text" name="gestionPlanilla" id="gestionPlanilla" class="d-none" value="<?php echo $_GET['fecha']; ?>">
                <input type="text" name="nomFacultad" id="nomFacultad" class="d-none" value="<?php echo $_GET['fac']; ?>">
                <input type="text" name="nomDepartamento" id="nomDepartamento" class="d-none" value="<?php echo $_GET['dep']; ?>">
                <input type="submit" class="btn btn-primary m-2" value="Generar PDF" id="btnSubForm">
            </div>
        </form>
     </div>
</body>
</html>