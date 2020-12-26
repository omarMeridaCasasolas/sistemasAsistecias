
<?php
//listarTableDocente()
    require_once("conexion.php");
    class Docente extends Conexion{
        private $sentenceSQL;
        public function Docente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        public function listarTableDocente(){
            $sql = "SELECT * FROM docente";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function insertarDocentesCSVData($id_departamento, $csvData){
            //Si el $csvData no es null
            if(!is_null($csvData)){
                $indexNomDoc = 0;
                $indexCiDoc = 1;
                $indexTelDoc = 2;
                $indexCorreoDoc = 3;
                $indexSisDoc = 4;
                $indexPassDoc = 5;

                $numeroFilas = count($csvData)-1;

                for($i=1; $i<$numeroFilas; $i++){
                    //obtenemos un arreglo de la posicion $i
                    $fila = $csvData[$i];

                    //insertamos el docente 
                    $sql = "INSERT INTO docente(nombre_docente,carnet_docente,correo_docente,telefono_docente,sis_docente,password_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":nombre"=>$fila[$indexNomDoc],":carnet"=>$fila[$indexCiDoc],":correo"=>$fila[$indexCorreoDoc],":tel"=>$fila[$indexTelDoc],":sis"=>$fila[$indexSisDoc],":pass"=>$fila[$indexPassDoc]));

                    //obtenemos id_docente insertado
                    $sql = "SELECT id_docente FROM docente WHERE sis_docente=:sis_doc";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $this->sentenceSQL->execute(array(":sis_doc"=>$fila[$indexSisDoc]));
                    $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                    
                    $id_docente = ($respuesta[0])['id_docente'];

                    //insertar departamento_docente
                    $sql = "INSERT INTO departamento_docente(id_departamento, id_docente) VALUES(:id_dep, :id_doc)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_doc"=>$id_docente));
                }
                $this->sentenceSQL->closeCursor();
            }
        }

        public function insertarDocente($nombreDocente,$ciDocente,$correoDocente,$telDocente,$sisDocente,$passDocente, $id_departamento){
            $sql = "INSERT INTO docente(nombre_docente,carnet_docente,correo_docente,telefono_docente,sis_docente,password_docente,activo_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,false)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":nombre"=>$nombreDocente,":carnet"=>$ciDocente,":correo"=>$correoDocente,":tel"=>$telDocente,":sis"=>$sisDocente,":pass"=>$passDocente));

            //obtenemos id_docente insertado
            $sql = "SELECT id_docente FROM docente WHERE sis_docente=:sis_doc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_doc"=>$sisDocente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                    
            $id_docente = ($respuesta[0])['id_docente'];

            //insertar departamento_docente
            $sql = "INSERT INTO departamento_docente(id_departamento, id_docente) VALUES(:id_dep, :id_doc)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_doc"=>$id_docente));

            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function editarDocente($sisDocente,$nombre_docente, $correoDocente, $telDocente){
            $sql = "UPDATE docente SET nombre_docente=:nom_doc, correo_docente=:correo_doc, telefono_docente=:tel_doc WHERE sis_docente=:sis_doc";       
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL ->execute(array(":sis_doc"=>$sisDocente,":nom_doc"=>$nombre_docente,":correo_doc"=>$correoDocente, ":tel_doc"=>$telDocente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function eliminarDocente($sis_docente, $id_departamento){
            //obtenemos id_docente 
            $sql = "SELECT id_docente FROM docente WHERE sis_docente=:sis_doc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_doc"=>$sis_docente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                    
            $id_docente = ($respuesta[0])['id_docente'];

            //eliminamos docente
            $sql = "DELETE FROM docente WHERE id_docente=:id_doc";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_doc"=>$id_docente));

            //eliminamos departamento_docente
            $sql = "DELETE FROM departamento_docente WHERE id_docente=:id_doc and id_departamento=:id_dep";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_doc"=>$id_docente,":id_dep"=>$id_departamento));

            $this->sentenceSQL->closeCursor();
        }

        public function verificarDocente($correoDocente,$passDocente){
            $sql = "SELECT * FROM docente WHERE UPPER(correo_docente) = UPPER(:correo) AND password_docente = :pass ";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":correo"=>$correoDocente,":pass"=>$passDocente));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0]; 
        }

        public function carrerasDisponibles($ambiente){
            $sql = "SELECT * FROM carrera  WHERE director_carrera IS NULL AND id_departamento = :departamento";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":departamento"=>$ambiente));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }
        public function AsignarDirectorCarrera($nomDirector,$textDirector){
            $sql = "UPDATE carrera SET director_carrera = :nombreDirector WHERE nombre_carrera = :departamento";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombreDirector"=>$nomDirector,":departamento"=>$textDirector));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function recuperarPasswordDocente($correo){
            $sql = "SELECT * FROM docente WHERE UPPER(correo_docente) = UPPER(:correo)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":correo"=>$correo));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }

        public function listarReportesDocenteDia($idDocente,$fechaActual){
            $sql = "SELECT current_date, grupo_horario.hora, grupo.nombre_grupo, materia.nombre_materia
            FROM docente, docente_grupo, grupo, materia, grupo_horario
            where docente.id_docente = docente_grupo.id_docente
            and docente.id_docente = :id
            and docente_grupo.id_grupo = grupo.id_grupo
            and grupo.id_grupo = grupo_horario.id_grupo
            and grupo.id_materia = materia.id_materia
            and grupo_horario.es_aux = false
            and grupo_horario.dia = :fecha
            order by grupo_horario.hora desc";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDocente,":fecha"=>$fechaActual));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            //return $respuesta[0];
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        
    }