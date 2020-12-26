<?php
    require_once("conexion.php");
    class EnlaceRecursoClase extends Conexion{
        private $sentenceSQL;
        public function EnlaceRecursoClase(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        //EN USO
        public function obtenerEnlaceRecursoClase($codigo_clase){
            /*//Obtener dia
            $sql = "SELECT dia_clase from clase where fecha_clase =:f_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":f_clase"=>$fecha_clase));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $dia =  ($respuesta[0])['dia_clase'];
            $dia = substr($dia,0,2);

            //obtenerIdMateria
            $sql = "SELECT materia.id_materia from materia, grupo, docente_grupo, grupo_horario where materia.id_materia = grupo.id_materia and materia.nombre_materia =:nom_mat and grupo.id_grupo = docente_grupo.id_grupo and grupo.nombre_grupo =:nom_grupo and docente_grupo.id_docente =:id_doc and grupo.id_grupo = grupo_horario.id_grupo and grupo_horario.hora =:h_grp and grupo_horario.dia =:d_grp";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_mat"=>$nombre_materia,":nom_grupo"=>$numero_grupo,":id_doc"=>$id_docente,":h_grp"=>$periodo_hora_clase,":d_grp"=>$dia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:num_grp AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":num_grp"=>$numero_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo =  ($respuesta[0])['id_grupo'];

            //Obtener codigo_clase
            $sql = "SELECT codigo_clase from clase where fecha_clase =:fecha and periodo_hora_clase =:periodo and id_grupo =:id_grp";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":fecha"=>$fecha_clase,":periodo"=>$periodo_hora_clase,":id_grp"=>$id_grupo));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $codigo_clase = ($respuesta[0])['codigo_clase'];*/

            //Obtenemos los enlaces y recursos de la clase
            $sql = "SELECT * from enlace_recurso_clase where codigo_clase =:cod_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":cod_clase"=>$codigo_clase));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function quitarEnlaceRecurso($id_enlace_recurso_clase){
            //eliminamos el enlace_recurso almacenado
            $sql = "DELETE from enlace_recurso_clase where id_enlace_recurso_clase =:id_e";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":id_e"=>$id_enlace_recurso_clase));
            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }

        //EN USO
        public function obtenerIdEnlaceRecursoInsertado($codigo_clase, $array_enlaces_recursos,$descripcion_enlace_recurso, $direccion_enlace_recurso, $es_enlace){
            //Insertamos el enlace o recurso
            $sql = "INSERT into enlace_recurso_clase(codigo_clase,descripcion_enlace_recurso,direccion_enlace_recurso,es_enlace)
                values(:cod_clase, :descripcion, :direccion, :es_e)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":cod_clase"=>$codigo_clase,":descripcion"=>$descripcion_enlace_recurso,":direccion"=>$direccion_enlace_recurso,":es_e"=>$es_enlace));

            //Para obtener el id del enlace o recurso insertado se consideran dos posibles consultas

            //Si no existe ningun enlace o recurso registrado para la clase antes de la insercion
            //entonces definimos la consulta de la siguiente forma
            $sql = "SELECT id_enlace_recurso_clase from enlace_recurso_clase where codigo_clase=:cod_clase";
            
            //Si existen enlaces o recursos registrados para la clase antes de la insercion
            if(!is_null($array_enlaces_recursos)){
                //concatenaremos los ids separados por comas excepto el ultimo id del array
                $numeroIds = count($array_enlaces_recursos)-1;
                $conjuntoIds = "(";
                for($i=0; $i<$numeroIds; $i++){
                    $conjuntoIds .= $array_enlaces_recursos[$i];
                    $conjuntoIds .= ",";
                }
                $conjuntoIds .= $array_enlaces_recursos[$numeroIds];
                $conjuntoIds .= ")";

                $sql = "SELECT id_enlace_recurso_clase from enlace_recurso_clase WHERE id_enlace_recurso_clase not in".$conjuntoIds." and codigo_clase =:cod_clase";
            }

            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":cod_clase"=>$codigo_clase));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function verificarEnlaceRecursoSubido($codigo_clase){
            $sql = "SELECT id_enlace_recurso_clase from enlace_recurso_clase where codigo_clase =:cod_clase limit 1";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":cod_clase"=>$codigo_clase));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        public function insertarRecursoClase($codigo_clase,$descripcion,$enlace){
            $sql = "INSERT into enlace_recurso_clase(codigo_clase,descripcion_enlace_recurso,direccion_enlace_recurso,es_enlace)
                values(:cod_clase, :descripcion, :direccion,'f')";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":cod_clase"=>$codigo_clase,":descripcion"=>$descripcion,":direccion"=>$enlace));
            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }


    }


