<?php
    $arrayName = array(26 => ['nombre'=>'Jhonatan' , 'edad'=>22 ], 27 => ['nombre'=>'Ana' , 'edad'=>17 ] );
    $arrayName[27];
    var_dump($arrayName[27]);
    //print_r($arrayName);
    
    // if(isset($_POST['idFacultadaes']) && isset($_POST['idDepartamentos'])){
    //     $idFacultad = $_POST['idFacultadaes'];
    //     $idDepartamentos = $_POST['idDepartamentos'];
    //     $fechaInicio = $_POST['fechaInicio']; 
    //     $fechaFinal = $_POST['fechaFinal']; 
    //     require_once("../modelo/model_clase.php");
    //     $clase = new Clase();
    //     //$respuesta = $clase->obtenerAuxliaresPizarraArray($idDepartamentos,$fechaInicio,$fechaFinal); 
    //     //
    //     require_once("model/model_materia_auxiliar_docente.php");
    //     $materiaAuxDocente = new MateriaAuxDocente();
    //     $res = $materiaAuxDocente->listaDeMateriasPorAuxiliar($idDepartamentos);
    //     $arrayAuxiliaresDeDocencia = array();
    //     foreach ($materiaAuxDocente as $elemento) {
    //         $listaClases = $clase->obtenerAuxliaresPizarraArray($elemento['id_materia'],$elemento['id_auxiliar_docente'],$fechaInicio,$fechaFinal); 
    //         foreach ($listaClases as $x){
    //             if($x['id_aux_docente']  )
    //         }
    //     }
    //     var_dump($respuesta);
    // }else{
    //     echo "No se pudo obtener los datos";
    // }