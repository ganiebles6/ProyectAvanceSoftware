<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conexion
 *
 * @author ganie
 */
class Conexion {

    //put your code here

    private $host, $user, $password, $database;

    function __construct() {
        $this->host = "localhost";
        $this->user = "root";
        $this->password = "toor";
        $this->database = "avancesoftware";
    }

    public function ReturnConnection() {

        $conexion = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($conexion->connect_error) {
            die("Error al intectar conectar a MySql " . $conexion->connect_errno);
            echo "Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
        }else{
            return $conexion;
        }
    }

}
