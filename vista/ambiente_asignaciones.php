<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
    	<div class="d-none">
            <input type="text" name="idCategoria" id="idCategoria" value="<?php echo $_SESSION['categoria_social'];?>">
        </div>
        <!-----------------------------MATERIAS---------------------------------------------------
---------------------------------------------------------------------------------------------->

        <h2 class="text-primary text-center">MATERIAS</h2>
        <br><br>
        <div class="col-md-4 custom-file">
                <label class="custom-file-label" for="customFileLang">Importar Materias</label>
                <input type="file" class="custom-file-input" id="inputFileMateria" lang="es" accept=".csv">
        </div>
        <button type="button" class="btn btn-primary float-right" id="btnCrearMateria">Crear Materia</button>
        <br><br>
        <table id="tablaMateriasDep" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>CODIGO SIS</th>
                    <th>NOMBRE MATERIA</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
        </table>        
<!--------------------------------------------------------------------------------------->
        <div class="modal fade" id="modalCrearMateria">
            <div class="modal-dialog">
                <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header bg-info">
                             <h2 class="modal-title text-center">Crear materia</h2>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!--modal body-->
                    <div class="modal-body">
                        <form action="" id="formInsertarMateria" method="post" class="was-validated">
                            <div class="form-group">
                                <label for="nomMateria">Nombre de la Materia: </label>
                                <input type="text" name="nomMateria" id="nomMateria" class="form-control" required pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁ ÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{6,80}">
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group">
                                    <label for="sisMateria">codigo SIS </label>
                                    <input type="text" name="sisMateria" id="sisMateria" class="form-control" required pattern="[0-9]{7,9}">
                                    <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="text-center my-2">
                                 <input type="submit" class="btn  btn-primary" value="Crear Materia">
                                <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaMateria">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarMateria">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Editar Materia</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarMateria" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomMateriaEdit">Nombre de la Materia : </label>
                                <input type="text" name="nomMateria" id="nomMateriaEdit" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="codigoEdit">codigo SIS: </label>
                                <input type="text" name="codigo" id="codigoEdit" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div style="display: none;">
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                        <div class="form-group">
                            <label>Docentes asignados:</label>
                            <div id="contenedorDocentesAsignados"></div>
                        </div>
                        <div class="row">
                                <div class="col-md-10">
                                    <select id="selectDocentes" class="form-control"></select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" id="btnAsignarDocente"><i class="fas fa-plus"></i></button>
                                </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                        <div class="form-group">
                            <label>Auxiliares asignados:</label>
                            <div id="contenedorAuxiliaresAsignados"></div>
                        </div>
                        <div class="row">
                                <div class="col-md-10">
                                    <select id="selectAuxiliares" class="form-control"></select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" id="btnAsignarAuxiliar"><i class="fas fa-plus"></i></button>
                                </div>
                        </div>
                        <hr style="height:2px;border-width:0;color:gray;background-color:gray"> 
                        <div class="form-group">
                            <label>Carreras asignadas:</label>
                            <div id="contenedorCarrerasAsignadas"></div>
                        </div>
                        <div class="row">
                                <div class="col-md-10">
                                    <select id="selectCarreras" class="form-control"></select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary" id="btnAsignarCarrera"><i class="fas fa-plus"></i></button>
                                </div>
                        </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Editar Materia">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaMateriaEdit">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <br><br>
        <h2 class="text-primary text-center">GRUPOS</h2>
        <br><br>
        <div class="col-md-4 custom-file">
            <label class="custom-file-label" for="customFileLang">Importar grupos:</label>
            <input type="file" class="custom-file-input" id="inputFileGrupo" lang="es" accept=".csv">
        </div>
        <button type="button" class="btn btn-primary float-right" id="btnCrearGrupo">Crear Grupo</button>
        <br><br>
        <table id="tablaGruposDep" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>CODIGO SIS MATERIA</th>
                    <th>NOMBRE MATERIA</th>
                    <th>NUMERO GRUPO</th>
                    <th>CODIGO SIS DOCENTE</th>
                    <th>NOMBRE DOCENTE</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="modalCrearGrupo">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">CREAR GRUPO</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formInsertarGrupo" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="selectMateriasDep">Seleccione materia:</label>
                                <select class="form-control" id="selectMateriasDep" name=""></select>
                                <div class="invalid-feedback">llene el campo</div>
                        </div>
                        <div class="form-group" id="divGruposMateria">
                            <h5>No existen grupos registrados</h5>
                       </div>
                       <div class="form-group">
                                <label for="nomGrupo">Numero grupo:</label>
                                <input type="text" name="" id="nomGrupo" class="form-control" required="">
                                <div class="invalid-feedback">llene el campo</div>
                        </div>
                        <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Asignar docente:</label>
                                    <select class="form-control" id="selectDocenteAsignado" name=""></select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Asignar auxiliar:</label>
                                    <select class="form-control" id="selectAuxiliarAsignado" name=""></select>
                                </div>
                        </div>
                        <div class="form-group" id="divCarrerasAsignadasMateria" style="display: none;">
                            <h5>No existen carreras asignadas</h5>
                        </div>
                        <div id="horariosGrupo">
                            <div class="row" id="horario_1">
                                <div class="form-group col-md-4">
                                    <label for="selectDias">Seleccione dia:</label>
                                    <select class="form-control horarioGrp" id="selectDias_1" name="">
                                        <option value="LU">LUNES</option>
                                        <option value="MA">MARTES</option>
                                        <option value="MI">MIERCOLES</option>
                                        <option value="JU">JUEVES</option>
                                        <option value="VI">VIERNES</option>
                                        <option value="SA">SABADO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="horarioGrupo">Ingrese horario:</label>
                                    <input type="text" name="" id="horarioGrupo_1" class="form-control horarioGrp" placeholder="Ej: 815-945" required pattern="[1-9]{1}[0-9]{2,3}[-][1-9]{1}[0-9]{2,3}">
                                    <div class="invalid-feedback">llene el campo</div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="selectAsignacionHorarioGrupo">Asignar a: </label>
                                    <select class="form-control horarioGrp" id="selectAsignacionHorarioGrupo_1">
                                        <option value="f">DOCENTE</option>
                                        <option value="t">AUXILIAR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">   
                            <div class="form-group col-md-6">
                                <button class="btn  btn-primary" id="btnAgregarHorarioGrp">Agregar siguiente horario</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn  btn-primary" id="btnQuitarHorarioGrp">Quitar anterior horario</button>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Registrar grupo">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCancelarNuevoGrupo">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalInformacionGrupo">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">INFORMACION GRUPO</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formInformacionGrupo" method="post" class="was-validated">
                        <div class="form-group">
                                <label>Codigo sis y nombre materia:</label>
                                <input type="text" name="" id="infoSisNomMat" class="form-control" required="" disabled="">
                        </div>
                        <div class="form-group">
                            <label>Numero grupo:</label>
                            <input type="text" name="" id="infoNumeroGrupo" class="form-control" required="" disabled="">
                        </div>
                        <div class="form-group">
                            <label>Docente asignado:</label>
                            <input type="text" name="" id="infoDocenteAsignado" class="form-control" required="" disabled="">            
                        </div>
                        <div class="form-group">
                            <label>Auxiliar asignado:</label>
                            <input type="text" name="" id="infoAuxiliarAsignado" class="form-control" required="" disabled="">            
                        </div>
                        <div class="form-group" style="display: none;">
                                <h5>Asignado para la(s) carrera(s):</h5>
                                <div id="divInfoCarrerasAsignadas"></div>
                        </div>
                        <div class="form-group">
                            <h5>Horarios:</h5>
                        </div>
                        <div id="divInfoHorariosGrupo">
                            <div class="row" id="horario_1">
                                <div class="form-group col-md-4">
                                    <label for="selectDias">Seleccione dia:</label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="selectDias">Seleccione dia:</label>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="selectDias">Seleccione dia:</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalEditarGrupo">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">EDITAR GRUPO</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarGrupo" method="post" class="was-validated">
                        <div class="form-group">
                                <label>Codigo sis y nombre materia:</label>
                                <input type="text" name="" id="infoSisNomMatEdit" class="form-control" required="" disabled="">
                        </div>
                        <div class="form-group">
                                    <label>Numero grupo:</label>
                                    <input type="text" name="" id="infoNumeroGrupoEdit" class="form-control" required="" disabled="">
                        </div>
                        <div class="row">
                             <div class="form-group col-md-6">
                                <label>Docente asignado:</label>
                                <select class="form-control" id="selectDocenteAsignadoEdit" name=""></select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Auxiliar asignado:</label>
                                <select class="form-control" id="selectAuxiliarAsignadoEdit" name=""></select>
                            </div>   
                                
                        </div>
                        <div class="form-group" style="display: none;">
                                <div id="divInfoCarrerasAsignadasEdit"></div>
                        </div>
                        <div class="form-group">
                            <h5>Horarios:</h5>
                        </div>
                        <div id="divInfoHorariosGrupoEdit"></div>
                        <div class="row">   
                            <div class="form-group col-md-6">
                                <button class="btn  btn-primary" id="btnAgregarHorarioGrpEdit">Agregar siguiente horario</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn  btn-primary" id="btnQuitarHorarioGrpEdit">Quitar anterior horario</button>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Guardar cambios">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCancelarGrupoEdit">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/ambiente_asignaciones.js"></script>
</body>
</html>