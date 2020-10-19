<?php
    require_once("conexion.php");
    class Director extends Conexion{
        public function Director(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
        public function loginAutoridad($correo,$codigo,$password){
            $sql = "SELECT * FROM director_unidad WHERE UPPER(correo_electronico_director) = UPPER(:correo) AND codigo_sis_director = :codigo AND password_director = :pass ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":correo"=>$correo,":codigo"=>$codigo,":pass"=>$password));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }
        public function listarDirectoresAcademicos(){
            $sql = "SELECT * FROM director_unidad WHERE cargo_director = 'Director academico'";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $this->cerrarConexion();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        
        public function listarDirectoresDepartamentales(){
            $sql = "SELECT * FROM director_unidad WHERE cargo_director = 'Director departamental'";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $this->cerrarConexion();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function listarTableDirectorCarrera(){
            $sql = "SELECT * FROM director_unidad WHERE cargo_director = 'Director de carrera'";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $this->cerrarConexion();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        public function insertarDirectorAcademico($nomDirAcad,$ciDirAcad,$correoDirAcad,$telDirAcad,$facDirAcad,$sisDirAcad,$passDirAcad,$cargoDirAca){
            $sql = "INSERT INTO director_unidad(nombre_director,carnet_director,correo_electronico_director,telefono_director,codigo_sis_director,password_director,cargo_director)
            VALUES(:nom,:ci,:correo,:telef,:sis,:pass,:cargo)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirAcad,":ci"=>$ciDirAcad,":correo"=>$correoDirAcad,":telef"=>$telDirAcad,":sis"=>$sisDirAcad,":pass"=>$passDirAcad,":cargo"=>$cargoDirAca));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        public function insertarDirectorDepartamental($nomDirector,$ciDirector,$correoDirector,$telDirector,$asigDirector,$sisDirector,$passDirector,$cargoDirector,$textDirector){
            $sql = "INSERT INTO director_unidad(nombre_director,carnet_director,correo_electronico_director,telefono_director,id_departamento,codigo_sis_director,password_director,cargo_director,director_actual)
            VALUES(:nom,:ci,:correo,:telef,:depar,:sis,:pass,:cargo,:dirActual)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirector,":ci"=>$ciDirector,":correo"=>$correoDirector,":telef"=>$telDirector,":depar"=>$asigDirector,":sis"=>$sisDirector,":pass"=>$passDirector,":cargo"=>$cargoDirector,":dirActual"=>$textDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        
        
        public function insertarDirectorCarrera($nomDirector,$ciDirector,$correoDirector,$telDirector,$asigDirector,$sisDirector,$passDirector,$cargoDirector,$textDirector){
            $sql = "INSERT INTO director_unidad(nombre_director,carnet_director,correo_electronico_director,telefono_director,id_carrera,codigo_sis_director,password_director,cargo_director,director_actual)
            VALUES(:nom,:ci,:correo,:telef,:depar,:sis,:pass,:cargo,:dirActual)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirector,":ci"=>$ciDirector,":correo"=>$correoDirector,":telef"=>$telDirector,":depar"=>$asigDirector,":sis"=>$sisDirector,":pass"=>$passDirector,":cargo"=>$cargoDirector,":dirActual"=>$textDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
} 