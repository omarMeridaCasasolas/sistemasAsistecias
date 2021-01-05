
<?php
//listarTableDocente()
    require_once("conexion.php");
    class MateriaAuxDocente extends Conexion{
        private $sentenceSQL;
        public function MateriaAuxDocente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        public function listaDeMateriasPorAuxiliar($idDepartamentos){
                $sql = "SELECT * FROM materia_auxiliar_docente where id_materia in (select id_materia from materia where id_departamento = :idDepartamento)";
                $sentenceSQL = $this->connexion_bd->prepare($sql);
                $sentenceSQL ->execute(array(":idDepartamento"=>$idDepartamentos));
                $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                $sentenceSQL->closeCursor();
                return $respuesta; 
        }

        public function listaDeMateriasPorDocente($idDepartamentos){
            $sql = "SELECT * FROM materia_docente where id_materia in (select id_materia from materia where id_departamento = :idDepartamento)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":idDepartamento"=>$idDepartamentos));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta; 
       }
        // public function listarTableDocente(){
        //     $sql = "SELECT * FROM docente";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute();
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }

        // public function insertarDocente($nombreDocente,$ciDocente,$correoDocente,$telDocente,$sisDocente,$passDocente){
        //     $sql = "INSERT INTO docente(nombre_docente,carnet_docente,correo_docente,telefono_docente,sis_docente,password_docente,activo_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,false)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":nombre"=>$nombreDocente,":carnet"=>$ciDocente,":correo"=>$correoDocente,":tel"=>$telDocente,":sis"=>$sisDocente,":pass"=>$passDocente));
        //     return $respuesta;
        // }

        // public function verificarDocente($correoDocente,$passDocente){
        //     $sql = "SELECT * FROM docente WHERE UPPER(correo_docente) = UPPER(:correo) AND password_docente = :pass ";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL ->execute(array(":correo"=>$correoDocente,":pass"=>$passDocente));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return $respuesta[0]; 
        // }

        // public function carrerasDisponibles($ambiente){
        //     $sql = "SELECT * FROM carrera  WHERE director_carrera IS NULL AND id_departamento = :departamento";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":departamento"=>$ambiente));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     $res = json_encode($respuesta);
        //     return $res;
        // }
        // public function AsignarDirectorCarrera($nomDirector,$textDirector){
        //     $sql = "UPDATE carrera SET director_carrera = :nombreDirector WHERE nombre_carrera = :departamento";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":nombreDirector"=>$nomDirector,":departamento"=>$textDirector));
        //     $sentenceSQL->closeCursor();
        //     return $respuesta;
        // }

        // public function recuperarPasswordDocente($correo){
        //     $sql = "SELECT * FROM docente WHERE UPPER(correo_docente) = UPPER(:correo)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":correo"=>$correo));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return $respuesta[0];
        // }

        // public function listarReportesDocenteDia($idDocente,$fechaActual){
        //     $sql = "SELECT current_date, grupo_horario.hora, grupo.nombre_grupo, materia.nombre_materia
        //     FROM docente, docente_grupo, grupo, materia, grupo_horario
        //     where docente.id_docente = docente_grupo.id_docente
        //     and docente.id_docente = :id
        //     and docente_grupo.id_grupo = grupo.id_grupo
        //     and grupo.id_grupo = grupo_horario.id_grupo
        //     and grupo.id_materia = materia.id_materia
        //     and grupo_horario.es_aux = false
        //     and grupo_horario.dia = :fecha
        //     order by grupo_horario.hora desc";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":id"=>$idDocente,":fecha"=>$fechaActual));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     //return $respuesta[0];
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }
        
        //ruben
        //EN USO
        public function obtenerAuxiliaresAsignados_acoplado($sis_materia){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerDocentesAsignados
            $sql = "SELECT auxiliar_docente.id_aux_docente, auxiliar_docente.sis_auxiliar, auxiliar_docente.nombre_aux_docente from auxiliar_docente, materia_auxiliar_docente where auxiliar_docente.id_aux_docente = materia_auxiliar_docente.id_auxiliar_docente and materia_auxiliar_docente.id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function obtenerAuxiliaresAsignadosMateriaAuxiliarAsignadoGrupo_acoplado($sis_materia, $nombre_grupo){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_grp AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_grp"=>$nombre_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo =  ($respuesta[0])['id_grupo'];

            //ObtenerDocentesAsignados
            $sql = "SELECT auxiliar_docente.sis_auxiliar, auxiliar_docente.nombre_aux_docente, exists(select 1 from auxiliar_docente_grupo where auxiliar_docente.id_aux_docente=auxiliar_docente_grupo.id_auxiliar_docente and auxiliar_docente_grupo.id_grupo=:id_grp) from auxiliar_docente, materia_auxiliar_docente where auxiliar_docente.id_aux_docente = materia_auxiliar_docente.id_auxiliar_docente and materia_auxiliar_docente.id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_grp"=>$id_grupo));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }
    }