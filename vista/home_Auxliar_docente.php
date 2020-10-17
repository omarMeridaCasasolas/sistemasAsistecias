<?php
    session_start();
    if(isset($_SESSION['nombreAuxDoc'])){

    }else{
        header("Location:../index.php?error=auntentificacion&tipo=auxiliar_docente");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido auxiliar de docente</title>
</head>
<body>
    <h1>Bienvenido auxiliar de docente<?php echo $_SESSION['nombreAuxDoc']; ?></h1>
    <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>
</body>
</html>