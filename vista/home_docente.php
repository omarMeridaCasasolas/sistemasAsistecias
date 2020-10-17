<?php
    session_start();
    if(isset($_SESSION['nombreDocente'])){

    }else{
        header("Location:../index.php?error=auntentificacion&tipo=docente");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Docente</title>
</head>
<body>
    <h1>Bienvenido <?php echo $_SESSION['nombreDocente']; ?></h1>
    <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>
</body>
</html>