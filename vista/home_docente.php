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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-dark">
    <header>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <h1 class="bg-white">Bienvenido <?php echo $_SESSION['nombreDocente']; ?></h1>
            <div class="d-block">
            <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>
            </div>
        </nav>
    </header>
    <main class="bg-secondary">
        <form action="post" id="escogerClases">
            <input type="text" name="idDocente" id="idDocente" value="<?php echo $_SESSION['idDocente'];?>">
        </form>
        <?php 
            $res = 1;
        ?>
        <table id="tablaReporteDocente">
            <thead>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Grupo</th>
                <th>Materia</th>
                <th>Contenido de clase</th>
                <!-- <th>Plataforma o medio digital</th>
                <th>Observacion</th> -->
                <th>Opciones</th>
            </thead>
        </table>
    </main>
    <script src="src/home_docente.js"></script>
    
</body>
</html>