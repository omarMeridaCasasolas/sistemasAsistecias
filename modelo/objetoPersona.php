<?php

// se declara el objeto
class Avion {

    // variables
    public $nombreAuxiliar,$idAuxiliar,$totalDeHoras,$faltasMensuales,$horasLicencia,$horasBaja,$horasPagables;


    // a partir de aquí estan las funciones
    // constructor de la clase
    function __construct($nombre,$id,$total,$faltasMensuales,$horasLicencia,$horasBaja,$horasPagables) {
        $this->nombreAuxiliar = $nombre; 
        $this->idAuxiliar = $id; 
        $this->totalDeHoras = $total; 
        $this->faltasMensuales = $faltasMensuales; 
        $this->horasLicencia = $horasLicencia; 
        $this->horasBaja = $horasBaja; 
        $this->horasPagables = $horasPagables; 
    }

    public function getTipo() {
        switch ($tipoMotor) {
            case 1: $descripcion = "Hélices";
                break;
            case 2: $descripcion = "Propulsión a chorro";
                break;
            default:
                $descripcion = "Tipo no encontrado";
        }
        return $descripcion;
    }

    public function getEstado() {
        return "El avión con matrícula >" . $this->matricula . "< está: " . $this->estado;
    }

    public function despegar() {
        $this->estado = "Volando";
    }

    public function aterrizar() {
        $this->estado = "Esperando";
    }

    public function setMatricula($m) {
        $this->matricula = $m;
    }

    // destructor de la clase
    function __destruct() {
        echo "El avión con matrícula >" . $this->matricula . "< se ha destruido.";
    }

}