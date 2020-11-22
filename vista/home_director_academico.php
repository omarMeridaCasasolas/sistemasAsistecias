<?php include_once("parts/cabezera_director.php");?>
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
        <div class="d-none">
            <input type="text" name="idCategoria" id="idCategoria" value="<?php echo $_SESSION['categoria_social'];?>">
        </div>
        <!-- <a href="Crear_director_carrera.php">Crear director de carrera/unidad</a> -->
        <div>
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal2">
                Crear departamento
            </button>
        </div>
        <h2 class="text-primary text-center">Departamentos de FCYT</h2>
        <table id="tableDepartamentos" class="hover" style="width:100%">
            <thead class="bg-info">
                <tr>
                    <th>Codigo Departamento</th>
                    <th>Nombre de departamento</th>
                    <th>Fecha de creacion</th>
                    <th>Jefe de departamento</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
        <!-- Tabla de Jefes de departamentos -->
        <br>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" id="btnCrearJefe">
                Crear jefe de departamento
            </button>
        <br>
        <br>
        <h2 class="text-primary text-center">Directores de departamentos</h2>
        <table id="tablaDirector" class="hover" style="width:100%">
            <thead class="bg-info">
                <tr>
                    <th>Codigo SIS</th>
                    <th>Nombre del director</th>
                    <th>Asignacion </th>
                    <th>Correo electronico</th>
                    <th>Telefono</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>



<div class="modal fade" id="modalEditarDirectorDep">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="modal-title text-center">Editar director de departamento</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <form id="formEditarDirectorDep">    
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nombre director de departamento</label>
                    <input type="text" name="" id="formEditarNomDirDep" class="form-control" required>
                    <div class="invalid-feedback">llene el campo</div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Codigo SIS:</label>
                    <input type="text" class="form-control" id="formEditarCodSisDirDep" required="">
                    <div class="invalid-feedback">llene el campo</div>
                    </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Departamento asignado:</label>
                    <select class="form-control" id="formEditarFacAsiDirDep" name="formEditarFacAsiDirDep" required="">
                    </select>
                    </div> 
                    </div>    
                </div>
                <div class="row"> 
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Correo electronico</label>
                    <input type="text" class="form-control" id="formEditarCorDirDep">
                    <div class="invalid-feedback">llene el campo</div>
                    </div> 
                    </div> 
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Telefono</label>
                    <input type="text" class="form-control" id="formEditarTelDirDep" required="">
                    <div class="invalid-feedback">llene el campo</div>
                    </div>               
                    </div> 
                </div> 
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  
        

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
                    <form action="" id="formInsertarDirector" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomDirector">Nombre jefe de departamento</label>
                                <input type="text" name="nomDirector" id="nomDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="ciDirector">Carnet de identidad</label>
                                <input type="text" name="ciDirector" id="ciDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoDirector">Correo electronico: </label>
                                <input type="email" name="correoDirector" id="correoDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telDirector">Telefono: </label>
                                <input type="text" name="telDirector" id="telDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="asigDirector">Seleccione Departamento: </label>
                                <select class="form-control" id="asigDirector" name="asigDirector">
                                </select>
                                <div class="invalid-feedback">Seleccione departamento</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisDirector">Codigo SIS: </label>
                                <input type="password" name="sisDirector" id="sisDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passDirector">Ingrese password: </label>
                                <input type="password" name="passDirector" id="passDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Jefe de departamento">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCancelarJefe">Cancelar</button>
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
                    <form action="" id="formCrearDepartamento" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomFacultad">Nombre del departamento: </label>
                                <input type="text" name="nomDep" id="nomDep" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="facCodigo">Cod. Departamento: </label>
                                <input type="text" name="depCod" id="depCod" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="facFechaCrea">Seleccione fecha: </label>
                                <input type="date" name="depFechaCrea" id="depFechaCrea" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                            <input type="submit" class="btn  btn-primary" value="Crear">
                            <button class="btn btn-danger" class="close" data-dismiss="modal" id="btnCancelar">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
<div class="modal fade" id="modalEditarDep">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="modal-title text-center">Editar departamento</h2>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <form id="formEditarDep">    
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Nombre de departamento</label>
                    <input type="text" name="" id="formEditarNomDep" class="form-control" required>
                    <div class="invalid-feedback">llene el campo</div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Codigo de departamento</label>
                    <input type="text" class="form-control" id="formEditarCodDep" required="">
                    <div class="invalid-feedback">llene el campo</div>
                    </div>
                    </div> 
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Fecha de creacion</label>
                    <input type="date" name="form-control" id="formEditarFechaCreaDep" class="form-control" required>
                    <div class="invalid-feedback">llene el campo</div>
                    </div>               
                    </div> 
                </div>
                <div class="row"> 
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Jefe de departamento</label>
                    <select class="form-control" id="formEditarJefeDep" name="" required="">
                    </select>
                    <div class="invalid-feedback">llene el campo</div>
                    </div> 
                    </div> 
                </div> 
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </form>    
        </div>
    </div>
</div>  
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/home_director_academico.js"></script>
</body>
</html>