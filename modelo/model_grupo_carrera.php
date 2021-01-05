<?php
    require_once("conexion.php");
    class GrupoCarrera extends Conexion{
        private $sentenceSQL;
        public function GrupoCarrera(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        public function insertarGrupoCarrera($id_grupo, $id_carrera){
            $sql = "INSERT INTO grupo_carrera(id_grupo, id_carrera)
            VALUES(:id_grp, :id_carrera)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id_grp"=>$id_grupo,":id_carrera"=>$id_carrera));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function obtenerNombresCarrerasGrupo($id_grupo){
            $sql = "SELECT carrera.nombre_carrera FROM grupo_carrera, carrera WHERE grupo_carrera.id_carrera = carrera.id_carrera and grupo_carrera.id_grupo = :id_grp";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id_grp"=>$id_grupo));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function obtenerNombresCarrerasGrupo_acoplado($sis_materia, $nombre_grupo){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtnerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_grp AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_grp"=>$nombre_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo = ($respuesta[0])['id_grupo'];

            //ObtenerCarrerasGrupo
            $sql = "SELECT carrera.nombre_carrera FROM grupo_carrera, carrera WHERE grupo_carrera.id_carrera = carrera.id_carrera and grupo_carrera.id_grupo = :id_grp";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function obtenerCarrerasGrupoMateria_acoplado($sis_materia, $nombre_grupo){
            //ObtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtnerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_grp AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_grp"=>$nombre_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo = ($respuesta[0])['id_grupo'];

            //ObtenerCarrerasGrupoMateria
            $sql = "SELECT materia_carrera.id_carrera, carrera.nombre_carrera, exists(select 1 from grupo_carrera where materia_carrera.id_carrera=grupo_carrera.id_carrera and grupo_carrera.id_grupo=:id_grp) from materia_carrera, carrera where materia_carrera.id_carrera = carrera.id_carrera and materia_carrera.id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }
    }