<?php
    require_once("conexion.php");
    class Carrera extends Conexion{
        private $sentenceSQL;
        public function Carrera(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        public function actualizarNombreDirectorCarrera($nomDirectorAnterior,$nomDirectorNuevo){
            $sql = "UPDATE carrera SET director_carrera = :nuevo WHERE director_carrera = :antiguo ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nuevo"=>$nomDirectorNuevo,":antiguo"=>$nomDirectorAnterior));
            $res = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $respuesta);
            $sentenceSQL->closeCursor();
            return $res;
        }
        public function actualizarDirectorCarrera($nomDirector){
            $sql = "UPDATE carrera SET director_carrera = 'Ninguno' WHERE director_carrera = :director ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":director"=>$nomDirector));
            $res = preg_replace("/[\r\n|\n|\r]+/", PHP_EOL, $respuesta);
            $sentenceSQL->closeCursor();
            return $res;
        }

        public function  eliminarCarrera($idCarrera){
            $sql = "DELETE FROM carrera  WHERE id_carrera = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta =$sentenceSQL->execute(array(":id"=>$idCarrera));
            // $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            // $res = json_encode($respuesta);
            return $respuesta;
        }
        

        public function editarCarrera($idCarrera,$nomCarrera,$codCarrera,$fecCarrera,$dirCarrera){
            $sql = "UPDATE carrera SET nombre_carrera = :nombre, codigo_carrera = :codigo, fecha_creacion_carrera = :fecha, director_carrera = :director WHERE id_carrera = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombre"=>$nomCarrera,":codigo"=>$codCarrera,":fecha"=>$fecCarrera,":director"=>$dirCarrera,":id"=>$idCarrera));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function editarCarreraDepartamento($idCarrera,$nomCarrera,$codCarrera,$fecCarrera){
            $sql = "UPDATE carrera SET nombre_carrera = :nombre, codigo_carrera = :codigo, fecha_creacion_carrera = :fecha WHERE id_carrera = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombre"=>$nomCarrera,":codigo"=>$codCarrera,":fecha"=>$fecCarrera,":id"=>$idCarrera));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function agregarCarrera($depAgregarCarrera,$nomAgregarCarrera,$codAgregarCarrera,$fecAgregarCarrera){
            $sql = "INSERT INTO  carrera(id_departamento,nombre_carrera,codigo_Carrera,fecha_creacion_carrera,director_carrera) VALUES(:departamento,:nombre,:codigo,:fecha,'Ninguno')";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":departamento"=>$depAgregarCarrera,":nombre"=>$nomAgregarCarrera,":codigo"=>$codAgregarCarrera,":fecha"=>$fecAgregarCarrera));
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            return $respuesta;
        }

        public function carrerasDisponibles($ambiente){
            $sql = "SELECT * FROM carrera  WHERE director_carrera IS NULL OR director_carrera = 'Ninguno' AND id_departamento = :departamento";
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

        public function listarCarrera(){
            $sql = "SELECT c.id_carrera, c.nombre_carrera, codigo_carrera, director_carrera, fecha_creacion_carrera,id_ditector   FROM carrera as c 
            FULL OUTER JOIN director_unidad ON c.id_carrera = director_unidad.id_carrera WHERE c.id_carrera <> 666";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);

            //return $res;
        }

        public function obtenerCarreras(){
            $sql = "SELECT id_carrera, nombre_carrera from carrera where id_carrera not in(666);";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute();
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

    }