<?php
    require_once("conexion.php");
    class HorarioLaboratorio extends Conexion{
        public function HorarioLaboratorio(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
        
        public function insertarHorarioLaboratorio($idDepartamento, $idAuxiliar,$idLaboratorio,$fechaInicio){
            $sql = "INSERT INTO horario_laboratorio(id_departamento,id_aux_laboratorio,id_laboratorio,fecha_inicio_trabajo,fecha_reinicio_reporte) VALUES(:idDepartamento, :idAuxiliar, :idLaboratorio, :fecha_inicio ,:fecha_reinicio)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":idDepartamento"=>$idDepartamento,":idAuxiliar"=>$idAuxiliar,":idLaboratorio"=>$idLaboratorio,":fecha_inicio"=>$fechaInicio,":fecha_reinicio"=>$fechaInicio));
            $sentenceSQL->closeCursor();
            // $res = json_encode($respuesta);
            return $respuesta;
        }

        public function listaLaboratoriosAux($idAuxiliar){
            $sql = "SELECT * FROM horario_laboratorio WHERE id_aux_laboratorio= :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idAuxiliar));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        
        public function atualizarFechaReinicio($id,$date){
            $sql = "UPDATE horario_laboratorio SET fecha_reinicio_reporte = :fecha  WHERE id_horario_laboratorio = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id"=>$id,":fecha"=>$date));
            $sentenceSQL->closeCursor();
            // $res = json_encode($respuesta);
            return $respuesta;
        }

        public function listaLaboratoriosAsignados($idAuxiliar){
            $sql = "SELECT * FROM laboratorio WHERE id_laboratorio IN (SELECT id_laboratorio FROM horario_laboratorio WHERE id_aux_laboratorio = :id )";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idAuxiliar));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function obtenerReportePorMetria($idAuxiliar,$idLaboratorio){
            $sql = "SELECT * FROM reporte_aux_lab WHERE id_horario_laboratorio IN (SELECT id_horario_laboratorio FROM horario_laboratorio WHERE id_aux_laboratorio = :idAuxiliar AND id_laboratorio = :idLaboratorio)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":idAuxiliar"=>$idAuxiliar,":idLaboratorio"=>$idLaboratorio));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function obtenerTodoReporteLaboratorio($idDepartamento){
            $sql = "SELECT hl.id_horario_laboratorio, fecha_reporte_lab, nombre_Laboratorio, nombre_auxiliar_lab, trabajo_lab_hecho, obs_reporte_lab, doc_reporte_lab FROM  horario_laboratorio hl INNER JOIN laboratorio l 
            ON hl.id_laboratorio = l.id_laboratorio INNER JOIN auxiliar_laboratorio al ON hl.id_aux_laboratorio = al.id_aux_laboratorio INNER JOIN reporte_aux_lab ral ON ral.id_horario_laboratorio = hl.id_horario_laboratorio WHERE hl.id_departamento = :idDepartamento ORDER BY fecha_reporte_lab DESC";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":idDepartamento"=>$idDepartamento));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        
        public function obtenerReporteLaboratorioEspecfico($idDepartamento,$idLaboratorio){
            $sql = "SELECT hl.id_horario_laboratorio, fecha_reporte_lab, nombre_Laboratorio, nombre_auxiliar_lab, trabajo_lab_hecho, obs_reporte_lab, doc_reporte_lab FROM  horario_laboratorio hl INNER JOIN laboratorio l 
            ON hl.id_laboratorio = l.id_laboratorio INNER JOIN auxiliar_laboratorio al ON hl.id_aux_laboratorio = al.id_aux_laboratorio INNER JOIN reporte_aux_lab ral ON ral.id_horario_laboratorio = hl.id_horario_laboratorio WHERE hl.id_departamento = :idDepartamento AND hl.id_laboratorio = :idLaboratorio ORDER BY fecha_reporte_lab DESC";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":idDepartamento"=>$idDepartamento,":idLaboratorio"=>$idLaboratorio));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function obtenerReporteLaboratorioPorNombreAux($idDepartamento,$idLaboratorio,$idAuxiliar){
            $sql = "SELECT hl.id_horario_laboratorio, fecha_reporte_lab, nombre_Laboratorio, nombre_auxiliar_lab, trabajo_lab_hecho, obs_reporte_lab, doc_reporte_lab FROM  horario_laboratorio hl INNER JOIN laboratorio l 
            ON hl.id_laboratorio = l.id_laboratorio INNER JOIN auxiliar_laboratorio al ON hl.id_aux_laboratorio = al.id_aux_laboratorio INNER JOIN reporte_aux_lab ral ON ral.id_horario_laboratorio = hl.id_horario_laboratorio WHERE hl.id_departamento = :idDepartamento AND hl.id_laboratorio = :idLaboratorio AND hl.id_aux_laboratorio = :idAuxLab ORDER BY fecha_reporte_lab DESC";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":idDepartamento"=>$idDepartamento,":idLaboratorio"=>$idLaboratorio,":idAuxLab"=>$idAuxiliar));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }


    } 
    