
<?php
//listarTableDocente()
    require_once("conexion.php");
    class Materia extends Conexion{
        private $sentenceSQL;
        public function Materia(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        public function listaMateriasPorDepartamento($idDepartamento){
            $sql = "SELECT * FROM materia WHERE id_departamento = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode($respuesta); 
        }

        public function obtenerReporteMes($idMateria,$idAuxiliar,$fechaInicio,$FechaFinal,$idDepartamento){
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia 
            WHERE fecha_clase BETWEEN :fechaInicio AND :fechaFinal AND revisado = 'Jefe Departamento' AND clase.id_materia = :idMateria AND clase.id_aux_docente = :idAuxiliar
            AND clase.id_materia IN(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento,":fechaInicio"=>$fechaInicio,":fechaFinal"=>$FechaFinal,":idMateria"=>$idMateria,":idAuxiliar"=>$idAuxiliar));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }
        
        public function obtenerMateriaPorDepartamento($idDepartamento,$fechaInicio,$FechaFinal){
            $sql = "SELECT * FROM clase INNER JOIN materia ON clase.id_materia = materia.id_materia WHERE id_aux_docente is not null 
            AND fecha_clase BETWEEN :fechaInicio AND :fechaFinal AND revisado = 'Ninguno'
            AND clase.id_materia IN(SELECT materia.id_materia FROM materia WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento,":fechaInicio"=>$fechaInicio,":fechaFinal"=>$FechaFinal));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function listaMateriaAuxPizarra($idAuxPizarra){
            $sql = "SELECT * FROM materia WHERE id_materia IN(SELECT id_materia FROM materia_auxiliar_docente WHERE id_auxiliar_docente = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idAuxPizarra));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode($respuesta); 
        }

        // public function listarTableDocente(){
        //     $sql = "SELECT * FROM docente";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute();
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }

        // public function insertarDocente($nombreDocente,$ciDocente,$correoDocente,$telDocente,$sisDocente,$passDocente){
        //     $sql = "INSERT INTO docente(nombre_docente,carnet_docente,correo_docente,telefono_docente,sis_docente,password_docente,activo_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,false)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":nombre"=>$nombreDocente,":carnet"=>$ciDocente,":correo"=>$correoDocente,":tel"=>$telDocente,":sis"=>$sisDocente,":pass"=>$passDocente));
        //     return $respuesta;
        // }

        // public function verificarDocente($correoDocente,$passDocente){
        //     $sql = "SELECT * FROM docente WHERE UPPER(correo_docente) = UPPER(:correo) AND password_docente = :pass ";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL ->execute(array(":correo"=>$correoDocente,":pass"=>$passDocente));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return $respuesta[0]; 
        // }

        // public function carrerasDisponibles($ambiente){
        //     $sql = "SELECT * FROM carrera  WHERE director_carrera IS NULL AND id_departamento = :departamento";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":departamento"=>$ambiente));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     $res = json_encode($respuesta);
        //     return $res;
        // }
        // public function AsignarDirectorCarrera($nomDirector,$textDirector){
        //     $sql = "UPDATE carrera SET director_carrera = :nombreDirector WHERE nombre_carrera = :departamento";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $respuesta = $sentenceSQL->execute(array(":nombreDirector"=>$nomDirector,":departamento"=>$textDirector));
        //     $sentenceSQL->closeCursor();
        //     return $respuesta;
        // }

        // public function recuperarPasswordDocente($correo){
        //     $sql = "SELECT * FROM docente WHERE UPPER(correo_docente) = UPPER(:correo)";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":correo"=>$correo));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     return $respuesta[0];
        // }

        // public function listarReportesDocenteDia($idDocente,$fechaActual){
        //     $sql = "SELECT current_date, grupo_horario.hora, grupo.nombre_grupo, materia.nombre_materia
        //     FROM docente, docente_grupo, grupo, materia, grupo_horario
        //     where docente.id_docente = docente_grupo.id_docente
        //     and docente.id_docente = :id
        //     and docente_grupo.id_grupo = grupo.id_grupo
        //     and grupo.id_grupo = grupo_horario.id_grupo
        //     and grupo.id_materia = materia.id_materia
        //     and grupo_horario.es_aux = false
        //     and grupo_horario.dia = :fecha
        //     order by grupo_horario.hora desc";
        //     $sentenceSQL = $this->connexion_bd->prepare($sql);
        //     $sentenceSQL->execute(array(":id"=>$idDocente,":fecha"=>$fechaActual));
        //     $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
        //     $sentenceSQL->closeCursor();
        //     //return $respuesta[0];
        //     echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        // }
        public function listarTableMateria($id_carrera){
            $sql = "SELECT materia.codigo_materia, materia.nombre_materia from materia inner join materia_docente_carrera on materia.id_materia = materia_docente_carrera.id_materia where materia_docente_carrera.id_carrera=:carrera";
             $sentenceSQL = $this->connexion_bd->prepare($sql);
             $sentenceSQL ->execute(array(":carrera"=>$id_carrera));
             $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
             $sentenceSQL->closeCursor();
 
             echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
         }
 
         //EN USO
         public function listarMateriasDepartamento($id_departamento){
             $sql = "SELECT codigo_materia, nombre_materia from materia where id_departamento = :id_dep";
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento));
             $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
             $this->sentenceSQL->closeCursor();
             //$res = json_encode($respuesta);
             echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
         }
 
         //EN USO
         public function insertarMateriasCSVData($id_departamento, $csvData){
             //Si el $csvData no es null
             if(!is_null($csvData)){
                 $indexSisDoc = 0;
                 $indexNomDoc = 1;
                 //$indexIdDepDoc = 2;
 
                 $numeroFilas = count($csvData)-1;
 
                 for($i=1; $i<$numeroFilas; $i++){
                     //obtenemos un arreglo de la posicion $i
                     $fila = $csvData[$i];
 
                     //insertamos la materia
                     $sql = "INSERT INTO materia(nombre_materia,codigo_materia,id_departamento) VALUES(:nombre,:codigo,:id)";
                     $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                     $respuesta = $this->sentenceSQL->execute(array(":nombre"=>$fila[$indexNomDoc],":codigo"=>$fila[$indexSisDoc],":id"=>$id_departamento));
 
                 }
                 $this->sentenceSQL->closeCursor();
             }
         }
 
         //EN USO
         public function insertarMateria($nombreMateria,$sis_materia,$id_departamento){
            $sql = "SELECT id_materia from materia where codigo_materia =:cod_mat";
           $this->sentenceSQL = $this->connexion_bd->prepare($sql);
           $this->sentenceSQL->execute(array(":cod_mat"=>$sis_materia));
           $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

           if(count($respuesta) == 0){
               $sql = "INSERT INTO materia(nombre_materia,codigo_materia,id_departamento) VALUES(:nombre,:sis,:depa)";
               $this->sentenceSQL = $this->connexion_bd->prepare($sql);
               $respuesta = $this->sentenceSQL->execute(array(":nombre"=>$nombreMateria,":sis"=>$sis_materia,":depa"=>$id_departamento));
           }else{
               $respuesta = 0;
           }
            
            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }      
 
         //EN USO
         public function editarMateria($nombre_materia, $sisMateria, $nuevo_sisMateria, $arrayDocentes, $arrayAuxiliares, $arrayCarreras){
             $sql = "SELECT id_materia from materia where codigo_materia =:cod_mat";
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL->execute(array(":cod_mat"=>$sisMateria));
             $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
             $id_materia = ($respuesta[0])['id_materia'];
 
             $sql = "DELETE FROM materia_docente WHERE id_materia=:id_mat";    
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL->execute(array(":id_mat"=>$id_materia));
             if(!is_null($arrayDocentes)){
                 $numeroIdentificadores = count($arrayDocentes);
                 $valores = "";
                 for ($i=0; $i < $numeroIdentificadores; $i++) { 
                     $valores .= "(";
                     $valores .= $id_materia.",".$arrayDocentes[$i];
                     $valores .= ")";
                     if($i+1 == $numeroIdentificadores){
                         $valores .= ";";
                     }else{
                         $valores .= ",";
                     }
                 }
                 
                 $sql = "INSERT into materia_docente(id_materia, id_docente) values".$valores;
                 $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                 $this->sentenceSQL->execute();
             }
 
             $sql = "DELETE FROM materia_auxiliar_docente WHERE id_materia=:id_mat";    
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL->execute(array(":id_mat"=>$id_materia));
 
             if(!is_null($arrayAuxiliares)){
                 $numeroIdentificadores = count($arrayAuxiliares);
                 $valores = "";
                 for ($i=0; $i < $numeroIdentificadores; $i++) { 
                     $valores .= "(";
                     $valores .= $id_materia.",".$arrayAuxiliares[$i];
                     $valores .= ")";
                     if($i+1 == $numeroIdentificadores){
                         $valores .= ";";
                     }else{
                         $valores .= ",";
                     }
                 }
 
                 $sql = "INSERT into materia_auxiliar_docente(id_materia, id_auxiliar_docente) values".$valores;
                 $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                 $this->sentenceSQL->execute();
             }
 
             $sql = "DELETE FROM materia_carrera WHERE id_materia=:id_mat";    
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL->execute(array(":id_mat"=>$id_materia));
             if(!is_null($arrayCarreras)){
 
                 $numeroIdentificadores = count($arrayCarreras);
                 $valores = "";
                 for ($i=0; $i < $numeroIdentificadores; $i++) { 
                     $valores .= "(";
                     $valores .= $id_materia.",".$arrayCarreras[$i];
                     $valores .= ")";
                     if($i+1 == $numeroIdentificadores){
                         $valores .= ";";
                     }else{
                         $valores .= ",";
                     }
                 }
 
                 $sql = "INSERT into materia_carrera(id_materia, id_carrera) values".$valores;
                 $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                 $this->sentenceSQL->execute();
             }
 
             $sql = "UPDATE materia SET nombre_materia=:nom_mat, codigo_materia=:nuevo_codmat WHERE codigo_materia=:codmat";       
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL ->execute(array(":nom_mat"=>$nombre_materia,":codmat"=>$sisMateria,":nuevo_codmat"=>$nuevo_sisMateria));
             $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
             $this->sentenceSQL->closeCursor();
             echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
         }
 
         //EN USO
         public function eliminarMateria($sis_materia, $id_departamento){
             $sql = "DELETE FROM materia WHERE codigo_materia=:id_mat";    
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL->execute(array(":id_mat"=>$sis_materia));
         }
 
         public function obtenerIdMateria($sisMat){
             $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
             $sentenceSQL = $this->connexion_bd->prepare($sql);
             $sentenceSQL->execute(array(":sis_mat"=>$sisMat));
             $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
             $sentenceSQL->closeCursor();
             return $respuesta[0];
         }
 
         //EN USO
         public function obtenerMateriasDepartamento($id_departamento){
             $sql = "SELECT codigo_materia, nombre_materia from materia where id_departamento = :id_dep";
             $this->sentenceSQL = $this->connexion_bd->prepare($sql);
             $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento));
             $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
             $this->sentenceSQL->closeCursor();
             $res = json_encode($respuesta);
             return $res;
         }
 
    }