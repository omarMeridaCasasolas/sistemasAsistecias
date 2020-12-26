<?php
    require_once("conexion.php");
    class DepartamentoDocente extends Conexion{
        private $sentenceSQL;
        public function DepartamentoDocente(){
            parent::__construct();
        }

        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        //EN USO
    	public function listarDocentesDepartamento($id_departamento){
            $sql = "SELECT docente.sis_docente, docente.nombre_docente, docente.correo_docente, docente.telefono_docente from docente, departamento_docente where docente.id_docente = departamento_docente.id_docente and departamento_docente.id_departamento = :id_dep";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }


    }