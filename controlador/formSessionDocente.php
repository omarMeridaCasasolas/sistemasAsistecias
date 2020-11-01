<?php 
    session_start();
    if(isset($_POST['correoDocente']) && isset($_POST['passDocente'])){
        require_once("../modelo/model_docente.php");
        $correoDocente = $_POST['correoDocente'];
        $passDocente  = $_POST['passDocente'];
        $docente = new Docente();
        $respuesta = $docente->verificarDocente($correoDocente,$passDocente);
        if(isset($respuesta['nombre_docente'])){
            $_SESSION['nombreDocente'] = $respuesta['nombre_docente'];
            $_SESSION['idDocente'] = $respuesta['id_docente'];
            $_SESSION['passwordDocente'] = $respuesta['password_docente'];
            header("Location:../vista/home_docente.php");
        }else{
            // var_dump($respuesta);
            header("Location:../index.php?error=auntentificacion&tipo=docente");
        }
    }else{
        echo "error 404";
    }