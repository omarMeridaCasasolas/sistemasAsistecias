<?php
    require_once("conexion.php");
    class DepartamentoAuxiliarDocente extends Conexion{
        private $sentenceSQL;
        public function DepartamentoAuxiliarDocente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

    	public function listarAuxiliaresDocenciaDepartamento($id_departamento){
            $sql = "SELECT auxiliar_docente.sis_auxiliar, auxiliar_docente.nombre_aux_docente, auxiliar_docente.correo_aux_docente, auxiliar_docente.telefono_aux_docente from auxiliar_docente, departamento_auxiliar_docente where auxiliar_docente.id_aux_docente = departamento_auxiliar_docente.id_auxiliar_docente and departamento_auxiliar_docente.id_departamento = :id_dep";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }


    }