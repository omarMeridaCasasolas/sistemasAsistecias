<?php
    // session_start();
    // if(isset($_SESSION["codigo_autoridad"])){

    // }else{
    //     header("Location:../../index.php?error=auntentificacion&tipo=autoridad");
    // }
    
?>
<?php include_once("parts/cabezera_director.php");?>
<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home director departamental</title>
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

        <img src="<?php //echo $_SESSION['myFoto'];?>" class="rounded" width="75" height="75">
        <h4 class="text-white d-inline-block"><?php //echo $_SESSION['cargo'].": ".$_SESSION['nombre_autoridad'];?></h4>
        <div class="float-right py-3 ">
            <button class="btn btn-primary" data-toggle="modal" id="btnEditSelf" data-target="#myModalEditarDatos"><i class="fas fa-user-edit"></i></button>
            <button type="button" class="btn btn-primary d-inline-block" data-toggle="modal" data-target="#abrirVtnCorreo" id="btnAbrirCorreo"><i class="fas fa-envelope"></i></button>
            <a href="../controlador/formCerrarSession.php" class="btn btn-primary"><i class="fas fa-sign-out-alt"></i></a>
            <br>
            <h6 class="text-white my-1">Bolivia <span id="div_date_time"></span></h6>
        </div>
        <ul class="navbar-nav">

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Ambientes:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="ambiente_docente.php">Docentes</a>
                <a class="dropdown-item" href="ambiente_pizarra.php">Aux. pizarra</a>
                <a class="dropdown-item" href="personal_laboratorio.php">Aux. Laboratorio</a>
            </div>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Reportes:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="reportes_departamento_docentes.php">Docentes</a>
                <a class="dropdown-item" href="reportes_departamento_pizarra.php">Aux. pizarra</a>
                <a class="dropdown-item" href="reportes_departamento_laboratorio.php">Aux. Laboratorio</a>
            </div>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                Historial:
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="historial_departamento_docentes.php">Docentes</a>
                <a class="dropdown-item" href="historial_departamento_pizarra.php">Aux. pizarra</a>
                <a class="dropdown-item" href="historial_departamento_laboratorio.php">Aux. Laboratorio</a>
            </div>
            </li>
        </ul>
    </nav> -->
    <body class="bg-secondary">
    <main class="container bg-white p-2">
        <input type="text" class="d-none" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
        <!-- Modal -->
        <div class="modal fade" id="abrirVtnCorreo" role="dialog">
            <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h2 class="modal-title text-white">Enviar @mail</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" id="formEnviarCorreos">
                        <div class="row">
                            <div class="form-group col-5">
                                <label for="idCampo">Escoja el campo</label>
                                <select name="idCampo" id="idCampo" class="form-control">
                                    <option value="Ninguno">Ninguno</option>
                                    <option value="Laboratorio">Laboratorio</option>
                                    <option value="Docente">Docente</option>
                                    <option value="Auxiliar Docente">Auxiliar Docente</option>
                                </select>
                            </div>
                            <div class="d-none form-group col-7" id="idGrpAmbiente">
                                <label for="idAmbiente">Seleccione materia-laboratorio</label>
                                <select name="idAmbiente" id="idAmbiente" class="form-control">
                                    <option value="Ninguno">Ninguno</option>
                                </select>
                            </div>
                        </div>
                        <div id="contCorreos" class="p-2">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="idCorreoAsunto">Asunto :</label>
                            <input type="text" name="idCorreoAsunto" id="idCorreoAsunto" class="form-control" value="Reportes" required>
                        </div>
                        <span>remitente: <strong>"Asistencia_Virtual_UMSS@mail.com"</strong></span>
                        <h4>Descripcion</h4>
                        <textarea name="idCorreoDes" id="idCorreoDes" class="form-control" required>Ya esta disponible la lista de hacer reportes</textarea>
                        <div class="text-center my-2">
                            <input type="submit" class="btn btn-primary" value="Enviar">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
            
            </div>
        </div>


        </div> 
        <div class="d-none">
            <input type="text" name="idCategoria" id="idCategoria" value="<?php echo $_SESSION['categoria_social'];?>">
        </div>
        <!-- <a href="Crear_director_carrera.php">Crear director de carrera/unidad</a> -->
        <div>
            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#myModal2">
                Crear carrera
            </button>
        </div>
        <h2 class="text-primary text-center">Carreras del departamento</h2>
        <table id="tablaCarrera" class="hover cell-border" style="width:100%">
            <thead class="bg-info">
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
                        <input type="text" name="idDeletCarreraDirector" id="idDeletCarreraDirector" class="d-none">
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
                            <input type="text" name="idEditDirectorCarrera" id="idEditDirectorCarrera" class="d-none">
                            <span class="d-none" id="dirAntiguoEditarCarrera"></span>
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
                            <div class="form-group d-none" >
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
        <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#myModal">
                Crear director de carrera
            </button>
        <br>
        <h2 class="text-primary text-center">Directores de carrera</h2>
        <table id="tablaDirector" class="hover cell-border" style="width:100%">
            <thead class="bg-info">
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
        <br>

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
                                <input type="text" name="nomDirector" id="nomDirector" class="form-control"   autocomplete="off" required pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁ ÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{6,80}">
                                <div class="invalid-feedback">Solo nombres entre 6 a 60 letras</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="ciDirector">Carnet de identidad: </label>
                                <input type="text" name="ciDirector" id="ciDirector" class="form-control"   autocomplete="off" required pattern="[0-9]{6,8}">
                                <div class="invalid-feedback">Solo números entre 6 a 8 dígitos</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoDirector">Correo electronico: </label>
                                <input type="email" name="correoDirector" id="correoDirector" class="form-control" required  autocomplete="off" >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telDirector">Telefono: </label>
                                <input type="text" name="telDirector" id="telDirector" class="form-control" autocomplete="off" required pattern="[0-9]{6,8}">
                                <div class="invalid-feedback">Solo números entre 6 a 8 dígitos</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="asigDirector">Seleccione carrera: </label>
                                <select class="form-control" id="asigDirector" name="asigDirector" required  >
                                </select>
                                <div class="invalid-feedback">Debe asignarle un departamento</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisDirector">Codigo SIS: </label>
                                <input type="password" name="sisDirector" id="sisDirector" class="form-control"  autocomplete="off" required pattern="[0-9]{6,8}">
                                <div class="invalid-feedback">Solo números entre 6 a 8 dígitos</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passDirector">Ingrese password: </label>
                                <input type="password" name="passDirector" id="passDirector" class="form-control" autocomplete="off" required pattern="[A-Za-z0-9_-]{4,15}">
                                <div class="invalid-feedback">Solo letras y números entre 4 y 15 caracteres</div>
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
                                <input type="text" name="nomAgregarCarrera" id="nomAgregarCarrera" class="form-control"  autocomplete="off" required pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁ ÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{6,80}">
                                <div class="invalid-feedback">Solo nombres entre 6 a 60 letras</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="codAgregarCarrera">Codigo carrera: </label>
                                <input type="text" name="codAgregarCarrera" id="codAgregarCarrera" class="form-control"  autocomplete="off" required pattern="[a-zA-Z]{3,6}">
                                <div class="invalid-feedback">Solo siglas entre 3 a 6 letras</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="fecAgregarCarrera">Seleccione fecha: </label>
                                <input type="date" name="fecAgregarCarrera" id="fecAgregarCarrera" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha:</div>
                            </div>
                        </div>
                        <div class="form-group d-none">
                                <label for="dirAgregarCarrera">Escoja Director de carrera: </label>
                                <select class="form-control" id="dirAgregarCarrera" name="dirAgregarCarrera">
                                    <option value="Ninguno">Ninguno</option>
                                </select>
                                <div class="invalid-feedback">Seleccione director</div>
                            </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear carrera">
                            <button class="btn btn-danger" class="close" data-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        
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
                                <input type="text" name="nomEditDirector" id="nomEditDirector"  autocomplete="off" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="ciEditDirector">Editar codigo SIS: </label>
                                <input type="text" name="ciEditDirector" id="ciEditDirector"  autocomplete="off" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telEditDirector">Telefono: </label>
                                <input type="text" name="telEditDirector" id="telEditDirector" autocomplete="off" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoEditDirector">Correo electronico: </label>
                                <input type="email" name="correoEditDirector" id="correoEditDirector"  autocomplete="off" class="form-control" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>

                        <div class="form-group">
                                <label for="matEditDirector">Telefono: </label>
                                <select name="matEditDirector" id="matEditDirector"  autocomplete="off" class="form-control">
                                
                                </select>
                                <div class="invalid-feedback">llene el campo</div>
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