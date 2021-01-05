<?php
    session_start();
    if(isset($_POST['codClaseReporte']) && isset($_POST['textareaDescripcionRecurso'])){
        $id = $_POST['codClaseReporte'];
        $descripcion = $_POST['textareaDescripcionRecurso'];
        require_once("../modelo/model_clase.php");
        $clase = new Clase();
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['inputFileRecurso']) && $_FILES['inputFileRecurso']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['inputFileRecurso']['tmp_name'])) {
            require('../vendor/autoload.php');
            $s3 = new Aws\S3\S3Client([
                'version'  => '2006-03-01',
                'region'   => 'us-east-2',
            ]);
            $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
            // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
            try {
                // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                $upload = $s3->upload($bucket, $_FILES['inputFileRecurso']['name'], fopen($_FILES['inputFileRecurso']['tmp_name'], 'rb'), 'public-read');
                $enlace= $upload->get('ObjectURL');
                echo $enlace."\n";
                $res = $clase->adjuntarArchivoClaseURL($id,$descripcion,$enlace);
                if($res != 1 || $res ==false){
                    header("Location:../vista/home_docente.php?result=".$res);
                }else{
                    header("Location:../vista/home_docente.php?result=success");
                }
            }catch(Exception $e) {
                echo $e;
            }
        }else{
            $res = $clase->adjuntarArchivoClase($id,$descripcion);
            if($res != 1 || $res ==false){
                header("Location:../vista/home_docente.php?result=".$res);
            }else{
                header("Location:../vista/home_docente.php?result=success");
            }
            echo "sin errorres\n";
            header("Location:../vista/home_docente.php?result=success");
        }
    }else{
        echo "Error al precentar\n".$_POST['codClaseReporte']," o ".$_POST['textareaDescripcionRecurso'];
    }
?>