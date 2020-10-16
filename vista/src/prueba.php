<?php
    require_once("../../modelo/model_director.php");
    $director = new Director();
    $res = $director->listarDirectoresAcademicos();
    //var_dump($res);
    echo $res;
