<?php
    require_once("../modelo/model_director.php");
    require_once("../modelo/model_facultad.php");
    require_once("../modelo/model_departamento.php");
    require_once("../modelo/model_carrera.php");
    require_once("../modelo/model_docente.php");
    require_once("../modelo/model_auxiliar_docente.php");
    require_once("../modelo/model_auxiliar_laboratorio.php");
    $clase ="";
    $metodo = "";
    $tmp = "";
    if(isset($_REQUEST["clase"]) && isset($_REQUEST["metodo"])){
        $clase = $_REQUEST['clase'];
        $metodo = $_REQUEST['metodo'];
        switch($clase){
            case 'AuxiliarLaboratorio':
                $tmp = ejecutarConsultasAuxiliarLaboratorio();
                break;
            case 'AuxiliarDocente':
                $tmp = ejecutarConsultasAuxiliarDocente();
                break;
            case 'Docente':
                $tmp = ejecutarConsultasDocente();
                break;
            case 'Carrera':
                $tmp = ejecutarConsultasCarrera();
                break;
            case 'Departamento':
                $tmp = ejecutarConsultasDepartamento();
                break;
            case 'Director':
                $tmp = ejecutarConsultasAutoridades();
                break;
            case 'Facultad':
                $tmp = ejecutarConsultasFacultad();
                break;
            default:
                break;
        }
        echo $tmp;
    }
    function ejecutarConsultasAutoridades(){
        $director = new Director();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'listarTableDirectorCarrera':
                $res = $director->listarTableDirectorCarrera();
                break;
            case 'listarDirectoresDepartamentales':
                $res = $director->listarDirectoresDepartamentales();
                break;
            case 'insertarDirectorCarrera':
                $nomDirector = $_REQUEST['nomDirector'];
                $ciDirector = $_REQUEST['ciDirector'];
                $correoDirector = $_REQUEST['correoDirector'];
                $telDirector = $_REQUEST['telDirector'];
                $asigDirector = $_REQUEST['asigDirector'];
                $sisDirector = $_REQUEST['sisDirector'];
                $passDirector = $_REQUEST['passDirector'];
                $cargoDirector = "Director de carrera";
                $textDirector = $_REQUEST['textDirector'];
                $res = $director->insertarDirectorCarrera($nomDirector,$ciDirector,$correoDirector,$telDirector,$asigDirector,$sisDirector,$passDirector,$cargoDirector,$textDirector);
                if($res == 1){
                    $carrera = new Carrera();
                    $res = $carrera->AsignarDirectorCarrera($nomDirector,$textDirector);
                }
                break;
            case 'insertarDirectorDepartamental':
                $nomDirector = $_REQUEST['nomDirector'];
                $ciDirector = $_REQUEST['ciDirector'];
                $correoDirector = $_REQUEST['correoDirector'];
                $telDirector = $_REQUEST['telDirector'];
                $asigDirector = $_REQUEST['asigDirector'];
                $sisDirector = $_REQUEST['sisDirector'];
                $passDirector = $_REQUEST['passDirector'];
                $cargoDirector = "Director departamental";
                $textDirector = $_REQUEST['textDirector'];
                $res = $director->insertarDirectorDepartamental($nomDirector,$ciDirector,$correoDirector,$telDirector,$asigDirector,$sisDirector,$passDirector,$cargoDirector,$textDirector);
                if($res == 1){
                    $departamento = new Departamento();
                    $res = $departamento->AsignarDirectorDepartamento($nomDirector,$textDirector);
                }
                break;
            case 'insertarDirectorAcademico':
                $nomDirAcad = $_REQUEST['nomDirAcad'];
                $ciDirAcad = $_REQUEST['ciDirAcad'];
                $correoDirAcad = $_REQUEST['correoDirAcad'];
                $telDirAcad = $_REQUEST['telDirAcad'];
                $facDirAcad = $_REQUEST['facDirAcad'];
                $sisDirAcad = $_REQUEST['sisDirAcad'];
                $passDirAcad = $_REQUEST['passDirAcad'];
                $cargoDirAca = "Director academico";
                $res = $director->insertarDirectorAcademico($nomDirAcad,$ciDirAcad,$correoDirAcad,$telDirAcad,$facDirAcad,$sisDirAcad,$passDirAcad,$cargoDirAca);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
    
    function ejecutarConsultasFacultad(){
        $facultad = new Facultad();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'facultadesDisponibles':
                $res = $facultad->facultadesDisponibles();
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
    function ejecutarConsultasDepartamento(){
        $departamento = new Departamento();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'departamentosDisponibles':
                $ambiente = $_REQUEST['categoria'];
                $res = $departamento->departamentosDisponibles($ambiente);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
    function ejecutarConsultasCarrera(){
        $carrera = new Carrera();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'carreraDisponibles':
                $ambiente = $_REQUEST['categoria'];
                $res = $carrera->carrerasDisponibles($ambiente);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
    function ejecutarConsultasDocente(){
        $docente = new Docente();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'insertarDocente':
                $nomDocente = $_REQUEST['nomDocente'];
                $ciDocente = $_REQUEST['ciDocente'];
                $correoDocente = $_REQUEST['correoDocente'];
                $telDocente = $_REQUEST['telDocente'];
                $sisDocente = $_REQUEST['sisDocente'];
                $passDocente = $_REQUEST['passDocente'];
                $res = $docente->insertarDocente($nomDocente,$ciDocente,$correoDocente,$telDocente,$sisDocente,$passDocente);
                break;
            case 'listarTableDocente':
                $res = $docente->listarTableDocente();
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
    function ejecutarConsultasAuxiliarDocente(){
        $auxiliarDocente = new AuxliarDocente();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'insertarAuxiliarDocente':
                $nomAuxiliarDocente = $_REQUEST['nomAuxiliarDocente'];
                $ciAuxiliarDocente = $_REQUEST['ciAuxiliarDocente'];
                $correoAuxiliarDocente = $_REQUEST['correoAuxiliarDocente'];
                $telAuxiliarDocente = $_REQUEST['telAuxiliarDocente'];
                $sisAuxiliarDocente = $_REQUEST['sisAuxiliarDocente'];
                $passAuxiliarDocente = $_REQUEST['passAuxiliarDocente'];
                $res = $auxiliarDocente->insertarAuxiliarDocente($nomAuxiliarDocente,$ciAuxiliarDocente,$correoAuxiliarDocente,$telAuxiliarDocente,$sisAuxiliarDocente,$passAuxiliarDocente);
                break;
            case 'listarTableAuxiliarDocente':
                $res = $auxiliarDocente->listarTableAuxiliarDocente();
                break;
            default:
                # code...
                break;
        }
        return $res;
    }

    function ejecutarConsultasAuxiliarLaboratorio(){
        $auxiliarLaboratorio = new AuxiliarLaboratorio();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'insertarAuxiliarLaboratorio':
                $nomPersLab = $_REQUEST['nomPersLab'];
                $ciPersLab = $_REQUEST['ciPersLab'];
                $correoPersLab = $_REQUEST['correoPersLab'];
                $telPersLab = $_REQUEST['telPersLab'];
                $sisPersLab = $_REQUEST['sisPersLab'];
                $passPersLab = $_REQUEST['passPersLab'];
                $res = $auxiliarLaboratorio->insertarAuxiliarLaboratorio($nomPersLab,$ciPersLab,$correoPersLab,$telPersLab,$sisPersLab,$passPersLab);
                break;
            case 'listarTableAuxiliarLaboratorio':
                $res = $auxiliarLaboratorio->listarTableAuxiliarLaboratorio();
                break;
            default:
                # code...
                break;
        }
        return $res;
    }
?>