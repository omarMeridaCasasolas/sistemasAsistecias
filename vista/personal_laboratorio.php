<?php include_once("parts/cabezera_director.php");?>

<input type="text" class="d-none" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
<body class="bg-secondary">
    <main class="container bg-white p-2">
    <h1 class="text-center">Laboratorios</h1>
    <div class="float-right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalCrearLaboratorio">
                    Crear Laboratorio <i class="fas fa-plus"></i>
        </button>
    </div>
    <br><br>
    <!-- modal crear laboratorio  -->
        <div class="modal fade" id="myModalCrearLaboratorio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h2 class="modal-title text-center">Crear laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnAgregarLab">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formAgregarLaboratorio" method="post">
                            <div class="form-group">
                                    <label for="nomAgregarLaboratorio">Nombre del laboratorio: </label>
                                    <input type="text" name="nomAgregarLaboratorio" id="nomAgregarLaboratorio" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="codAgregarLaboratorio">Codigo laboratorio: </label>
                                    <input type="text" name="codAgregarLaboratorio" id="codAgregarLaboratorio" class="form-control" required>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="fecAgregarLaboratorio">fecha de creacion: </label>
                                    <input type="date" name="fecAgregarLaboratorio" id="fecAgregarLaboratorio" class="form-control" required>
                                </div>
                            </div>
                            <h4>Descripcion del laboratorio</h4>
                            <textarea rows="6" class="form-control" name="desAgregarLaboratorio" id="desAgregarLaboratorio" required></textarea>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="mesAgregarLaboratorio">Duracion de laboratorio: </label>
                                    <select class="form-control" id="mesAgregarLaboratorio" name="mesAgregarLaboratorio">
                                    <option value="1">1 mes</option>
                                    <option value="2">2 meses</option>
                                    <option value="3">3 meses</option>
                                    <option value="4">4 meses</option>
                                    <option value="5">5 meses</option>
                                    <option value="6">6 meses</option>
                                    <option value="7">7 meses</option>
                                    <option value="8">8 meses</option>
                                    <option value="9">9 meses</option>
                                    <option value="10">10 meses</option>
                                    <option value="11">11 meses</option>
                                    <option value="12">12 meses</option>
                                    </select required>
                                    <!-- <div class="invalid-feedback">llene el campo</div> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="horAgregarLaboratorio">Cant.de dias Trabajo: </label>
                                    <input type="text" name="horAgregarLaboratorio" id="horAgregarLaboratorio" class="form-control" required>
                                    <!-- <div class="invalid-feedback">Llene campo:</div> -->
                                </div>
                            </div>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-primary" value="Crear laboratorio">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- modal para editar laboratorio  -->
    <div class="modal fade" id="myModalEditarLaboratorio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnEditarLab">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formEditarLaboratorio" method="post">
                            <input type="text" name="idEditarLaboratorio" id="idEditarLaboratorio" class="d-none">
                            <div class="form-group">
                                    <label for="nomEditarLaboratorio">Nombre del laboratorio: </label>
                                    <input type="text" name="nomEditarLaboratorio" id="nomEditarLaboratorio" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="codEditarLaboratorio">Codigo laboratorio: </label>
                                    <input type="text" name="codEditarLaboratorio" id="codEditarLaboratorio" class="form-control" required>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="fecEditarLaboratorio">fecha de creacion: </label>
                                    <input type="date" name="fecEditarLaboratorio" id="fecEditarLaboratorio" class="form-control" required>
                                </div>
                            </div>
                            <h4>Descripcion del laboratorio</h4>
                            <textarea rows="10" class="form-control" name="desEditarLaboratorio" id="desEditarLaboratorio" required></textarea>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="mesEditarLaboratorio">Duracion de laboratorio: </label>
                                    <select class="form-control" id="mesEditarLaboratorio" name="mesEditarLaboratorio">
                                    <option value="1">1 mes</option>
                                    <option value="2">2 meses</option>
                                    <option value="3">3 meses</option>
                                    <option value="4">4 meses</option>
                                    <option value="5">5 meses</option>
                                    <option value="6">6 meses</option>
                                    <option value="7">7 meses</option>
                                    <option value="8">8 meses</option>
                                    <option value="9">9 meses</option>
                                    <option value="10">10 meses</option>
                                    <option value="11">11 meses</option>
                                    <option value="12">12 meses</option>
                                    </select required>
                                    <!-- <div class="invalid-feedback">llene el campo</div> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="horEditarLaboratorio">Cant. de dias Trabajo: </label>
                                    <input type="text" name="horEditarLaboratorio" id="horEditarLaboratorio" class="form-control" required>
                                    <!-- <div class="invalid-feedback">Llene campo:</div> -->
                                </div>
                            </div>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-primary" value="Actualizar laboratorio">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal para eliminar laboratorio  -->
    <div class="modal fade" id="myModalEliminarLaboratorio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnEliminarLab">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formEliminarLaboratorio" method="post">
                            <input type="text" name="idEliminarLaboratorio" id="idEliminarLaboratorio" class="d-none">
                            <h5>Usted esta seguro de eliminar el laboratorio: <strong id="nomEliminarLaboratorio"></strong> con siglas: <strong id="codEliminarLaboratorio"></strong></h5>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-primary" value="Eliminar laboratorio">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <table id="tablaLaboratorio" class="display" style="width:100%">
        <thead>
            <th>Siglas</th>
            <th>Nombre de Laboratorio</th>
            <th>Fecha de creacion</th>
            <th>Cant. de dias trabajo</th>
            <th>Opciones</th>
        </thead>
    </table>

    <!-- CRUD tabla auxiliares de laboratorio  -->
    <hr>
    <h1 class="text-center">Auxiliares de laboratorio</h1>
    <div class="float-right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalCrearAuxLaboratorio">
                    Crear auxiliar para laboratorio <i class="fas fa-plus"></i>
        </button>
    </div>
    <br><br>

    <!-- modal crear auxiliar de laboratorio  -->
        <div class="modal fade" id="myModalCrearAuxLaboratorio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h2 class="modal-title text-center">Crear auxiliar de laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnAgregarAuxLab">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formAgregarAuxLaboratorio" method="post">
                            <div class="form-group">
                                    <label for="nomAgregarAuxLaboratorio">Nombre del laboratorio: </label>
                                    <input type="text" name="nomAgregarAuxLaboratorio" id="nomAgregarAuxLaboratorio" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="codAgregarAuxLaboratorio">Carnet de identidad: </label>
                                    <input type="text" name="codAgregarAuxLaboratorio" id="codAgregarAuxLaboratorio" class="form-control" required>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="corAgregarAuxLaboratorio">Correo del auxiliar: </label>
                                    <input type="email" name="corAgregarAuxLaboratorio" id="corAgregarAuxLaboratorio" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="telAgregarAuxLaboratorio">Telefono/celular: </label>
                                    <input type="text" name="telAgregarAuxLaboratorio" id="telAgregarAuxLaboratorio" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="pasAgregarAuxLaboratorio">Password: </label>
                                    <input type="password" name="pasAgregarAuxLaboratorio" id="pasAgregarAuxLaboratorio" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="dirAgregarAuxLaboratorio">Nombre del laboratorio: </label>
                                    <select  name="dirAgregarAuxLaboratorio" id="dirAgregarAuxLaboratorio" class="form-control">
                                        <option value="Ninguno">Ninguno</option>
                                    </select>
                            </div>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-secondary" value="Crear Auxiliar de laboratorio">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- modal para editar laboratorio  -->
    <div class="modal fade" id="myModalEditarLaboratorio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnEditarLab">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formEditarLaboratorio" method="post">
                            <input type="text" name="idEditarLaboratorio" id="idEditarLaboratorio" class="d-none">
                            <div class="form-group">
                                    <label for="nomEditarLaboratorio">Nombre del laboratorio: </label>
                                    <input type="text" name="nomEditarLaboratorio" id="nomEditarLaboratorio" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="codEditarLaboratorio">Codigo laboratorio: </label>
                                    <input type="text" name="codEditarLaboratorio" id="codEditarLaboratorio" class="form-control" required>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="fecEditarLaboratorio">fecha de creacion: </label>
                                    <input type="date" name="fecEditarLaboratorio" id="fecEditarLaboratorio" class="form-control" required>
                                </div>
                            </div>
                            <h4>Descripcion del laboratorio</h4>
                            <textarea rows="10" class="form-control" name="desEditarLaboratorio" id="desEditarLaboratorio" required></textarea>
                            <br>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="mesEditarLaboratorio">Duracion de laboratorio: </label>
                                    <select class="form-control" id="mesEditarLaboratorio" name="mesEditarLaboratorio">
                                    <option value="1">1 mes</option>
                                    <option value="2">2 meses</option>
                                    <option value="3">3 meses</option>
                                    <option value="4">4 meses</option>
                                    <option value="5">5 meses</option>
                                    <option value="6">6 meses</option>
                                    <option value="7">7 meses</option>
                                    <option value="8">8 meses</option>
                                    <option value="9">9 meses</option>
                                    <option value="10">10 meses</option>
                                    <option value="11">11 meses</option>
                                    <option value="12">12 meses</option>
                                    </select required>
                                    <!-- <div class="invalid-feedback">llene el campo</div> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="horEditarLaboratorio">Cant. de dias Trabajo: </label>
                                    <input type="text" name="horEditarLaboratorio" id="horEditarLaboratorio" class="form-control" required>
                                    <!-- <div class="invalid-feedback">Llene campo:</div> -->
                                </div>
                            </div>
                            <p>pesonal selecionado para laboratorio: <strong> Sin auxiliar designado</strong></p>
                            <div class="form-group">
                                    <label for="auxEditarLaboratorio">Cambiar director de carrera: </label>
                                    <input type="search" name="auxEditarLaboratorio" id="auxEditarLAboratoria" class="form-control">
                                    <!-- <div class="invalid-feedback">Seleccione director</div> -->
                                </div>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-primary" value="Actualizar laboratorio">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal para eliminar laboratorio  -->
    <div class="modal fade" id="myModalEliminarAuxLaboratorio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar auxiliar de laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnEliminarAuxLab">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formEliminarAuxLaboratorio" method="post">
                            <input type="text" name="idEliminarAuxLaboratorio" id="idEliminarAuxLaboratorio" class="d-none">
                            <h5>Usted esta seguro de eliminar auxiliar de laboratorio: <strong id="nomEliminarAuxLaboratorio"></strong> con carnet de identidad: <strong id="codEliminarAuxLaboratorio"></strong></h5>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-primary" value="Eliminar auxiliar de laboratorio">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- modal para editar auxiliar de Laboratorio  -->
    <div class="modal fade" id="myModalEditarAuxLaboratorio">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar auxiliar de laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnEditarAuxLab">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formEditarAuxLaboratorio" method="post">
                        <input type="text" name="idEditarAuxLaboratorio" id="idEditarAuxLaboratorio" class="d-none">
                        <div class="form-group">
                                    <label for="nomEditarAuxLaboratorio">Nombre del auxiliar de laboratorio: </label>
                                    <input type="text" name="nomEditarAuxLaboratorio" id="nomEditarAuxLaboratorio" class="form-control" required>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="codEditarAuxLaboratorio">Carnet de identidad: </label>
                                    <input type="text" name="codEditarAuxLaboratorio" id="codEditarAuxLaboratorio" class="form-control" required>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="corEditarAuxLaboratorio">Correo del auxiliar: </label>
                                    <input type="email" name="corEditarAuxLaboratorio" id="corEditarAuxLaboratorio" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="telEditarAuxLaboratorio">Telefono/celular: </label>
                                    <input type="text" name="telEditarAuxLaboratorio" id="telEditarAuxLaboratorio" class="form-control" required>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="dirEditarAuxLaboratorio">Nombre del laboratorio: </label>
                                    <select  name="dirEditarAuxLaboratorio" id="dirEditarAuxLaboratorio" class="form-control">
                                        <option value="Ninguno">Ninguno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-secondary" value="Actualizar auxiliar de laboratorio">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    <table id="tablaAuxiliarLaboratorio" class="display" style="width:100%">
        <thead>
            <th>Nombre de auxiliar Laboratorio</th>
            <th>Responsable de</th>
            <th>Correo Electronico</th>
            <th>Telefono/cel</th>
            <th>Opciones</th>
        </thead>
    </table>

    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/personal_laboratorio.js"></script>
</body>
</html>