<?php
    require_once("conexion.php");
    class Director extends Conexion{
        public function Director(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
        public function obtenerDirectorActual($codigo_sis_director){
            $sql = "SELECT director_actual FROM director_unidad WHERE codigo_sis_director=:cod_dir";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":cod_dir"=>$codigo_sis_director));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }
        public function eliminarDirectorAcademico($codigo_sis_director){
            $sql = "DELETE FROM director_unidad WHERE codigo_sis_director=:codigo";     
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":codigo"=>$codigo_sis_director));
            $sentenceSQL->closeCursor();
            $this->cerrarConexion(); 
        }

        public function insertarDirectorDepartamental($nomDirector,$ciDirector,$correoDirector,$telDirector,$asigDirector,$sisDirector,$passDirector,$cargoDirector,$textDirector){
            $sql = "INSERT INTO director_unidad(nombre_director,carnet_director,correo_electronico_director,telefono_director,id_departamento,codigo_sis_director,password_director,cargo_director,director_actual)
            VALUES(:nom,:ci,:correo,:telef,:depar,:sis,:pass,:cargo,:dirActual)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirector,":ci"=>$ciDirector,":correo"=>$correoDirector,":telef"=>$telDirector,":depar"=>$asigDirector,":sis"=>$sisDirector,":pass"=>$passDirector,":cargo"=>$cargoDirector,":dirActual"=>$textDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function listarDirectoresDepartamentales($categoria){
            $sql = "SELECT * from director_unidad inner join departamento on director_unidad.id_departamento = departamento.id_departamento where departamento.id_facultad=:id_fac";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id_fac"=>$categoria));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
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
        
        // public function listarDirectoresDepartamentales($categoria){
        //     $sql = "SELECT * from director_unidad inner join departamento on director_unidad.id_departamento = departamento.id_departamento where departamento.id_facultad=:id_fac";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":id_fac"=>$categoria));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     $this->cerrarConexion();
        //     //$res = json_encode($respuesta);
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }

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

        public function insertarDirectorAcademicoFacul($nomDirAcad,$ciDirAcad,$correoDirAcad,$telDirAcad,$facDirAcad,$sisDirAcad,$passDirAcad,$cargoDirAca,$idfacDirAcad){
            $sql = "INSERT INTO director_unidad(nombre_director,carnet_director,correo_electronico_director,telefono_director,codigo_sis_director,password_director,cargo_director,director_actual,id_facultad)
            VALUES(:nom,:ci,:correo,:telef,:sis,:pass,:cargo,:dir,:idFacultad)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirAcad,":ci"=>$ciDirAcad,":correo"=>$correoDirAcad,":telef"=>$telDirAcad,":sis"=>$sisDirAcad,":pass"=>$passDirAcad,":cargo"=>$cargoDirAca,":dir"=>$facDirAcad,":idFacultad"=>$idfacDirAcad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        public function insertarDirectorAcademico($nomDirAcad,$ciDirAcad,$correoDirAcad,$telDirAcad,$facDirAcad,$sisDirAcad,$passDirAcad,$cargoDirAca){
            $sql = "INSERT INTO director_unidad(nombre_director,carnet_director,correo_electronico_director,telefono_director,codigo_sis_director,password_director,cargo_director,director_actual)
            VALUES(:nom,:ci,:correo,:telef,:sis,:pass,:cargo,:dir)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirAcad,":ci"=>$ciDirAcad,":correo"=>$correoDirAcad,":telef"=>$telDirAcad,":sis"=>$sisDirAcad,":pass"=>$passDirAcad,":cargo"=>$cargoDirAca,":dir"=>$facDirAcad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function editarDirectorDepartamento($id_departamento,$nombre_director,$codigo_sis_director,$director_actual,$telefono_director,$correo_director, $codigo_sis_noModificado){
            $sql = "UPDATE director_unidad SET id_departamento=:id_dep, nombre_director=:nombre, codigo_sis_director=:codigo, director_actual=:facAsig, telefono_director=:telefono, correo_electronico_director=:correo WHERE codigo_sis_director = :codigo_noModificado";       
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":id_dep"=>$id_departamento, ":nombre"=>$nombre_director, ":codigo"=>$codigo_sis_director,":facAsig"=>$director_actual,":telefono"=>$telefono_director,":correo"=>$correo_director, ":codigo_noModificado"=>$codigo_sis_noModificado));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $this->cerrarConexion();

            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        // public function insertarDirectorDepartamental($nomDirector,$ciDirector,$correoDirector,$telDirector,$asigDirector,$sisDirector,$passDirector,$cargoDirector,$textDirector){
        //     $sql = "INSERT INTO director_unidad(nombre_director,carnet_director,correo_electronico_director,telefono_director,id_departamento,codigo_sis_director,password_director,cargo_director,director_actual)
        //     VALUES(:nom,:ci,:correo,:telef,:depar,:sis,:pass,:cargo,:dirActual)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirector,":ci"=>$ciDirector,":correo"=>$correoDirector,":telef"=>$telDirector,":depar"=>$asigDirector,":sis"=>$sisDirector,":pass"=>$passDirector,":cargo"=>$cargoDirector,":dirActual"=>$textDirector));
        //     $sentenceSQL->closeCursor();
        //     return $respuesta;
        // }
        
        
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

    public function actualizarFacultadDirector($idFacultad,$nuevaAsig,$nomFacultad){
        $sql = "UPDATE director_unidad SET director_actual = :facultad, id_facultad = :nuevaAsig  WHERE id_facultad = :idFacultad";
        $sentenceSQL = $this->connexion_bd->prepare($sql);
        $respuesta = $sentenceSQL->execute(array(":facultad"=>$nomFacultad,":nuevaAsig"=>$nuevaAsig,":idFacultad"=>$idFacultad));
        $sentenceSQL->closeCursor();
        return $respuesta;
    }

    public function actualizarDirectorAcademico($idDirector,$nomDirector,$codSis,$telDirector,$correoDirector,$nomFacultad,$idFacultad){
        $sql = "UPDATE director_unidad SET nombre_director = :nom, codigo_sis_director = :sis, correo_electronico_director = :correo ,telefono_director = :telef, director_actual = :dirAct, id_facultad = :idFacultad  WHERE id_ditector = :claveP";
        $sentenceSQL = $this->connexion_bd->prepare($sql);
        $respuesta = $sentenceSQL->execute(array(":nom"=>$nomDirector,":sis"=>$codSis,":correo"=>$correoDirector,":telef"=>$telDirector,":dirAct"=>$nomFacultad,":idFacultad"=>$idFacultad,":claveP"=>$idDirector));
        $sentenceSQL->closeCursor();
        return $respuesta;
    }

    // public function directoresAcademicosDisponibles(){
    //     $sql = "SELECT * FROM director_unidad WHERE cargo_director = 'Director academico' WHERE ";
    //     $sentenceSQL = $this->connexion_bd->prepare($sql);
    //     $sentenceSQL->execute();
    //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
    //     return $respuesta;
    // }

    public function buscarUsuarioNomCargo($nombre,$cargo){
        $sql = "SELECT * FROM director_unidad WHERE cargo_director = :cargo AND nombre_director = :nombre ";
        $sentenceSQL = $this->connexion_bd->prepare($sql);
        $sentenceSQL->execute(array(":cargo"=>$cargo,":nombre"=>$nombre));
        $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        return json_encode($respuesta[0]);
    }

    public function actualizarDatosDirectorUrl($idUsuario,$correo ,$telefono,$password,$enlace){
        $sql = "UPDATE director_unidad SET correo_electronico_director = :correo, password_director = :pass, telefono_director = :telf, user_tmp = :enlace WHERE id_ditector = :id";
        $sentenceSQL = $this->connexion_bd->prepare($sql);
        $respuesta = $sentenceSQL->execute(array(":correo"=>$correo,":pass"=>$password,":telf"=>$telefono,":enlace"=>$enlace,":id"=>$idUsuario));
        $sentenceSQL->closeCursor();
        return $respuesta;
    }

    public function actualizarDatosDirector($idUsuario,$correo ,$telefono,$password){
        $sql = "UPDATE director_unidad SET correo_electronico_director = :correo, password_director = :pass, telefono_director = :telf  WHERE id_ditector = :id";
        $sentenceSQL = $this->connexion_bd->prepare($sql);
        $respuesta = $sentenceSQL->execute(array(":correo"=>$correo,":pass"=>$password,":telf"=>$telefono,":id"=>$idUsuario));
        $sentenceSQL->closeCursor();
        return $respuesta;
    }
} 