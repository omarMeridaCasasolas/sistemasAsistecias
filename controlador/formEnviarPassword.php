<?php
    // If you are using Composer
    require '../vendor/autoload.php';
                    
    $from = new SendGrid\Email(null, "Asistencia_Virtual_UMSS@mail.com");
    $subject = "Recuperacion de password ";
    $to = new SendGrid\Email(null, $destino);
    $content = new SendGrid\Content("text/html", "<p>Hemos visto que ha tenido problemas para recordar su password <strong>$password</strong></p>");
    //$content = new SendGrid\Content("text/plain","Hemos visto que ha tenido problemas para recordar su password ");
    $mail = new SendGrid\Mail($from, $subject, $to, $content);

    $apiKey = getenv('SENDGRID_API_KEY');
    $sg = new \SendGrid($apiKey);

    $response = $sg->client->mail()->send()->post($mail);
    echo $response->statusCode();
    //echo $response->headers();
    //echo $response->body();
?>
