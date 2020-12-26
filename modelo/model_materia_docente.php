<?php
    require_once("conexion.php");
    class MateriaDocente extends Conexion{
        private $sentenceSQL;
        public function MateriaDocente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        //EN USO
        public function obtenerDocentesAsignados_acoplado($sis_materia){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerDocentesAsignados
            $sql = "SELECT docente.sis_docente, docente.nombre_docente from docente, materia_docente where docente.id_docente = materia_docente.id_docente and materia_docente.id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function obtenerDocentesAsignadosMateriaDocenteAsignadoGrupo_acoplado($sis_materia, $nombre_grupo){
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
            $sql = "SELECT docente.sis_docente, docente.nombre_docente, exists(select 1 
                    from docente_grupo where docente.id_docente=docente_grupo.id_docente 
                    and docente_grupo.id_grupo=:id_grp) from docente, materia_docente where docente.id_docente = materia_docente.id_docente and materia_docente.id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_grp"=>$id_grupo));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

    }