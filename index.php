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
    <main class="container bg-white mt-5 rounded">
        <h1 class="text-center text-danger py-2">Sistema de Asistencia Virtual UMSS</h1>
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item active" id="idItemUno"><a href="#indice" class="nav-link active" id="idLinkUno" data-toggle="tab">Indice</a></li>
            <li class="nav-item" id="idItemDos"><a href="#autoridadesAcademicas" class="nav-link" id="idLinkDos" data-toggle="tab">Autoridades Academicas</a></li>
            <li class="nav-item" id="idItemTres"><a href="#docente" class="nav-link" id="idLinkTres" data-toggle="tab">Docentes</a></li>
            <li class="nav-item" id="idItemCuatro"><a href="#auxiliarLaboratorio" class="nav-link" id="idLinkCuatro" data-toggle="tab">Personal de laboratorio</a></li>
            <li class="nav-item" id="idItemCinco"><a href="#auxiliarDocencia" class="nav-link " id="idLinkCinco" data-toggle="tab">Auxiliares de docencia</a></li>
        </ul>
        <br>
        <div class="tab-content">
            <div id="indice" class="container tab-pane active">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum illo exercitationem repellendus quam eius. Pariatur molestiae recusandae labore modi sequi
                 laborum laboriosam dolor repellendus dolorum? Et amet perferendis laudantium laboriosam.</p>
                 <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum illo exercitationem repellendus quam eius. Pariatur molestiae recusandae labore modi sequi
                 laborum laboriosam dolor repellendus dolorum? Et amet perferendis laudantium laboriosam.</p>
            </div>
            <div id="autoridadesAcademicas" class="container tab-pane fade">
                <form action="controlador/formSessionDirector.php" method="post" class="was-validated">
                    <h2 class="text-center">Ingreso a autoridades academicas <i class="fas fa-user"></i></h2>
                    <div class="form-group mx-3">
                        <label for="correoAutoridad">Ingrese su correo electronico: </label>
                        <input type="email" name="correoAutoridad" id="correoAutoridad" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="codigoAutoridad">Ingrese codigo asignado: </label>
                        <input type="password" name="codigoAutoridad" id="codigoAutoridad" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="passAutoridad">Ingrese password: </label>
                        <input type="password" name="passAutoridad" id="passAutoridad" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                <h5><a href="">Olvidate tu contraseña</a></h5>
                <br>
            </div>
            <div id="docente" class="container tab-pane fade">
                <form action="" method="post" class="was-validated">
                    <h2 class="text-center">Ingreso Docente</h2>
                    <div class="form-group mx-3">
                        <label for="correoDocente">Ingrese su correo electronico: </label>
                        <input type="email" name="correoDocente" id="correoDocente" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="codigoDocente">Ingrese codigo asignado: </label>
                        <input type="password" name="codigoDocente" id="codigoDocente" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="passDocente">Ingrese password: </label>
                        <input type="password" name="passDocente" id="passDocente" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                <h5><a href="">Olvidate tu contraseña</a></h5>
                <br>
            </div>
            <div id="auxiliarLaboratorio" class="container tab-pane fade">
                <form action="" method="post" class="was-validated">
                    <h2 class="text-center">Ingreso Auxiliares laboratorios</h2>
                    <div class="form-group mx-3">
                        <label for="correoAuxLab">Ingrese su correo electronico: </label>
                        <input type="email" name="correoAuxLab" id="correoAuxLab" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="codigoAuxLab">Ingrese codigo asignado: </label>
                        <input type="password" name="codigoAuxLab" id="codigoAuxLab" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="passAuxLab">Ingrese password: </label>
                        <input type="password" name="passAuxLab" id="passAuxLab" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                <h5><a href="">Olvidate tu contraseña</a></h5>
                <br>
            </div>
            <div id="auxiliarDocencia" class="container tab-pane fade">
                <form action="" method="post" class="was-validated">
                    <h2 class="text-center">Auxiliar de docencia</h2>
                    <div class="form-group mx-3">
                        <label for="correoAuxDoc">Ingrese su correo electronico: </label>
                        <input type="email" name="correoAuxDoc" id="correoAuxDoc" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="codigoAuxDoc">Ingrese codigo asignado: </label>
                        <input type="password" name="codigoAuxDoc" id="codigoAuxDoc" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="form-group mx-3">
                        <label for="passAuxDoc">Ingrese password: </label>
                        <input type="password" name="passAuxDoc" id="passAuxDoc" class="form-control" required>
                        <div class="valid-feedback">Formato aceptado</div>
                    </div>
                    <div class="text-center pb-2">
                        <input type="submit" class="btn btn-primary" value="Ingresar">
                    </div>
                </form>
                <h5><a href="">Olvidate tu contraseña</a></h5>
                <br>
            </div>
        </div>
    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="vista/src/index.js"></script>
</body>
</html>