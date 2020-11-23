<?php 
    session_start();
    if(isset($_SESSION['nombreAuxLab'])){
        $idAuxiliar = $_SESSION['idAuxLab'];
        require_once('../modelo/model_horario_laboratorio.php');
        $horarioLaboratorio = new HorarioLaboratorio();
        $laboratoriosPorAux = $horarioLaboratorio->listaLaboratoriosAux($idAuxiliar);

        require_once('../modelo/model_reporte_aux_lab.php');
        $reporteAuxiliarLaboratorio = new ReporteAuxLab();
    }else{
        header("Location:../index.php?error=auntentificacion&tipo=auxiliar_laboratorio");
        // var_dump($_SESSION['nombreAuxLab']);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HIstorila de Auxliar de laboratorio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"></head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>
<body class="bg-secondary">
    <header class="bg-dark text-white p-2">
        <h1>Bienvenido Axiliar de laboratorio <?php echo $_SESSION['nombreAuxLab']; ?></h1>
        <a class="float-right" href="../controlador/formCerrarSession.php">Cerrar session</a> 
    </header>
    <main class="bg-white mt-4 p-4 mx-auto rounded col-lg-8 col-md-12">
        <form action="" id="buscarReportesLab">
            <h2 class="text-center">Buscar reporte por</h2>
            <input type="text" class="d-none" name="idAuxiliarLaboratorio" id="idAuxiliarLaboratorio" value="<?php echo  $idAuxiliar; ?>">
                <div class="mx-auto">
                    <div class="form-group mx-auto col-lg-5 col-md-6">
                            <label for="selLaboratorio">Selecione sus reporten de:</label>
                            <select name="selLaboratorio" id="selLaboratorio" class="form-control">
                                <option value="Ninguno">Ninguno</option>
                            </select>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary" value="Buscar">
                    </div>
                </div>
            
        </form>
        <div class="responsive">
        <table id="tablaHistorialReporteLaboratorio" class="display nowrap cell-border" style="width:100%">
            <thead class="bg-info">
                <tr>
                    <th>Fecha</th>
                    <th>Trabajo relizado</th>
                    <th>Observacion</th>
                    <th>Documentos entregados</th>
                    <th>Opciones</th>
                </tr>
            </thead>
        </table>
        </div>
    </main>    
    <script src="src/historial_repotes_laboratorio.js"></script>
</body>
</html>
