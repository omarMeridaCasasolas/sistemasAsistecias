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
    <title>UTI-DPA</title>
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
        <h2 class="text-white d-inline-block"><?php echo $_SESSION['nombreTrabajador'];?></h2>
        <div class="float-right py-3">
            <button class="btn btn-primary"><i class="fas fa-envelope"></i></button>
            <button class="btn btn-primary" data-toggle="modal" id="btnEditSelf" data-target="#myModalEditarDatos"><i class="fas fa-user-edit"></i></button>
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
                <a class="dropdown-item" href="historial_reportes_uti_docentes.php">Docentes</a>
                <a class="dropdown-item" href="historial_reportes_uti_pizarra.php">Aux. pizarra</a>
                <a class="dropdown-item" href="historial_reportes_uti_laboratorio.php">Aux. Laboratorio</a>
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

    <!-- The Modal -->
    <div class="modal fade" id="myModalEditarDatos">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Cambiar datos peronales</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="../controlador/formActualizarDatosUTIDPA.php" id="editFormSelf" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <input type="text" name="idUsuarioSync" id="idUsuarioSync" class="d-none" value="<?php echo $_SESSION['idTrabajador'];?>">
                            <div class="form-group col-7">
                                <label for="editCorreo">Correo electronico:</label>
                                <input type="text" name="editCorreo" id="editCorreo" class="form-control" required value="<?php echo $_SESSION['correoTrabajador'];?>">
                            </div>
                            <div class="form-group col-5">
                                <label for="editTel">Telefono:</label>
                                <input type="text" name="editTel" id="editTel" class="form-control" value="<?php echo $_SESSION['telefonoTrabajador'];?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="nuevoPass">Nueva contraseña</label>
                                <input type="password" name="nuevoPass" id="nuevoPass" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <label for="repeatPAss">Repetir contaseña</label>
                                <input type="password" name="repeatPAss" id="repeatPAss" class="form-control">
                            </div>
                        </div>
                        <span class="text-danger" id="changePassUser"></span>
                        <div class="form-group">
                            <label for="myFile">Selecione una foto o imagen</label>
                            <input type="file" name="myFile" id="myFile" accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="editPass">Contraseña:</label>
                            <input type="password" name="editPass" id="editPass" class="form-control" required>
                            <span class="text-danger" id="editUsurPassSelf"></span>
                        </div>
                        <input type="text" name="passTrabajador" id="passTrabajador" value="<?php echo $_SESSION['passTrabajador'];?>" class="d-none">
                        <div class="text-center">
                        <input type="submit" class="btn btn-secondary" value="Actualizar">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/home_uti.js"></script>
</body>
</html>