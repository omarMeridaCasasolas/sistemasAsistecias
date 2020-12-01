<?php include_once("parts/cabezera_director.php");?>
<body class="bg-secondary">
    <main class="container bg-white p-2">
        <form action="" id="formBusquedaReportes" class="mx-auto col-lg-5 col-md-7">
            <h2 class="text-center text-primary">Busqueda de reportes por: </h2>
            <input type="text" class="d-none" name="idDepartamento" id="idDepartamento" value="<?php echo $_SESSION['categoria_social'];?>">
            <div id="elemGrupo" class="form-group d-none">
                <label for="gestionAuxPiz">Selecione Gestion</label>
                <select name="gestionAuxPiz" id="gestionAuxPiz" class="form-control">
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div id="elemNombre" class="form-group d-none">
                <label for="materiaAuxPiz">Selecione materia</label>
                <select name="materiaAuxPiz" id="materiaAuxPiz" class="form-control">
                    <option value="Todos">Todos</option>
                </select>
            </div>
            <div id="elemNombre" class="form-group d-none">
                <label for="verAuzPiz">Forma de ver</label>
                <select name="verAuzPiz" id="verAuzPiz" class="form-control">
                    <option value="Todos">Todos</option>
                </select>
            </div>

            <div class="text-center my-3">
                <input type="submit" value="Buscar" class="btn btn-secondary">
            </div>
        </form>
        <h3>Fecha <span>Fecha inicio</span>- <span>Fecha-Final</span> del mes de <span>MES</span></h3>
        <div class="table-responsive">
            <table id="tablaHistorialReporte" class="display nowrap cell-border" style="width:100%">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Horario de clases</th>
                        <th>Materia</th>
                        <th>Asignado</th>
                        <th>Avanze</th>
                        <th>Plataforma</th>
                        <th>Documentos entregados</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
            </table>
        </div>

    </main>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="src/reportes_auxiliar_pizarra.js"></script>
</body>
</html>
