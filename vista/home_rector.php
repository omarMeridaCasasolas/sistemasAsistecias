<?php
    session_start();
    if(isset($_SESSION["codigo_autoridad"])){

    }else{
         header("Location:../index.php");
     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home rector</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<header>
    <input type="text" name="cargoActualUsuario" id="cargoActualUsuario" class="d-none" value="<?php echo $_SESSION['cargo']; ?>">
    <input type="text" name="nomActualUsuario" id="nomActualUsuario" class="d-none" value="<?php echo $_SESSION['nombre_autoridad']; ?>">

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div>
        <img src="https://convocatoriaumss.s3.us-east-2.amazonaws.com/Avatares/user-icon-vector.jpg" class="rounded" alt="Cinque Terre" width="75" height="75"> 
            <h2 class="text-white p-2"><?php echo $_SESSION['cargo'].": ".$_SESSION['nombre_autoridad'];?></h2>
        </div>
        <div class="d-block">
        <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a>
        </div>
        <br>
        <button type="button" class="btn btn-warning" data-toggle="modal" id="btnEditSelf" data-target="#myModalEditarDatos">
        <i class="fas fa-user-cog"></i>
  </button>

  <!-- The Modal -->
  <div class="modal fade" id="myModalEditarDatos">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header bg-info">
          <h4 class="modal-title">Cambiar datos peronales</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
            <form action="../controlador/formActualizarDatosUsuario.php" id="editFormSelf" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <input type="text" name="idUsuarioSync" id="idUsuarioSync" class="d-none">
                    <div class="form-group col-7">
                        <label for="editCorreo">Correo electronico:</label>
                        <input type="text" name="editCorreo" id="editCorreo" class="form-control" required>
                    </div>
                    <div class="form-group col-5">
                        <label for="editTel">Telefono:</label>
                        <input type="text" name="editTel" id="editTel" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="nuevoPass">Nueva contraseña</label>
                        <input type="text" name="nuevoPass" id="nuevoPass" class="form-control">
                    </div>
                    <div class="form-group col-6">
                        <label for="repeatPAss">Repetir contaseña</label>
                        <input type="text" name="repeatPAss" id="repeatPAss" class="form-control">
                    </div>
                </div>
                <span class="text-danger" id="changePassUser"></span>
                <div class="form-group">
                    <label for="myFile">Selecione una foto o imagen</label>
                    <input type="file" name="myFile" id="myFile" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="editPass">Contraseña:</label>
                    <input type="text" name="editPass" id="editPass" class="form-control" required>
                    <span class="text-danger" id="editUsurPassSelf"></span>
                </div>
                <div class="text-center">
                <input type="submit" class="btn btn-secondary" value="Actualizar">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>
    </nav>
</header>

<!-- HU agregar funcionalidades a X usuario -->
    <div>
    <button type="button" class="float-rigth btn btn-light" data-toggle="modal" data-target="#vtnAsignarFunciones" id="btnAyunRector">
                Crear ayudante 
            </button> 
    </div>
    <div class="modal fade" id="vtnAsignarFunciones">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-success">
                        <h2 class="modal-title text-center">Crear ayudante</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formCrearAyudanteRector" method="post">
                        <div class="form-group">
                                <label for="nomAyudanteRector">Nombre del ayudante: </label>
                                <input type="text" name="nomAyudanteRector" id="nomAyudanteRector" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off">
                            </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ciAyudanteRector">Carnet identidad: </label>
                                <input type="text" name="ciAyudanteRector" id="ciAyudanteRector" class="form-control" required pattern="[0-9]{6,8}" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="telAyudanteRector">Telefono/cel: </label>
                                <input type="text" name="telAyudanteRector" id="telAyudanteRector" class="form-control" required pattern="[0-9]{6,8}" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label for="correoAyudanteRector">Correo electronico: </label>
                                <input type="email" name="correoAyudanteRector" id="correoAyudanteRector" class="form-control" required autocomplete="off">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="nomCargoAyudanteRector">Nom. cargo: </label>
                                <input type="text" name="nomCargoAyudanteRector" id="nomCargoAyudanteRector" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required autocomplete="off">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label for="fileFotoAyudante">Ingrese foto:</label>
                            <input type="file" name="fileFotoAyudante" id="fileFotoAyudante">
                        </div> -->
                        <div class="bg-light" id="myDivFuncionesRector"></div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Ayudante">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarVtnAyudante">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
<!-- HU agregar funcionalidades a X usuario -->

<body class="bg-secondary">
    <main class="container bg-white p-2">

        <!--Inicio  Crear facultad UMSS  -->
        <div>
            <button type="button" class="btn btn-primary justify-content-end" data-toggle="modal" data-target="#myModal2">
                Crear facultad
            </button>
        </div>
        <h2 class="text-primary text-center">Facultades de UMSS</h2>
        <table id="tableFacultad" class="hover" style="width:100%">
            <thead class="bg-info">
                <tr>
                    <th>Codigo Facultad</th>
                    <th>Nombre de la facultad</th>
                    <th>Fecha de creacion</th>
                    <th>Director Academico</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            </tbody>
        </table>

        <div class="modal fade" id="myModal2">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear Facultad</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formCrearFacultad" method="post" class="was-validated">
                        <div class="form-group">
                                <label for="nomFacultad">Nombre de la facultad: </label>
                                <input type="text" name="nomFacultad" id="nomFacultad" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="facCodigo">Codigo facultad: </label>
                                <input type="text" name="facCodigo" id="facCodigo" class="form-control"  pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,7}" autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="facFechaCrea">Seleccione fecha: </label>
                                <input type="date" name="facFechaCrea" id="facFechaCrea" class="form-control" autoclolete="off" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Facultad">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!--Fin Crear facultad UMSS  -->
        <!-- Eliminar Facultad -->
        <div class="modal fade" id="myModal5">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center">Eliminar Facultad</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEliminarFacultad" method="post" class="was-validated">
                        <input type="text" class="d-none" name="" id="idFacultadEliminar">
                        <p> Usted esta seguro que quiere eliminar la facultadad <strong id="nomFacultadEliminar"></strong> con el codigo: <strong id="codFacultadEliminar"></strong><p>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Eliminar Facultad">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEliminarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Editar Facultad ventana -->
        <div class="modal fade" id="myModal4">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-warning">
                        <h2 class="modal-title text-center">Editar Facultad</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body-->
                    <div class="modal-body">
                    <form action="" id="formEditarFacultad" method="post" class="was-validated">
                    <input type="text" class="d-none" name="idFacultadEditar" id="idFacultadEditar">
                        <div class="form-group">
                                <label for="nomEditFacultad">Editar nombre de la facultad: </label>
                                <input type="text" name="nomEditFacultad" id="nomEditFacultad" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}"  autocomplete="off" required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="facEditCodigo">Editar codigo facultad: </label>
                                <input type="text" name="facEditCodigo" id="facEditCodigo" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,6}" autocomplete="off"required>
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="facEditFechaCrea">Editar fecha: </label>
                                <input type="date" name="facEditFechaCrea" id="facEditFechaCrea" class="form-control" required>
                                <div class="invalid-feedback">Escoje fecha</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Actualizar facultad">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCloseEditarFacultad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- director academico -->

        <br>
        <h2 class="text-primary text-center">Directores academicos</h2>
            <button type="button" class="btn btn-primary float-right" id="crearDirectorAcademico">Crear director academico</button>
        <br><br><br>
        <table id="tablaDirAcademico" class="hover" style="width:100%">
            <thead class="bg-info">
                <tr>
                    <!-- <th>Codigo SIS</th> -->
                    <th>Nombre del director</th>
                    <th>Asignacion </th>
                    <th>Correo electronico</th>
                    <th>Telefono</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>

        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-center">Crear director academico</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body ../controlador/formRegistrarDirectorAcademico.php-->
                    <div class="modal-body">
                    <form action="" method="post" class="was-validated" id="formAgregarDirectorAcademico">
                        <div class="form-group">
                                <label for="nomDirAcad">Nombre director Academico</label>
                                <input type="text" name="nomDirAcad" id="nomDirAcad" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,80}" required autocomplete="off">
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="ciDirAcad">Carnet de identidad</label>
                                <input type="text" name="ciDirAcad" id="ciDirAcad" class="form-control" required autocomplete="off" pattern="[0-9]{6,8}" >
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="correoDirAcad">Correo electronico: </label>
                                <input type="email" name="correoDirAcad" id="correoDirAcad" class="form-control" required autocomplete="off" >
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-5">
                                <label for="telDirAcad">Telefono: </label>
                                <input type="text" name="telDirAcad" id="telDirAcad" class="form-control" required autocomplete="off" pattern="[0-9]{6,8}">
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="facDirAcad">Escoja Facultadad: </label>
                                <select class="form-control" id="facDirAcad" name="facDirAcad" >
                                </select>
                                <div class="invalid-feedback">Selecione facultad</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="sisDirAcad">Codigo SIS</label>
                                <input type="password" name="sisDirAcad" id="sisDirAcad" class="form-control" required autocomplete="off" pattern="[0-9]{6,9}">
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passDirAcad">Ingrese password</label>
                                <input type="password" name="passDirAcad" id="passDirAcad" class="form-control" required autocomplete="off">
                                <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Crear Director Academico">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarAutoridad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Eliminar director acedemico -->
        <div class="modal fade" id="myModalDelDirector">
            <div class="modal-dialog">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header bg-danger">
                        <h2 class="modal-title text-center text-white">Eliminar director Academico</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                <!--modal body ../controlador/formRegistrarDirectorAcademico.php-->
                    <div class="modal-body">
                    <form action="" id="formEliminarDirectorAcademico">
                    <input type="text" class="d-none" name="" id="idDirectorEliminar">
                    <input type="text" class="d-none" name="idFacultadDirectorEliminar" id="idFacultadDirectorEliminar">
                        <p> Usted esta seguro que quiere eliminar al director Academico <strong id="nomDirectorEliminar"></strong> con el codigo SIS: <strong id="codDirectorEliminar"></strong><p>
                        <div><p>Dir. facultad de: <strong id="nomFacEliminar"></strong></p></div>
                        <div class="text-center my-2">
                            <input type="submit" class="btn  btn-primary" value="Eliminar Director Academico">
                            <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" id="btnCerrarAutoridad">Cancelar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="modalCrearDirector">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h2 class="modal-title text-center">Crear director academico</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="formCrearDirectorAcademico" class="">    
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nombre director academico</label>
                        <input type="text" name="" id="formCrearnomDirAca" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð]{2,80}" required  autocomplete="off">
                        <div class="invalid-feedback">llene el campo</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="" class="col-form-label">Carnet de identidad:</label>
                                <input type="text" class="form-control" id="formCrearCiDirAca" required  autocomplete="off">
                            <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="form-group">
                                <label for="" class="col-form-label">Correo electronico:</label>
                                <input type="email" class="form-control" id="formCrearCorDirAca" required  autocomplete="off">
                            <div class="invalid-feedback">llene el campo</div>
                            </div>
                        </div>   
                    </div>
                    <div class="row"> 
                        <div class="form-group col-lg-4 col-sm-12">
                            <label for="" class="col-form-label">Telefono:</label>
                            <input type="text" class="form-control" id="formCrearTelDirAca" required pattern="[0-9]{6,8}" autocomplete="off">
                        <div class="invalid-feedback">llene el campo</div>           
                        </div>
                        <div class="form-group col-lg-8 col-sm-12">
                            <label for="" class="col-form-label">Escoja Facultad:</label>
                            <select class="form-control" id="formCrearFacAsiDirAca" name="formCrearFacAsiDirAca" required="none">
                            <!-- <option value="666">Ninguno</option> -->
                            </select>
                        </div>  
                    </div> 
                    <div class="row"> 
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="" class="col-form-label">Codigo SIS:</label>
                            <input type="password" class="form-control" id="formCrearCodSisDirAca" required pattern="[0-9]{6,8}" autocomplete="off">
                            <div class="invalid-feedback">llene el campo</div>
                            </div>               
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                            <label for="" class="col-form-label">Ingrese password:</label>
                            <input type="password" class="form-control" id="formCrearPasDirAca" required autocomplete="off">
                            <div class="invalid-feedback">llene el campo</div>
                        </div> 
                        </div>  
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnGuardarNuevoDirector" class="btn btn-primary">Guardar</button>
                    <button type="button" id="btnCancelarNuevoDirector"class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
                </form>    
            </div>
    </div>
