<?php
    if(isset($_POST['nomJefDep'])){
        $nomJefDep = $_POST['nomJefDep'];
        $ciJefDep = $_POST['ciJefDep'];
        $correoJefDep = $_POST['correoJefDep'];
        $telJefDep = $_POST['telJefDep'];
        $depJef = $_POST['depJef'];
        $sisJefDep = $_POST['sisJefDep'];
        $passJefDep = $_POST['passJefDep'];
        $cargoJefDep = "Jefe departamental";
        require_once("../modelo/model_director.php");
        $directorAcademico = new Director();
        $res = $directorAcademico->insertarJefeDepartamento($nomJefDep,$ciJefDep,$correoJefDep,$telJefDep,$depJef,$sisJefDep,$passJefDep,$cargoJefDep);
        var_dump($res);
        if(is_array($res)){
            header("Location:../vista/home_director_academico.php?event=success");
        }else{
            header("Location:../vista/home_director_academico.php?event=danger");
        }
    }else{
        echo "Error 404";
    }