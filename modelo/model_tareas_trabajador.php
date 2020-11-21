
<?php
//listarTableDocente()
    require_once("conexion.php");
    class TareasTrabajador extends Conexion{
        public function TareasTrabajador(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }

        public  function crearFuncionesTrabajador($nombreFuncion){
            $sql = "INSERT INTO tareas_trabajador(titulo_tarea) VALUES(:nom)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nombreFuncion));
            if($respuesta == 1 || $respuesta == true){
                $res = $this->connexion_bd->lastInsertId();
                //$res = eregi_replace("[\n|\r|\n\r]", ' ', $res);
                $sentenceSQL->closeCursor();
                return $res;
            }
            $sentenceSQL->closeCursor();
            echo $respuesta;
        }

        public  function obtenerNombresFunciones($idTrabajador){
            $sql = "SELECT titulo_tarea FROM tareas_trabajador WHERE id_tarea IN (SELECT id_tarea from trabajador_tareas WHERE id_personal_laboral = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idTrabajador));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        

        // public function ingresarPersonalLaboral($nomTrabajador,$ciTrabajador,$telTrabajador,$correoTrabajador,$cargo,$fecha){
        //     $sql = "INSERT INTO personal_laboral(nombre_trabador,ci_trabajador,tel_trabajador,correo_trabajador,cargo_nom_trab,fecha_cracion_cargo) VALUES(:nom,:ci,:tel,:correo,:cargo,:fecha)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":nom"=>$nomTrabajador,":ci"=>$ciTrabajador,":tel"=>$telTrabajador,":correo"=>$correoTrabajador,"cargo"=>$cargo,":fecha"=>$fecha));
        //     $sentenceSQL->closeCursor();
        //     echo $respuesta;
        // }
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