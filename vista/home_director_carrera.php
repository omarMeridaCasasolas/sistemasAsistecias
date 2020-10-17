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
        <br>
        


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