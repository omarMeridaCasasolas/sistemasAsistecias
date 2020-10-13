<?php
session_start();
if(isset($_SESSION["cargo"])){
    
}else{
    header("Location:../index.php?error=auntentificacion&tipo=autoridad");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home rector</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-secondary">
    <main class="container bg-white p-2 mt-4">
        <?php
            if(isset($_GET['event'])){
                $evento = $_GET['event'];
                if($evento == "success"){
                    echo "<div class='alert alert-success alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Exito!</strong> Se ha creado el usuario correctamente.
                        </div>";
                }else{
                    if($evento == "danger"){
                        echo "<div class='alert alert-danger alert-dismissible'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <strong>Problema!</strong> No se ha podido crear al usuario.
                        </div>";
                    }
                }
            }
        ?>
        <!-- <a href="Crear_director_carrera.php">Crear director de carrera/unidad</a> -->
        <div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                Crear jefe de departamento
            </button>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal2">
                Crear departamento
            </button>
        </div>
        <h2 class="text-primary text-center">Departamentos de FCYT</h2>
        <table id="example" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Codigo Departamento</th>
                    <th>Nombre de departamento</th>
                    <th>Fecha de creacion</th>
                    <th>Jefe de departamento</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>DPT-10</td>
                    <td>Departamento de Sistemas e informatica</td>
                    <td>1905-10-10</td>
                    <td>Maguel fulanito Mendes</td>
                </tr>
                <tr>
                    <td>DPT-105</td>
                    <td>Departamento de Civil</td>
                    <td>1905-05-10</td>
                    <td>Carlos choque Perez</td>
                </tr>
                <tr>
                    <td>DPT-71</td>
                    <td>Departamento de electronica y electromecanica</td>
                    <td>1945-05-10</td>
                    <td>Karen Gutierrez</td>
                </tr>
                <tr>
                    <td>DPT-152</td>
                    <td>Departamento industrial</td>
                    <td>1925-05-10</td>
                    <td>Juan Terreazas Prada</td>
                </tr>
            </tbody>
        </table>
        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear jefe de departamento</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="../controlador/formRegistrarJefeDepartamento.php" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomJefDep">Nombre jefe de departamento</label>
                                <input type="text" name="nomJefDep" id="nomJefDep" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="ciJefDep">Carnet de identidad</label>
                                <input type="text" name="ciJefDep" id="ciJefDep" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoJefDep">Correo electronico: </label>
                                <input type="email" name="correoJefDep" id="correoJefDep" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telJefDep">Telefono: </label>
                                <input type="text" name="telJefDep" id="telJefDep" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="depJef">Selccione Departamento: </label>
                                <select class="form-control" id="depJef" name="depJef">
                                    <option>Departamento de Sistemas e informatica</option>
                                    <option>Departamento Industrial</option>
                                    <option>Departamento De ingenieria Civil</option>
                                    <option>Departamento de Electronica y Electromecanica</option>
                                </select required>
                                <div class="invalid-feedback">Seleccione departamento</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisJefDep">Codigo SIS: </label>
                                <input type="password" name="sisJefDep" id="sisJefDep" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passJefDep">Ingrese password: </label>
                                <input type="password" name="passJefDep" id="passJefDep" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Jefe de departamento">
                            <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal2">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear departamento</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomFacultad">Nombre de la facultad: </label>
                                <input type="text" name="nomFacultad" id="nomFacultad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="facCodigo">Codigo facultad: </label>
                                <input type="text" name="facCodigo" id="facCodigo" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="facFechaCrea">Seleccione fecha: </label>
                                <input type="date" name="facFechaCrea" id="facFechaCrea" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="dirFac">Escoja Director Academico: </label>
                                <select class="form-control" id="dirFac">
                                    <option>Sujeto Uno</option>
                                    <option>Sujeto Dos</option>
                                    <option>Sujeto Tres</option>
                                    <option>Sujeto Cinco</option>
                                </select required>
                                <div class="invalid-feedback">Silecione facultad</div>
                            </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Director Academico">
                            <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--<script src="src/home_rector.js"></script>-->
    <script >$(document).ready(function() {
        $('#example').DataTable();
        } );</script>
</body>
</html>