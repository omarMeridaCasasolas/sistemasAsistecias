<?php
    require_once("../../modelo/model_facultad.php");
    $facultad = new Facultad();
    $res = $facultad->LeerFacultades();
    var_dump($res);
    return $res;
