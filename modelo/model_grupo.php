<?php
    require_once("conexion.php");
    class Grupo extends Conexion{
        private $sentenceSQL;
        public function Grupo(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        //EN USO
        public function listarGruposDepartamento($id_departamento){
            $sql = "SELECT materia.codigo_materia, materia.nombre_materia, grupo.nombre_grupo, docente.sis_docente, docente.nombre_docente from materia, grupo, docente_grupo, docente where materia.id_materia = grupo.id_materia and materia.id_departamento = :id_dep and grupo.id_grupo = docente_grupo.id_grupo and docente_grupo.id_docente = docente.id_docente order by materia.nombre_materia asc, grupo.nombre_grupo asc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            //$res = json_encode($respuesta);
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function insertarGrupo($nomGrp, $id_materia){
            $sql = "INSERT INTO grupo(nombre_grupo, id_materia)
            VALUES(:nom_grp, :id_mat)";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $sentenceSQL->execute(array(":nom_grp"=>$nomGrp,":id_mat"=>$id_materia));
            $sentenceSQL->closeCursor();
            return $respuesta;
        }

        public function obtenerIdGrupo($nomGrp, $id_materia){
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_mat AND id_materia=:id_mat";
            $sentenceSQL = $this->connexion_bd->prepare($sql);
            $sentenceSQL->execute(array(":nom_mat"=>$nomGrp, ":id_mat"=>$id_materia));
            $respuesta = $sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $sentenceSQL->closeCursor();
            return $respuesta[0];
        }

        //EN USO
        public function obtenerGruposMateria($sis_materia){
            $sql = "SELECT grupo.nombre_grupo from materia, grupo where materia.id_materia = grupo.id_materia and materia.codigo_materia = :sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            $res = json_encode($respuesta);
            return $res;
        }

        //EN USO
        public function insertarGrupo_acoplado($sis_materia,$nombre_grupo,$arrayHorariosGrupo,$arrayCarrerasAsignadasGrupo,$sis_docente_asignado,$sis_auxiliar_asignado){
            //obtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
            $id_materia = ($respuesta[0])['id_materia'];

            //InsertarGrupo
            $sql = "INSERT INTO grupo(nombre_grupo, id_materia)
            VALUES(:nom_grp, :id_mat)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":nom_grp"=>$nombre_grupo,":id_mat"=>$id_materia));

            //ObtenerIdGrupoInsertado
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_mat AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_mat"=>$nombre_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo =  ($respuesta[0])['id_grupo'];

            //ObtenerIdDocente
            $id_docente = 9;
            if($sis_docente_asignado != "Ninguno"){
                $sql = "SELECT id_docente from docente where sis_docente=:sis_doc";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":sis_doc"=>$sis_docente_asignado));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
                $id_docente = ($respuesta[0])['id_docente'];
            }

            //InsertarDocenteGrupo
            $sql = "INSERT INTO docente_grupo(id_docente, id_grupo)
            VALUES(:id_doc, :id_grp)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":id_doc"=>$id_docente,":id_grp"=>$id_grupo));

            /*$sql = "INSERT into materia_docente(id_materia, id_docente) values(:id_mat, :id_doc)";
                 $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                 $this->sentenceSQL->execute(array(":id_mat"=>$id_materia, ":id_doc"=>$id_docente));*/

            //ObtenerIdAuxiliar
            $id_auxiliar = 9;
            if($sis_auxiliar_asignado != "Ninguno"){
                $sql = "SELECT id_aux_docente from auxiliar_docente where sis_auxiliar=:id_aux";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":id_aux"=>$sis_auxiliar_asignado));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
                $id_auxiliar = ($respuesta[0])['id_aux_docente'];
            }

            //InsertarAuxiliarDocenteGrupo
            $sql = "INSERT INTO auxiliar_docente_grupo(id_auxiliar_docente, id_grupo)
            VALUES(:id_aux, :id_grp)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":id_aux"=>$id_auxiliar,":id_grp"=>$id_grupo));

            /*$sql = "INSERT into materia_auxiliar_docente(id_materia, id_auxiliar_docente) values(:id_mat, :id_aux)";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":id_mat"=>$id_materia, ":id_aux"=>$id_auxiliar));*/


            //InsertarCarrerasAsignadasGrupo
            if(!is_null($arrayCarrerasAsignadasGrupo)){
                $numeroCarreras = count($arrayCarrerasAsignadasGrupo);
                for($i=0; $i<$numeroCarreras; $i++){
                    $id_carrera = $arrayCarrerasAsignadasGrupo[$i];
                    $sql = "INSERT INTO grupo_carrera(id_grupo, id_carrera) VALUES(:id_grp, :id_carrera)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo,":id_carrera"=>$id_carrera));
                }
            }

            //InsertarGrupoHorario
            $numeroFilas = count($arrayHorariosGrupo);
            
            for($i=0; $i<$numeroFilas; $i++){
                $horario = $arrayHorariosGrupo[$i];
                $dia = $horario[0];
                $hora = $horario[1];
                $esAux = $horario[2];

                $sql = "INSERT INTO grupo_horario(id_grupo, dia, hora, es_aux) VALUES(:id_grp, :dia_grp, :hora_grp, :asignacion)";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo,":dia_grp"=>$dia,":hora_grp"=>$hora,":asignacion"=>$esAux));
            }
            
            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }

        //EN USO
        public function insertarCambiosGrupo_acoplado($sis_materia,$nombre_grupo,$arrayHorariosGrupo,$arrayCarrerasAsignadasGrupo,$sis_docente,$sis_auxiliar){
            //obtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_mat AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_mat"=>$nombre_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo =  ($respuesta[0])['id_grupo'];

            //EliminarDocenteGrupo
            $sql = "DELETE FROM docente_grupo WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //EliminarAuxiliarDocenteGrupo
            $sql = "DELETE FROM auxiliar_docente_grupo WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //EliminarGrupoHorario
            $sql = "DELETE FROM grupo_horario WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //EliminarGrupoCarrera
            $sql = "DELETE FROM grupo_carrera WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //ObtenerIdDocente
            $id_docente = 9;
            if($sis_docente != "Ninguno"){
                $sql = "SELECT id_docente from docente where sis_docente=:sis_doc";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":sis_doc"=>$sis_docente));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
                $id_docente = ($respuesta[0])['id_docente'];
            }

            //InsertarDocenteGrupo
            $sql = "INSERT INTO docente_grupo(id_docente, id_grupo)
            VALUES(:id_doc, :id_grp)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":id_doc"=>$id_docente,":id_grp"=>$id_grupo));

            //ObtenerIdAuxiliar
            $id_auxiliar = 9;
            if($sis_auxiliar != "Ninguno"){
                $sql = "SELECT id_aux_docente from auxiliar_docente where sis_auxiliar=:id_aux";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":id_aux"=>$sis_auxiliar));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
                $id_auxiliar = ($respuesta[0])['id_aux_docente'];
            }

            //InsertarAuxiliarDocenteGrupo
            $sql = "INSERT INTO auxiliar_docente_grupo(id_auxiliar_docente, id_grupo)
            VALUES(:id_aux, :id_grp)";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $respuesta = $this->sentenceSQL->execute(array(":id_aux"=>$id_auxiliar,":id_grp"=>$id_grupo));

            //InsertarGrupoHorario
            $numeroFilas = count($arrayHorariosGrupo);
            
            for($i=0; $i<$numeroFilas; $i++){
                $horario = $arrayHorariosGrupo[$i];
                $dia = $horario[0];
                $hora = $horario[1];
                $esAux = $horario[2];

                $sql = "INSERT INTO grupo_horario(id_grupo, dia, hora, es_aux) VALUES(:id_grp, :dia_grp, :hora_grp, :asignacion)";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo,":dia_grp"=>$dia,":hora_grp"=>$hora,":asignacion"=>$esAux));
            }

            //InsertarCarrerasAsignadasGrupo
            if(!is_null($arrayCarrerasAsignadasGrupo)){
                $numeroCarreras = count($arrayCarrerasAsignadasGrupo);
                for($i=0; $i<$numeroCarreras; $i++){
                    $id_carrera = $arrayCarrerasAsignadasGrupo[$i];
                    $sql = "INSERT INTO grupo_carrera(id_grupo, id_carrera) VALUES(:id_grp, :id_carrera)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo,":id_carrera"=>$id_carrera));
                }
            }
            
            $this->sentenceSQL->closeCursor();
            return $respuesta;
        }

        //EN USO
        public function eliminarGrupo_acoplado($sis_materia, $nombre_grupo){
            //obtenerIdMateria
            $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":sis_mat"=>$sis_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
            $id_materia = ($respuesta[0])['id_materia'];

            //ObtenerIdGrupo
            $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_mat AND id_materia=:id_mat";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":nom_mat"=>$nombre_grupo, ":id_mat"=>$id_materia));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $id_grupo =  ($respuesta[0])['id_grupo'];

            //EliminarGrupo
            $sql = "DELETE FROM grupo WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //EliminarDocenteGrupo
            $sql = "DELETE FROM docente_grupo WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //EliminarAuxiliarDocenteGrupo
            $sql = "DELETE FROM auxiliar_docente_grupo WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //EliminarGrupoHorario
            $sql = "DELETE FROM grupo_horario WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            //EliminarGrupoCarrera
            $sql = "DELETE FROM grupo_carrera WHERE id_grupo=:id_grp";     
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo));

            $this->sentenceSQL->closeCursor();
        }

        //EN USO
        public function cargarGruposCSVData_acoplado($csvData) {
            //PosicionDatosQueSeranLeidosDelArray
            $indexSisMat = 0;
            $indexNomGrp = 2;
            $indexGrpDia = 3;
            $indexGrpHora = 4;
            $indexSisDoc = 5;
            $indexSisAux = 7;
            $indexNomCarreras = 9;

            $id_materia = "";
            $id_grupo = "";

            //AlmacenanValoresDelGrupoQueSeEstaRegistrando
            $oldSisMat = "";
            $oldNomGrp = "";

            $docRegistrado = false;
            $auxRegistrado = false;

            //ObtenemosUnArrayQueRepresentaUnaFilaDelArchivoEnCadaIteracion
            for ($i=1, $len=count($csvData)-1; $i<$len; $i++) {

                $arrayLine = $csvData[$i];

                //Verificamos si el nuevo array corresponde al grupo que teniamos registrado
                //De ser asi solo guardamos el horario 
                //Y posiblemente registrar al docente o auxiliar que quedo pendiente registrarlo
                if(($oldSisMat == $arrayLine[$indexSisMat]) && ($oldNomGrp == $arrayLine[$indexNomGrp])){

                    //Registrar GrupoHorario
                    $this->registrarHorario($arrayLine[$indexSisDoc], $id_grupo, $arrayLine[$indexGrpDia], $arrayLine[$indexGrpHora]);

                    //Verificamos si el docente no ha sido registrado
                    if(!$docRegistrado){
                        //Registramos DocenteGrupo
                        //Si el arrayline corresponde al horario del docente
                        //El resultado sera true
                        $docRegistrado = $this->resultadoRegistrarDocenteGrupo($arrayLine[$indexSisAux], $arrayLine[$indexSisDoc], $id_grupo);

                        //Verificamos y registramos MateriaDocente
                        if($docRegistrado){
                            $this->registrarMateriaDocente($id_materia, $arrayLine[$indexSisDoc]);
                        }

                    //Verificamos si el auxiliar de docencia no ha sido registrado
                    }else if(!$auxRegistrado){
                        //Registramos AuxiliarDocenteGrupo
                        //Si el arrayline corresponde al horario del auxiliar de docencia
                        //Resultado sera distinto true
                        $auxRegistrado = $this->resultadoRegistrarAuxiliarGrupo($arrayLine[$indexSisDoc], $arrayLine[$indexSisAux], $id_grupo);

                        //Verificamos y registramos MateriaAuxiliarDocente
                        if($auxRegistrado){
                            $this->registrarMateriaAuxiliarDocente($id_materia, $arrayLine[$indexSisAux]);
                        }
                    }

                }else{
                    //Como el arreglo corresponde a la informacion de un nuevo grupo
                    //Establecemos los valores del nuevo grupo para luego compararlos
                    $oldSisMat = $arrayLine[$indexSisMat];
                    $oldNomGrp = $arrayLine[$indexNomGrp];

                    //Antes de registrar el nuevo grupo, obtenemos el id de la materia
                    $sql = "SELECT id_materia FROM materia WHERE codigo_materia=:sis_mat";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $this->sentenceSQL->execute(array(":sis_mat"=>$oldSisMat));
                    $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                    $id_materia = ($respuesta[0])['id_materia'];

                    //Registramos el nuevo grupo
                    $sql = "INSERT INTO grupo(nombre_grupo, id_materia)
                    VALUES(:nom_grp, :id_mat)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":nom_grp"=>$oldNomGrp,":id_mat"=>$id_materia));

                    //Obtenemos el id del grupo registrado
                    $sql = "SELECT id_grupo FROM grupo WHERE nombre_grupo=:nom_grp AND id_materia=:id_mat";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $this->sentenceSQL->execute(array(":nom_grp"=>$oldNomGrp, ":id_mat"=>$id_materia));
                    $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                    $id_grupo = ($respuesta[0])['id_grupo'];
                
                    //Registrar GrupoHorario
                    $this->registrarHorario($arrayLine[$indexSisDoc], $id_grupo, $arrayLine[$indexGrpDia], $arrayLine[$indexGrpHora]);

                    //RegistrarDocenteGrupo
                    //Si el arrayline corresponde al horario del docente
                    //El resultado sera true
                    $docRegistrado = $this->resultadoRegistrarDocenteGrupo($arrayLine[$indexSisAux], $arrayLine[$indexSisDoc], $id_grupo);

                    //Si se registro el docente, entonces registramos MateriaDocente
                    if($docRegistrado){
                        $this->registrarMateriaDocente($id_materia, $arrayLine[$indexSisDoc]);
                    }

                    //RegistrarAuxiliarDocenteGrupo
                    //Si el arrayline corresponde al horario del auxiliar de docencia
                    //El resultado sera true
                    $auxRegistrado = $this->resultadoRegistrarAuxiliarGrupo($arrayLine[$indexSisDoc], $arrayLine[$indexSisAux], $id_grupo);

                    //Si se registro el auxiliar de docencia, entonces registramos MateriaAuxiliarDocente
                    if($auxRegistrado){
                        $this->registrarMateriaAuxiliarDocente($id_materia, $arrayLine[$indexSisAux]);
                    }

                    //Obtenemos un arreglo con los nombres de las carreras
                    //Que son asignadas al grupo
                    $arrayCarreras = explode('-', $arrayLine[$indexNomCarreras]);

                    //Registramos las carreras al grupo y a la materia
                    $this->registrarCarrerasAsignadasGrupoMateria($arrayCarreras, $id_grupo, $id_materia);

                }
            }

            $this->sentenceSQL->closeCursor();
        }

        //EN USO
        function registrarHorario($sisDocente, $id_grupo, $dia, $hora){
            //Si el codigo sisDocente es una cadena vacia, entonces ese horario es para el auxiliar
            //y ponemos 't' como valor del campo es_aux
            if($sisDocente == ""){
                $sql = "INSERT INTO grupo_horario(id_grupo, dia, hora, es_aux)
                VALUES(:id_grp, :dia_grp, :hora_grp, 't')";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo,":dia_grp"=>$dia,":hora_grp"=>$hora));
            }else{
                $sql = "INSERT INTO grupo_horario(id_grupo, dia, hora, es_aux)
                VALUES(:id_grp, :dia_grp, :hora_grp, 'f')";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo,":dia_grp"=>$dia,":hora_grp"=>$hora));
            }

        }

        //EN USO
        function resultadoRegistrarDocenteGrupo($sisAux, $sisDoc, $id_grupo){
            $resultadoRegistro = false;
            //Si el sisAux es una cadena vacia, entonces se registra al docente
            if($sisAux == ""){
                //si el sisDoc es '*' entonces se trata de un grupo sin docente asignado
                if($sisDoc == "*"){
                    //Se asigna el valor por defecto para los grupos que no tienen un docente asignado
                    $id_docente_default = 9;
                    //Registramos DocenteGrupo
                    $sql = "INSERT INTO docente_grupo(id_docente, id_grupo)
                    VALUES(:id_docente, :id_grp)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_docente"=>$id_docente_default,":id_grp"=>$id_grupo));
                }else {
                    //Obtenemos el id del docente
                    $sql = "SELECT id_docente FROM docente WHERE sis_docente=:sis_doc";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $this->sentenceSQL->execute(array(":sis_doc"=>$sisDoc));
                    $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                    $id_docente = ($respuesta[0])['id_docente'];

                    //Registramos DocenteGrupo
                    $sql = "INSERT INTO docente_grupo(id_docente, id_grupo)
                    VALUES(:id_doc, :id_grp)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_doc"=>$id_docente,":id_grp"=>$id_grupo));
                }
                $resultadoRegistro = true;
            }
            return $resultadoRegistro;
        }

        //EN USO
        function resultadoRegistrarAuxiliarGrupo($sisDoc, $sisAux, $id_grupo){
            $resultadoRegistro = false;
            //Si el sisDoc es una cadena vacia, entonces se registra al auxiliar
            if($sisDoc == ""){
                //si el sisAux es '*' entonces se trata de un grupo sin auxiliar asignado
                if($sisAux == "*"){
                    //Se asigna el valor por defecto para los grupos que no tienen un auxiliar asignado
                    $id_auxiliar_default = 9;
                    //Registramos AuxiliarDocenteGrupo
                    $sql = "INSERT INTO auxiliar_docente_grupo(id_auxiliar_docente,id_grupo)
                    VALUES(:id_aux, :id_grp)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_aux"=>$id_auxiliar_default, ":id_grp"=>$id_grupo));
                }else {
                    //Obtenemos el id del AuxiliarDocente
                    $sql = "SELECT id_aux_docente FROM auxiliar_docente WHERE sis_auxiliar=:sis_aux";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $this->sentenceSQL->execute(array(":sis_aux"=>$sisAux));
                    $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                    $id_auxiliar = ($respuesta[0])['id_aux_docente'];
                    
                    //Registramos AuxiliarDocenteGrupo
                    $sql = "INSERT INTO auxiliar_docente_grupo(id_auxiliar_docente, id_grupo)
                    VALUES(:id_aux, :id_grp)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_aux"=>$id_auxiliar,":id_grp"=>$id_grupo));
                }
                $resultadoRegistro = true;
            }
            return $resultadoRegistro;
        }

        //EN USO
        function registrarMateriaDocente($id_materia, $sisDoc){
            //Si el sisDoc es distinto de '*' entonces el grupo tiene un docente asignado
            if($sisDoc != '*'){
                //Obtenemos el id del docente
                $sql = "SELECT id_docente FROM docente WHERE sis_docente=:sis_doc";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":sis_doc"=>$sisDoc));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                $id_docente = ($respuesta[0])['id_docente'];

                //Verificamos si existe una tupla con el id_materia e id_docente ya registrados
                $sql = "SELECT exists(select 1 from materia_docente where id_materia=:id_mat and id_docente=:id_doc) from materia_docente where id_materia=:id_mat and id_docente=:id_doc";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_doc"=>$id_docente));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                //Si no existe una tupla registrada, la registramos
                if(!($respuesta[0])['exists']){
                    $sql = "INSERT INTO materia_docente(id_materia, id_docente)
                    VALUES(:id_mat, :id_doc)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_doc"=>$id_docente));
                }
            }
        }

        //EN USO
        function registrarMateriaAuxiliarDocente($id_materia, $sisAux){
            //Si el sisAux es distinto de '*' entonces el grupo tiene un auxiliar de docencia asignado
            if($sisAux != "*"){
                //Obtenemos el id del AuxiliarDocente
                $sql = "SELECT id_aux_docente FROM auxiliar_docente WHERE sis_auxiliar=:sis_aux";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":sis_aux"=>$sisAux));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                $id_auxiliar = ($respuesta[0])['id_aux_docente'];

                //Verificamos si existe una tupla con el id_materia e id_auxiliar_docente ya registrados
                $sql = "SELECT exists(select 1 from materia_auxiliar_docente where id_materia=:id_mat and id_auxiliar_docente=:id_aux) from materia_auxiliar_docente where id_materia=:id_mat and id_auxiliar_docente=:id_aux";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_aux"=>$id_auxiliar));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                //Si no existe una tupla registrada, la registramos
                if(!($respuesta[0])['exists']){
                    $sql = "INSERT INTO materia_auxiliar_docente(id_materia, id_auxiliar_docente)
                    VALUES(:id_mat, :id_aux)";
                    $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                    $respuesta = $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_aux"=>$id_auxiliar));
                }
            }
        }

        //EN USO
        function registrarCarrerasAsignadasGrupoMateria($arrayCarreras, $id_grupo, $id_materia){
            for($index=0, $size=count($arrayCarreras); $index<$size; $index++){
                //Obtenemos el id de la carrera
                $sql = "SELECT id_carrera FROM carrera WHERE nombre_carrera=:nom_carrera";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":nom_carrera"=>$arrayCarreras[$index]));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

                $id_carrera = ($respuesta[0])['id_carrera'];

                //Registramos GrupoCarrera
                $sql = "INSERT INTO grupo_carrera(id_grupo, id_carrera)
                VALUES(:id_grp, :id_carrera)";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":id_grp"=>$id_grupo,":id_carrera"=>$id_carrera));

                //Registramos MateriaCarrera
                $this->registrarMateriaCarrera($id_materia, $id_carrera);
            }
        }

        //EN USO
        function registrarMateriaCarrera($id_materia, $id_carrera){
            //Verificamos si existe una tupla con el id_materia e id_carrera ya registrados
            $sql = "SELECT exists(select 1 from materia_carrera where id_materia=:id_mat and id_carrera=:id_carr) from materia_carrera where id_materia=:id_mat and id_carrera=:id_carr";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_carr"=>$id_carrera));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
            //Si no existe una tupla registrada, la registramos
            if(!($respuesta[0])['exists']){
                $sql = "INSERT INTO materia_carrera(id_materia, id_carrera)
                VALUES(:id_mat, :id_carr)";
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $respuesta = $this->sentenceSQL->execute(array(":id_mat"=>$id_materia,":id_carr"=>$id_carrera));
            }
        }

    }