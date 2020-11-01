<?php
    require_once("conexion.php");
    class Director extends Conexion{
        public function Director(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }


        public function recuperarPassword($correo){
            $sql = "SELECT * FROM director_unidad WHERE UPPER(correo_electronico_director) = UPPER(:correo)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":correo"=>$correo));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }

        public function  actualizarAsignacionDirector($idDirector,$carDirector){
            $sql = "UPDATE director_unidad SET director_actual = :dirActual  WHERE id_ditector = :claveP";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":dirActual"=>$carDirector,":claveP"=>$idDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }


        public function actualizarCarreraDeDirector($idDirector,$nomActualizarDirectorCargo,$idCarrera){
            $sql = "UPDATE director_unidad SET id_carrera = :idCarrera, director_actual = :dirActual  WHERE id_ditector = :claveP";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":idCarrera"=>$idCarrera,":dirActual"=>$nomActualizarDirectorCargo,":claveP"=>$idDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function loginAutoridad($correo,$password){
            $sql = "SELECT * FROM director_unidad WHERE UPPER(correo_electronico_director) = UPPER(:correo)  AND password_director = :pass ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":correo"=>$correo,":pass"=>$password));
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

        public function directoresCarreraDisponibles(){
            $sql = "SELECT * FROM director_unidad WHERE cargo_director = 'Director de carrera'";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
            //cerrarConexion();
            //$res = json_encode($respuesta);
            //echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
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

        public function actualizarDirector($clavePrimaria,$nomDirector,$ciDirector,$correoDirector,$telDirector){
            $sql = "UPDATE director_unidad SET nombre_director = :nom, carnet_director = :ci, correo_electronico_director = :correo ,telefono_director = :telef  WHERE id_ditector = :claveP";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirector,":ci"=>$ciDirector,":correo"=>$correoDirector,":telef"=>$telDirector,":claveP"=>$clavePrimaria));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        public function eliminarDirector($clavePrimaria){
            $sql = "DELETE FROM director_unidad  WHERE id_ditector = :claveP";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":claveP"=>$clavePrimaria));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
} 