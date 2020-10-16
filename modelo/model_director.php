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
            $sql = "SELECT * FROM director_unidad WHERE correo_electronico_director = :correo AND codigo_sis_director = :codigo AND password_director = :pass ";
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

        //metodos porst y get
        /*
        public function createReporte($usuario,$lugar,$pieza,$tiempo,$precio,$descripcionServicio,$calificacion,$nombre,$contacto,$piel,$origen,$edad,$contextura,$rasgosEspecificos,$vista,$fecha){
            $sql = "INSERT INTO reporte(id_usuaria,establecimiento_servicio,pieza_servicio,tiempo_servicio,precio_servicio,valoracion_servicio,descripcion_servicio
            ,nombre_damita, contacto_damita,color_damita,origen_damita,edad_damita,contextura_damita,rasgo_particular,vista_reporte,fecha_reporte) VALUES(:usuario,:establecimiento,:pieza
            ,:tiempo,:precio,:calif,:descServicio,:nombre,:contacto,:piel,:origen,:edad,:contextura,:rasgos,:vista,:fecha)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":usuario"=>$usuario,":establecimiento"=>$lugar,":pieza"=>$pieza,":tiempo"=>$tiempo,":precio"=>$precio,":descServicio"=>$descripcionServicio,":calif"=>$calificacion,":nombre"=>$nombre,
            ":contacto"=>$contacto,":piel"=>$piel,":origen"=>$origen,":edad"=>$edad,":contextura"=>$contextura,":rasgos"=>$rasgosEspecificos,":vista"=>$vista,":fecha"=>$fecha));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function readyTodosReportesPublicosVotacion(){
            $sql = "SELECT * FROM reporte WHERE vista_reporte = 'Publico' ORDER BY puntuacion_global DESC" ;
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $resultado = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $resultado;
        }

        public function readyTodosReportesPublicosEdad(){
            $sql = "SELECT * FROM reporte WHERE vista_reporte = 'Publico' ORDER BY edad_damita asc" ;
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $resultado = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $resultado;
        }

        public function readyTodosReportesPublicosPrecio(){
            $sql = "SELECT * FROM reporte WHERE vista_reporte = 'Publico' ORDER BY precio_servicio asc";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $resultado = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $resultado;
        }
        
        public function readyTodosReportesPublicos(){
            $sql = "SELECT * FROM reporte WHERE vista_reporte = 'Publico'";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $resultado = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $resultado;
        }
        

        public function readyTodosReportesPrivados($idUsuario){
            $sql = "SELECT * FROM reporte WHERE vista_reporte = 'Privado' AND id_usuaria = :idUsuario";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":idUsuario"=>$idUsuario));
            $resultado = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $resultado;
        }
        */
    } 