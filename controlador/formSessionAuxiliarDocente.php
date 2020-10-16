<?php 
    session_start();
    if(isset($_POST['correoAuxDoc']) && isset($_POST['passAuxDoc']) && isset($_POST['codigoAuxDoc'])){
        require_once("../modelo/model_auxiliar_docente.php");
        $correoAuxDoc = $_POST['correoAuxDoc'];
        $passAuxDoc  = $_POST['passAuxDoc'];
        $codigoAuxDoc = $_POST['codigoAuxDoc'];
        $auxliarDocente = new AuxliarDocente();
        $respuesta = $auxliarDocente->verificarAuxliarDocente($correoAuxDoc,$passAuxDoc,$codigoAuxDoc);
        if(isset($respuesta['nombre_aux_docente'])){
            $_SESSION['nombreAuxDoc'] = $respuesta['nombre_aux_docente'];
            $_SESSION['idAuxDoc'] = $respuesta['id_aux_docente'];
            $_SESSION['passwordAuxDoc'] = $respuesta['password_aux_docente'];
            header("Location:../vista/home_Auxliar_docente.php");
        }else{
            // var_dump($respuesta);
            header("Location:../index.php?error=auntentificacion&tipo=auxiliar_docente");
        }
    }else{
        echo "error 404";
    }