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
    require_once("../modelo/model_funciones.php");
    require_once("../modelo/model_personal_laboral.php");
    require_once("../modelo/model_tareas_trabajador.php");
    require_once("../modelo/model_trabajador_tareas.php");
    require_once("../modelo/model_clase.php");
    require_once("../modelo/model_materia.php");
    require_once("../modelo/model_enlaces.php");

    $clase ="";
    $metodo = "";
    $tmp = "";
    if(isset($_REQUEST["clase"]) && isset($_REQUEST["metodo"])){
        $clase = $_REQUEST['clase'];
        $metodo = $_REQUEST['metodo'];
        switch($clase){
            case 'Correo':
                $tmp = ejecutarConsultasCorreo();
                break;
            case 'Enlace':
                $tmp = ejecutarConsultasEnlaces();
                break;
            case 'TareasTrabajador':
                $tmp = ejecutarConsultasTareasTrabajador();
                break;
            case 'PersonalLaboral':
                $tmp = ejecutarConsultasPersonalLaboral();
                break;
            case 'Funcionalidad':
                $tmp = ejecutarConsultasFuncionalidades();
                break;
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
            case "Clase":
                $tmp = ejecutarConsultasClase();
                break;
            case "Materia":
                $tmp = ejecutarConsultasMateria();
                break;
            default:
                break;
        }
        echo trim($tmp);
    }
    function ejecutarConsultasCorreo(){
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'enviarCorreoSimple':
                $destino = $_REQUEST['to'];
                $asunto = $_REQUEST['asunto'];
                $descripcion = $_REQUEST['descripcion'];
                $res = require_once("../controlador/formEnviarPassword.php");
                break;
            default:
                # code...
                break;        
        }
        return $res;
    }

    function ejecutarConsultasEnlaces(){
        $enlace = new Enlace();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'obtenerEnlacesClase':
                $idClase = $_REQUEST['idClase'];
                $res = $enlace->obtenerEnlacesClase($idClase);
                break;
        
            default:
                # code...
                break;   
                         
        }
        $enlace->cerrarConexion();
        return $res;
    }


    function ejecutarConsultasMateria(){
        $materia = new Materia();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'listaMateriasPorDepartamento':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $materia->listaMateriasPorDepartamento($idDepartamento);
                break;
            case 'obtenerReporteMes':
                $fechaAntes = $_REQUEST['fechaAntes'];
                $fechaDespues = $_REQUEST['fechaDespues'];
                $idMateria = $_REQUEST['idMateria'];
                $idAuxiliar = $_REQUEST['idAuxiliar'];
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $materia->obtenerReporteMes($idMateria,$idAuxiliar,$fechaAntes,$fechaDespues,$idDepartamento);
                break;
            case 'listaMateriaAuxPizarra':
                $idAuxPizarra = $_REQUEST['idAuxPizarra'];
                $res = $materia->listaMateriaAuxPizarra($idAuxPizarra);
                break;
            case 'obtenerMateriaPorDepartamento':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $fechaInicio = $_REQUEST['fechaInicio'];
                $fechaFinal = $_REQUEST['fechaFinal'];
                $res = $materia->obtenerMateriaPorDepartamento($idDepartamento,$fechaInicio,$fechaFinal);
                break;
        
            default:
                # code...
                break;   
                         
        }
        $materia->cerrarConexion();
        return $res;
    }

    function ejecutarConsultasClase(){
        $clase = new Clase();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'listarClasesDocentesID':
                $idMateria = $_REQUEST['idMateria'];
                $res = $clase->listarClasesDocentesID($idMateria);
                break;
            case 'listarClasesAuxiliaresID':
                $idMateria = $_REQUEST['idMateria'];
                $res = $clase->listarClasesAuxiliaresID($idMateria);
                break;
            case 'listarClasesAuxiliares':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $idFacultad = $_REQUEST['idFacultad'];
                $res = $clase->listarClasesAuxiliares($idFacultad,$idDepartamento);
                break;
            case 'listarClasesDocentes':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $idFacultad = $_REQUEST['idFacultad'];
                $res = $clase->listarClasesDocentes($idFacultad,$idDepartamento);
                break;
            case 'enviarReporteAsistenciaDPA':
                $idClase = $_REQUEST['idClase'];
                $estado = $_REQUEST['estado'];
                $res = $clase->enviarReporteAsistenciaDPA($idClase,$estado);
                break;
            case 'enviarReporteAsistenciaJD':
                $idClase = $_REQUEST['idClase'];
                $estado = $_REQUEST['estado'];
                $res = $clase->enviarReporteAsistenciaJD($idClase,$estado);
                break;
            case 'obtenerAuxliaresPizarra':
                //$idDepartamento = $_REQUEST['idDepartamento'];
                $res = $clase->obtenerAuxliaresPizarra();
                break;
        
            default:
                # code...
                break;   
                         
        }
        $clase->cerrarConexion();
        return $res;
    }

    function ejecutarConsultasAutoridades(){
        $director = new Director();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) { 
            case 'AddRector':
                $nombre = $_REQUEST['nombre'];
                $ci = $_REQUEST['ci'];
                $correo = $_REQUEST['correo']; 
                $tel = $_REQUEST['tel'];
                $pass = $_REQUEST['pass'];
                $res = $director->AddRector($nombre,$ci,$correo,$tel,$pass);    
                break;
            case 'actualizarDirectorRector':
                $codigo = $_REQUEST['codigo'];
                $nombre = $_REQUEST['nombre'];
                $ci = $_REQUEST['ci'];
                $correo = $_REQUEST['correo']; 
                $tel = $_REQUEST['tel'];
                $res = $director->actualizarDirectorRector($codigo,$nombre,$ci,$correo,$tel);    
                break;
            case 'listaRector':
                $res = $director->listaRector();    
                break;
            case 'buscarUsuarioNomCargo':
                $nombre = $_REQUEST['nombre'];
                $cargo = $_REQUEST['cargo'];
                $res = $director->buscarUsuarioNomCargo($nombre,$cargo);    
                break;
            case 'eliminarDirectorDepartamento':
                $codigo_sis_director = $_REQUEST['codigo_sis_director'];
                $res = $director->obtenerDirectorActual($codigo_sis_director);
                $departamento = new Departamento();
                $departamento->retirarAsignacionDirectorDepartamento($res['director_actual']);
                $res = $director->eliminarDirectorAcademico($codigo_sis_director);
            break;
            case 'editarDirectorDepartamento':
                $nombre_director = $_REQUEST['nombre_director'];
                $codigo_sis_director = $_REQUEST['codigo_sis_director'];
                $director_actual = $_REQUEST['director_actual'];
                $telefono_director = $_REQUEST['telefono_director'];
                $correo_director = $_REQUEST['correo_director'];
                $codigo_sis_noModificado = $_REQUEST['codigo_sis_noModificado'];
                $res = $director->obtenerDirectorActual($codigo_sis_noModificado);
                if($director_actual == $res['director_actual']){
                    $res = $director->editarDirectorAcademicoDatosPersonales($nombre_director,$codigo_sis_director,$telefono_director,$correo_director, $codigo_sis_noModificado);
                }else{
                    $departamento = new Departamento();
                    $departamento->retirarAsignacionDirectorDepartamento($res['director_actual']);
                    $departamento->AsignarDirectorDepartamento($nombre_director, $director_actual);
                    $res = $departamento->obtenerIdDepartamentoNomDep($director_actual);
                    $id_departamento = $res['id_departamento'];
                    $res = $director->editarDirectorDepartamento($id_departamento,$nombre_director,$codigo_sis_director,$director_actual,$telefono_director,$correo_director, $codigo_sis_noModificado);
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
            case 'actualizarDirectorAcademico':
                $idDirector = $_REQUEST['idDirector'];
                $nomDirector = $_REQUEST['nomDirector'];
                $codSis = $_REQUEST['codSis'];
                $telDirector = $_REQUEST['telDirector'];
                $correoDirector = $_REQUEST['correoDirector'];
                $nomFacultad= $_REQUEST['nomFacultadAsig'];
                $idFacultad = $_REQUEST['idFacultad'];
                $res = $director->actualizarDirectorAcademico($idDirector,$nomDirector,$codSis,$telDirector,$correoDirector,$nomFacultad,$idFacultad);
                break;
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
                // case 'eliminarDirectorAcademico':
                //     $res = $director->obtenerDirectorActual($_REQUEST['codigo_sis_director']);
                //     $facultad = new Facultad();
                //     $facultad->retirarAsignacionDirectorAcademico($res['director_actual']);
                //     $res = $director->eliminarDirectorAcademico($_REQUEST['codigo_sis_director']);
                //     break;
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
                $res = $director->listarDirectoresDepartamentales($_REQUEST['categoria']);
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
                $idfacDirAcad = $_REQUEST['idfacDirAcad'];
                if(intval($idfacDirAcad) == 666){
                    $res = $director->insertarDirectorAcademico($nomDirAcad,$ciDirAcad,$correoDirAcad,$telDirAcad,$facDirAcad,$sisDirAcad,$passDirAcad,$cargoDirAca);
                }else{
                    $res = $director->insertarDirectorAcademicoFacul($nomDirAcad,$ciDirAcad,$correoDirAcad,$telDirAcad,$facDirAcad,$sisDirAcad,$passDirAcad,$cargoDirAca,$idfacDirAcad);
                }
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
            case 'mostrarFacultades':
                $res = $facultad->mostrarFacultades();
                break;
            case 'cambiarDirectorAcedemicoFacultad':
                $idFacultad = $_REQUEST['idFacultad'];
                $nomDirector = $_REQUEST['nomDirector'];
                $res = $facultad->cambiarDirectorAcedemicoFacultad($idFacultad,$nomDirector);
                break;
            case 'cambiarDirectorNinguno':
                $idFacultad = $_REQUEST['idFacultad'];
                $director = "Ninguno";
                $res = $facultad->cambiarDirectorNinguno($idFacultad,$director);
                break;
            case 'AsignarDirectorFacultad':
                $idFacultad = $_REQUEST['idFacultad'];
                $nomDirector = $_REQUEST['nomDirector'];
                $res = $facultad->AsignarDirectorFacultad($idFacultad,$nomDirector);
                break;
            case 'EditarFacultad':
                $idFacultad = $_REQUEST['idFacultad'];
                $nomEditFacultad = $_REQUEST['nomEditFacultad'];
                $facEditCodigo = $_REQUEST['facEditCodigo'];
                $facEditFechaCrea = $_REQUEST['facEditFechaCrea'];
                $res = $facultad->EditarFacultad($idFacultad,$nomEditFacultad,$facEditCodigo,$facEditFechaCrea);
                break;
            case 'EliminarFacultad':
                $idFacultad = $_REQUEST['idFacultad'];
                $director = new Director();
                $nuevaAsig = 666;
                $nomFacultad = "Ninguno";
                $resultado = $director->actualizarFacultadDirector($idFacultad,$nuevaAsig,$nomFacultad);
                if($resultado){
                    $departamento = new Departamento();
                    $aux = $departamento->eliminarDepartamentosPorFacultad($idFacultad);
                    if($aux){
                        $res = $facultad->EliminarFacultad($idFacultad);
                    }else{
                        $res = $aux;
                    }
                }else{
                    $res = $resultado;
                }
                break;
            case 'listarFacultades':
                $res = $facultad->LeerFacultades();
                break;
            case 'insertarFacultad':
                $nomFacultad = $_REQUEST['nomFacultad'];
                $facCodigo = $_REQUEST['facCodigo'];
                $facFechaCrea = $_REQUEST['fechaCreacion']; //129
                $dirFac = "Ninguno";
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
            case 'mostrarDepartamentos':
                $codigo_dep = $_REQUEST['idFacultad'];
                $res = $departamento->mostrarDepartamentos($codigo_dep);
                break;
            case 'eliminarDepartamento':
                $codigo_dep = $_REQUEST['codigo_dep'];
                $res = $departamento->eliminarDepartamento_acoplado($codigo_dep);
                break;
            case 'editarDepartamento':
                $codigo_dep = $_REQUEST['codigo_dep'];
                $codigo_dep_noModificado = $_REQUEST['codigo_dep_noModificado'];
                $nombre_dep = $_REQUEST['nombre_dep'];    
                $fecha_creacion_departamento = $_REQUEST['fecha_creacion_departamento'];
                $jefe_dep = $_REQUEST['jefe_dep'];
                if($jefe_dep == 'Ninguno'){
                    $departamento->quitarAsignacionDirectorDepartamento($codigo_dep_noModificado);
                    $res = $departamento->obtenerIdDepartamento($codigo_dep_noModificado);
                    $id_departamento = $res['id_departamento'];
                    $director = new Director();
                    $director->quitarAsignacionDirectorDepartamento($id_departamento);
                }
                $res = $departamento->editarDepartamento($codigo_dep_noModificado, $codigo_dep, $nombre_dep, $fecha_creacion_departamento);
                break;
            // case 'eliminarDepartamento':
            //     $codigo_dep = $_REQUEST['codigo_dep'];
            //     $res = $departamento->obtenerIdDepartamento($codigo_dep);
            //     $id_departamento = $res['id_departamento'];
            //     $director = new Director();
            //     $director->quitarAsignacionDirectorDepartamento($id_departamento);
            //     $res = $departamento->eliminarDepartamento($id_departamento);
            //     break;
            // case 'editarDepartamento':
            //     $codigo_dep = $_REQUEST['codigo_dep'];
            //     $codigo_dep_noModificado = $_REQUEST['codigo_dep_noModificado'];
            //     $nombre_dep = $_REQUEST['nombre_dep'];    
            //     $fecha_creacion_departamento = $_REQUEST['fecha_creacion_departamento'];
            //     $jefe_dep = $_REQUEST['jefe_dep'];
            //     if($jefe_dep == 'Ninguno'){
            //         $departamento->quitarAsignacionDirectorDepartamento($codigo_dep_noModificado);
            //         $res = $departamento->obtenerIdDepartamento($codigo_dep_noModificado);
            //         $id_departamento = $res['id_departamento'];
            //         $director = new Director();
            //         $director->quitarAsignacionDirectorDepartamento($id_departamento);
            //     }
            //     $res = $departamento->editarDepartamento($codigo_dep_noModificado, $codigo_dep, $nombre_dep, $fecha_creacion_departamento);
            //     break;
            case 'insertarNuevoDepartamento':
                $ambiente = $_REQUEST['categoria'];
                $nomDep = $_REQUEST['nomDep'];
                $depCod = $_REQUEST['depCod'];
                $depFechaCrea = $_REQUEST['depFechaCrea'];
                $res = $departamento->insertarNuevoDepartamento($nomDep, $depCod, $depFechaCrea, $ambiente);
            case 'listarDepartamentos':
                $ambiente = $_REQUEST['categoria'];
                $res = $departamento->listarDepartamentos($ambiente);
                break;
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
                break;
        }
        $carrera->cerrarConexion();
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
            case 'listaDeAuxiliares':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $auxiliarDocente->listaDeAuxiliares($idDepartamento);
                break;
            case 'obtenerAuxiliarDocente':
                $idAuxiliar = $_REQUEST['idAuxilirDocente'];
                $res = $auxiliarDocente->obtenerAuxiliarDocente($idAuxiliar);
                break;
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
            case 'obtenerReportesLaboratorioSem':
                $fechaInicio = $_REQUEST['fechaInicio'];
                $fechaFinal = $_REQUEST['fechaFinal'];
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $auxiliarLaboratorio->obtenerReportesLaboratorioSem($idDepartamento,$fechaInicio,$fechaFinal);
                break;
            case 'listarHistorialLaboratorio':
                //echo $_REQUEST['idDepartament'];
                $idDepartamento = $_REQUEST['idDepartamento'];
                $res = $auxiliarLaboratorio->listarHistorialLaboratorio($idDepartamento);
                break;
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
            case 'obtenerReporteLaboratorioPorNombreAux':
                $idDepartamento = $_REQUEST['idDepartamento'];
                $idLaboratorio = $_REQUEST['idLaboratorio'];
                $idAuxiliar = $_REQUEST['idAuxiliar'];                
                $res = $horarioLaboratorio->obtenerReporteLaboratorioPorNombreAux($idDepartamento,$idLaboratorio,$idAuxiliar); 
                break;
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

    function  ejecutarConsultasPersonalLaboral(){
        $personalLaboral = new PersonalLaboral();
        $metodo = $_REQUEST['metodo'];
        $res = ""; 
        switch ($metodo) {
            case 'AddPersonalDPA':
                $nombre = $_REQUEST['nombre'];
                $ci = $_REQUEST['ci'];
                $correo = $_REQUEST['correo']; 
                $tel = $_REQUEST['tel'];
                $pass = $_REQUEST['pass'];
                $res = $personalLaboral->AddPersonalDPA($nombre,$ci,$correo,$tel,$pass);
                break;
            case 'AddPersonalUTI':
                $nombre = $_REQUEST['nombre'];
                $ci = $_REQUEST['ci'];
                $correo = $_REQUEST['correo']; 
                $tel = $_REQUEST['tel'];
                $pass = $_REQUEST['pass'];
                $res = $personalLaboral->AddPersonalUTI($nombre,$ci,$correo,$tel,$pass);
                break;
            case 'editarPersonalDPA': 
                $codigo = $_REQUEST['codigo'];
                $nombre = $_REQUEST['nombre'];
                $ci = $_REQUEST['ci'];
                $correo = $_REQUEST['correo']; 
                $tel = $_REQUEST['tel'];
                $res = $personalLaboral->editarPersonalDPA($codigo,$nombre,$ci,$correo,$tel);
                break;
            case 'eliminarPersonalDPA':
                $id = $_REQUEST['clavePrimaria']; 
                $res = $personalLaboral->eliminarPersonalDPA($id);
                break;
            case 'eliminarPersonalUTI':
                $id = $_REQUEST['clavePrimaria'];
                $res = $personalLaboral->eliminarPersonalUTI($id);
                break;
            case 'editarPersonalUTI':
                $codigo = $_REQUEST['codigo'];
                $nombre = $_REQUEST['nombre'];
                $ci = $_REQUEST['ci'];
                $correo = $_REQUEST['correo']; 
                $tel = $_REQUEST['tel'];
                $res = $personalLaboral->editarPersonalUTI($codigo,$nombre,$ci,$correo,$tel);
                break;
            case 'listaDPA':
                $res = $personalLaboral->listaDPA();
                break;
            case 'listaUTI':
                $res = $personalLaboral->listaUTI();
                break;
            case 'ingresarPersonalLaboral':
                $nomTrabajador = $_REQUEST['nombreTrabajador'];
                $ciTrabajador = $_REQUEST['ciTrabajador'];
                $telTrabajador = $_REQUEST['telTrabajador'];
                $correoTrabajador = $_REQUEST['correoTrabajador'];
                $cargo = $_REQUEST['cargoTrabajador'];
                date_default_timezone_set('America/La_Paz');
                $fecha = date("Y-m-d");
                $pass = $_REQUEST['passwordTrabajador'];
                $res = $personalLaboral->ingresarPersonalLaboral($nomTrabajador,$ciTrabajador,$telTrabajador,$correoTrabajador,$cargo,$fecha,$pass);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }

    function ejecutarConsultasFuncionalidades(){
        $funcionalidades = new Funcionalidad();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'mostrarFunciones':
                $cargo = $_REQUEST['cargo'];
                $res = $funcionalidades->mostrarFunciones($cargo);
                break;
            default:
                # code...
                break;
        }
        return $res;
    }

    function  ejecutarConsultasTareasTrabajador(){
        $tareasTrabajador = new TareasTrabajador();
        $metodo = $_REQUEST['metodo'];
        $res = "";
        switch ($metodo) {
            case 'asignarTareasTrab':
                //$cargo = $_REQUEST['cargo'];
                $idTrabajador = $_REQUEST['idTrabajador'];
                $listaFunciones  = array($_REQUEST['funciones']);
                $lista = $listaFunciones[0];
                $arrIdFunciones = array();
                foreach ($lista as $value) {
                    $respuesta = $tareasTrabajador->crearFuncionesTrabajador($value);
                    if(is_numeric($respuesta)){
                        array_push($arrIdFunciones,$respuesta);
                    }else{
                        $res = -1;
                        return $res;
                        break;
                    }
                }
                $trabajadorTareas = new TrabajadorTareas();
                foreach ($arrIdFunciones as $funcion) {
                    $aux = $trabajadorTareas->asignarTareaTrabajador($idTrabajador,$funcion);
                    //var_dump($aux);
                    if(!($aux)){
                        $res = $aux;
                        $res = -1;
                        return $res;
                        break;
                    }
                }
                $res = 1;
                //echo $listaFunciones[0];
                //$res = $funcionalidades->asignarTareasTrab($cargo);
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