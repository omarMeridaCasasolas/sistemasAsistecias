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
    <title>home DPA</title>
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
        <img src="<?php echo $_SESSION['foto_trabajador'];?>" class="rounded" width="75" height="75">
        <h4 class="text-white d-inline-block"><?php echo $_SESSION['cargoTrabajador'].": ".$_SESSION['nombreTrabajador'];?></h4>
        <div class="float-right py-3">
            <button class="btn btn-primary" data-toggle="modal" id="btnEditSelf" data-target="#myModalEditarDatos"><i class="fas fa-user-edit"></i></button>
            <button type="button" class="btn btn-primary d-inline-block" data-toggle="modal" data-target="#abrirVtnCorreo" id="btnAbrirCorreo"><i class="fas fa-envelope"></i></button>
            <a href="../controlador/formCerrarSession.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
            <br>
            <h6 class="text-white my-1">Bolivia <span id="div_date_time"></span></h6>
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
        <h2 class="text-center">Publicaciones a la UTI</h2>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam nesciunt odit et deserunt minima ea, officiis vitae cupiditate consectetur culpa quaerat reprehenderit, animi impedit blanditiis saepe laborum! Ipsa, incidunt aliquam.</p>
        <hr>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad accusantium aut, explicabo quaerat aliquid inventore dolor aperiam! Suscipit vero earum esse dolor. Ad nisi, iusto libero doloremque deleniti modi quod.</p>
        <hr>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nulla, vitae! Tenetur, est nam? Eum nulla architecto porro laboriosam dolores, quasi magni molestiae. Atque quis vero porro ipsa veniam, culpa dolore!</p>
    </main>
    <script src="src/home_dpa.php"></script>
</body>
</html>