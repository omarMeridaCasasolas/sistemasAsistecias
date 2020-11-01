<?php
    if(isset($_POST['correoAutoridad'])){
        session_start();
        $correoAutoridad = $_POST['correoAutoridad'];
        $passAutoridad = $_POST['passAutoridad'];
        require_once("../modelo/model_director.php");
        $director = new Director();
        $res = $director->loginAutoridad($correoAutoridad,$passAutoridad);
        //var_dump($res);
        if($res){
            $_SESSION["codigo_autoridad"] = $res["id_ditector"];
            $_SESSION["cargo"] = $res["cargo_director"];
            $_SESSION['nombre_autoridad'] = $res['nombre_director'];
            if(!empty($res['id_facultad'])){
                $_SESSION['categoria_social'] = $res['id_facultad'];
            }else{
                if(!empty($res['id_departamento'])){
                    $_SESSION['categoria_social'] = $res['id_departamento'];
                }else{
                    if(!empty($res['id_carrera'])){
                        $_SESSION['categoria_social'] = $res['id_carrera'];
                    }
                }
            }
            switch ($res['cargo_director']) {
                case 'Rector':
                    header("Location:../vista/home_rector.php");
                    break;
                case 'Director academico':
                    header("Location:../vista/home_director_academico.php");
                    break;
                case 'Director departamental':
                    header("Location:../vista/home_director_departamento.php");
                    break;
                case 'Director de carrera':
                    header("Location:../vista/home_director_carrera.php");
                    break;
                default:
                    # code...
                    break;
            }
        }else{
            header("Location:../index.php?error=auntentificacion&tipo=autoridad");
        }
    }else{
        echo "Error 404";
    }
    ?>
