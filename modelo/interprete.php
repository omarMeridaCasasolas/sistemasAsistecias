<?php
    $metodo = $_GET["method"];
    if($metodo == "listarFacultades"){
        require_once("model_faculdad.php");
        $facultad = new Facultad();
        $res = $facultad->LeerFacultades();
        echo ($res);
        return $res;
    }
?>