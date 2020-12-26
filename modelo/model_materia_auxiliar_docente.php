<?php
    require_once("conexion.php");
    class MateriaAuxiliarDocente extends Conexion{
        private $sentenceSQL;
        public function MateriaAuxiliarDocente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        //EN USO
        public function obtenerAuxiliaresAsignados_acoplado($sis_materia){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerDocentesAsignados
            $sql = "SELECT auxiliar_docente.sis_auxiliar, auxiliar_docente.nombre_aux_docente from auxiliar_docente, materia_auxiliar_docente where auxiliar_docente.id_aux_docente = materia_auxiliar_docente.id_auxiliar_docente and materia_auxiliar_docente.id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function obtenerAuxiliaresAsignadosMateriaAuxiliarAsignadoGrupo_acoplado($sis_materia, $nombre_grupo){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_grp AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_grp"=>$nombre_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo =  ($respuesta[0])['id_grupo'];

            //ObtenerDocentesAsignados
            $sql = "SELECT auxiliar_docente.sis_auxiliar, auxiliar_docente.nombre_aux_docente, exists(select 1 from auxiliar_docente_grupo where auxiliar_docente.id_aux_docente=auxiliar_docente_grupo.id_auxiliar_docente and auxiliar_docente_grupo.id_grupo=:id_grp) from auxiliar_docente, materia_auxiliar_docente where auxiliar_docente.id_aux_docente = materia_auxiliar_docente.id_auxiliar_docente and materia_auxiliar_docente.id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_grp"=>$id_grupo));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

    }