</div>  

<!-- modal editar direcotr academicos     -->
<div class="modal fade" id="myModaEditDirector">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="modal-title text-center">Editar director academico</h2>
                <button type="button" class="close"  data-dismiss="modal">&times;</button>
            </div>
        <form id="formEditarDirector">    
            <div class="modal-body">
            <input type="text" class="d-none" name="idDirectorEdit" id="idDirectorEdit">
            <input type="text" class="d-none" name="nomDirectorEditFac" id="nomDirectorEditFac">
            <input type="text" class="d-none" name="idFacultadActDir" id="idFacultadActDir">
                <div class="form-group">
                    <label for="">Nombre director academico</label>
                    <input type="text" name="" id="formEditarNomDirAca" class="form-control" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,80}"  required autocomplete="off">
                    <div class="invalid-feedback">llene el campo</div>
                </div>
                <div class="row">
                    <div class="form-group col-4">
                    <label for="formEditarCodSisDirAca">Codigo SIS:</label>
                    <input type="text" class="form-control" id="formEditarCodSisDirAca" required pattern="[0-9]{6,8}" autocomplete="off">
                    <div class="invalid-feedback">llene el campo</div>
                    </div>
                    <div class="form-group col-8">
                    <label for="formEditarFacAsiDirAca" >Facultad asignada:</label>
                    <select class="form-control" id="formEditarFacAsiDirAca" name="formEditarFacAsiDirAca" required autocomplete="off">
                    </select>
                    </div>    
                </div>
                <div class="row"> 
                    <div class="form-group col-4">
                        <label for="formEditarTelDirAca" >Telefono</label>
                        <input type="text" class="form-control" id="formEditarTelDirAca" required pattern="[0-9]{6,8}" autocomplete="off">
                        <div class="invalid-feedback">llene el campo</div>             
                    </div>
                    <div class="form-group col-8">
                    <label for="formEditarCorDirAca" >Correo electronico</label>
                    <input type="email" class="form-control" id="formEditarCorDirAca" required autocomplete="off">
                    <div class="invalid-feedback">llene el campo</div>
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="src/home_rector.js"></script>
</body>
</html>