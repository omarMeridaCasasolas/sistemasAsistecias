<?php 
    session_start();
    if(isset($_POST['correoAuxLab']) && isset($_POST['passAuxLab']) && isset($_POST['codigoAuxLab'])){
        require_once("../modelo/model_auxiliar_laboratorio.php");
        $correoAuxLab = $_POST['correoAuxLab'];
        $passAuxLab  = $_POST['passAuxLab'];
        $codigoAuxLab = $_POST['codigoAuxLab'];
        $auxLaboratorio = new AuxiliarLaboratorio();
        $respuesta = $auxLaboratorio->verificarAuxiliarLaboratorio($correoAuxLab,$passAuxLab,$codigoAuxLab);
        var_dump($correoAuxLab,$passAuxLab,$codigoAuxLab);
        if(isset($respuesta['nombre_auxiliar_lab'])){
            $_SESSION['nombreAuxLab'] = $respuesta['nombre_auxiliar_lab'];
            $_SESSION['idAuxLab'] = $respuesta['id_aux_labpratorio'];
            $_SESSION['passwordAuxLab'] = $respuesta['passAuxLab'];
            header("Location:../vista/home_auxiliar_docente.php");
        }else{
            var_dump($respuesta);
            header("Location:../index.php?error=auntentificacion&tipo=auxiliar_laboratorio");
        }
    }else{
        echo "error 404";
    }
