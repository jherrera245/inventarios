<?php
    //incluyendo librerias
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(MODELS."model.php");
    require_once(REQUESTS."request.php");

    //para hacer uso del modulo debe tener rol admin
    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }

    //Definimos la codificación de caracteres en la cabecera.
    header('Content-Type: text/html; charset=utf-8');
    
    //configuracion de tabla
    $table = "roles_usuarios"; //nombre tabla
    
    //columnas
    $columnas = [
        'id' => 'NULL',
        'id_usuario' => 'NULL',
        'id_rol' => 'NULL'
    ];

    //validaciones
    $filter = [
        "id" => FILTER_SANITIZE_ENCODED,
        "id_usuario" => FILTER_VALIDATE_INT,
        "id_rol" => FILTER_VALIDATE_INT,
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        //cargado datos a modelo
        $columnas["id_usuario"] = getParam('usuario');
        $columnas["id_rol"] = getParam('rol');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (insert($table, $data) > 0) {
            header('Location: /inventarios/usuarios');
        }else {
            header('Location: /inventarios/usuarios');
        }
    }

    //Actualizar datos
    if (isPost() and getParam("action") == "update") {
        //cargado datos a modelo
        $columnas["id"] = getParam("id");
        $columnas["id_usuario"] = getParam('usuario');
        $columnas["id_rol"] = getParam('rol');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (update($table, $data) > 0) {
            header('Location: /inventarios/usuarios');
        }else {
            header('Location: /inventarios/usuarios');
        }
    }

?>