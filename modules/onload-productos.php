<?php
    //incluyendo librerias
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(MODELS."model.php");
    require_once(REQUESTS."request.php");

    //para hacer uso del modulo debe tener rol admin
    session_start();
    if (!isset($_SESSION["logged_ok"])) {
        header("Location: /inventarios/login");
    }

    //Definimos la codificación de caracteres en la cabecera.
    header('Content-Type: text/html; charset=utf-8');
    
    //configuracion de tabla
    $table = "productos"; //nombre tabla

    //cargar datos
    if (isPost() and getParam("action") == "onload") {
        $json = array();

        foreach (find($table, getParam("id")) as $producto) {
            $json["id"] = $producto["id"];
            $json["producto"] = $producto["nombre"];
            $json["stock"] = $producto["stock"];
        }
        
        echo json_encode($json);
    }

?>