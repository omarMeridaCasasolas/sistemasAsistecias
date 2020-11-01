<?php
    session_start();
    if(isset($_SESSION['nombreAuxLab'])){

    }else{
        header("Location:../index.php?error=auntentificacion&tipo=auxiliar_laboratorio");
        // var_dump($_SESSION['nombreAuxLab']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido Auxliar de laboratorio</title>
</head>
<body>
    <h1>Bienvenido Axiliar de laboratorio <?php echo $_SESSION['nombreAuxLab']; ?></h1>
    <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>       
</body>
</html>