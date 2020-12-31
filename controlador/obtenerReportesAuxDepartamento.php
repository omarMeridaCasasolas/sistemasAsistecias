<?php
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
    if(isset($_POST['idFacultadaes']) && isset($_POST['idDepartamentos'])){
        $idFacultad = $_POST['idFacultadaes'];
        $idDepartamentos = $_POST['idDepartamentos'];
        $fechaInicio = $_POST['fechaInicio']; 
        //echo $fechaInicio;
        $fechaFinal = $_POST['fechaFinal']; 
        //echo $fechaFinal;
        require_once("../modelo/model_clase.php");
        $clase = new Clase();
        //$respuesta = $clase->obtenerAuxliaresPizarraArray($idDepartamentos,$fechaInicio,$fechaFinal); 
        //
        require_once("../modelo/model_materia_auxiliar_docente.php");
        $materiaAuxDocente = new MateriaAuxDocente();
        $res = $materiaAuxDocente->listaDeMateriasPorAuxiliar($idDepartamentos);
        //var_dump($res);
        $arrayAuxiliaresDeDocencia = array();
        foreach ($res as $elemento) {
            $listaClases = $clase->obtenerAuxliaresPizarraArrayMateria($elemento['id_materia'],$elemento['id_auxiliar_docente'],$fechaInicio,$fechaFinal); 
            $horasTotal = 0;
            $faltas = 0;
            $licenciaPedidas = 0;
            $horasDeLicencia = 0;
            $horasPagables = 0;
            $x;
            foreach ($listaClases as $x){
                $horasTotal = $horasTotal + 90 ;
                if($x['existe_falta_clase'] == true){
                    $faltas = $faltas +1;
                }
                if($x['existe_falta_clase'] == false){
                    $horasPagables =  $horasPagables + 90;
                }

                if($x['existe_falta_clase'] != null){
                    if($x['clase_con_licencia'] == false){
                        $horasDeLicencia = $horasDeLicencia + 90;
                    }
                    if($x['clase_con_licencia'] == true){
                        $licenciaPedidas =  $licenciaPedidas +90;
                    }
                }else{
                    //$licenciaPedidas =  $licenciaPedidas +90;
                }

            }
            $horasPagables = $horasPagables + $horasDeLicencia;
            if(array_key_exists($x['nombre_aux_docente'],$arrayAuxiliaresDeDocencia)){
                $arrayAuxiliaresDeDocencia['nombre_aux_docente']['horasTotal'] = $arrayAuxiliaresDeDocencia['id_aux_docente']['horasTotal'] + ($horasTotal/60);
                $arrayAuxiliaresDeDocencia['nombre_aux_docente']['faltas'] = $arrayAuxiliaresDeDocencia['id_aux_docente']['faltas'] + $faltas;
                $arrayAuxiliaresDeDocencia['nombre_aux_docente']['horasDeLicencia'] = $arrayAuxiliaresDeDocencia['id_aux_docente']['horasDeLicencia'] + ($horasTotal/60);
                $arrayAuxiliaresDeDocencia['nombre_aux_docente']['licenciaPedidas'] = $arrayAuxiliaresDeDocencia['id_aux_docente']['licenciaPedidas'] + ($licenciaPedidas/60);
                $arrayAuxiliaresDeDocencia['nombre_aux_docente']['horasPagables'] = $arrayAuxiliaresDeDocencia['id_aux_docente']['horasPagables'] + ($horasPagables/60);
            }else{
                $aux = array($x['nombre_aux_docente'] => ['horasTotal' => $horasTotal/60 , 'faltas' => $faltas , 'horasDeLicencia' => $horasDeLicencia/60, 'licenciaPedidas' =>$licenciaPedidas/60,'horasPagables' => $horasPagables/60 ,'id_auxiliar' => $x['id_aux_docente']]);
                array_push($arrayAuxiliaresDeDocencia,$aux);
            } 
        }
        $_SESSION['datosReporte'] = $arrayAuxiliaresDeDocencia;
        header("Location:../vista/reportes_auxiliar_dpa.php?facultad=".$_POST['idFacultadaes']."&departamento=".$_POST['idDepartamentos']);
        
        var_dump($arrayAuxiliaresDeDocencia);
        
    }else{
        echo "No se pudo obtener los datos";
    }