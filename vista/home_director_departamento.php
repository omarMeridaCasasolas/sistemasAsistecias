<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <div class="text-center"> <a href="personal_laboratorio.php" class="btn btn-primary"><i class="fas fa-vial"></i> Laboratorios</a> <a href="personal_clases.php" class="btn btn-primary"><i class="fas fa-door-open"></i> Clases</a></div>
        <!-- <div id="exito" class="d-none">
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Exito!</strong> Se ha creado el director de carrera.
            </div>
        </div>
        <div id="error" class="d-none">
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Problema!</strong> No se pudo procesar la tarea del director de carrera.
            </div>
        </div>
        <div id="VtnEditarDirector" class="d-none">
            <div class='alert alert-info alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Tarea terminada!</strong> Se ha actualizado los datos del director de carrera.
            </div>
        </div>
        <div id="VtnEliminarDirector" class="d-none">
            <div class='alert alert-warning alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Tarea terminada!</strong> Se ha eliminado el director de carrera.
            </div>
        </div> -->
        <div class="d-none">
            <input type="text" name="idCategoria" id="idCategoria" value="<?php echo $_SESSION['categoria_social'];?>">
        </div>
        <!-- <a href="Crear_director_carrera.php">Crear director de carrera/unidad</a> -->
        <div>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal2">
                Crear carrera
            </button>
        </div>
        <h2 class="text-primary text-center">Carreras del departamento</h2>
        <table id="tablaCarrera" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Codigo carrera</th>
                    <th>Nombre de carrera</th>
                    <th>Fecha de creacion</th>
                    <th>director de carrera</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
        <!-- Eliminar Carrera -->
        <div class="modal fade" id="myModalEliminarCarrera">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar carrera</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarCarrera" method="post" class="was-validated">
                        <input type="text" name="idDeletCarrera" id="idDeletCarrera" class="d-none">
                        <h5>Desea eliminar la carrera <strong id="nomDeletCarrera"></strong> con codigo <strong id="codDeletCarrera"></strong></h5>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Eliminar carrera">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarVtnCarrera">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editar Carrera -->
        <div class="modal fade" id="myModalEditarCarrera">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar Carrera</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnEditarCarrera">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formEditarCarrera" method="post" class="was-validated" >
                            <input type="text" name="idEditarCarrera" id="idEditarCarrera" class="d-none">
                            <span class="d-none" is="#dirAntiguoEditarCarrera"></span>
                            <div class="form-group">
                                    <label for="nomEditarCarrera">Nombre de la carrea: </label>
                                    <input type="text" name="nomEditarCarrera" id="nomEditarCarrera" class="form-control" required>
                                    <div class="invalid-feedback">llene el campo</div>
                                </div>
                            <div class="row">
                                <div class="form-group col-md-5">
                                    <label for="codEditarCarrera">Codigo Carrera: </label>
                                    <input type="text" name="codEditarCarrera" id="codEditarCarrera" class="form-control" required>
                                    <div class="invalid-feedback">llene el campo</div>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="fecEditarCarrera">fecha de creacion: </label>
                                    <input type="date" name="fecEditarCarrera" id="fecEditarCarrera" class="form-control" required>
                                    <div class="invalid-feedback">Escoje fecha:</div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="dirEditarCarrera">Cambiar director de carrera: </label>
                                    <select class="form-control" id="dirEditarCarrera">
                                    <option value="Ninguno">Ninguno</option>
                                    </select required>
                                    <div class="invalid-feedback">Seleccione director</div>
                                </div>
                            <div class="text-center my-2">
                                <input type="submit" class="btn  btn-primary" value="Actualizar cambios">
                                <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de directores de carrera -->
        <br>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
                Crear director de carrera
            </button>
        <br>
        <h2 class="text-primary text-center">Directores de carrera</h2>
        <table id="tablaDirector" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre del director</th>
                    <th>Asignacion </th>
                    <th>Correo electronico</th>
                    <th>Telefono</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>

        <br>
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal3">
                Crear personal para laboratorio
            </button>
        <div id="exitoPersLab" class="d-none">
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Exito!</strong> Se ha creado el director de carrera.
            </div>
        </div>
        <div id="errorPersLab" class="d-none">
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Problema!</strong> No se ha podido crear el usuario director de carrera.
            </div>
        </div> -->
        <br>
            <!-- mensajes para el personal de laboratorio  -->
        <!-- <div id="exitoPersLab" class="d-none">
            <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Exito!</strong> Se ha creado personal de laboratorio.
            </div>
        </div>
        <div id="errorPersLab" class="d-none">
            <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Problema!</strong> No se pudo procesar la tarea sobre personal de laboratorio.
            </div>
        </div>
        <div id="VtnEditarPersLab" class="d-none">
            <div class='alert alert-info alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Tarea terminada!</strong> Se ha actualizado los datos de personal de laboratorio.
            </div>
        </div>
        <div id="VtnEliminarPersLab" class="d-none">
            <div class='alert alert-warning alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Tarea terminada!</strong> Se ha eliminado el auxiliar de laboratorio.
            </div>
        </div>
        <br> -->
        <!-- <h2 class="text-primary text-center">Personal de laboratorio</h2>
        <table id="tablaPersonalLaboratorio" class="hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre del personal</th>
                    <th>Asignacion </th>
                    <th>Correo electronico</th>
                    <th>Telefono</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table> -->

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-success">
                        <h2 class="modal-title text-center">Director de carrera</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formInsertarDirector" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomDirector">Nombre director de carrera: </label>
                                <input type="text" name="nomDirector" id="nomDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="ciDirector">Carnet de identidad: </label>
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
                                <label for="asigDirector">Seleccione carrera: </label>
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
                            <input type="submit" class="btn  btn-primary" value="Crear usuario">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarAutoridad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- crear carrera  -->
        <div class="modal fade" id="myModal2">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear Carrera</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnCerrarVtnCrearCarrera">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formCrearCarrera" method="post" class="was-validated">
                    <input type="text" class="d-none" name="idAgregarDepartamento" id="idAgregarDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
                        <div class="form-group">
                                <label for="nomAgregarCarrera">Nombre de la Carrera: </label>
                                <input type="text" name="nomAgregarCarrera" id="nomAgregarCarrera" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="codAgregarCarrera">Codigo carrera: </label>
                                <input type="text" name="codAgregarCarrera" id="codAgregarCarrera" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="fecAgregarCarrera">Seleccione fecha: </label>
                                <input type="date" name="fecAgregarCarrera" id="fecAgregarCarrera" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha:</div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="dirAgregarCarrera">Escoja Director de carrera: </label>
                                <select class="form-control" id="dirAgregarCarrera" name="dirAgregarCarrera">
                                    <option value="Ninguno">Ninguno</option>
                                </select>
                                <div class="invalid-feedback">Seleccione director</div>
                            </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Director de carrera">
                            <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
      <!-- 
        <div class="modal fade" id="myModal3">
            <div class="modal-dialog">
                <div class="modal-content"> 

                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear personal para el laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div> 

                    <div class="modal-body">
                    <form action="" id="formInsertarPersonalLaboratorio" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomPersLab">Nombre personal laboratorio: </label>
                                <input type="text" name="nomPersLab" id="nomPersLab" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ciPersLab">Carnet de identidad: </label>
                                <input type="text" name="ciPersLab" id="ciPersLab" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telPersLab">Telefono: </label>
                                <input type="text" name="telPersLab" id="telPersLab" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="correoPersLab">Correo electronico: </label>
                                <input type="email" name="correoPersLab" id="correoPersLab" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisPersLab">Codigo SIS: </label>
                                <input type="password" name="sisPersLab" id="sisPersLab" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passPersLab">Ingrese password: </label>
                                <input type="password" name="passPersLab" id="passPersLab" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear personal">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarPersLab">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div> 

        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal4">
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
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
      
        crear docente
        <div class="modal fade" id="myModal4">
            <div class="modal-dialog">
                <div class="modal-content">
    
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear docente</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
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

          
        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal6">
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
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
        

        <div class="modal fade" id="myModal6">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear Auxiliar de docencia</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
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
        -->
        
        <!-- ventanas para editar directores -->
        <div class="modal fade" id="myModalEditarDirector">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar director de carrera</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarDirectorCarrera" method="post" class="was-validated">
                        <input type="text" name="idEditarDirector" id="idEditarDirector" class="d-none">
                        <input type="text" name="nomEditAntiguoDirector" id="nomEditAntiguoDirector" class="d-none">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="nomEditDirector">Editar nombre: </label>
                                <input type="text" name="nomEditDirector" id="nomEditDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="ciEditDirector">Editar codigo SIS: </label>
                                <input type="text" name="ciEditDirector" id="ciEditDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telEditDirector">Telefono: </label>
                                <input type="text" name="telEditDirector" id="telEditDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoEditDirector">Correo electronico: </label>
                                <input type="email" name="correoEditDirector" id="correoEditDirector" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Actualizar datos">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaEditDirector">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- modal eliminar director de carrera  -->
        <div class="modal fade" id="myModalELiminarDirector">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Eliminar director de carrera</h2>
                        <button type="button" class="close" data-dismiss="modal" id="btnEliminarVtnDirector">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarDirectorCarrera" method="post" class="was-validated">
                            <!-- <strong>¡Estas seguro que quieres eliminar al director de carrera: <span id="nomDirectorDel"></span></strong> -->
                            <p>¡Estas seguro que quieres eliminar al director de carrera : <strong id="nomDirectorDel"></strong> con carnet de identidad: <strong id="ciDirectorDel"></strong></p>
                            <input type="text" class="d-none" name="idEliminarDirector" id="idEliminarDirector">
                            <input type="text" class="d-none" name="idActualizarCarreraDirector" id="idActualizarCarreraDirector">                     
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Borrar director">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaEliminarDirector">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- editar eliminar personal de laboratorio  -->
    <button type="button" class="editarPersLabor d-none" data-toggle="modal" data-target="#myModal9"></button>
        <div class="modal fade" id="myModal9">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar auxiliar de laboratorio</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarPersLab" method="post" class="was-validated">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="nomEditPersLabor">Editar nombre auxilia de laboratorio: </label>
                                <input type="text" name="nomEditPersLabor" id="nomEditPersLabor" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="ciEditPersLabor">Editar codigo SIS auxiliar de laboratorio: </label>
                                <input type="text" name="ciEditPersLabor" id="ciEditPersLabor" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telEditPersLabor">Telefono: </label>
                                <input type="text" name="telEditPersLabor" id="telEditPersLabor" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoEditPersLabor">Correo electronico: </label>
                                <input type="email" name="correoEditPersLabor" id="correoEditPersLabor" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Actualizar datos">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaEditPersLab">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="eliminarPersonalLaboratorio d-none" data-toggle="modal" data-target="#myModal10"></button>
        <div class="modal fade" id="myModal10">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar director de carrera</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarPersonalLaboratorio" method="post" class="was-validated">
                            <span>¡Estas seguro que quieres eliminar al auxiliar de laboratorio : <strong id="nomPersonaldelLab"></strong></span>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Borrar director">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnVentanaEliminarPerLab">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/home_director_departamento.js"></script>
</body>
</html>