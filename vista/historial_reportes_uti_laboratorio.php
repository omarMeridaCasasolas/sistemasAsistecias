<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historila de Auxliar de laboratorio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark d-inline-block w-100">
        <!-- Brand -->
        <img src="https://convocatoriaumss.s3.us-east-2.amazonaws.com/user.png" class="rounded" width="75" height="75">
        <h2 class="text-white d-inline-block"><?php echo $_SESSION['nombreTrabajador'];?></h2>
        <div class="float-right py-3">
            <button class="btn btn-primary"><i class="fas fa-envelope"></i></button>
            <button class="btn btn-primary"><i class="fas fa-user-edit"></i></button>
            <a href="" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
            </div>
        <ul class="navbar-nav">
            <!-- Dropdown -->
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Reportes:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="reportes_docentes.php">Docentes</a>
                <a class="dropdown-item" href="reportes_auxiliar_uti_dpa.php">Aux. pizarra</a>
                <a class="dropdown-item" href="reportes_uti_aux_lab.php">Aux. Laboratorio</a>
            </div>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Historial:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="historial_docentes_uti_dpa.php">Docentes</a>
                <a class="dropdown-item" href="historial_auxiliar_uti_dpa.php">Aux. pizarra</a>
                <a class="dropdown-item" href="historial_labo_uti_dpa.php">Aux. Laboratorio</a>
            </div>
            </li>
        </ul>
    </nav>
<body class="bg-secondary">
    <main class="bg-white mt-4 p-4 mx-auto rounded col-lg-8 col-md-12">
        <form action="" id="buscarReportesLab">
            <h2 class="text-center">Buscar reporte por</h2>
            <input type="text" class="d-none" name="idAuxiliarLaboratorio" id="idAuxiliarLaboratorio" value="<?php echo  $idAuxiliar; ?>">
                <div class="mx-auto">
                    <div class="form-group mx-auto col-lg-5 col-md-6">
                            <label for="selLaboratorio">Selecione sus reporten de:</label>
                            <select name="selLaboratorio" id="selLaboratorio" class="form-control">
                                <option value="Ninguno">Ninguno</option>
                            </select>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Buscar">
                    </div>
                </div>
            
        </form>
        <div class="responsive">
        <table id="tablaHistorialReporteLaboratorio" class="display nowrap cell-border" style="width:100%">
            <thead class="bg-info">
                <tr>
                    <th>Fecha</th>
                    <th>Trabajo relizado</th>
                    <th>Observacion</th>
                    <th>Documentos entregados</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
        </div>
    </main>    
    <script src="src/historial_repotes_laboratorio.js"></script>
</body>
</html>
