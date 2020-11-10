<?php
    require_once("../modelo/model_director.php");
    require_once("../modelo/model_facultad.php");
    require_once("../modelo/model_departamento.php");
    require_once("../modelo/model_carrera.php");
    require_once("../modelo/model_docente.php");
    require_once("../modelo/model_auxiliar_docente.php");
    require_once("../modelo/model_auxiliar_laboratorio.php");
    require_once("../modelo/model_laboratorio.php");
    require_once("../modelo/model_horario_laboratorio.php");
    
    $clase ="";
    $metodo = "";
    $tmp = "";
    if(isset($_REQUEST["clase"]) && isset($_REQUEST["metodo"])){
        $clase = $_REQUEST['clase'];
        $metodo = $_REQUEST['metodo'];
        switch($clase){
            case 'horarioAuxiliarLaboratorio':
                $tmp = ejecutarConsultasHorarioLab();
                break;
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
            case 'Laboratorio':
                $tmp = ejecutarConsultasLaboratorio();
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
            case 'recuperarPassword':
                $correo = $_REQUEST['correo'];
                $respuesta = $director->recuperarPassword($correo);
                if(is_array($respuesta)){
                    $destino = $respuesta['correo_electronico_director'];
                    $password = $respuesta['password_director'];
                    $res = include_once('../controlador/formEnviarPassword.php');
                    //$res = true;
                }else{
                    $res = 2;
                }
                break;
            case 'actualizarAsignacionDirector':
                $idDirector = $_REQUEST['idDirector'];
                $carDirector = $_REQUEST['carDirector'];
                $res = $director->actualizarAsignacionDirector($idDirector,$carDirector);
                break;
            case 'actualizarCarreraDeDirector':
                $idDirector = $_REQUEST['idDirector'];
                $nomActualizarDirectorCargo = $_REQUEST['nomActualizarDirectorCargo'];
                $idCarrera = $_REQUEST['idCarrera'];
                $res = $director->actualizarCarreraDeDirector($idDirector,$nomActualizarDirectorCargo,$idCarrera);
                break;
            case 'directoresCarreraDisponibles':
                $res = $director->directoresCarreraDisponibles();
                break;
            case 'directoresAcademicosDisponibles':
                $res = $director->directoresAcademicosDisponibles();
                break;
            case 'eliminarDirector':
                $clavePrimaria = $_REQUEST['clavePrimaria'];
                $res = $director->eliminarDirector($clavePrimaria);
                break;
            case 'actualizarDirector':
                $clavePrimaria = $_REQUEST['clavePrimaria'];
                $nomDirector = $_REQUEST['nomDirector'];
                $ciDirector = $_REQUEST['ciDirector'];
                $correoDirector = $_REQUEST['correoDirector'];
                $telDirector = $_REQUEST['telDirector'];
                $res = $director->actualizarDirector($clavePrimaria,$nomDirector,$ciDirector,$correoDirector,$telDirector);
                break;
            case 'listarDirectoresAcademicos':
                $res = $director->listarDirectoresAcademicos();
                break;
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
            case 'EditarFacultad':
                $idFacultad = $_REQUEST['idFacultad'];
                $nomEditFacultad = $_REQUEST['nomEditFacultad'];
                $facEditCodigo = $_REQUEST['facEditCodigo'];
                $facEditFechaCrea = $_REQUEST['facEditFechaCrea'];
                $dirEditFac = $_REQUEST['dirEditFac'];
                $res = $facultad->EditarFacultad($idFacultad,$nomEditFacultad,$facEditCodigo,$facEditFechaCrea,$dirEditFac);
                break;
            case 'EliminarFacultad':
                $idFacultad = $_REQUEST['idFacultad'];
                $res = $facultad->EliminarFacultad($idFacultad);
                break;
            case 'listarFacultades':
                $res = $facultad->LeerFacultades();
                break;
            case 'insertarFacultad':
                $nomFacultad = $_REQUEST['nomFacultad'];
                $facCodigo = $_REQUEST['facCodigo'];
                $facFechaCrea = $_REQUEST['fechaCreacion']; //129
                $dirFac = $_POST['dirFac'];
                $res = $facultad->insertarFacultad($nomFacultad,$facCodigo,$facFechaCrea,$dirFac);
                break;
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
            case 'actualizarNombreDirectorCarrera':
                $nomDirectorAnterior = $_REQUEST['nomDirectorAnterior'];
                $nomDirectorNuevo = $_REQUEST['nomDirectorNuevo'];
                $res = $carrera->actualizarNombreDirectorCarrera($nomDirectorAnterior,$nomDirectorNuevo);
                break;
            case 'actualizarDirectorCarrera':
                $nomDirector = $_REQUEST['nomDirector'];
                $res = $carrera->actualizarDirectorCarrera($nomDirector);
                break;
            case 'editarCarrera':
                $idCarrera = $_REQUEST['idCarrera'];
                $nomCarrera = $_REQUEST['nomCarrera']; 
                $codCarrera = $_REQUEST['codCarrera']; 
                $fecCarrera = $_REQUEST['fecCarrera']; 
                $dirCarrera = $_REQUEST['dirCarrera']; 
                $res = $carrera->editarCarrera($idCarrera,$nomCarrera,$codCarrera,$fecCarrera,$dirCarrera);
                break;
            case 'agregarCarrera':
                $depAgregarCarrera = $_REQUEST['depAgregarCarrera'];
                $nomAgregarCarrera = $_REQUEST['nomAgregarCarrera']; 
                $codAgregarCarrera = $_REQUEST['codAgregarCarrera']; 
                $fecAgregarCarrera = $_REQUEST['fecAgregarCarrera']; 
                $dirAgregarCarrera = $_REQUEST['dirAgregarCarrera']; 
                $res = $carrera->agregarCarrera($depAgregarCarrera,$nomAgregarCarrera,$codAgregarCarrera,$fecAgregarCarrera,$dirAgregarCarrera);
                break;
            case 'eliminarCarrera':
                $idCarrera = $_REQUEST['idCarrera']; 
                $res = $carrera->eliminarCarrera($idCarrera);
                break;
            case 'listarCarrera':
                $res = $carrera->listarCarrera();
                break;
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
            case 'listarReportesDocenteDia':
                $idDocente = $_REQUEST['docente'];
                $fechaActual =  recuperarDia();
                // echo $fechaActual;
                $res = $docente->listarReportesDocenteDia($idDocente,$fechaActual);
                break;
            case 'recuperarPasswordDocente':
                $correo = $_REQUEST['correo'];
                $respuesta = $docente->recuperarPasswordDocente($correo);
                if(is_array($respuesta)){
                    $destino = $respuesta['correo_docente'];
                    $password = $respuesta['password_docente'];
                    $res = include_once('../controlador/formEnviarPassword.php');
                    //$res = true;
                }else{
                    $res = 2;
                }
                break;
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
            case 'recuperarPasswordAuxDoc':
                $correo = $_REQUEST['correo'];
                $respuesta = $auxiliarDocente->recuperarPasswordAuxDoc($correo);
                if(is_array($respuesta)){
                    $destino = $respuesta['correo_aux_docente'];
                    $password = $respuesta['password_aux_docente'];
                    $res = include_once('../controlador/formEnviarPassword.php');
                    //$res = true;
                }else{
                    $res = 2;
                }
                break;
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
            case 'listaCorreosAuxiliarLab':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $auxiliarLaboratorio->listaCorreosAuxiliarLab($idDepartamento);
                break;
            case 'listaDeAuxiliaresLabTrabajando':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $idLaboratorio = $_REQUEST['idLaboratorio'];
                $res = $auxiliarLaboratorio->listaDeAuxiliaresLabTrabajando($idDepartamento,$idLaboratorio);
                break;
            case 'recuperarPasswordAuxLab':
                $correo = $_REQUEST['correo'];
                $respuesta = $auxiliarLaboratorio->recuperarPasswordAuxLab($correo);
                if(is_array($respuesta)){
                    $destino = $respuesta['correo_auxiliar_lab'];
                    $password = $respuesta['password_auxiliar_lab'];
                    $res = include_once('../controlador/formEnviarPassword.php');
                    //$res = true;
                }else{
                    $res = 2;
                }
                break;
            case 'eliminarAuxiliarLaboratorio':
                $clavePrimaria = $_REQUEST['idAuxLaboratorio'];
                $res = $auxiliarLaboratorio->eliminarAuxiliarLaboratorio($clavePrimaria);
                break;
            case 'actualizarAuxiliarLaboratorio':
                $nomAuxLaboratorio = $_REQUEST['nomAuxLaboratorio'];
                $codAuxLaboratorio = $_REQUEST['codAuxLaboratorio'];
                $corAuxLaboratorio = $_REQUEST['corAuxLaboratorio'];
                $telAuxLaboratorio = $_REQUEST['telAuxLaboratorio'];
                $dirAuxLaboratorio = $_REQUEST['dirAuxLaboratorio'];
                $clavePrimaria = $_REQUEST['idAuxLaboratorio'];
                $res = $auxiliarLaboratorio->actualizarAuxiliarLaboratorio($nomAuxLaboratorio,$codAuxLaboratorio,$corAuxLaboratorio,$telAuxLaboratorio,$dirAuxLaboratorio,$clavePrimaria);
                break;
            // case 'insertarAuxiliarLaboratorioFechaInicio':
            //     $nomAuxLaboratorio = $_REQUEST['nomAuxLaboratorio'];
            //     $codAuxLaboratorio = $_REQUEST['codAuxLaboratorio'];
            //     $corAuxLaboratorio = $_REQUEST['corAuxLaboratorio'];
            //     $telAuxLaboratorio = $_REQUEST['telAuxLaboratorio'];
            //     $pasAuxLaboratorio = $_REQUEST['pasAuxLaboratorio'];
            //     $dirAuxLaboratorio = $_REQUEST['dirAuxLaboratorio'];
            //     $idDepartamento = $_REQUEST['idDepartamento'];
            //     $aux = getdate();
            //     $fecha = $aux['year']."-".$aux['mon']."-".$aux['mday'];
            //     $res = $auxiliarLaboratorio->insertarAuxiliarLaboratorio($nomAuxLaboratorio,$codAuxLaboratorio,$corAuxLaboratorio,$telAuxLaboratorio,$pasAuxLaboratorio,$dirAuxLaboratorio,$idDepartamento);
            //     break;
            case 'insertarAuxiliarLaboratorio':
                $nomAuxLaboratorio = $_REQUEST['nomAuxLaboratorio'];
                $codAuxLaboratorio = $_REQUEST['codAuxLaboratorio'];
                $corAuxLaboratorio = $_REQUEST['corAuxLaboratorio'];
                $telAuxLaboratorio = $_REQUEST['telAuxLaboratorio'];
                $pasAuxLaboratorio = $_REQUEST['pasAuxLaboratorio'];
                $dirAuxLaboratorio = $_REQUEST['dirAuxLaboratorio'];
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $auxiliarLaboratorio->insertarAuxiliarLaboratorio($nomAuxLaboratorio,$codAuxLaboratorio,$corAuxLaboratorio,$telAuxLaboratorio,$pasAuxLaboratorio,$dirAuxLaboratorio,$idDepartamento);
                
                break;
            case 'listarTableAuxiliarLaboratorio':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $auxiliarLaboratorio->listarTableAuxiliarLaboratorio($idDepartamento);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }

    function ejecutarConsultasLaboratorio(){
        $laboratorio = new Laboratorio();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'reporteDeLaboratorios':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $laboratorio->reporteDeLaboratorios($idDepartamento);
                break;
            case 'laboratoriosDisponibles':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $laboratorio->laboratoriosDisponibles($idDepartamento);
                break;
            case 'elimarLaboratorio':
                $idLaboratorio = $_REQUEST['idLaboratorio'];
                $res = $laboratorio->elimarLaboratorio($idLaboratorio);
                break;
            case 'editarLaboratorio':
                $nomLaboratorio = $_REQUEST['nomLaboratorio'];
                $codLaboratorio = $_REQUEST['codLaboratorio'];
                $fecLaboratorio = $_REQUEST['fecLaboratorio'];
                $desLaboratorio = $_REQUEST['desLaboratorio'];
                $mesLaboratorio = $_REQUEST['mesLaboratorio'];
                $horLaboratorio = $_REQUEST['horLaboratorio'];
                $idLaboratorio = $_REQUEST['idLaboratorio'];
                $res = $laboratorio->editarLaboratorio($nomLaboratorio,$codLaboratorio,$fecLaboratorio,$desLaboratorio,$mesLaboratorio,$horLaboratorio,$idLaboratorio);
                break;
            case 'agregarLaboratorio':
                $nomLaboratorio = $_REQUEST['nomLaboratorio'];
                $codLaboratorio = $_REQUEST['codLaboratorio'];
                $fecLaboratorio = $_REQUEST['fecLaboratorio'];
                $desLaboratorio = $_REQUEST['desLaboratorio'];
                $mesLaboratorio = $_REQUEST['mesLaboratorio'];
                $horLaboratorio = $_REQUEST['horLaboratorio'];
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $laboratorio->agregarLaboratorio($nomLaboratorio,$codLaboratorio,$fecLaboratorio,$desLaboratorio,$mesLaboratorio,$horLaboratorio,$idDepartamento);
                break;
            case 'listarLaboratorios':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $laboratorio->listarLaboratorios($idDepartamento);
                break;
            default:
                # code...
                break;
        }

        return $res;
    }

    function ejecutarConsultasHorarioLab(){
        $horarioLaboratorio = new HorarioLaboratorio();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'obtenerReporteLaboratorioEspecfico':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $idLaboratorio = $_REQUEST['idLaboratorio'];                
                $res = $horarioLaboratorio->obtenerReporteLaboratorioEspecfico($idDepartamento,$idLaboratorio); 
                break;
            case 'obtenerTodoReporteLaboratorio':
                $idDepartamento = $_REQUEST['idDepartamento'];                
                $res = $horarioLaboratorio->obtenerTodoReporteLaboratorio($idDepartamento); 
                break;

            case 'obtenerReportePorMetria':
                $idAuxiliar = $_REQUEST['idAuxiliarLab'];
                $idLaboratorio = $_REQUEST['idLaboratorio'];                
                $res = $horarioLaboratorio->obtenerReportePorMetria($idAuxiliar,$idLaboratorio); 
                break;
            case 'insertarHorarioLaboratorio':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $idAuxiliar = $_REQUEST['idAuxiliarLaboratorio'];                
                $nombreLaboratorio = $_REQUEST['nombreLaboratorio'];
                $laboratorio = new Laboratorio();
                $idLaboratorio = $laboratorio->mostarIdPorNombreLab($nombreLaboratorio);
                //echo $idLaboratorio['id_laboratorio'];	
                $idLabConvertido = (string)$idLaboratorio['id_laboratorio'];
                date_default_timezone_set('America/La_Paz');
                $fechaInicio = date("Y-m-d");
                // Resultado de ejemplo: 6:33 PM
                $res = $horarioLaboratorio->insertarHorarioLaboratorio($idDepartamento, $idAuxiliar,$idLabConvertido,$fechaInicio); 
                break;
            case 'listaLaboratoriosAsignados':
                $idAuxiliar = $_REQUEST['idAuxiliarLab'];                
                $res = $horarioLaboratorio->listaLaboratoriosAsignados($idAuxiliar); 
                break;
            case 'obtenerReportePorMetria':
                $idAuxiliar = $_REQUEST['idAuxiliarLab'];
                $idLaboratorio = $_REQUEST['idLaboratorio'];                
                $res = $horarioLaboratorio->obtenerReportePorMetria($idAuxiliar,$idLaboratorio); 
                break;
            default:
                # code...
                break;
        }
        return $res;
    }

    function recuperarDia(){
        $nombreDIa ="";
        date_default_timezone_set('America/La_Paz');
        $dia = Date("N");
        switch ($dia) {
            case '1':
                $nombreDIa = "LU";
                break;
            case '2':
                $nombreDIa = "MA";
                break;
            case '3':
                $nombreDIa = "MI";
                break;
            case '4':
                $nombreDIa = "JU";
                break;
            case '5':
                $nombreDIa = "VI";
                break;
            case '6':
                $nombreDIa = "SA";
                break;
            default:
                # code...
                break;
        }
        return $nombreDIa;
    }
?>