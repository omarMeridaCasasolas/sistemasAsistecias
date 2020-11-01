<?php 
    session_start();
    if(isset($_POST['correoAuxLab']) && isset($_POST['passAuxLab'])){
        require_once("../modelo/model_auxiliar_laboratorio.php");
        $correoAuxLab = $_POST['correoAuxLab'];
        $passAuxLab  = $_POST['passAuxLab'];
        // $codigoAuxLab = $_POST['codigoAuxLab'];
        $auxLaboratorio = new AuxiliarLaboratorio();
        $respuesta = $auxLaboratorio->verificarAuxiliarLaboratorio($correoAuxLab,$passAuxLab);
        var_dump($respuesta);
        if($respuesta['nombre_auxiliar_lab']){
            echo "SI";
            $_SESSION['nombreAuxLab'] = $respuesta['nombre_auxiliar_lab'];
            $_SESSION['idAuxLab'] = $respuesta['id_aux_laboratorio'];
            $_SESSION['passwordAuxLab'] =  $passAuxLab;
            header("Location:../vista/home_auxiliar_laboratorio.php");
        }else{
            echo "NO";
            //header("Location:../index.php?error=auntentificacion&tipo=auxiliar_laboratorio");
        }
    }else{
        echo "error 404";
    }
