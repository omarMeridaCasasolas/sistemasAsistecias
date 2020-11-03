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
        

        // public function laboratoriosDisponibles($idDepartamento){
        //     $sql = "SELECT * FROM laboratorio WHERE id_departamento = :id";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":id"=>$idDepartamento));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return json_encode($respuesta);
        // }
        
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