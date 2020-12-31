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
    <link rel="stylesheet" href="src/vista_previa_reporte_auxiliar.css">
</head>
<body>
     <div id="contenedorDocuemnto">
         <h2 class="text-center">Universidad Mayor de San Simon</h2>
         <h3 class="text-center">Planilla de pago por departamento Noviembre-2020</h3>
         <h5>Facultad de ciencias y Tecnologia</h5>
         <h5>Departamento de Informactica y Sistemas</h5>  
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
                                  </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div> 
        <hr>
        <?php 
            if(isset($_SESSION['datosReporte'])){
                echo "<h6><strong>Total de horas pagables por departamento/mes : </strong>". $horasPagablesDeparamento ." Hrs/mes</h6> ";
                echo "<h6><strong>Total de horas no pagables por departamento/mes : </strong>".$horasNoPagablesDeparamento,"Hrs/mes</h6> ";
            }
        ?>
            <br>
            <br>
            <br>
         <div class="text-center">
            <span>_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</span>
            <br>
            <span>      Director Academico&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jefe Departamental</span>
            <br>
            <span>   Aqui va el nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aqui va el nombre</span>
         </div>       
     </div>
     <div class="text-center mt-2">
        <a href="getHTMLPDF.php">Imprimir Planillas</a>
     </div>
</body>
</html>