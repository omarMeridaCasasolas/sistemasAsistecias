<?php
    require_once("conexion.php");
    class ReporteAuxLab extends Conexion{
        public function ReporteAuxLab(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }
        

        

        public function reportePorFecha($idHoarario,$fecha){
            $sql = "SELECT * FROM reporte_aux_lab WHERE id_horario_laboratorio = :id AND fecha_reporte_lab = :fecha";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idHoarario,":fecha"=>$fecha));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            if(isset($respuesta[0])){
                return $respuesta[0];
            }else{
                return 0;
            }
        }


        public function actualizarReporteAuxLabUrl($identificador,$descripcion,$observacion,$enlace){
            $sql = "UPDATE reporte_aux_lab SET trabajo_lab_hecho = :trab, obs_reporte_lab = :obs, doc_reporte_lab = :enlace WHERE id_reporte_lab = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":trab"=>$descripcion,":obs"=>$observacion,":enlace"=>$enlace,":id"=>$identificador));
            $sentenceSQL->closeCursor();
            // $res = json_encode($respuesta);
            return $respuesta;
        }

        public function actualizarReporteAuxLab($identificador,$descripcion,$observacion){
            $sql = "UPDATE reporte_aux_lab SET trabajo_lab_hecho = :trab, obs_reporte_lab = :obs WHERE id_reporte_lab = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":trab"=>$descripcion,":obs"=>$observacion,":id"=>$identificador));
            $sentenceSQL->closeCursor();
            // $res = json_encode($respuesta);
            return $respuesta;
        }

        public function crearReporteDiaFecha($idHoarario,$fecha){
            $sql = "INSERT INTO reporte_aux_lab(id_horario_laboratorio,fecha_reporte_lab) VALUES(:id,:fecha)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":id"=>$idHoarario,":fecha"=>$fecha));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        
        // public function elimarLaboratorio($idLaboratorio){
        //     $sql = "DELETE FROM laboratorio WHERE id_laboratorio = :id";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":id"=>$idLaboratorio));
        //     $sentenceSQL->closeCursor();
        //     // $res = json_encode($respuesta);
        //     return $respuesta;
        // }

        // public function editarLaboratorio($nomLaboratorio,$codLaboratorio,$fecLaboratorio,$desLaboratorio,$mesLaboratorio,$horLaboratorio,$idLaboratorio){
        //     $sql = "UPDATE laboratorio SET nombre_laboratorio = :nombre ,fecha_creacion_lab = :fecha, siglas_laboratorio = :codigo, duracion_laboratorio = :mes, descripcion_laboratorio = :descripcion ,dias_trab_sem = :hora WHERE id_laboratorio = :id";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":id"=>$idLaboratorio,":nombre"=>$nomLaboratorio,":fecha"=>$fecLaboratorio,":codigo"=>$codLaboratorio,":descripcion"=>$desLaboratorio,":mes"=>$mesLaboratorio,":hora"=>$horLaboratorio));
        //     $sentenceSQL->closeCursor();
        //     // $res = json_encode($respuesta);
        //     return $respuesta;
        // }

        // public function agregarLaboratorio($nomLaboratorio,$codLaboratorio,$fecLaboratorio,$desLaboratorio,$mesLaboratorio,$horLaboratorio,$idDepartamento){
        //     $sql = "INSERT INTO laboratorio(id_departamento,nombre_laboratorio,fecha_creacion_lab,siglas_laboratorio,duracion_laboratorio,descripcion_laboratorio,horas_trab_mes) VALUES(:id, :nombre, :fecha, :codigo, :mes, :descripcion, :hora)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":id"=>$idDepartamento,":nombre"=>$nomLaboratorio,":fecha"=>$fecLaboratorio,":codigo"=>$codLaboratorio,":descripcion"=>$desLaboratorio,":mes"=>$mesLaboratorio,":hora"=>$horLaboratorio));
        //     $sentenceSQL->closeCursor();
        //     // $res = json_encode($respuesta);
        //     return $respuesta;
        // }
        
        

        // public function listarLaboratorios($idDepartamento){
        //     $sql = "SELECT * FROM laboratorio WHERE id_departamento = :id";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":id"=>$idDepartamento));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }

        // public function mostarIdPorNombreLab($laboratorio){
        //     $sql = "SELECT * FROM laboratorio WHERE nombre_laboratorio = :nombre";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":nombre"=>$laboratorio));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return $respuesta[0];
        // }
    } 