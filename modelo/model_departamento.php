<?php
    require_once("conexion.php");
    class Departamento extends Conexion{
        private $sentenceSQL;
        public function Departamento(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }
        
        public function obtenerIdDepartamentoNomDep($nombre_dep){
            $sql = "SELECT id_departamento FROM departamento WHERE nombre_departamento=:nom_dep";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":nom_dep"=>$nombre_dep));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }
        
        public function eliminarDepartamento_acoplado($codigo_departamento){
            //ObtenerIdDepartamento
            $sql = "SELECT id_departamento FROM departamento WHERE codigo_departamento=:cod_dep";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":cod_dep"=>$codigo_departamento));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_departamento = ($respuesta[0])['id_departamento'];

            //EliminarDirectorDepartamento
            $sql = "DELETE FROM director_unidad WHERE id_departamento=:id_dep";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id_dep"=>$id_departamento));
            $sentenceSQL->closeCursor();

            //EliminarDepartamento
            $sql = "DELETE FROM departamento WHERE id_departamento=:id_dep";     
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id_dep"=>$id_departamento));
            $sentenceSQL->closeCursor();
        }
        
        public function retirarAsignacionDirectorDepartamento($nombre_dep){
            $sql = "UPDATE departamento SET director_departamento=null WHERE nombre_departamento=:nom_dep";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":nom_dep"=>$nombre_dep));
            $sentenceSQL->closeCursor();
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

        public function eliminarDepartamento($id_departamento){
            $sql = "DELETE FROM departamento WHERE id_departamento=:id_dep";     
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id_dep"=>$id_departamento));
            $sentenceSQL->closeCursor();
            $this->cerrarConexion(); 
        }

        public function eliminarDepartamentosPorFacultad($idFacultad){
            $sql = "DELETE FROM departamento  WHERE id_facultad = :facultad";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":facultad"=>$idFacultad));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function insertarNuevoDepartamento($nomDep, $depCod, $depFechaCrea, $ambiente){
            $sql = "INSERT INTO departamento(id_facultad, nombre_departamento, fecha_creacion_departamento, codigo_departamento)
            VALUES(:id_fac, :nomDep, :fechaCre, :codDep)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id_fac"=>$ambiente,":nomDep"=>$nomDep,":fechaCre"=>$depFechaCrea,":codDep"=>$depCod));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function editarDepartamento($codigo_dep_noModificado, $codigo_dep, $nombre_dep, $fecha_creacion_departamento){
            $sql = "UPDATE departamento SET nombre_departamento=:nom_dep, codigo_departamento=:codigo_dep WHERE codigo_departamento=:codigo_noModificado";       
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":nom_dep"=>$nombre_dep,":codigo_dep"=>$codigo_dep, ":codigo_noModificado"=>$codigo_dep_noModificado));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $this->cerrarConexion();

            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function listarDepartamentos($ambiente){
            $sql = "SELECT * FROM departamento WHERE id_facultad = :id_fac";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id_fac"=>$ambiente));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        //EN USO
        public function obtenerDepartamentoDocente($id_facultad, $id_docente){
            $sql = "SELECT departamento.id_departamento, departamento.nombre_departamento from facultades, departamento, departamento_docente where facultades.id_facultad = departamento.id_facultad and facultades.id_facultad =:id_fac and departamento.id_departamento = departamento_docente.id_departamento and departamento_docente.id_docente =:id_doc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_fac"=>$id_facultad, ":id_doc"=>$id_docente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function obtenerDepartamentoAuxiliarDocente($id_facultad, $id_aux_docente){
            $sql = "SELECT departamento.id_departamento, departamento.nombre_departamento  from facultades, departamento, departamento_auxiliar_docente where facultades.id_facultad = departamento.id_facultad and facultades.id_facultad =:id_fac and departamento.id_departamento = departamento_auxiliar_docente.id_departamento and departamento_auxiliar_docente.id_auxiliar_docente =:id_aux_doc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_fac"=>$id_facultad, ":id_aux_doc"=>$id_aux_docente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }
    }