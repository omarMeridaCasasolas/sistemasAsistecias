<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <form action="" id="formBusquedaReportes" class="mx-auto col-lg-5 col-md-7">
            <h2 class="text-center text-primary">Busqueda de reportes por: </h2>
            <input type="text" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
            <div class="form-group">
                <label for="tipoUnidad">Tipo</label>
                <select name="tipoUnidad" id="tipoUnidad" class="form-control">
                    <option value="Ninguno">Ninguno</option>
                    <option value="Laboratorios">Laboratorios</option>
                    <option value="Docente">Docente</option>
                    <option value="Auxiliar de docencia">Auxiliar de docencia</option>
                </select>
            </div>
            <div id="elemGrupo" class="form-group d-none">
                <label for="tipoGrupo" id="labNombre">Materia _ Laboratorio</label>
                <select name="tipoGrupo" id="tipoGrupo" class="form-control">
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div id="elemNombre" class="form-group d-none">
                <label for="TipoNombre" id="labNombre">Nombre </label>
                <select name="TipoNombre" id="TipoNombre" class="form-control">
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div class="text-center">
                <input type="submit" value="Buscar" class="btn btn-secondary">
            </div>
        </form>

        <table id="tablaHistorialReporte" class="display nowrap cell-border" style="width:100%">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Materia-Laboratorio</th>
                    <th>Asignado</th>
                    <th>Trabajo relizado</th>
                    <th>Observacion</th>
                    <th>Documentos entregados</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>

    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/reportes_departamento.js"></script>
</body>
</html>
