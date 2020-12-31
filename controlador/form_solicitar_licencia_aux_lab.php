<?php 
    session_start();
    if(isset($_POST['descPermiso']) && isset($_POST['fechas']) && isset($_POST['idHorarioLab'])){
        $descripcionLicencia = $_POST['descPermiso'];
        $fechas = $_POST['fechas'];
        $id = $_POST['idHorarioLab'];

        require_once("../modelo/model_reporte_aux_lab.php");
        $reporteAuxLab = new ReporteAuxLab();

        foreach ($fechas as $fecha) {
            $res = $reporteAuxLab->solicitarLicenciaAuxLab($id,$fecha,$descripcionLicencia);
            if($res != 1 || $res ==false){
                header("Location:../vista/home_auxiliar_laboratorio.php?result=".$res);
            }  
        }
        header("Location:../vista/home_auxiliar_laboratorio.php?result=success");

        require('../vendor/autoload.php');
        $s3 = new Aws\S3\S3Client([
            'version'  => '2006-03-01',
            'region'   => 'us-east-2',
        ]);
        $bucket = getenv('S3_BUCKET')?: die('No "S3_BUCKET" config var in found in env!');
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['miFilePermiso']) && $_FILES['miFilePermiso']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['miFilePermiso']['tmp_name'])) {
            // FIXME: you should add more of your own validation here, e.g. using ext/fileinfo
            try {
                // FIXME: you should not use 'name' for the upload, since that's the original filename from the user's computer - generate a random filename that you then store in your database, or similar
                $upload = $s3->upload($bucket, $_FILES['miFilePermiso']['name'], fopen($_FILES['miFilePermiso']['tmp_name'], 'rb'), 'public-read');
                $enlace= $upload->get('ObjectURL');
                echo $enlace."\n";
                foreach ($fechas as $fecha) {
                    $res = $reporteAuxLab->solicitarLicenciaAuxLabURL($id,$fecha,$descripcionLicencia,$enlace);
                    if($res != 1 || $res ==false){
                        header("Location:../vista/home_auxiliar_laboratorio.php?result=".$res);
                    }  
                }
                header("Location:../vista/home_auxiliar_laboratorio.php?result=success");
            }catch(Exception $e) {
                echo $e;
            }
        }else{
            foreach ($fechas as $fecha) {
                $res = $reporteAuxLab->solicitarLicenciaAuxLab($id,$fecha,$descripcionLicencia);
                if($res != 1 || $res ==false){
                    header("Location:../vista/home_auxiliar_laboratorio.php?result=".$res);
                }  
            }
            header("Location:../vista/home_auxiliar_laboratorio.php?result=success");
        }
    }else{
        echo "No se encontraron las variables de descripcion y observacion";
        echo $_POST['descPermiso']."\n";
        echo $_POST['fechas']."\n";
    }
?>