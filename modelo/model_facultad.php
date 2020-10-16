<?php
    require_once("conexion.php");
    class Facultad extends Conexion{
        public function Facultad(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
        public function LeerFacultades(){
            $sql = "SELECT * FROM facultades";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        public function facultadesDisponibles(){
            $sql = "SELECT * FROM facultades WHERE director_academico IS NULL";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
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