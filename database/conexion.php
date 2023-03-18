<?php 
    #funcion para la conexion a base de datos
    function getConexion() {
        $server = "localhost";
        $database = "db_inventario";
        $user = "root";
        $password = "";
        // Create connection
        $conexion = new mysqli($server, $user, $password, $database);
        $conexion->set_charset("utf8mb4");

        // Check connection
        if (!$conexion) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $conexion;
    }
?>