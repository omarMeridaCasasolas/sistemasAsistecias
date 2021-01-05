<?php 
    session_start();
    if($_SESSION['cargoTrabajador'] == "SuperUsuario"){

    }else{
        header("Location:../index.php?error=Laboratorio");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Usuario</title>
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
            <a href="../controlador/formCerrarSession.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
            <br>
            <h6 class="text-white my-1">Bolivia <span id="div_date_time"></span></h6>
        </div>
    </nav>
    <main class="container bg-white my-2 py-2">
        <h1 class="text-center text-primary">Personal UTI</h1>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal7">Agregar UTI</button>
        <hr>
        <table class="table table-hover" id="tableUTI">
            <thead class="bg-info">
            <tr>
                <th>Nombre</th>
                <th>CorreoELectronico</th>
                <th>Telefono</th>
                <th>Opciones</th>
            </tr>
            </thead>
        </table>
        <hr>
        <h1 class="text-center text-primary">Personal DPA</h1>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal8">Agregar DPA</button>
        <hr>
        <table class="table table-hover" id="tableDPA">
            <thead class="bg-info">
            <tr>
                <th>Nombre</th>
                <th>CorreoELectronico</th>
                <th>Telefono</th>
                <th>Opciones</th>
            </tr>
            </thead>
        </table>
        <hr>
        <h1 class="text-center text-primary">Rector</h1>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal9">Agregar Rector</button>
        <hr>
        <table class="table table-hover" id="tableRector">
            <thead class="bg-info">
            <tr>
                <th>Nombre</th>
                <th>CorreoELectronico</th>
                <th>Telefono</th>
                <th>Opciones</th>
            </tr>
            </thead>
        </table>
        <hr>
    </main>
    <!-- Modal Editar UTI -->
    <div class="modal fade" id="myModal0">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar personal UTI</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarUTI"  class="was-validated">
                    <input type="text" name="editUTICod" id="editUTICod" class="d-none">
                    <!-- <input type="text" class="d-none" name="idFacultadEditar" id="idFacultadEditar"> -->
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="editUTINom">Editar nombre: </label>
                                <input type="text" name="editUTINom" id="editUTINom" class="form-control"  autocomplete="off"required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="editUTICi">Editar CI: </label>
                                <input type="text" name="editUTICi" id="editUTICi" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="EditUTICorreo">Editar correo: </label>
                                <input type="mail" name="EditUTICorreo" id="EditUTICorreo" class="form-control" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-5">
                                <label for="EditUTITel">Editar telefono: </label>
                                <input type="text" name="EditUTITel" id="EditUTITel" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal Eliminar personal de la UTI -->
    <div class="modal fade" id="myModal1">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar personal UTI</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarUTI" >
                        <input type="text" name="delUTICod" id="delUTICod" class="d-none">
                        <h4>¿Desea eliminar personal de la UTI?</h4>
                        <strong id="delUTINom" class="text-center"></strong>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal Editar DPA -->
    <div class="modal fade" id="myModal2">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar personal DPA</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarDPA"  class="was-validated">
                    <input type="text" name="editDPACod" id="editDPACod" class="d-none">
                    <!-- <input type="text" class="d-none" name="idFacultadEditar" id="idFacultadEditar"> -->
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="editDPANom">Editar nombre: </label>
                                <input type="text" name="editDPANom" id="editDPANom" class="form-control"  autocomplete="off"required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="editDPACi">Editar CI: </label>
                                <input type="text" name="editDPACi" id="editDPACi" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="EditDPACorreo">Editar correo: </label>
                                <input type="mail" name="EditDPACorreo" id="EditDPACorreo" class="form-control" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-5">
                                <label for="EditDPATel">Editar telefono: </label>
                                <input type="text" name="EditDPATel" id="EditDPATel" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Actualizar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal Eliminar DPA -->
    <div class="modal fade" id="myModal3">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar personal DPA</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarDPA" >
                        <input type="text" name="delDPACod" id="delDPACod" class="d-none">
                        <h4>¿Desea eliminar personal de la DPA?</h4>
                        <strong id="delDPANom" class="text-center"></strong>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal Editar Rector -->
    <div class="modal fade" id="myModal4">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar Rector</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarDirector"  class="was-validated">
                    <input type="text" name="editRectorCod" id="editRectorCod" class="d-none">
                    <!-- <input type="text" class="d-none" name="idFacultadEditar" id="idFacultadEditar"> -->
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="editRectorNom">Editar nombre: </label>
                                <input type="text" name="editRectorNom" id="editRectorNom" class="form-control"  autocomplete="off"required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="editRectorCi">Editar CI: </label>
                                <input type="text" name="editRectorCi" id="editRectorCi" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="EditRectorCorreo">Editar correo: </label>
                                <input type="mail" name="EditRectorCorreo" id="EditRectorCorreo" class="form-control" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-5">
                                <label for="EditRectorTel">Editar telefono: </label>
                                <input type="text" name="EditRectorTel" id="EditRectorTel" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Actualizar">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal Eliminar Rector -->
        <div class="modal fade" id="myModal5">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar Rector</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarDirector" >
                        <input type="text" name="delRectorCod" id="delRectorCod" class="d-none">
                        <h4>¿Desea eliminar al rector?</h4>
                        <strong id="delRectorNom" class="text-center"></strong>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Eliminar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Agregar UTI-->
    <div id="myModal7" class="modal fade">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title">Agregar persona UTI</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddUTI">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="addUTINom">Nombre: </label>
                                <input type="text" name="addUTINom" id="addUTINom" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="addUTICi">Carnet: </label>
                                <input type="text" name="addUTICi" id="addUTICi" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="addUTICorreo">Correo electronico: </label>
                                <input type="mail" name="addUTICorreo" id="addUTICorreo" class="form-control" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-5">
                                <label for="addUTITel">Telefono: </label>
                                <input type="text" name="addUTITel" id="addUTITel" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="addUTIPass">Contraseña: </label>
                            <input type="password" name="addUTIPass" id="addUTIPass" class="form-control"  autocomplete="off" required>
                            <div class="invalid-feedback">llene el campo</div>
                        </div>       
                        <div class="text-center">
                            <input type="submit" value="Crear" class="btn btn-primary">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar UTI-->
    <div id="myModal8" class="modal fade">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title">Agregar persona DPA</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddDPA">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="addDPANom">Nombre: </label>
                                <input type="text" name="addDPANom" id="addDPANom" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="addDPACi">Carnet: </label>
                                <input type="text" name="addDPACi" id="addDPACi" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="addDPACorreo">Correo electronico: </label>
                                <input type="mail" name="addDPACorreo" id="addDPACorreo" class="form-control" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-5">
                                <label for="addDPATel">Telefono: </label>
                                <input type="text" name="addDPATel" id="addDPATel" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="addDPAPass">Contraseña: </label>
                            <input type="password" name="addDPAPass" id="addDPAPass" class="form-control"  autocomplete="off" required>
                            <div class="invalid-feedback">llene el campo</div>
                        </div>       
                        <div class="text-center">
                            <input type="submit" value="Crear" class="btn btn-primary">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Agregar Rector-->
    <div id="myModal9" class="modal fade">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h4 class="modal-title">Agregar Rector</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" id="formAddRector">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="addRectorNom">Nombre: </label>
                                <input type="text" name="addRectorNom" id="addRectorNom" class="form-control"  autocomplete="off"required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="addRectorCi">Carnet: </label>
                                <input type="text" name="addRectorCi" id="addRectorCi" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-7">
                                <label for="addRectorCorreo">Correo electronico: </label>
                                <input type="mail" name="addRectorCorreo" id="addRectorCorreo" class="form-control" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-5">
                                <label for="addRectorTel">Telefono: </label>
                                <input type="text" name="addRectorTel" id="addRectorTel" class="form-control"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="addRectorPass">Contraseña: </label>
                            <input type="password" name="addRectorPass" id="addRectorPass" class="form-control"  autocomplete="off" required>
                            <div class="invalid-feedback">llene el campo</div>
                        </div>       
                        <div class="text-center">
                            <input type="submit" value="Crear" class="btn btn-primary">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/superUser.js"></script>
</body>
</html>