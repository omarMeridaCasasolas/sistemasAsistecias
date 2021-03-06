<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Asistencias UMSS</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body class="bg-secondary">
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h2 class="modal-title" class="text-center">Te olvidaste tu contraseña</h2>
                                <button type="button" id="btnCerrarVtnPass" class="close" data-dismiss="modal" >&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="formRecuperarPassword" class="was-validated">
                                <div class="form-group">
                                    <h5><label for="correoParaRecuparar">Escribe tu correo para recibir un mensaje: </label></h5>
                                    <input type="email" name="correoParaRecuparar" id="correoParaRecuparar" class="form-control" required>
                                    <div class="valid-feedback">Formato aceptado</div>
                                </div>
                                <h5 id="msmRespuesta" class="text-danger"></h5>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary" value="Enviar">    
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
    <main class="bg-white mt-4 mx-auto rounded col-lg-6 col-md-10">
        <h1 class="text-center text-danger py-2">Sistema de Asistencia Virtual SAVIR-UMSS</h1>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item active" id="idItemUno"><a href="#indice" class="nav-link active" id="idLinkUno" data-toggle="tab"><h5>Indice</h5></a></li>
            <li class="nav-item" id="idItemDos"><a href="#autoridadesAcademicas" class="nav-link" id="idLinkDos" data-toggle="tab"><h5>Autoridades</h5></a></li>
            <li class="nav-item" id="idItemTres"><a href="#docente" class="nav-link" id="idLinkTres" data-toggle="tab"><h5>Docentes</h5></a></li>
            <li class="nav-item" id="idItemCinco"><a href="#auxiliarDocencia" class="nav-link " id="idLinkCinco" data-toggle="tab"><h5>Aux. docencia</h5></a></li>
            <li class="nav-item" id="idItemCuatro"><a href="#auxiliarLaboratorio" class="nav-link" id="idLinkCuatro" data-toggle="tab"><h5>Aux. laboratorio</h5></a></li>
            <li class="nav-item" id="idItemSeis"><a href="#personalLaboral" class="nav-link" id="idLinkSeis" data-toggle="tab"><h5>Personal laboral</h5></a></li>
        </ul>
        <br>
        <div class="tab-content">
            <div id="indice" class="container tab-pane active">
                <div class="row">
                    <div class="col-md-4">
                        <img src="https://convocatoriaumss.s3.us-east-2.amazonaws.com/Logo_UMSS.jpg" alt="logo_umss" class="w-100">
                    </div>
                    <div class="col-md-8">
                        <h2>Acerca de UMSS</h2>
                        <p>La Universidad Mayor de San Simón o por sus siglas (UMSS) es una universidad pública de Bolivia cuya sede está ubicada en la ciudad de Cochabamba teniendo otras unidades académicas en distintos puntos del departamento de Cochabamba. </p>
                        <p>El presente proyecto tiene por objeto dotar a la UMSS de un instrumento técnico normativo que permita un adecuado control de asistencia, puntualidad y permanencia del personal docente a dedicación parcial en clases presenciales, según las características propias de las áreas de conocimiento y naturaleza teórica, práctica, taller, laboratorio de las diferentes Asignaturas, Carreras y Unidades Académicas; a través de un sistema biométrico dactilar, digital, ocular, tarjeta magnética u otro, en el marco de lo dispuesto mediante Resolución del HCU N°27/16 de fecha 21 de diciembre de 2016, y en correspondencia con el Reglamento General de la Docencia.</p>
                        <h4>Contactos</h4>
                        <h6><span><i class="fas fa-globe"></i> <a href="www.umss.edu.bo">www.umss.edu.bo</a> </span>       <span><i class="fas fa-at"></i> informaciones@umss.edu.bo </span>        <span><i class="fas fa-phone"></i> +591 4 4251515</span></h6>
                        <h4>Redes Sociales</h4>
                        <div class="d-inline-block"> <h1><a href="https://www.facebook.com/UmssBolOficial/" target="_blank"><i class="fab fa-facebook-square"></i></a></h1></div>
                        <div class="d-inline-block"> <h1><a href="https://twitter.com/UmssBolOficial" target="_blank"><i class="fab fa-twitter-square"></i></a></h1></div>
                        <div class="d-inline-block"> <h1><a href="https://www.linkedin.com/school/universidad-mayor-de-san-simon/" target="_blank"><i class="fab fa-linkedin"></i></a></h1></div>
                        <div class="d-inline-block"> <h1><a href="https://www.youtube.com/channel/UCe91rHUSEpxXgkz0Cojt3MA" target="_blank"><i class="fab fa-youtube"></i></a></h1></div>
                    </div>
                </div>
            </div>
            <div id="autoridadesAcademicas" class="container tab-pane fade">
                <form action="controlador/formSessionDirector.php" method="post" class="was-validated">
                    <h2 class="text-center">Autoridades academicas <i class="fas fa-user"></i></h2>
                    <div class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="correoAutoridad">Ingrese su correo electronico: </label>
                            <input type="email" name="correoAutoridad" id="correoAutoridad" class="form-control" required>
                            <div class="invalid-feedback">Verifique que no tenga espacio o caracteres especiales</div>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                        <label for="passAutoridad">Ingrese password: </label>
                        <input type="password" name="passAutoridad" id="passAutoridad" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    </div>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                <h6><a href="" data-toggle="modal" data-target="#myModal">Olvidaste tu contraseña</a></h6>
                <br>
            </div>
            <div id="docente" class="container tab-pane fade">
                <form action="controlador/formSessionDocente.php" method="post" class="was-validated">
                    <h2 class="text-center">Ingreso Docente</h2>
                    <div class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="correoDocente">Ingrese su correo electronico: </label>
                            <input type="email" name="correoDocente" id="correoDocente" class="form-control" required>
                            <div class="invalid-feedback">Verifique que no tenga espacio o caracteres especiales</div>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="passDocente">Ingrese password: </label>
                            <input type="password" name="passDocente" id="passDocente" class="form-control" required>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </div>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                <h6><a href="" data-toggle="modal" data-target="#myModalPassDocente">Olvidaste tu contraseña</a></h6>
                <br>
                <!-- ventana modal password docente  -->
                <div id="myModalPassDocente" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h2 class="modal-title" class="text-center">Contraseña-Docente</h2>
                                <button type="button" id="btnCerrarVtnPassDocente" class="close" data-dismiss="modal" >&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="formRecuperarPasswordDocente" class="was-validated">
                                <div class="form-group">
                                    <h5><label for="correoParaRecupararDocente">Escribe tu correo para recibir un mensaje: </label></h5>
                                    <input type="email" name="correoParaRecupararDocente" id="correoParaRecupararDocente" class="form-control" required>
                                    <div class="valid-feedback">Formato aceptado</div>
                                </div>
                                <h5 id="msmRespuestaDocente" class="text-danger"></h5>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary" value="Enviar">    
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="auxiliarLaboratorio" class="container tab-pane fade">
                <form action="controlador/formSessionAuxiliarLaboratorio.php" method="post" class="was-validated">
                    <h2 class="text-center">Ingreso Auxiliares laboratorios </i></h2>
                    <div class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="correoAuxLab">Ingrese su correo electronico: </label>
                            <input type="email" name="correoAuxLab" id="correoAuxLab" class="form-control" required>
                            <div class="invalid-feedback">Verifique que no tenga espacio o caracteres especiales</div>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="passAuxLab">Ingrese password: </label>
                            <input type="password" name="passAuxLab" id="passAuxLab" class="form-control"  required>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </div>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                <h6><a href="" data-toggle="modal" data-target="#myModalPassAuxLab">Olvidaste tu contraseña</a></h6>
                <br>
                <!-- ventana modal password Auxiliar Laboratorio  -->
                <div id="myModalPassAuxLab" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h2 class="modal-title" class="text-center">Contraseña-Auxiliares laboratorio</h2>
                                <button type="button" id="btnCerrarVtnPassAuxLab" class="close" data-dismiss="modal" >&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="formRecuperarPasswordAuxLab" class="was-validated">
                                <div class="form-group">
                                    <h5><label for="correoParaRecupararAuxLab">Escribe tu correo para recibir un mensaje: </label></h5>
                                    <input type="email" name="correoParaRecupararAuxLab" id="correoParaRecupararAuxLab" class="form-control" required>
                                    <div class="valid-feedback">Formato aceptado</div>
                                </div>
                                <h5 id="msmRespuestaAuxLab" class="text-danger"></h5>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary" value="Enviar">    
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="auxiliarDocencia" class="container tab-pane fade">
                <form action="controlador/formSessionAuxiliarDocente.php" method="post" class="was-validated">
                    <h2 class="text-center">Auxiliar de docencia</h2>
                    <div class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="correoAuxDoc">Ingrese su correo electronico: </label>
                            <input type="email" name="correoAuxDoc" id="correoAuxDoc" class="form-control" required>
                            <div class="invalid-feedback">Verifique que no tenga espacio o caracteres especiales</div>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </div>
                    <dov class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="passAuxDoc">Ingrese password: </label>
                            <input type="password" name="passAuxDoc" id="passAuxDoc" class="form-control" required>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </dov>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                
                <h6><a href="" data-toggle="modal" data-target="#myModalPassAuxDoc">Olvidaste tu contraseña</a></h6>
                <br>
            </div>

            <!-- ventana modal password Auxiliar Docencia  -->
            <div id="myModalPassAuxDoc" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h2 class="modal-title" class="text-center">Contraseña-Auxiliares Docencia</h2>
                                <button type="button" id="btnCerrarVtnPassAuxDoc" class="close" data-dismiss="modal" >&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="formRecuperarPasswordAuxDoc" class="was-validated">
                                <div class="form-group">
                                    <h5><label for="correoParaRecupararAuxDoc">Escribe tu correo para recibir un mensaje: </label></h5>
                                    <input type="email" name="correoParaRecupararAuxDoc" id="correoParaRecupararAuxDoc" class="form-control" required>
                                    <div class="valid-feedback">Formato aceptado</div>
                                </div>
                                <h5 id="msmRespuestaAuxDoc" class="text-danger"></h5>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary" value="Enviar">    
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>

            <div id="personalLaboral" class="container tab-pane fade">
                <form action="controlador/formSessionPersonalLaboral.php" method="post" class="was-validated">
                    <h2 class="text-center">Personal Laboral</h2>
                    <div class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="correo">Ingrese su correo electronico: </label>
                            <input type="email" name="correo" id="correo" class="form-control" required>
                            <div class="invalid-feedback">Verifique que no tenga espacio o caracteres especiales</div>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </div>
                    <dov class="row">
                        <div class="form-group mx-auto mt-2 col-lg-8 col-md-10 col-sm-12">
                            <label for="pass">Ingrese password: </label>
                            <input type="password" name="pass" id="pass" class="form-control" required>
                            <div class="valid-feedback">Formato aceptado</div>
                        </div>
                    </dov>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                
                <h6><a href="" data-toggle="modal" data-target="#myModalTrabajador">Olvidaste tu contraseña</a></h6>
                <br>
            </div>

            <!-- ventana modal password Auxiliar Docencia  -->
            <div id="myModalTrabajador" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h2 class="modal-title" class="text-center">Recuperar contraseña</h2>
                                <button type="button" id="btnCerrarVtnPassLab" class="close" data-dismiss="modal" >&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="formRecuperarPasswordAuxDoc" class="was-validated">
                                <div class="form-group">
                                    <h5><label for="correoParaRecupararAuxDoc">Escribe tu correo para recibir un mensaje: </label></h5>
                                    <input type="email" name="formRecuperarPasswordAuxDoc" id="formRecuperarPasswordAuxDoc" class="form-control" required>
                                    <div class="valid-feedback">Formato aceptado</div>
                                </div>
                                <h5 id="msmRespuestaAuxDoc" class="text-danger"></h5>
                                <div class="text-center">
                                    <input type="submit" class="btn btn-primary" value="Enviar">    
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </main>
    <footer>

    </footer>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="vista/src/index.js"></script>
</body>
</html>