<?php
    require_once("conexion.php");
    class GrupoHorario extends Conexion{
        private $sentenceSQL;
        public function GrupoHorario(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        public function insertarGrupoHorarioAuxiliar($id_grupo, $dia, $hora){
            $sql = "INSERT INTO grupo_horario(id_grupo, dia, hora, es_aux)
            VALUES(:id_grp, :dia_grp, :hora_grp, 't')";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id_grp"=>$id_grupo,":dia_grp"=>$dia,":hora_grp"=>$hora));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function insertarGrupoHorarioDocente($id_grupo, $dia, $hora){
            $sql = "INSERT INTO grupo_horario(id_grupo, dia, hora, es_aux)
            VALUES(:id_grp, :dia_grp, :hora_grp, 'f')";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id_grp"=>$id_grupo,":dia_grp"=>$dia,":hora_grp"=>$hora));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function insertarGrupoHorarioArray($id_grupo, $arrayHorarios){
            $numeroFilas = count($arrayHorarios);
            $respuesta = "";
            for($i=0; $i<$numeroFilas; $i++){
                $horario = $arrayHorarios[$i];
                $dia = $horario[0];
                $hora = $horario[1];
                $esAux = $horario[2];

                $sql = "INSERT INTO grupo_horario(id_grupo, dia, hora, es_aux) VALUES(:id_grp, :dia_grp, :hora_grp, :asignacion)";
                $sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $sentenceSQL->execute(array(":id_grp"=>$id_grupo,":dia_grp"=>$dia,":hora_grp"=>$hora,":asignacion"=>$esAux));
            }
            
            $sentenceSQL->closeCursor();
            return $respuesta;
        }   

        public function obtenerHorariosGrupo($id_grupo){
            $sql = "SELECT dia, hora, es_aux FROM grupo_horario WHERE id_grupo=:id_grp";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id_grp"=>$id_grupo));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function obtenerHorariosGrupo_acoplado($sis_materia, $nombre_grupo){
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
            
            //ObtenerHorariosGrupo
            $sql = "SELECT dia, hora, es_aux FROM grupo_horario WHERE id_grupo=:id_grp";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

    }