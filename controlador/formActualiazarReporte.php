<?php 
    session_start();
    if(isset($_POST['idRegistro']) && isset($_POST['txtDescripcion']) && isset($_POST['txtObservacion'])){
        $descripcion = $_POST['txtDescripcion'];
        $observacion = $_POST['txtObservacion'];
        $identificador = $_POST['idRegistro'];

        require_once("../modelo/model_reporte_aux_lab.php");
        $reporteAuxLab = new ReporteAuxLab();
        
        // $res = $reporteAuxLab->actualizarReporteAuxLabUrl($identificador,$descripcion,$observacion,$enlace);
        //         if($res){
        //             header("Location:../vista/home_auxiliar_laboratorio.php");
        //         }else{
        //             var_dump($res);
        //         }

        require('../vendor/autoload.php');
        // this will simply read AWS_ACCESS_KEY_ID and AWS_SECRET_ACCESS_KEY from env vars
        $s3 = new Aws\S3\S3Client([
            'version'  => '2006-03-01',
            'region'   => 'us-east-2',
        ]);
        $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
        //$bucket = 'convocatoriaumss';

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['myFile']) && $_FILES['myFile']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['myFile']['tmp_name'])) {
            // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
            try {
                // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                $upload = $s3->upload($bucket, $_FILES['myFile']['name'], fopen($_FILES['myFile']['tmp_name'], 'rb'), 'public-read');
                //Mi Codigo

                //$enlace= htmlspecialchars($upload->get('ObjectURL'));
                $enlace= $upload->get('ObjectURL');

                echo $enlace."\n";
                
                $res = $reporteAuxLab->actualizarReporteAuxLabUrl($identificador,$descripcion,$observacion,$enlace);
                if($res){
                    header("Location:../vista/home_auxiliar_laboratorio.php");
                }else{
                    var_dump($res);
                }
            }catch(Exception $e) {
                echo $e;
            }
        }else{
            $res = $reporteAuxLab->actualizarReporteAuxLab($identificador,$descripcion,$observacion);
            if($res){
                header("Location:../vista/home_auxiliar_laboratorio.php");
            }else{
                var_dump($res);
            }
        }
    }else{
        echo "No se encontraron las variables de descripcion y observacion";
    }


?>