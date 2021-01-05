<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
    	<div class="d-none">
            <input type="text" name="idCategoria" id="idCategoria" value="<?php echo $_SESSION['categoria_social'];?>">
        </div>

        <h2 class="text-primary text-center">AUXILIARES DE DOCENCIA</h2>
        <br><br>
        <div class="col-md-4 custom-file">
                <label class="custom-file-label" for="customFileLang">Importar Auxiliares</label>
                <input type="file" class="custom-file-input" id="inputFileAuxiliarDocente" lang="es" accept=".csv">
            </div>
        <button type="button" class="btn btn-primary float-right" id="btnCrearAuxiliarDocente">Crear Auxiliar Docente</button>
        <br><br>
        <table id="tablaAuxiliarDocenteDep" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>CODIGO SIS</th>
                    <th>NOMBRE AUXILIAR</th>
                    <th>CORREO ELECTRONICO</th>
                    <th>TELEFONO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="modalCrearAuxiliarDocente">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear auxiliar docente</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formInsertarAuxiliarDocente" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomAuxiliarDocente">Nombre del auxiliar: </label>
                                <input type="text" name="nomAuxiliarDocente" id="nomAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ciAuxiliarDocente">Carnet de identidad: </label>
                                <input type="text" name="ciAuxiliarDocente" id="ciAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telAuxiliarDocente">Telefono: </label>
                                <input type="text" name="telAuxiliarDocente" id="telAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="correoAuxiliarDocente">Correo electronico: </label>
                                <input type="email" name="correoAuxiliarDocente" id="correoAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisAuxiliarDocente">Codigo SIS: </label>
                                <input type="password" name="sisAuxiliarDocente" id="sisAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passAuxiliarDocente">Ingrese password: </label>
                                <input type="password" name="passAuxiliarDocente" id="passAuxiliarDocente" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Auxiliar Docente">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaAuxiliarDocente">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarAuxiliarDocente">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Editar auxiliar docente</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarAuxiliarDocente" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomAuxiliarDocenteEdit">Nombre del auxiliar docente: </label>
                                <input type="text" name="nomAuxiliarDocente" id="nomAuxiliarDocenteEdit" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="telAuxiliarDocenteEdit">Telefono: </label>
                                <input type="text" name="telAuxiliarDocente" id="telAuxiliarDocenteEdit" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="correoAuxiliarDocenteEdit">Correo electronico: </label>
                                <input type="email" name="correoAuxiliarDocente" id="correoAuxiliarDocenteEdit" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Editar Auxiliar Docente">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaAuxiliarDocenteEdit">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/ambiente_pizarra.js"></script>
</body>
</html>