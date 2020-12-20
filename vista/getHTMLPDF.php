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
         <?php 
            // echo "<table id='tablaMateriaAuxiliares' class='table table-bordered' style='width:95%'>
            // <thead class='bg-info'>
            //     <tr>
            //         <th>Nombre del Auxiliar</th>
            //         <th>Horas Asistidas</th>
            //         <th>Faltas Mensuales</th>
            //         <th>Hrs. Licencia </th>
            //         <th>Hrs. baja</th>
            //         <th>Horas pagable</th>
            //     </tr>
            // </thead>
            // <tbody>";
            //     $clase = new Clase();
            //     $tmp = explode("-",$gestionPlanilla);
            //     $fechaInicio = $tmp[1]."-"$tmp[0]."-"."01";
            //     $fechaFinal = date("Y-m-t", strtotime($fechaInicio));
            //     $listaDeClases = $clase->obtenerAuxliaresPizarraArray($idDepartamento,$fechaInicio,$fechaFinal);
            //     if(count($listaDeClases) == 0){
            //         echo "<tr>
            //                 <td>No tiene Datos</td>
            //                 <td>No tiene Datos</td>
            //                 <td>No tiene Datos</td>
            //                 <td>No tiene Datos</td>
            //                 <td>No tiene Datos</td>
            //                 <td>No tiene Datos</td>
            //             </tr>
            //             </tbody>
            //         </table>
            //         ";
            //     }else{
            //         echo ""
            //         foreach ($listaDeClases as $elemnto) {
            //             echo "<tr>
            //                     <td></td>
            //                     <td></td>
            //                     <td></td>
            //                     <td></td>
            //                     <td></td>
            //                     <td></td>
            //                 </tr>
            //         }
            //     }
            // ";
         ?> 
         <table id="tablaMateriaAuxiliares" class="table table-bordered" style="width:95%">
                <thead class="bg-info">
                    <tr>
                        <th>Nombre del Auxiliar</th>
                        <th>Horas Asistidas</th>
                        <th>Faltas Mensuales</th>
                        <th>Hrs. Licencia </th>
                        <th>Hrs. baja</th>
                        <th>Horas pagable</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                    <tr>
                        <td>Juan perez</td>
                        <td>54 hrs</td>
                        <td>5</td>
                        <td>12 horas</td>
                        <td>10 horas</td>
                        <td>50 hrs</td>
                    </tr>
                </tbody>
            </table>
            <h6><strong>Total de horas pagables por departamento/mes : </strong> 504 Hrs/mes</h6>
            <h6><strong>Total de horas no pagables por departamento/mes : </strong> 100 Hrs/mes</h6>
            <br>
            <br>
            <br>
         <div class="text-center">
            <span>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</span>
            <br>
            <span>Director del DPA</span>
            <br>
            <span>Aqui va el nombre</span>
         </div>       
     </div>
</body>
</html>

<?php
use Dompdf\Dompdf;

//generate some PDFs!
$dompdf = new DOMPDF();  //if you use namespaces you may use new \DOMPDF()
$dompdf->setPaper('a4', 'landscape');
$dompdf->loadHtml(ob_get_clean());
// ob_get_clean();
$dompdf->render();
$dompdf->stream("sample.pdf", array("Attachment"=>0));
?>