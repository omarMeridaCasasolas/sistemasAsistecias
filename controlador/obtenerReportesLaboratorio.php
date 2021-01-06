<?php
    function verificarKey($clave,$array){
        print_r($array);
    }
    // $arrayName = array(26 => ['nombre'=>'Jhonatan' , 'edad'=>22 ], 27 => ['nombre'=>'Ana' , 'edad'=>17 ] );
    // $arrayName[27];
    // //var_dump($arrayName[27]);
    // //var_dump("\n".array_key_exists("fato",$arrayName));
    // echo "\n";
    // if(array_key_exists(27,$arrayName)){
    //     $arreglo = $arrayName[27];
    //     $tmp= $arreglo['edad'] +1 ;
    //     echo $arrayName[27]['edad'] = $tmp;
    //     print_r($arrayName[27]);
    // }else{
    //     echo "No existe arreglo";
    // }

    //print_r($arrayName);
    session_start();
    //$_SESSION['datosReporteDocente'] ="";
    unset($_SESSION['datosReporteLaboratorio']);
    if(isset($_POST['idFacultadaes']) && isset($_POST['idDepartamentos'])){
        $idFacultad = $_POST['idFacultadaes'];
        $idDepartamentos = $_POST['idDepartamentos'];
        $fechaInicio = $_POST['fechaInicio']; 
        $fechaFinal = $_POST['fechaFinal']; 
        require_once("../modelo/model_horario_laboratorio.php");
        $reporte = new HorarioLaboratorio();
        $res = $reporte->resportesUltimoMes($idDepartamentos,$fechaInicio,$fechaFinal);
        $arrayReportes = array();
        $horasAsistidas = 0;
        $horasTotal = 0;
        $faltas = 0;
        $licenciaPedidas = 0;
        $horasDeLicencia = 0;
        $horasPagables = 0;
        foreach ($res as $x) {
            $horasTotal += 4;
            $variable = (String)$x['Asistido'];
            if($variable === "1"){
                $horasAsistidas += 4;
            }else{
                $faltas+=1;
                $var= (String)$x['sol_licencia'];
                if($var == "1"){
                    $licenciaPedidas+=4;
                }else{
                    $horasDeLicencia+=4;
                }
            }
            $tmp = $x['nombre_auxiliar_lab'];
            if(array_key_exists($tmp,$arrayReportes)){
                $arrayReportes[$tmp]['laboratorio'] = $x['nombre_laboratorio'];
                $arrayReportes[$tmp]['nombre'] = $tmp;
                $arrayReportes[$tmp]['horasTotal'] += $horasTotal;
                $arrayReportes[$tmp]['faltas'] += $faltas;
                $arrayReportes[$tmp]['horasDeLicencia'] +=  $horasDeLicencia;
                $arrayReportes[$tmp]['licenciaPedidas'] +=  $licenciaPedidas;
                $arrayReportes[$tmp]['horasPagables'] += $horasAsistidas + $horasDeLicencia; 
            }else{
                $arrayReportes[$tmp]=['laboratorio' => $x['nombre_laboratorio'],'nombre'=>$tmp,'horasTotal' => $horasTotal , 'faltas' => $faltas , 'horasDeLicencia' => $licenciaPedidas, 'licenciaPedidas' =>$horasDeLicencia,'horasPagables' => $horasAsistidas + $horasDeLicencia];    
            }
            $horasAsistidas = 0;
            $horasTotal = 0;
            $faltas = 0;
            $licenciaPedidas = 0;
            $horasDeLicencia = 0;
            $horasPagables = 0;
        }
        print_r($arrayReportes);
        $_SESSION['datosReporteLaboratorio'] = $arrayReportes;
        header("Location:../vista/reportes_dpa_laboratorio.php?facultad=".$_POST['idFacultadaes']."&departamento=".$_POST['idDepartamentos']);
    }else{
        echo "No se pudo obtener los datos";
    }