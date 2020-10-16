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
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
                Crear jefe de departamento
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
        <!-- Tabla de Jefes de departamentos -->
        <br>
        <h2 class="text-primary text-center">Directores de departamentos</h2>
        <table id="tablaDirector" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre del director</th>
                    <th>Asignacion </th>
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
                                <label for="asigDirector">Selccione Departamento: </label>
                                <select class="form-control" id="asigDirector" name="asigDirector">
                                    <option value="666">Ninguno</option>
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
    <script src="src/home_director_academico.js"></script>
</body>
</html>