
<?php
//listarTableDocente()
    require_once("conexion.php");
    class AuxiliarLaboratorio extends Conexion{
        public function AuxiliarLaboratorio(){  
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }

        public function listarTableAuxiliarLaboratorio(){
            $sql = "SELECT * FROM auxiliar_laboratorio";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function insertarAuxiliarLaboratorio($nomPersLab,$ciPersLab,$correoPersLab,$telPersLab,$sisPersLab,$passPersLab){
            $sql = "INSERT INTO auxiliar_laboratorio(nombre_auxiliar_lab,ci_auxiliar_lab,correo_auxiliar_lab,telefono_auxiliar_lab,sis_auxiliar_lab,password_auxiliar_lab,activo_auxiliar_lab) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,false)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombre"=>$nomPersLab,":carnet"=>$ciPersLab,":correo"=>$correoPersLab,":tel"=>$telPersLab,":sis"=>$sisPersLab,":pass"=>$passPersLab));
            return $respuesta;
        }

        public function verificarAuxiliarLaboratorio($correoAuxLab,$passAuxLab,$codigoAuxLab){
            $sql = "SELECT * FROM auxiliar_laboratorio WHERE UPPER(correo_auxiliar_lab) = UPPER(:correo) AND password_auxiliar_lab = :pass AND sis_auxiliar_lab = :sis";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":correo"=>$correoAuxLab,":pass"=>$passAuxLab,":sis"=>$codigoAuxLab));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0]; 
        }

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

    }