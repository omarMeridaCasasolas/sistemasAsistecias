<?php 
    session_start();
    if(isset($_POST['descLicencia']) && isset($_POST['clases'])){
        $descripcionLicencia = $_POST['descLicencia'];
        $listaClases = $_POST['clases'];
        $templ = $listaClases[0];
        require_once("../modelo/model_clase.php");
        $clase = new Clase();
        if(!is_numeric($templ)){
            $id = $_POST['ident'];
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['miFilePermiso']) && $_FILES['miFilePermiso']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['miFilePermiso']['tmp_name'])) {
                require('../vendor/autoload.php');
                $s3 = new Aws\S3\S3Client([
                    'version'  => '2006-03-01',
                    'region'   => 'us-east-2',
                ]);
                $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
                // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                try {
                    // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                    $upload = $s3->upload($bucket, $_FILES['miFilePermiso']['name'], fopen($_FILES['miFilePermiso']['tmp_name'], 'rb'), 'public-read');
                    $enlace= $upload->get('ObjectURL');
                    echo $enlace."\n";
                    foreach ($listaClases as $x) {
                        $res = $clase->solicitarLicenciaClaseSemURL($x,$id,$descripcionLicencia,$enlace);
                        if($res != 1 || $res ==false){
                            header("Location:../vista/home_docente.php?result=".$res);
                        }  
                    }
                    header("Location:../vista/home_docente.php?result=success");
                }catch(Exception $e) {
                    echo $e;
                }
            }else{
                foreach ($listaClases as $x) {
                    var_dump($x);
                    $res = $clase->solicitarLicenciaClaseSem($x,$id,$descripcionLicencia);
                    if($res != 1 || $res ==false){
                        header("Location:../vista/home_docente.php?result=".$res);
                        echo "huvo un error\n";
                    }  
                }
                echo "sin errorres\n";
                header("Location:../vista/home_docente.php?result=success");
            }
        }else{
            if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['miFilePermiso']) && $_FILES['miFilePermiso']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['miFilePermiso']['tmp_name'])) {
                require('../vendor/autoload.php');
                $s3 = new Aws\S3\S3Client([
                    'version'  => '2006-03-01',
                    'region'   => 'us-east-2',
                ]);
                $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
                // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
                try {
                    // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                    $upload = $s3->upload($bucket, $_FILES['miFilePermiso']['name'], fopen($_FILES['miFilePermiso']['tmp_name'], 'rb'), 'public-read');
                    $enlace= $upload->get('ObjectURL');
                    echo $enlace."\n";
                    foreach ($listaClases as $x) {
                        $res = $clase->solicitarLicenciaClaseURL($x,$descripcionLicencia,$enlace);
                        if($res != 1 || $res ==false){
                            header("Location:../vista/home_docente.php?result=".$res);
                        }  
                    }
                    header("Location:../vista/home_docente.php?result=success");
                }catch(Exception $e) {
                    echo $e;
                }
            }else{
                foreach ($listaClases as $x) {
                    var_dump($x);
                    $res = $clase->solicitarLicenciaClase($x,$descripcionLicencia);
                    if($res != 1 || $res ==false){
                        header("Location:../vista/home_docente.php?result=".$res);
                        echo "huvo un error\n";
                    }  
                }
                echo "sin errorres\n";
                header("Location:../vista/home_docente.php?result=success");
            }
        }     
    }else{
        echo "No se encontraron las variables de descripcion y observacion";
        echo $_POST['descLicencia']."\n";
        echo $_POST['clases']."\n";
    }
?>