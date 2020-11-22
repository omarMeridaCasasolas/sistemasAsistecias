<?php
    session_start();
    if(isset($_SESSION['nombreAuxLab'])){
        $idAuxiliar = $_SESSION['idAuxLab'];
        require_once('../modelo/model_horario_laboratorio.php');
        $horarioLaboratorio = new HorarioLaboratorio();
        $laboratoriosPorAux = $horarioLaboratorio->listaLaboratoriosAux($idAuxiliar);

        // Nuevo S3    
        require('../vendor/autoload.php');
        $s3 = new Aws\S3\S3Client([
            'version'  => '2006-03-01',
            'region'   => 'us-east-2',
        ]);
        $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
        // NUevo S3

        require_once('../modelo/model_reporte_aux_lab.php');
        $reporteAuxiliarLaboratorio = new ReporteAuxLab();
    }else{
        header("Location:../index.php?error=auntentificacion&tipo=auxiliar_laboratorio");
        // var_dump($_SESSION['nombreAuxLab']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Auxliar de laboratorio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-secondary">
    <header class="bg-dark text-white p-5">
        <h1>Bienvenido Axiliar de laboratorio <?php echo $_SESSION['nombreAuxLab']; ?></h1>
        <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a> 
        <a href="historial_reportes_Laboratorio.php">Historial de reportes</a>
    </header>
    <main class="bg-white mt-4 mx-auto rounded col-lg-8 col-md-12"> 
        <button type="button" class="d-none" data-toggle="modal" data-target="#myModal" id="btnCerrarModal">
            Open modal
        </button>

        <!-- The Modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Reporte</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="../controlador/formActualiazarReporte.php" method="post">
                            <input type="text" name="idRegistro" id="idRegistro" class="d-none">
                            <div class="form-group">
                                <h4>Trabajo hecho durante el dia: </h4>
                                <textarea name="txtDescripcion" id="txtDescripcion" class="form-control" style='resize: none;'></textarea>
                            </div>
                            <div class="form-group">
                                <h4>Agregar observaciones :</h4>
                                <textarea name="txtObservacion" id="txtObservacion" class="form-control" style='resize: none;'></textarea>
                            </div>
                            <span>Enlace anterior : <a href="" target="_blank" id="linkFile">Enlace</a></span>
                            <div class="form-group">
                                <label for="myFile">Subir archivos pdf o img</label>
                                <input type="file" name="myFile" id="myFile" class="form-control">
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary" value="Actualizar">
                                <button type="button" class="btn btn-danger" id="cerrarModal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            $diaSiguiente ="";
            foreach ($laboratoriosPorAux as $elemnto) {
                require_once('../modelo/model_laboratorio.php');
                $laboratorio = new Laboratorio();
                $detallesLaboratorio = $laboratorio->mostarLaboratorio($elemnto['id_laboratorio']);
                echo "<h2>Auxiliar de laboratorio: ".$detallesLaboratorio['nombre_laboratorio']." </h2>";
                $fechaInicio = $elemnto['fecha_inicio_trabajo'];
                $fechaReinicio = $elemnto['fecha_reinicio_reporte'];  //2021-02-20 fecha de reinicio
                //Cambiar a cantidad de dias por laboratorio
                $cantDias = $detallesLaboratorio['dias_trab_sem'];  //5
                var_dump($cantDias);
                if($fechaInicio == $fechaReinicio){
                    $nombreDia = date("l", strtotime($fechaReinicio));
                    $diaSiguiente = date("Y-m-d",strtotime($fechaReinicio."+ 1 days")); 
                    $nombreDiaSiguiente = date("l", strtotime($diaSiguiente));
                    $diasTrabajados = "";
                    echo "<table class='table table-hover'>
                            <thead>
                                <th>Fecha</th>
                                <th>Trabajo hecho</th>
                                <th>Observacion</th>
                                <th>Adjuntar documento</th>
                            </thead><tbody>";
                    if($cantDias == 6){
                        while($nombreDiaSiguiente != "Saturday"){
                            $diasTrabajados = $diasTrabajados." ".$nombreDiaSiguiente;
                            $respuesta = $reporteAuxiliarLaboratorio->reportePorFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                            if(is_numeric($respuesta)){
                                $dila = $reporteAuxiliarLaboratorio->crearReporteDiaFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                                echo "<tr><td>$diaSiguiente</td> 
                                        <td><textarea id='' style='resize: none;' placeholder='Aqui va el trabajo hecho' class='form-control' disabled></textarea></td>
                                        <td><textarea id='' style='resize: none;' placeholder='Aqui va las observaciones' class='form-control' disabled></textarea></td> 
                                        <td><a>Sin Enlace</a></td>
                                        <td><button class='btn btn-primary' ".fechaParaBoton($diaSiguiente)." data-toggle='modal' data-target='#myModal'>Generar</button></td>
                                        </tr>";
                            }else{
                                echo "<tr><td>$diaSiguiente</td> 
                                        <td><textarea id='txt_des_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_des' style='resize: none;' class='form-control' disabled> ".$respuesta['trabajo_lab_hecho']."</textarea></td>
                                        <td><textarea id='txt_obs_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_obs' style='resize: none;' class='form-control' disabled>".$respuesta['obs_reporte_lab']."</textarea></td> 
                                        <td><a id='url_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' href='".$respuesta['doc_reporte_lab']."'>Link</a></td>
                                        <td><button type='button'class='btn btn-primary generarReporte' ".fechaParaBoton($diaSiguiente)." id='btn_generar/".$respuesta['id_reporte_lab']."_".$diaSiguiente."'>Generar</button></td>
                                        </tr>";
                            }    
                            $diaSiguiente = date("Y-m-d",strtotime($diaSiguiente."+ 1 days")); 
                            $nombreDiaSiguiente = date("l", strtotime($diaSiguiente));
                        }
                        echo "</tbody></table>";
                        // $res = $horarioLaboratorio->atualizarFechaReinicio($elemnto['id_horario_laboratorio'],$diaSiguiente);
                        // var_dump($res);
                    }else{
                        while($nombreDiaSiguiente != "Saturday"){
                            if($nombreDiaSiguiente != "Sunday"){
                                $diasTrabajados = $diasTrabajados." ".$nombreDiaSiguiente;
                                $respuesta = $reporteAuxiliarLaboratorio->reportePorFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                                if(is_numeric($respuesta)){
                                    $dila = $reporteAuxiliarLaboratorio->crearReporteDiaFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                                    echo "<tr><td>$diaSiguiente</td> 
                                            <td><textarea id='' style='resize: none;' placeholder='Aqui va el trabajo hecho' class='form-control' disabled></textarea></td>
                                            <td><textarea id='' style='resize: none;' placeholder='Aqui va las observaciones' class='form-control' disabled></textarea></td> 
                                            <td><a>Sin Enlace</a></td>
                                            <td><button class='btn btn-primary' ".fechaParaBoton($diaSiguiente)." data-toggle='modal' data-target='#myModal'>Generar</button></td>
                                            </tr>";
                                }else{
                                    echo "<tr><td>$diaSiguiente</td> 
                                            <td><textarea id='txt_des_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_des' style='resize: none;' class='form-control' disabled> ".$respuesta['trabajo_lab_hecho']."</textarea></td>
                                            <td><textarea id='txt_obs_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_obs' style='resize: none;' class='form-control' disabled>".$respuesta['obs_reporte_lab']."</textarea></td> 
                                            <td><a id='url_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' href='".$respuesta['doc_reporte_lab']."'>Link</a></td>
                                            <td><button type='button'class='btn btn-primary generarReporte' ".fechaParaBoton($diaSiguiente)." id='btn_generar/".$respuesta['id_reporte_lab']."_".$diaSiguiente."'>Generar</button></td>
                                            </tr>";
                                }  
                            }  
                            $diaSiguiente = date("Y-m-d",strtotime($diaSiguiente."+ 1 days")); 
                            $nombreDiaSiguiente = date("l", strtotime($diaSiguiente));
                        }
                        echo "</tbody></table>";
                        // $res = $horarioLaboratorio->atualizarFechaReinicio($elemnto['id_horario_laboratorio'],$diaSiguiente);
                        // var_dump($res);
                    }

                }else{  //2021-02-20 fecha de reinicio
                    $nombreDia = date("l", strtotime($fechaReinicio));  //2021-02-20 dia siguiente
                    $diaSiguiente = date("Y-m-d",strtotime($fechaReinicio."+ 1 days")); //2021-02-21 dia siguiente
                    $nombreDiaSiguiente = date("l", strtotime($diaSiguiente));  //DOmingo
                    $diasTrabajados = "";
                    echo "<table class='table table-hover'>
                            <thead>
                                <th>Fecha</th>
                                <th>Trabajo hecho</th>
                                <th>Observacion</th>
                                <th>Adjuntar documento</th>
                            </thead><tbody>";
                    if($cantDias == 6){
                        while($nombreDiaSiguiente != "Saturday"){
                            $diasTrabajados = $diasTrabajados." ".$nombreDiaSiguiente;
                            echo $diasTrabajados;
                            $respuesta = $reporteAuxiliarLaboratorio->reportePorFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                            //echo $respuesta;
                            if(is_numeric($respuesta)){
                                $dila = $reporteAuxiliarLaboratorio->crearReporteDiaFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                                echo "<tr><td>$diaSiguiente</td> 
                                        <td><textarea id='' style='resize: none;' placeholder='Aqui va el trabajo hecho' class='form-control' disabled></textarea></td>
                                        <td><textarea id='' style='resize: none;' placeholder='Aqui va las observaciones' class='form-control' disabled></textarea></td> 
                                        <td><a>Sin Enlace</a></td>
                                        <td><button class='btn btn-primary' ".fechaParaBoton($diaSiguiente)." data-toggle='modal' data-target='#myModal'>Generar</button></td>
                                        </tr>";
                            }else{
                                echo "<tr><td>$diaSiguiente</td> 
                                        <td><textarea id='txt_des_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_des' style='resize: none;' class='form-control' disabled> ".$respuesta['trabajo_lab_hecho']."</textarea></td>
                                        <td><textarea id='txt_obs_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_obs' style='resize: none;' class='form-control' disabled>".$respuesta['obs_reporte_lab']."</textarea></td> 
                                        <td><a id='url_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' href='".$respuesta['doc_reporte_lab']."'>Link</a></td>
                                        <td><button type='button'class='btn btn-primary generarReporte' ".fechaParaBoton($diaSiguiente)." id='btn_generar/".$respuesta['id_reporte_lab']."_".$diaSiguiente."'>Generar</button></td>
                                        </tr>";
                            }    
                            $diaSiguiente = date("Y-m-d",strtotime($diaSiguiente."+ 1 days")); 
                            $nombreDiaSiguiente = date("l", strtotime($diaSiguiente));
                        }
                        echo "</tbody></table>";
                        // $res = $horarioLaboratorio->atualizarFechaReinicio($elemnto['id_horario_laboratorio'],$diaSiguiente);
                        //var_dump($res);
                    }else{ //cantidad dias es 5
                        while($nombreDiaSiguiente != "Saturday"){
                            if($nombreDiaSiguiente != "Sunday"){
                                $diasTrabajados = $diasTrabajados." ".$nombreDiaSiguiente;
                                $respuesta = $reporteAuxiliarLaboratorio->reportePorFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                                //echo $respuesta;
                                if(is_numeric($respuesta)){
                                    $dila = $reporteAuxiliarLaboratorio->crearReporteDiaFecha($elemnto['id_horario_laboratorio'],$diaSiguiente);
                                    echo "<tr><td>$diaSiguiente</td> 
                                            <td><textarea id='' style='resize: none;' placeholder='Aqui va el trabajo hecho' class='form-control' disabled></textarea></td>
                                            <td><textarea id='' style='resize: none;' placeholder='Aqui va las observaciones' class='form-control' disabled></textarea></td> 
                                            <td><a>Sin Enlace</a></td>
                                            <td><button class='btn btn-primary' ".fechaParaBoton($diaSiguiente)." data-toggle='modal' data-target='#myModal'>Generar</button></td>
                                            </tr>";
                                }else{
                                    echo "<tr><td>$diaSiguiente</td> 
                                            <td><textarea id='txt_des_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_des' style='resize: none;' class='form-control' disabled> ".$respuesta['trabajo_lab_hecho']."</textarea></td>
                                            <td><textarea id='txt_obs_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' name ='txt_obs' style='resize: none;' class='form-control' disabled>".$respuesta['obs_reporte_lab']."</textarea></td> 
                                            <td><a id='url_".$respuesta['id_reporte_lab']."_".$diaSiguiente."' href='".$respuesta['doc_reporte_lab']."'>Link</a></td>
                                            <td><button type='button'class='btn btn-primary generarReporte' ".fechaParaBoton($diaSiguiente)." id='btn_generar/".$respuesta['id_reporte_lab']."_".$diaSiguiente."'>Generar</button></td>
                                            </tr>";
                                }  
                            }  
                            $diaSiguiente = date("Y-m-d",strtotime($diaSiguiente."+ 1 days")); 
                            $nombreDiaSiguiente = date("l", strtotime($diaSiguiente));
                        }
                        echo "</tbody></table>";

                        // if($diaSiguiente)                        
                        // $res = $horarioLaboratorio->atualizarFechaReinicio($elemnto['id_horario_laboratorio'],$diaSiguiente);
                        // var_dump($res);
                    }
                }
                date_default_timezone_set('America/La_Paz');
                $today = date("Y-m-d");
                // echo $today."\n";
                // echo $diaSiguiente."\n";
                if($today>$diaSiguiente){
                    $res = $horarioLaboratorio->atualizarFechaReinicio($elemnto['id_horario_laboratorio'],$diaSiguiente);
                }
            }
        ?>
    </main>

    <footer>
            <h1>S3 upload example</h1>
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                    try {
                    // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                    $upload = $s3->upload($bucket, $_FILES['userfile']['name'], fopen($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');
                    ?>
                    <p>Upload <a href="<?=htmlspecialchars($upload->get('ObjectURL'))?>" target='_blank'>successful</a> :)</p>
                        <?php } catch(Exception $e) { 
                        echo $e;
                    ?>
                    <p>Upload error :(</p>                    
            <?php 
                } 
                    } ?>
                    <h2>Upload a file</h2>
                    <form enctype="multipart/form-data" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                        <input name="userfile" type="file"><input type="submit" value="Upload">
                    </form>        
                <!-- Fin  subir archivos S3   -->
    </footer>    
    <script src="src/home_auxiliar_laboratorio.js"></script>
</body>
</html>


<?php
    function fechaParaBoton($diaSiguiente){
        date_default_timezone_set('America/La_Paz');
        $fechaHoy = date("Y-m-d");
        // echo "Dia ".$diaSiguiente."\n";
        // echo "Hoy ".$fechaHoy."\n";
        if($diaSiguiente>$fechaHoy){
            return "disabled='true'";
        }else{
            return "";
        }
    }
?>