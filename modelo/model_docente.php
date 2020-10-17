
<?php
//listarTableDocente()
    require_once("conexion.php");
    class Docente extends Conexion{
        public function Docente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }

        public function listarTableDocente(){
            $sql = "SELECT * FROM docente";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function insertarDocente($nombreDocente,$ciDocente,$correoDocente,$telDocente,$sisDocente,$passDocente){
            $sql = "INSERT INTO docente(nombre_docente,carnet_docente,correo_docente,telefono_docente,sis_docente,password_docente,activo_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,false)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombre"=>$nombreDocente,":carnet"=>$ciDocente,":correo"=>$correoDocente,":tel"=>$telDocente,":sis"=>$sisDocente,":pass"=>$passDocente));
            return $respuesta;
        }

        public function verificarDocente($correoDocente,$passDocente,$codigoDocente){
            $sql = "SELECT * FROM docente WHERE UPPER(correo_docente) = UPPER(:correo) AND password_docente = :pass AND sis_docente = :sis";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":correo"=>$correoDocente,":pass"=>$passDocente,":sis"=>$codigoDocente));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0]; 
        }

        public function carrerasDisponibles($ambiente){
            $sql = "SELECT * FROM carrera  WHERE director_carrera IS NULL AND id_departamento = :departamento";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":departamento"=>$ambiente));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }
        
        public function AsignarDirectorCarrera($nomDirector,$textDirector){
            $sql = "UPDATE carrera SET director_carrera = :nombreDirector WHERE nombre_carrera = :departamento";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombreDirector"=>$nomDirector,":departamento"=>$textDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

    }