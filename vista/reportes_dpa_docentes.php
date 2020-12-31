<?php
    session_start();
    if(isset($_SESSION['nombreTrabajador'])){
        
    }else{
        header("Location:../index.php?error=auntentificacion&tipo=docente");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes DPA docentes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-secondary">
<nav class="navbar navbar-expand-sm bg-dark navbar-dark d-inline-block w-100">
        <!-- Brand -->
        <img src="https://convocatoriaumss.s3.us-east-2.amazonaws.com/user.png" class="rounded" width="75" height="75">
        <h2 class="text-white d-inline-block"><?php echo $_SESSION['nombreTrabajador'];?></h2>
        <div class="float-right py-3">
            <button class="btn btn-primary"><i class="fas fa-envelope"></i></button>
            <a href="home_dpa.php" class="btn btn-primary"><i class="fas fa-home"></i></a>
            <a href="../controlador/formCerrarSession.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        <ul class="navbar-nav">
            <!-- Dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Reportes:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="reportes_dpa_docentes.php">Docentes</a>
                <a class="dropdown-item" href="reportes_dpa_pizarra.php">Aux. pizarra</a>
                <a class="dropdown-item" href="reportes_dpa_laboratorio.php">Aux. Laboratorio</a>
            </div>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Historial:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="historial_dpa_docentes.php">Docentes</a>
                <a class="dropdown-item" href="historial_dpa_pizarra.php">Aux. pizarra</a>
                <a class="dropdown-item" href="historial_dpa_laboratorio.php">Aux. Laboratorio</a>
            </div>
            </li>
        </ul>
    </nav>
    <main class="container bg-white py-4">
        
    </main>
</body>
</html>