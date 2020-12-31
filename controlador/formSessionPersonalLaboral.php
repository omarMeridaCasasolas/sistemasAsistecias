<?php 
    session_start();
    if(isset($_POST['correo']) && isset($_POST['pass'])){
        require_once("../modelo/model_personal_laboral.php");
        require_once("../modelo/model_tareas_trabajador.php");
        $correoDocente = $_POST['correo'];
        $passDocente  = $_POST['pass'];
        $personalLaboral = new PersonalLaboral();
        $tareasTrabajador = new TareasTrabajador();
        $respuesta = $personalLaboral->verificarPersonalLaboral($correoDocente,$passDocente);
        //var_dump($respuesta);
        if($respuesta['unidad'] == "UTI" && $respuesta['cargo_nom_trab'] == "Jefe UTI"){
            $_SESSION['nombreTrabajador'] = $respuesta['nombre_trabador'];
            $_SESSION['idTrabajador'] = $respuesta['id_personal_laboral'];
            $_SESSION['passTrabajador'] = $respuesta['password_trabajador'];
            $_SESSION['cargoTrabajador'] = $respuesta['cargo_nom_trab'];
            $_SESSION['foto_trabajador'] = $respuesta['foto_trabajador'];
            header("Location:../vista/home_uti.php");
        }else{
            if($respuesta['unidad'] == "DPA" && $respuesta['cargo_nom_trab'] == "Jefe DPA"){
                $_SESSION['nombreTrabajador'] = $respuesta['nombre_trabador'];
                $_SESSION['idTrabajador'] = $respuesta['id_personal_laboral'];
                $_SESSION['passTrabajador'] = $respuesta['password_trabajador'];
                $_SESSION['cargoTrabajador'] = $respuesta['cargo_nom_trab'];
                $_SESSION['foto_trabajador'] = $respuesta['foto_trabajador'];
                header("Location:../vista/home_dpa.php");
            }else{
                if(isset($respuesta['nombre_trabador']) && isset($respuesta['cargo_nom_trab'])){
                    $_SESSION['nombreTrabajador'] = $respuesta['nombre_trabador'];
                    $_SESSION['idTrabajador'] = $respuesta['id_personal_laboral'];
                    $_SESSION['passTrabajador'] = $respuesta['password_trabajador'];
                    $_SESSION['cargoTrabajador'] = $respuesta['cargo_nom_trab'];
                    $nombresDeFunciones = $tareasTrabajador->obtenerNombresFunciones($respuesta['id_personal_laboral']);
                    var_dump($nombresDeFunciones);
                    $_SESSION['listaFunciones'] = $nombresDeFunciones;
                    header("Location:../vista/home_trabajador_rector.php");
                }else{
                    var_dump($respuesta);
                    header("Location:../index.php?error=auntentificacion&tipo=docente");
                }
            }
        }

        
    }else{
        echo "error 404";
    }