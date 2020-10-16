<?php
    require_once("conexion.php");
    class Departamento extends Conexion{
        public function Departamento(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
        public function departamentosDisponibles($ambiente){
            $sql = "SELECT * FROM departamento  WHERE director_departamento  IS NULL AND id_facultad = :facultad";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":facultad"=>$ambiente));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }
        
        public function AsignarDirectorDepartamento($nomDirector,$textDirector){
            $sql = "UPDATE departamento SET director_departamento = :nombreDirector WHERE nombre_departamento = :departamento";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombreDirector"=>$nomDirector,":departamento"=>$textDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

    }