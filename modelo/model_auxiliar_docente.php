
<?php
//listarTableDocente()
    require_once("conexion.php");
    class AuxliarDocente extends Conexion{
        public function AuxliarDocente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }

        public function listarTableAuxiliarDocente(){
            $sql = "SELECT * FROM auxiliar_docente";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }


        public function verificarAuxliarDocente($correoAuxDoc,$passAuxDoc,$codigoAuxDoc){
            $sql = "SELECT * FROM auxiliar_docente WHERE UPPER(correo_aux_docente) = UPPER(:correo) AND password_aux_docente = :pass AND sis_auxiliar = :sis";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":correo"=>$correoAuxDoc,":pass"=>$passAuxDoc,":sis"=>$codigoAuxDoc));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0]; 
        }
        
        public function insertarAuxiliarDocente($nomAuxiliarDocente,$ciAuxiliarDocente,$correoAuxiliarDocente,$telAuxiliarDocente,$sisAuxiliarDocente,$passAuxiliarDocente){
            $sql = "INSERT INTO auxiliar_docente(nombre_aux_docente,ci_aux_docente,correo_aux_docente,telefono_aux_docente,sis_auxiliar,password_aux_docente,activo_aux_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,false)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombre"=>$nomAuxiliarDocente,":carnet"=>$ciAuxiliarDocente,":correo"=>$correoAuxiliarDocente,":tel"=>$telAuxiliarDocente,":sis"=>$sisAuxiliarDocente,":pass"=>$passAuxiliarDocente));
            return $respuesta;
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