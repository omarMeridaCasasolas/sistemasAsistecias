<?php
    require_once("conexion.php");
    class Facultad extends Conexion{
        public function Facultad(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
        public function EditarFacultad($idFacultad,$nomEditFacultad,$facEditCodigo,$facEditFechaCrea){
            $sql = "UPDATE facultades SET nombre_facultad = :nombre ,codigo_facultad = :codigo,fecha_creacion = :fecha WHERE id_facultad = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":nombre"=>$nomEditFacultad,":codigo"=>$facEditCodigo,":fecha"=>$facEditFechaCrea,":id"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        public function EliminarFacultad($idFacultad){
            $sql = "DELETE FROM facultades WHERE id_facultad = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":id"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        public function LeerFacultades(){
            $sql = "SELECT * FROM facultades WHERE UPPER(codigo_facultad) <> UPPER('Ninguno') ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
            //return $res;
        }

        public function facultadesDisponibles(){
            $sql = "SELECT * FROM facultades WHERE director_academico IS NULL or director_academico = 'Ninguno'";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        public function insertarFacultad($nomFacultad,$facCodigo,$facFechaCrea,$dirFac){
            $sql = "INSERT INTO facultades(nombre_facultad,fecha_creacion,codigo_facultad,director_academico) VALUES(:nameFacultad,:fecha,:codigo,:director)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $res = $sentenceSQL->execute(array(":nameFacultad"=>$nomFacultad,":fecha"=>$facFechaCrea,":codigo"=>$facCodigo,":director"=>$dirFac));
            //$respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            return $res;
        }

        public function AsignarDirectorFacultad($idFacultad,$nomDirector){
            $sql = "UPDATE facultades SET director_academico = :director WHERE id_facultad = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":director"=>$nomDirector,":id"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function cambiarDirectorNinguno($idFacultad,$director){
            $sql = "UPDATE facultades SET director_academico = :director WHERE id_facultad = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":director"=>$director,":id"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function cambiarDirectorAcedemicoFacultad($idFacultad,$nomDirector){
            $sql = "UPDATE facultades SET director_academico = :director WHERE id_facultad = :idFacultad";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL-> execute(array(":director"=>$nomDirector,":idFacultad"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function obtenerCodigoFacultad($id_facultad){
            $sql = "SELECT codigo_facultad FROM facultades WHERE id_facultad=:id_fac";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id_fac"=>$id_facultad));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            //echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
            return $res;
        }
    } 