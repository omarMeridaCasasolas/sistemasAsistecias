<?php
    session_start();
    if(isset($_SESSION["codigo_autoridad"])){

    }else{
         header("Location:../index.php");
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
<header>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <h2 class="text-white p-2"><?php echo $_SESSION['cargo'].": ".$_SESSION['nombre_autoridad'];?></h2>
        <div class="d-block">
        <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>
        </div>
    </nav>
</header>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <div id="exito" class="d-none">
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Exito!</strong> Se ha creado el usuario correctamente.
            </div>
        </div>
        <div id="error" class="d-none">
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Problema!</strong> No se ha podido crear al usuario.
            </div>
        </div>
        <!-- <a href="Crear_director_carrera.php">Crear director de carrera/unidad</a> -->
        <div>
            <button type="button" class="btn btn-primary justify-content-end" data-toggle="modal" data-target="#myModal2">
                Crear facultad
            </button>
        </div>
        <h2 class="text-primary text-center">Facultades de UMSS</h2>
        <table id="tableFacultad" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Codigo Facultad</th>
                    <th>Nombre de la facultad</th>
                    <th>Fecha de creacion</th>
                    <th>Director Academico</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            </tbody>
        </table>
        <!-- director academico -->
        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
                Crear director academico
            </button>
        <br>
        <h2 class="text-primary text-center">Directores academicos</h2>
        <table id="tablaDirAcademico" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Director Academico</th>
                    <th>Facultad </th>
                    <th>Correo electronico</th>
                    <th>Telefono</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear director academico</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body ../controlador/formRegistrarDirectorAcademico.php-->
                    <div class="modal-body">
                    <form action="" method="post" class="was-validated" id="formAgregarDirectorAcademico">
                        <div class="form-group">
                                <label for="nomDirAcad">Nombre director Academico</label>
                                <input type="text" name="nomDirAcad" id="nomDirAcad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="ciDirAcad">Carnet de identidad</label>
                                <input type="text" name="ciDirAcad" id="ciDirAcad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoDirAcad">Correo electronico: </label>
                                <input type="email" name="correoDirAcad" id="correoDirAcad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telDirAcad">Telefono: </label>
                                <input type="text" name="telDirAcad" id="telDirAcad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="facDirAcad">Escoja Facultadad: </label>
                                <select class="form-control" id="facDirAcad" name="facDirAcad" >
                                    <option value="">Ninguno</option>
                                </select>
                                <div class="invalid-feedback">Selecione facultad</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisDirAcad">Codigo SIS</label>
                                <input type="password" name="sisDirAcad" id="sisDirAcad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passDirAcad">Ingrese password</label>
                                <input type="password" name="passDirAcad" id="passDirAcad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Director Academico">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarAutoridad">Cancelar</button>
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
                        <h2 class="modal-title text-center">Crear Facultad</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formCrearFacultad" method="post" class="was-validated">
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
                                <select class="form-control" id="dirFac" required>
                                    <option value="">None</option>
                                    <option>Sujeto Uno</option>
                                    <option>Sujeto Dos</option>
                                    <option>Sujeto Tres</option>
                                    <option>Sujeto Cinco</option>
                                </select required>
                                <div class="invalid-feedback">Silecione facultad</div>
                            </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Director Academico">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Facultad ventana -->

        <div class="modal fade" id="myModal4">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar Facultad</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarFacultad" method="post" class="was-validated">
                    <input type="text" class="d-none" name="idFacultadEditar" id="idFacultadEditar">
                        <div class="form-group">
                                <label for="nomEditFacultad">Editar nombre de la facultad: </label>
                                <input type="text" name="nomEditFacultad" id="nomEditFacultad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="facEditCodigo">Editar codigo facultad: </label>
                                <input type="text" name="facEditCodigo" id="facEditCodigo" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="facEditFechaCrea">Editar fecha: </label>
                                <input type="date" name="facEditFechaCrea" id="facEditFechaCrea" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="dirEditFac">Editar Director Academico: </label>
                                <select class="form-control" id="dirEditFac" required>
                                    <option value="">None</option>
                                    <option>Sujeto Uno</option>
                                    <option>Sujeto Dos</option>
                                    <option>Sujeto Tres</option>
                                    <option>Sujeto Cinco</option>
                                </select required>
                                <div class="invalid-feedback">Silecione facultad</div>
                            </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Actualizar facultad">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEditarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal eliminar ventana -->

        <div class="modal fade" id="myModal5">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar Facultad</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarFacultad" method="post" class="was-validated">
                        <input type="text" class="d-none" name="" id="idFacultadEliminar">
                        <p> Usted esta seguro que quiere eliminar la facultadad <strong id="nomFacultadEliminar"></strong> con el codigo: <strong id="codFacultadEliminar"></strong><p>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Eliminar Facultad">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEliminarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/home_rector.js"></script>
</body>
</html>