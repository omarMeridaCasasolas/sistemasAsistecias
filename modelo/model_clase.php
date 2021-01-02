
<?php
//listarTableDocente()
    require_once("conexion.php");
    class Clase extends Conexion{
        public function Clase(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
    
        public function listarClasesAuxiliaresID($idMateria){
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia 
            INNER JOIN auxiliar_docente ON clase.id_aux_docente = auxiliar_docente.id_aux_docente
            WHERE clase.id_materia = :id AND clase.id_aux_docente is not null";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idMateria));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function listarClasesDocentesID($idMateria){
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia 
            INNER JOIN docente ON clase.id_docente = docente.id_docente
            WHERE clase.id_materia = :id AND clase.id_docente is not null";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idMateria));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }


        public function listarClasesAuxiliares($idFacultad,$idDepartamento){
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia INNER JOIN auxiliar_docente ON clase.id_aux_docente = auxiliar_docente.id_aux_docente
            WHERE clase.id_aux_docente is not null AND clase.id_materia in(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function listarClasesDocentes($idFacultad,$idDepartamento){
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia INNER JOIN docente ON clase.id_docente = docente.id_docente
            WHERE clase.id_docente is not null AND clase.id_materia in(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function enviarReporteAsistenciaDPA($idClase,$estado){
            $sql = "UPDATE clase SET revisado = 'UTI', existe_falta_clase = :estado  WHERE codigo_clase = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":estado"=>$estado,":id"=>$idClase));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        public function obtenerAuxliaresPizarra($idDepartamento,$fechaInicio,$FechaFinal){
            //$sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia WHERE id_aux_docente is not null AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal AND clase.id_materia IN(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia WHERE id_aux_docente is not null 
            AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal
            AND clase.id_materia IN(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento,":fechaInicio"=>$fechaInicio,":fechaFinal"=>$FechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function enviarReporteAsistenciaJD($idClase,$estado){
            $sql = "UPDATE clase SET revisado = 'Jefe Departamento', existe_falta_clase = :estado  WHERE codigo_clase = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":estado"=>$estado,":id"=>$idClase));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function obtenerAuxliaresPizarraArray($idDepartamento,$fechaInicio,$FechaFinal){
            //$sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia WHERE id_aux_docente is not null AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal AND clase.id_materia IN(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia WHERE id_aux_docente is not null 
            AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal
            AND clase.id_materia IN(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento,":fechaInicio"=>$fechaInicio,":fechaFinal"=>$FechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function obtenerClasesAuxPorMes($idDepartamentos,$fechaInicio,$fechaFinal){
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia WHERE id_aux_docente is not null 
            AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal
            AND clase.id_materia IN(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento,":fechaInicio"=>$fechaInicio,":fechaFinal"=>$FechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function obtenerAuxliaresPizarraArrayMateria($idMateria,$idAuxiliar,$fechaInicio,$fechaFinal){
            $sql = "SELECT * FROM clase Cl JOIN auxiliar_docente Ad ON Cl.id_aux_docente = Ad.id_aux_docente  WHERE id_materia = :idMateria AND Cl.id_aux_docente = :idAuxiliar AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":idMateria"=>$idMateria,":idAuxiliar"=>$idAuxiliar,":fechaInicio"=>$fechaInicio,":fechaFinal"=>$fechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function obtenerDocentesArrayMateria($idMateria,$idDocente,$fechaInicio,$fechaFinal){
            $sql = "SELECT * FROM clase Cl INNER JOIN docente doc ON Cl.id_docente = doc.id_docente 
            INNER JOIN materia ON Cl.id_materia = materia.id_materia
             WHERE Cl.id_materia = :idMateria AND Cl.id_docente = :idDocente AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":idMateria"=>$idMateria,":idDocente"=>$idDocente,":fechaInicio"=>$fechaInicio,":fechaFinal"=>$fechaFinal));
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

    }