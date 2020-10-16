<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <div id="exito" class="d-none">
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Exito!</strong> Se ha creado docente
            </div>
        </div>
        <div id="error" class="d-none">
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Problema!</strong> No se ha podido crear el usuario docente.
            </div>
        </div>
        <div class="d-none">
            <input type="text" name="idCategoria" id="idCategoria" value="<?php echo $_SESSION['categoria_social'];?>">
        </div>
        <!-- <a href="Crear_director_carrera.php">Crear director de carrera/unidad</a> -->
        <div>
            <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal2">
                Crear Materia
            </button>
        </div>
        <h2 class="text-primary text-center">Materias de la carrera</h2>
        <table id="example" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Codigo carrera</th>
                    <th>Nombre de carrera</th>
                    <th>Fecha de creacion</th>
                    <th>director de carrera</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>LII</td>
                    <td>Licenciatura en ingenieria informatica</td>
                    <td>1905-10-10</td>
                    <td>Maguel fulanito Mendes</td>
                </tr>
                <tr>
                    <td>LIS</td>
                    <td>Licenciatura en ingeniria en Sistemas</td>
                    <td>1905-05-10</td>
                    <td>Carlos choque Perez</td>
                </tr>
                <tr>
                    <td>LI</td>
                    <td>Licenciatura en informatica</td>
                    <td>1945-05-10</td>
                    <td>Karen Gutierrez</td>
                </tr>
            </tbody>
        </table>
        <!-- Tabla de Docentes -->
        <br>
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
            Crear docente
        </button>
        <div id="exitoDocente" class="d-none">
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Exito!</strong> Se ha creado docente
            </div>
        </div>
        <div id="errorDocente" class="d-none">
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Problema!</strong> No se ha podido crear el usuario docente.
            </div>
        </div>
        <h2 class="text-primary text-center">Docentes de la carrera</h2>
        <table id="tablaDocente" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre del docente</th>
                    <th>Asignacion </th>
                    <th>Telefono</th>
                    <th>Correo electronico</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear docente</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formInsertarDocente" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomDocente">Nombre del docente: </label>
                                <input type="text" name="nomDocente" id="nomDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ciDocente">Carnet de identidad: </label>
                                <input type="text" name="ciDocente" id="ciDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telDocente">Telefono: </label>
                                <input type="text" name="telDocente" id="telDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="correoDocente">Correo electronico: </label>
                                <input type="email" name="correoDocente" id="correoDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisDocente">Codigo SIS: </label>
                                <input type="password" name="sisDocente" id="sisDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passDocente">Ingrese password: </label>
                                <input type="password" name="passDocente" id="passDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Docente">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaDocente">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal3">
            Crear Auxiliar
        </button>
        <div id="exitoAuxiliarDocente" class="d-none">
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Exito!</strong> Se ha creado docente
            </div>
        </div>
        <div id="errorAuxiliarDocente" class="d-none">
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Problema!</strong> No se ha podido crear el usuario docente.
            </div>
        </div>
        <h2 class="text-primary text-center">Auxiliar de la carrera</h2>
        <table id="tablaAuxiliar" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre del Auxiliar</th>
                    <th>Asignacion </th>
                    <th>Telefono</th>
                    <th>Correo electronico</th>
                </tr>
            </thead>
        </table>


        <div class="modal fade" id="myModal3">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear Auxiliar de docencia</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formInsertarAuxiliarDocente" method="post" class="was-validated">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="nomAuxiliarDocente">Nombre del auxiliar: </label>
                                <input type="text" name="nomAuxiliarDocente" id="nomAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="ciAuxiliarDocente">Carnet de identidad: </label>
                                <input type="text" name="ciAuxiliarDocente" id="ciAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telAuxiliarDocente">Telefono: </label>
                                <input type="text" name="telAuxiliarDocente" id="telAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoAuxiliarDocente">Correo electronico: </label>
                                <input type="email" name="correoAuxiliarDocente" id="correoAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisAuxiliarDocente">Codigo SIS: </label>
                                <input type="password" name="sisDirector" id="sisAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passAuxiliarDocente">Ingrese password: </label>
                                <input type="password" name="passDirector" id="passAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear usuario">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaAuxiliarDocente">Cancelar</button>
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
                        <h2 class="modal-title text-center">Crear Materia</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomFacultad">Nombre de la materia: </label>
                                <input type="text" name="nomFacultad" id="nomFacultad" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="facCodigo">Codigo materia: </label>
                                <input type="text" name="facCodigo" id="facCodigo" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="facFechaCrea">Seleccione fecha: </label>
                                <input type="date" name="facFechaCrea" id="facFechaCrea" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha:</div>
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
    <script src="src/home_director_carrera.js"></script>
</body>
</html>