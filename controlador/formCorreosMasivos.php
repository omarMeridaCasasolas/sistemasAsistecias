
<?php
    if(isset($_POST['titulo']) && isset($_POST['descripcion'])){
        $subject = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];

        require '../vendor/autoload.php';
        $from = new SendGrid\Email(null, "umss_asistencia_vitrual@mail.com");
        //$to = new SendGrid\Email(null, $destino);
        $content = new SendGrid\Content("text/html", "<p>".$descripcion."</p>");

        for ($i=0; $i < count($_POST['correos']); $i++) { 
            $correo = $_POST['correos'][$i];
            $to = new SendGrid\Email(null, $correo);
            $mail = new SendGrid\Mail($from, $subject, $to, $content);
            $apiKey = getenv('SENDGRID_API_KEY');
            $sg = new \SendGrid($apiKey);
            $response = $sg->client->mail()->send()->post($mail);
            $res = $response->statusCode();
            if($res != 202){
                return $res;
            }
        }
        return true;


        //echo $response->headers();
        //echo $response->body();
    }
?>
