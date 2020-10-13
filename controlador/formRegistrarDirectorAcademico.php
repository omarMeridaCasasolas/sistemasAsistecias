<?php
    if(isset($_POST['nomDirAcad'])){
        $nomDirAcad = $_POST['nomDirAcad'];
        $ciDirAcad = $_POST['ciDirAcad'];
        $correoDirAcad = $_POST['correoDirAcad'];
        $telDirAcad = $_POST['telDirAcad'];
        $facDirAcad = $_POST['facDirAcad'];
        $sisDirAcad = $_POST['sisDirAcad'];
        $passDirAcad = $_POST['passDirAcad'];
        $cargoDirAca = "Director academico";
        require_once("../modelo/model_director.php");
        $directorAcademico = new Director();
        $res = $directorAcademico->insertarDirectorAcademico($nomDirAcad,$ciDirAcad,$correoDirAcad,$telDirAcad,$facDirAcad,$sisDirAcad,$passDirAcad,$cargoDirAca);
        var_dump($res);
        if(is_array($res)){
            header("Location:../vista/home_rector.php?event=success");
        }else{
            header("Location:../vista/home_rector.php?event=danger");
        }
    }else{
        echo "Error 404";
    }