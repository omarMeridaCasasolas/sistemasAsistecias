
<?php
//listarTableDocente()
    require_once("conexion.php");
    class AuxiliarLaboratorio extends Conexion{
        public function AuxiliarLaboratorio(){  
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }

        public function listarTableAuxiliarLaboratorio($idDepartamento){
            $sql = "SELECT * FROM auxiliar_laboratorio WHERE id_departamento = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        
        public function insertarAuxiliarLaboratorio($nomAuxLaboratorio,$codAuxLaboratorio,$corAuxLaboratorio,$telAuxLaboratorio,$pasAuxLaboratorio,$dirAuxLaboratorio,$idDepartamento){
            $sql = "INSERT INTO auxiliar_laboratorio(nombre_auxiliar_lab,ci_auxiliar_lab,correo_auxiliar_lab,telefono_auxiliar_lab,password_auxiliar_lab,responsable_lab, id_departamento) VALUES(:nombre,:carnet,:correo,:tel,:pass,:responsable,:id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombre"=>$nomAuxLaboratorio,":carnet"=>$codAuxLaboratorio,":correo"=>$corAuxLaboratorio,":tel"=>$telAuxLaboratorio,":pass"=>$pasAuxLaboratorio,":responsable"=>$dirAuxLaboratorio,":id"=>$idDepartamento));
            return $respuesta;
        }

        public function verificarAuxiliarLaboratorio($correoAuxLab,$passAuxLab){
            $sql = "SELECT * FROM auxiliar_laboratorio WHERE UPPER(correo_auxiliar_lab) = UPPER(:correo) AND password_auxiliar_lab = :pass";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":correo"=>$correoAuxLab,":pass"=>$passAuxLab));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0]; 
        }


        public function actualizarAuxiliarLaboratorio($nomAuxLaboratorio,$codAuxLaboratorio,$corAuxLaboratorio,$telAuxLaboratorio,$dirAuxLaboratorio,$clavePrimaria){
            $sql = "UPDATE auxiliar_laboratorio SET nombre_auxiliar_lab = :nom, ci_auxiliar_lab = :ci, correo_auxiliar_lab = :correo ,telefono_auxiliar_lab = :telef ,responsable_lab = :resp WHERE id_aux_laboratorio = :claveP";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom"=>$nomAuxLaboratorio,":ci"=>$codAuxLaboratorio,":correo"=>$corAuxLaboratorio,":telef"=>$telAuxLaboratorio,":resp"=>$dirAuxLaboratorio,":claveP"=>$clavePrimaria));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }
        public function eliminarAuxiliarLaboratorio($clavePrimaria){
            $sql = "DELETE from auxiliar_laboratorio  WHERE id_aux_laboratorio = :claveP";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":claveP"=>$clavePrimaria));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

    }