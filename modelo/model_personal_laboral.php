
<?php
//listarTableDocente()
    require_once("conexion.php");
    class PersonalLaboral extends Conexion{
        public function PersonalLaboral(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }

        public function ingresarPersonalLaboral($nomTrabajador,$ciTrabajador,$telTrabajador,$correoTrabajador,$cargo,$fecha,$pass){
            $sql = "INSERT INTO personal_laboral(nombre_trabador,ci_trabajador,tel_trabajador,correo_trabajador,cargo_nom_trab,fecha_cracion_cargo,password_trabajador) VALUES(:nom,:ci,:tel,:correo,:cargo,:fecha,:pass)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomTrabajador,":ci"=>$ciTrabajador,":tel"=>$telTrabajador,":correo"=>$correoTrabajador,"cargo"=>$cargo,":fecha"=>$fecha,":pass"=>$pass));
            if($respuesta == 1 || $respuesta == true){
                $res = $this->connexion_bd->lastInsertId();
                $string = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $res);
                $sentenceSQL->closeCursor();
                return $string;
            }
            $sentenceSQL->closeCursor();
            echo $respuesta;
        }

        public function verificarPersonalLaboral($correo,$pass){
            $sql = "SELECT * FROM personal_laboral WHERE UPPER(correo_trabajador) = UPPER(:correo) AND password_trabajador = :pass";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":correo"=>$correo,":pass"=>$pass));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }

        public function actualizarDatosUTIDPAUrl($id,$correo ,$telefono,$password,$enlace){
            $sql = "UPDATE personal_laboral SET correo_trabajador = :correo, tel_trabajador = :tel, password_trabajador = :pass, foto_trabajador = :enlace WHERE id_personal_laboral = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":correo"=>$correo,":tel"=>$telefono,":pass"=>$password,":enlace"=>$enlace,":id"=>$id));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function actualizarDatosUTIDPA($id,$correo ,$telefono,$password){
            $sql = "UPDATE personal_laboral SET correo_trabajador = :correo, tel_trabajador = :tel, password_trabajador = :pass WHERE id_personal_laboral = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":correo"=>$correo,":tel"=>$telefono,":pass"=>$password,":id"=>$id));
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