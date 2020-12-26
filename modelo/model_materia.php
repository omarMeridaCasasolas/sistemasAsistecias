<?php
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
            $sql = "INSERT INTO materia(nombre_materia,codigo_materia,id_departamento) VALUES(:nombre,:sis,:depa)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":nombre"=>$nombreMateria,":sis"=>$sis_materia,":depa"=>$id_departamento));
            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }    

        //EN USO
        public function editarMateria($nombre_materia, $sisMateria, $nuevo_sisMateria){
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