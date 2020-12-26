<?php
    require_once("conexion.php");
    class Clase extends Conexion{
        private $sentenceSQL;
        public function Clase(){
            parent::__construct();
        }
        public function cerrarConexion(){
            $this->sentenceSQL=null;
            $this->connexion_bd=null;
        }

        //EN USO
        public function obtenerClaseDocente($id_departamento, $id_docente, $fecha_inicio, $fecha_fin){
            //Obtenemos las clases correspondientes a la semana
            $sql = "SELECT clase.codigo_clase, clase.fecha_clase, clase.periodo_hora_clase, grupo.nombre_grupo, materia.nombre_materia, clase.contenido_clase, clase.plataforma_clase, clase.observaciones_clase from clase , departamento, materia, grupo where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and grupo.id_grupo = clase.id_grupo and departamento.id_departamento =:id_dep and clase.id_docente =:id_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin order by clase.fecha_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_doc"=>$id_docente,":f_ini"=>$fecha_inicio,":f_fin"=>$fecha_fin));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            //Cerramos el cursor, y empaquetamos la respuesta de la consulta en formato JSON
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        //EN USO
        public function obtenerCodigoClase($id_departamento, $id_docente, $fecha_inicio, $fecha_fin){
            $sql = "SELECT clase.codigo_clase, clase.fecha_clase, clase.periodo_hora_clase from clase , departamento, materia, grupo where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and grupo.id_grupo = clase.id_grupo and departamento.id_departamento =:id_dep and clase.id_docente =:id_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_doc"=>$id_docente,":f_ini"=>$fecha_inicio,":f_fin"=>$fecha_fin));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            
            $insertaronClases = false;
             
            //Verificamos la existencia de clases registradas
            //En caso de no tener ningun resultado, insertamos las clases para esa semana    
            if(count($respuesta) == 0 || is_null($respuesta)){
                $this->insertarClasesDocente($id_departamento, $id_docente, $fecha_inicio, $fecha_fin);
                $insertaronClases = true;
            }
            //De haberse insertado las clases anteriormente
            //Volvemos a realizar la consulta para obtener las clases de la semana correspondiente
            if($insertaronClases){
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_doc"=>$id_docente,":f_ini"=>$fecha_inicio,":f_fin"=>$fecha_fin));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            }



            $this->sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        private function insertarClasesDocente($id_departamento, $id_docente, $fecha_inicio, $fecha_fin){
            //Generamos las fechas de la semana anterior;
            $fecha_inicio_anterior = date("Y-m-d",strtotime($fecha_inicio."- 7 days"));
            $fecha_fin_anterior = date("Y-m-d",strtotime($fecha_fin."- 7 days"));
            //Obtenemos las clases que dicta el docente
            //Junto con los datos de la plataforma utilizada de la semana anterior
            $sql = "SELECT grupo_horario.dia, grupo_horario.hora, grupo.id_grupo, materia.id_materia, clase.plataforma_clase from materia, materia_docente, grupo, grupo_horario, clase where materia.id_materia = materia_docente.id_materia and materia_docente.id_docente =:id_doc and materia.id_departamento =:id_dep and materia.id_materia = grupo.id_materia and grupo.id_grupo = grupo_horario.id_grupo and grupo_horario.es_aux = 'f' and grupo_horario.dia = substring(clase.dia_clase,1,2)  and grupo_horario.hora = clase.periodo_hora_clase and grupo_horario.id_grupo = clase.id_grupo and clase.fecha_clase >=:f_ini_ant and clase.fecha_clase <=:f_fin_ant"; 
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_doc"=>$id_docente,":f_ini_ant"=>$fecha_inicio_anterior,":f_fin_ant"=>$fecha_fin_anterior));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);

            $existeCampoPlataforma = true;

            //Verificamos si la consulta nos genera resultado
            if(count($respuesta) == 0 || is_null($respuesta)){
                //Modificamos la consulta para solo obtener las clases que dicta el docente
                $sql = "SELECT grupo_horario.dia, grupo_horario.hora, grupo.id_grupo, materia.id_materia from materia, materia_docente, grupo, grupo_horario where materia.id_materia = materia_docente.id_materia and materia_docente.id_docente =:id_doc and materia.id_departamento =:id_dep and materia.id_materia = grupo.id_materia and grupo.id_grupo = grupo_horario.id_grupo and grupo_horario.es_aux = 'f'"; 
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_doc"=>$id_docente));
                $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
                $existeCampoPlataforma = false;
            }

            //Iteramos la variable $respuesta
            //Para concatenar la lista de valores a insertar
            $numeroClases = count($respuesta);
            $listaValores = "";
            for($i=0; $i<$numeroClases; $i++){
                $array_clase = $respuesta[$i];
                $listaValores .="(";
                switch ($array_clase['dia']) {
                    case 'LU':
                        $listaValores .="'".$fecha_inicio."',";
                        $listaValores .="'LUNES',";
                        break;
                    case 'MA':
                        $listaValores .="'".date("Y-m-d",strtotime($fecha_inicio."+ 1 days"))."',";
                        $listaValores .="'MARTES',";
                        break;
                    case 'MI':
                        $listaValores .="'".date("Y-m-d",strtotime($fecha_inicio."+ 2 days"))."',";
                        $listaValores .="'MIERCOLES',";
                        break;
                    case 'JU':
                        $listaValores .="'".date("Y-m-d",strtotime($fecha_inicio."+ 3 days"))."',";
                        $listaValores .="'JUEVES',";
                        break;
                    case 'VI':
                        $listaValores .="'".date("Y-m-d",strtotime($fecha_inicio."+ 4 days"))."',";
                        $listaValores .="'VIERNES',";
                        break;
                    case 'SA':
                        $listaValores .="'".date("Y-m-d",strtotime($fecha_inicio."+ 5 days"))."',";
                        $listaValores .="'SABADO',";
                        break;
                }
                $listaValores .= "'".$array_clase['hora']."',";
                $listaValores .= $array_clase['id_grupo'].",";
                $listaValores .= $array_clase['id_materia'].",";
                $listaValores .= $id_docente.",";
                $listaValores .= "'',";//Contenido
                if($existeCampoPlataforma){
                    $listaValores .= "'".$array_clase['plataforma_clase']."',";
                }else{
                    $listaValores .= "'',";    
                }
                $listaValores .= "'',";//Observaciones
                $listaValores .= "'f',";//existe_falta_clase
                $listaValores .= "'Ninguno',";//revisado
                $listaValores .= "'".$fecha_inicio."/".$fecha_fin."',";//periodo_reporte
                $listaValores .= "'No')";//asistencia_revisada

                //Verificamos si es el ultimo arreglo
                if($i+1 == $numeroClases){
                    $listaValores .= ";";
                }else{
                    $listaValores .= ",";
                }

            }
            
            //En caso de que el docente no tenga asignado ningun grupo
            //La variable $listaValores seria una cadena vacia
            //En ese caso no hacemos nada
            if($listaValores != ''){
                //Escribimos la consulta para la insercion de la(s) clase(s)
                $sql = "INSERT INTO clase(fecha_clase, dia_clase, periodo_hora_clase, id_grupo, id_materia, id_docente, contenido_clase, plataforma_clase, observaciones_clase, existe_falta_clase, revisado, periodo_reporte, asistencia_revisada) values".$listaValores;
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute();
            }

        }

        //EN USO
        public function actualizarClase($codigo_clase, $contenido_clase, $plataforma_clase, $observaciones_clase){
            $sql = "UPDATE clase set contenido_clase =:cont, plataforma_clase =:plat, observaciones_clase =:obs where codigo_clase =:cod_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":cont"=>$contenido_clase,":plat"=>$plataforma_clase,":obs"=>$observaciones_clase,":cod_clase"=>$codigo_clase));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }   

        public function obtenerReportesPendientesDocente($id_departamento, $fechaInicioSemanaActual){
            $sql = "SELECT distinct docente.sis_docente, docente.nombre_docente, clase.periodo_reporte from docente, materia, clase where docente.id_docente = clase.id_docente and materia.id_materia = clase.id_materia and materia.id_departamento =:id_dep and clase.revisado = 'Ninguno' and clase.fecha_clase < :f_ini order by clase.periodo_reporte desc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento, ":f_ini"=>$fechaInicioSemanaActual));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        } 

        public function obtenerFormularioControlAvanceDocente($id_departamento, $sis_docente, $array_periodo_reporte){
            $sql = "SELECT clase.fecha_clase, clase.periodo_hora_clase, grupo.nombre_grupo, materia.nombre_materia, clase.asistencia_revisada from clase, departamento, materia, grupo, docente where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and grupo.id_grupo = clase.id_grupo and departamento.id_departamento =:id_dep and clase.id_docente = docente.id_docente and docente.sis_docente =:sis_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin and revisado = 'Ninguno' order by clase.fecha_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":sis_doc"=>$sis_docente,":f_ini"=>$array_periodo_reporte[0],":f_fin"=>$array_periodo_reporte[1]));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function obtenerCamposRestantesFormularioControlAvanceDocente($id_departamento, $sis_docente, $array_periodo_reporte){
            $sql = "SELECT clase.codigo_clase, clase.fecha_clase, clase.periodo_hora_clase, clase.contenido_clase, clase.plataforma_clase, clase.observaciones_clase, clase.clase_recuperacion, clase.asunto_reposicion, clase.fecha_reposicion, clase.hora_reposicion, clase.plataforma_reposicion, clase.avanze_posicion, clase.existe_falta_clase, clase.asistencia_revisada from clase, departamento, materia, grupo, docente where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and departamento.id_departamento =:id_dep and clase.id_docente = docente.id_docente and docente.sis_docente =:sis_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin order by clase.fecha_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":sis_doc"=>$sis_docente,":f_ini"=>$array_periodo_reporte[0],":f_fin"=>$array_periodo_reporte[1]));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function obtenerEnlacesRecursosFormularioControlAvanceDocente($id_departamento, $sis_docente, $array_periodo_reporte){
            $sql = "SELECT clase.fecha_clase, clase.periodo_hora_clase,enlace_recurso_clase.descripcion_enlace_recurso, enlace_recurso_clase.direccion_enlace_recurso, enlace_recurso_clase.es_enlace from clase, departamento, materia, docente, enlace_recurso_clase where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and departamento.id_departamento =:id_dep and clase.id_docente = docente.id_docente and docente.sis_docente =:sis_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin and clase.codigo_clase = enlace_recurso_clase.codigo_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":sis_doc"=>$sis_docente,":f_ini"=>$array_periodo_reporte[0],":f_fin"=>$array_periodo_reporte[1]));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function actualizarAsistenciaClase($codigo_clase, $asistencia){
            $sql = "UPDATE clase set existe_falta_clase =:asistencia, asistencia_revisada = 'Si' where codigo_clase =:cod_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":asistencia"=>$asistencia,":cod_clase"=>$codigo_clase));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
        }

        public function actualizarRevisionJefeDepartamento($array_codigo_clase){
            if(!is_null($array_codigo_clase)){
                //concatenaremos los codigos de clase separados por comas excepto el ultimo
                $numeroCodigosClase = count($array_codigo_clase)-1;
                $conjuntoCodigosClase = "(";
                for($i=0; $i<$numeroCodigosClase; $i++){
                    $conjuntoCodigosClase .= $array_codigo_clase[$i];
                    $conjuntoCodigosClase .= ",";
                }
                $conjuntoCodigosClase .= $array_codigo_clase[$numeroCodigosClase];
                $conjuntoCodigosClase .= ")";

                $sql = "UPDATE clase set revisado = 'Jefe Departamento' where codigo_clase in".$conjuntoCodigosClase;
                $this->sentenceSQL = $this->connexion_bd->prepare($sql);
                $this->sentenceSQL->execute();
                $this->sentenceSQL->closeCursor();
            }
        }

        public function obtenerGestionesClasesRegistradasDepartamento($id_departamento){
            $sql = "SELECT distinct to_char(clase.fecha_clase, 'yyyy') as gestion from clase, materia where materia.id_materia = clase.id_materia and materia.id_departamento =:id_dep order by gestion desc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function obtenerMesClasesRegistradasDepartamento($gestion, $id_departamento){
            $sql = "SELECT distinct to_char(clase.fecha_clase, 'mm') as mes from clase, materia where materia.id_materia = clase.id_materia and materia.id_departamento =:id_dep and date_part('year',clase.fecha_clase) =:gestion order by mes desc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":gestion"=>$gestion));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }

        public function obtenerReportesRevisadosDocente($id_departamento, $gestion, $mes){
            $sql = "SELECT distinct docente.sis_docente, docente.nombre_docente, clase.periodo_reporte from docente, materia, clase where docente.id_docente = clase.id_docente and materia.id_materia = clase.id_materia and materia.id_departamento =:id_dep and clase.revisado = 'Jefe Departamento' and date_part('year', clase.fecha_clase) =:gestion and ((date_part('month', to_date(substring(clase.periodo_reporte from 1 for 10),'yyyy-mm-dd')) =:mes)or(date_part('month', to_date(substring(clase.periodo_reporte from 12 for 10),'yyyy-mm-dd')) =:mes)) order by clase.periodo_reporte desc";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":gestion"=>$gestion,":mes"=>$mes));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function obtenerFormularioControlAvanceDocenteRevisado($id_departamento, $sis_docente, $array_periodo_reporte){
            $sql = "SELECT clase.fecha_clase, clase.periodo_hora_clase, grupo.nombre_grupo, materia.nombre_materia, Case When clase.existe_falta_clase Then 'Si' ELse 'No' END  as falta_clase from clase, departamento, materia, grupo, docente where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and grupo.id_grupo = clase.id_grupo and departamento.id_departamento =:id_dep and clase.id_docente = docente.id_docente and docente.sis_docente =:sis_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin order by clase.fecha_clase";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":sis_doc"=>$sis_docente,":f_ini"=>$array_periodo_reporte[0],":f_fin"=>$array_periodo_reporte[1]));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

        public function obtenerClaseAuxiliarDocente($id_departamento, $id_aux_docente, $fecha_inicio, $fecha_fin){
            $sql = "SELECT clase.fecha_clase, clase.periodo_hora_clase, grupo.nombre_grupo, materia.nombre_materia, clase.contenido_clase, clase.plataforma_clase, clase.observaciones_clase from clase , departamento, materia, grupo where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and grupo.id_grupo = clase.id_grupo and departamento.id_departamento =:id_dep and clase.id_aux_docente =:id_aux_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_aux_doc"=>$id_aux_docente,":f_ini"=>$fecha_inicio,":f_fin"=>$fecha_fin));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            echo json_encode(array('data' => $respuesta), JSON_PRETTY_PRINT);
        }

            public function obtenerCodigoClaseAuxiliar($id_departamento, $id_aux_docente, $fecha_inicio, $fecha_fin){
            $sql = "SELECT clase.codigo_clase, clase.fecha_clase, clase.periodo_hora_clase from clase , departamento, materia, grupo where departamento.id_departamento = materia.id_departamento and materia.id_materia = clase.id_materia and grupo.id_grupo = clase.id_grupo and departamento.id_departamento =:id_dep and clase.id_aux_docente =:id_aux_doc and clase.fecha_clase >=:f_ini and clase.fecha_clase <=:f_fin";
            $this->sentenceSQL = $this->connexion_bd->prepare($sql);
            $this->sentenceSQL->execute(array(":id_dep"=>$id_departamento,":id_aux_doc"=>$id_aux_docente,":f_ini"=>$fecha_inicio,":f_fin"=>$fecha_fin));
            $respuesta = $this->sentenceSQL->fetchAll(PDO::FETCH_ASSOC);
            $this->sentenceSQL->closeCursor();
            return json_encode($respuesta);
        }
    }


