<?php
    if(isset($_POST['correoAutoridad'])){
        session_start();
        $correoAutoridad = $_POST['correoAutoridad'];
        $codigoAutoridad = $_POST['codigoAutoridad'];
        $passAutoridad = $_POST['passAutoridad'];
        require_once("../modelo/model_director.php");
        $director = new Director();
        $res = $director->loginAutoridad($correoAutoridad,$codigoAutoridad,$passAutoridad);
        //var_dump($res);
        if($res){
            $_SESSION["codigo_autoridad"] = $res["id_ditector"];
            $_SESSION["cargo"] = $res["cargo_director"];
            var_dump($res['cargo_director']);
            switch ($res['cargo_director']) {
                case 'Rector':
                    header("Location:../vista/home_rector.php");
                    break;
                case 'Director academico':
                    header("Location:../vista/home_director_academico.php");
                    break;
                case 'Jefe departamental':
                    header("Location:../vista/home_jefe_departamental.php");
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
