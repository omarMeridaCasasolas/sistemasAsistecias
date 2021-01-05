<?php
session_start();
ob_start();
date_default_timezone_set("America/La_Paz");
require "../vendor/autoload.php";
require_once("../modelo/model_clase.php");

if(isset($_POST['gestionPlanilla'])){
    $gestionPlanilla = $_POST['gestionPlanilla'];
}else{
    $fecha_actual = date("d-m-Y");
    $gestionPlanilla = date("m-Y",strtotime($fecha_actual."- 1 month"));
}

if(isset($_POST['nomFacultad'])){
    $nomFacultad = $_POST['nomFacultad'];
}else{
    $nomFacultad = "Sin asignar faculad";
}

if(isset($_POST['nomDepartamento'])){
    $nomDepartamento = $_POST['nomDepartamento'];
}else{
    $nomDepartamento = "Sin asignar Departamento";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista previa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/vista_previa_reporte_auxiliarPDF.css">
</head>
<body>
     <div id="contenedorDocuemnto">
         <h2 class="text-center">Universidad Mayor de San Simon</h2>    
         <h3 class="text-center">Planilla de pago por departamento <?php echo $gestionPlanilla;?></h3>
         <h5><?php echo $nomFacultad;?></h5>
         <h5><?php echo $nomDepartamento;?></h5>  
            <table id="tablaMateriaAuxiliares" class="table table-bordered" style="width:95%">
                <thead class="bg-info">
                    <tr>
                        <th>Nombre del Auxiliar</th>
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
                                        <td>$llave</td>
                                        <td>".$x[$llave]['materia']."</td>
                                        <td>".$x[$llave]['horasTotal']." Hrs</td>
                                        <td>".$x[$llave]['faltas']."</td>
                                        <td>".$x[$llave]['horasDeLicencia']." Hrs</td>
                                        <td>".$x[$llave]['licenciaPedidas']." Hrs</td>
                                        <td>".$x[$llave]['horasPagables']." Hrs</td>
                                      </tr>";
                                      $horasPagablesDeparamento = $horasPagablesDeparamento + $x[$llave]['horasPagables'];
                                      $horasNoPagablesDeparamento = $horasNoPagablesDeparamento + $x[$llave]['licenciaPedidas'];
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
            <?php 
            if(isset($_SESSION['datosReporteDocente'])){
                echo "<h6><strong>Total de horas pagables por departamento/mes : </strong>". $horasPagablesDeparamento ." Hrs/mes</h6> ";
                echo "<h6><strong>Total de horas no pagables por departamento/mes : </strong>".$horasNoPagablesDeparamento," Hrs/mes</h6> ";
            }
            ?>
            <br>
            <br>
            <br>
            <br>
         <div class="text-center" style="clear: both;"> 
         <span>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</span>
            <br>
            <span><?php echo $_SESSION['nombreTrabajador'];?></span>
            <br>
            <span>Jefe del DPA</span>
            <h6>Cochabamba-Bolivia</h6>
         </div>
         </div></body></html>
<?php
use Dompdf\Dompdf;
    $dompdf = new DOMPDF();  //if you use namespaces you may use new \DOMPDF()
    $dompdf->setPaper('a4', 'landscape');
    $dompdf->loadHtml(ob_get_clean());
    // ob_get_clean();
    $dompdf->render();
    $dompdf->stream("sample.pdf", array("Attachment"=>0));
?>