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
<body class="bg-secondary">
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark d-inline-block w-100">
        <!-- Brand -->
        <img src="<?php echo $_SESSION['foto_user'];?>" class="rounded" width="75" height="75">
        <h4 class="text-white d-inline-block">Docente: <?php echo $_SESSION['nombreDocente'];?></h4>
        <div class="float-right py-3">
            <a href="home_docentes.php" class="btn btn-primary" title="historial de licencias"><i class="fas fa-home"></i></a>
            <button class="btn btn-primary" data-toggle="modal" id="btnEditSelf" data-target="#myModalEditarDatos" title="Editar datos"><i class="fas fa-user-edit"></i></button>
            <a href="historial_reportes_docente.php" class="btn btn-primary" title="historial de asistencia"><i class="far fa-clipboard"></i></a>
            <a href="../controlador/formCerrarSession.php" class="btn btn-primary" title="Cerrar Session"><i class="fas fa-sign-out-alt"></i></a>
            <br>
            <h6 class="text-white my-1">Bolivia <span id="div_date_time"></span></h6>
        </div>
    </nav>
    <main class="bg-secondary container my-2 py-2 bg-white min-vh-100">
        <input type="text" class="d-none" name="idDocente" id="idDocente" value="<?php echo $_SESSION['idDocente'];?>">
        <h2 class="text-center text-primary">Lista de licencias solicitadas</h2>
        <hr>
        <table id="tablaLicencias" class="hover cell-border">
            <thead>
                <tr class="bg-info">
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Materia</th>
                    <th>Asunto</th>
                    <th>Enlace</th>
                </tr>
            </thead>
        </table>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/licencias_presentadas_docentes.js"></script>
    
</body>
</html>