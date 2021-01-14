
<?php
//listarTableDocente()
    require_once("conexion.php");
    class AuxliarDocente extends Conexion{
        public function AuxliarDocente(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->connexion_bd=null;
        }

        public function obtenerAuxiliarDocente($idAuxiliar){
            $sql = "SELECT * FROM auxiliar_docente WHERE id_aux_docente = :id";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":id"=>$idAuxiliar));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta[0]); 
        }

        public function listarTableAuxiliarDocente(){
            $sql = "SELECT * FROM auxiliar_docente";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute();
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }


        public function verificarAuxliarDocente($correoAuxDoc,$passAuxDoc){
            $sql = "SELECT * FROM auxiliar_docente WHERE UPPER(correo_aux_docente) = UPPER(:correo) AND password_aux_docente = :pass";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL ->execute(array(":correo"=>$correoAuxDoc,":pass"=>$passAuxDoc));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0]; 
        }
        
        public function insertarAuxiliarDocente($nomAuxiliarDocente,$ciAuxiliarDocente,$correoAuxiliarDocente,$telAuxiliarDocente,$sisAuxiliarDocente,$passAuxiliarDocente){
            $sql = "INSERT INTO auxiliar_docente(nombre_aux_docente,ci_aux_docente,correo_aux_docente,telefono_aux_docente,sis_auxiliar,password_aux_docente,activo_aux_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,false)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nombre"=>$nomAuxiliarDocente,":carnet"=>$ciAuxiliarDocente,":correo"=>$correoAuxiliarDocente,":tel"=>$telAuxiliarDocente,":sis"=>$sisAuxiliarDocente,":pass"=>$passAuxiliarDocente));
            return $respuesta;
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

        public function recuperarPasswordAuxDoc($correo){
            $sql = "SELECT * FROM auxiliar_docente WHERE UPPER(correo_aux_docente) = UPPER(:correo)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":correo"=>$correo));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }

        public function listaDeAuxiliares($idDepartamento){
            $sql = "SELECT * FROM auxiliar_docente WHERE id_aux_docente IN (SELECT id_auxiliar_docente FROM departamento_auxiliar_docente WHERE id_departamento = :id)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":id"=>$idDepartamento));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        //Ruben
        
        public function insertarAuxiliarDocenteCSVData($id_departamento, $csvData){
            //Si el $csvData no es null
            if(!is_null($csvData)){
                $indexNomAuxDoc = 0;
                $indexCiAuxDoc = 1;
                $indexTelAuxDoc = 2;
                $indexCorreoAuxDoc = 3;
                $indexSisAuxDoc = 4;
                $indexPassAuxDoc = 5;

                $numeroFilas = count($csvData)-1;

                for($i=1; $i<$numeroFilas; $i++){
                    //obtenemos un arreglo de la posicion $i
                    $fila = $csvData[$i];

                    //insertamos al AuxiliarDocente
                    $sql = "INSERT INTO auxiliar_docente(nombre_aux_docente,ci_aux_docente,correo_aux_docente,telefono_aux_docente,sis_auxiliar,password_aux_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":nombre"=>$fila[$indexNomAuxDoc],":carnet"=>$fila[$indexCiAuxDoc],":correo"=>$fila[$indexCorreoAuxDoc],":tel"=>$fila[$indexTelAuxDoc],":sis"=>$fila[$indexSisAuxDoc],":pass"=>$fila[$indexPassAuxDoc]));

                    //obtenemos id_aux_docente insertado
                    $sql = "SELECT id_aux_docente FROM auxiliar_docente WHERE sis_auxiliar=:sis_aux";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $this->sentenceSQL->execute(array(":sis_aux"=>$fila[$indexSisAuxDoc]));
                    $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                    
                    $id_auxiliar = ($respuesta[0])['id_aux_docente'];

                    //insertar departamento_auxiliar_docente
                    $sql = "INSERT INTO departamento_auxiliar_docente(id_departamento, id_auxiliar_docente) VALUES(:id_dep, :id_aux_doc)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_aux_doc"=>$id_auxiliar));
                }
                $this->sentenceSQL->closeCursor();
            }
        }


        public function insertarAuxiliarDocente_acoplado($nomAuxiliarDocente,$ciAuxiliarDocente,$correoAuxiliarDocente,$telAuxiliarDocente,$sisAuxiliarDocente,$passAuxiliarDocente,$id_departamento){
            $sql = "SELECT id_aux_docente from auxiliar_docente where sis_auxiliar =:cod_sis";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":cod_sis"=>$sisAuxiliarDocente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
            if(count($respuesta) == 0){
                $sql = "INSERT INTO auxiliar_docente(nombre_aux_docente,ci_aux_docente,correo_aux_docente,telefono_aux_docente,sis_auxiliar,password_aux_docente,activo_aux_docente) VALUES(:nombre,:carnet,:correo,:tel,:sis,:pass,'t')";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":nombre"=>$nomAuxiliarDocente,":carnet"=>$ciAuxiliarDocente,":correo"=>$correoAuxiliarDocente,":tel"=>$telAuxiliarDocente,":sis"=>$sisAuxiliarDocente,":pass"=>$passAuxiliarDocente));
            
                //obtenemos id_aux_docente insertado
                $sql = "SELECT id_aux_docente FROM auxiliar_docente WHERE sis_auxiliar=:sis_aux";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":sis_aux"=>$sisAuxiliarDocente));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                    
                $id_auxiliar = ($respuesta[0])['id_aux_docente'];

                //insertar departamento_auxiliar_docente
                $sql = "INSERT INTO departamento_auxiliar_docente(id_departamento, id_auxiliar_docente) VALUES(:id_dep, :id_aux_doc)";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_aux_doc"=>$id_auxiliar));
            }else{
                $respuesta = 0;
            }
            


            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function editarAuxiliarDocente($sisAuxiliarDocente,$nombre_auxiliar_docente, $correoAuxiliarDocente, $telAuxiliarDocente){
            $sql = "UPDATE auxiliar_docente SET nombre_aux_docente=:nom_aux, correo_aux_docente=:correo_aux, telefono_aux_docente=:tel_aux WHERE sis_auxiliar=:sis_aux";       
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL ->execute(array(":sis_aux"=>$sisAuxiliarDocente,":nom_aux"=>$nombre_auxiliar_docente,":correo_aux"=>$correoAuxiliarDocente, ":tel_aux"=>$telAuxiliarDocente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function eliminarAuxiliarDocente($sis_auxiliar_docente, $id_departamento){
           //obtenemos id_aux_docente 
            $sql = "SELECT id_aux_docente FROM auxiliar_docente WHERE sis_auxiliar=:sis_aux";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_aux"=>$sis_auxiliar_docente));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                    
            $id_auxiliar = ($respuesta[0])['id_aux_docente'];

            //eliminamos auxiliar docente
            $sql = "DELETE FROM auxiliar_docente WHERE id_aux_docente=:id_aux";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_aux"=>$id_auxiliar));

            //eliminamos departamento_auxiliar_docente
            $sql = "DELETE FROM departamento_auxiliar_docente WHERE id_auxiliar_docente=:id_aux and id_departamento=:id_dep";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_aux"=>$id_auxiliar,":id_dep"=>$id_departamento));

            $this->sentenceSQL->closeCursor();
        }

    }