<?php 
    class Conexion {
        protected $connexion_bd;
        public function Conexion(){
            try {
                $this->connexion_bd = new PDO("pgsql:host=ec2-54-166-251-173.compute-1.amazonaws.com;port=5432;dbname=dctiulnicj379o","xmsyriiyuioakv","e2cd0393af2275c14b3139ffe58729909452073a0c0e00f814f3ffdbc47754c2");
                $this->connexion_bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->connexion_bd;
            } catch(Exception $e){
                echo $e->getMessage()."<br>";
                echo "Error en la linea ".$e->getLine();
            }
        }
    }