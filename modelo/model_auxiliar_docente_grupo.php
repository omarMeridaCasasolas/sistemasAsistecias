<?php
    require_once("conexion.php");
    class AuxiliarDocenteGrupo extends Conexion{
        private $sentenceSQL;
        public function AuxiliarDocenteGrupo(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        public function insertarAuxiliarGrupoSinAsignar($id_grupo){
            $sql = "INSERT INTO auxiliar_docente_grupo(id_grupo)
            VALUES(:id_grp)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id_grp"=>$id_grupo));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function insertarAuxiliarGrupo($id_auxiliar, $id_grupo){
            $sql = "INSERT INTO auxiliar_docente_grupo(id_auxiliar_docente, id_grupo)
            VALUES(:id_aux, :id_grp)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id_aux"=>$id_auxiliar,":id_grp"=>$id_grupo));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        //EN USO
        public function obtenerAuxiliarAsignado_acoplado($sis_materia, $nom_grupo){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_grp AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_grp"=>$nom_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo =  ($respuesta[0])['id_grupo'];

            //ObtenerAuxiliarAsignado
            $sql = "SELECT auxiliar_docente.sis_auxiliar, auxiliar_docente.nombre_aux_docente from auxiliar_docente, auxiliar_docente_grupo where auxiliar_docente.id_aux_docente = auxiliar_docente_grupo.id_auxiliar_docente and auxiliar_docente_grupo.id_grupo=:id_grp";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }
    }