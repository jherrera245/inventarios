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
    $table = "proveedores"; //nombre tabla
    
    //columnas
    $columnas = [
        'id' => 'NULL',
        'nombres' => 'NULL',
        'apellidos' => 'NULL',
        'documento' => 'NULL',
        'direccion' => 'NULL',
        'telefono' => 'NULL',
        'correo' => 'NULL'
    ];

    //validaciones
    $filter = [
        "id" => FILTER_SANITIZE_ENCODED,
        "nombres" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "apellidos" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "documento" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "direccion" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "telefono" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "correo" => FILTER_VALIDATE_EMAIL
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        //cargado datos a modelo
        $columnas["nombres"] = getParam('nombres');
        $columnas["apellidos"] = getParam('apellidos');
        $columnas["documento"] = getParam('documento');
        $columnas["direccion"] = getParam('direccion');
        $columnas["telefono"] = getParam('telefono');
        $columnas["correo"] = getParam('correo');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (insert($table, $data) > 0) {
            header('Location: /inventarios/proveedores');
        }else {
            header('Location: /inventarios/proveedores');
        }
    }


    //Actualizar datos
    if (isPost() and getParam("action") == "update") {
        //cargado datos a modelo
        $columnas["id"] = getParam("id");
        $columnas["nombres"] = getParam('nombres');
        $columnas["apellidos"] = getParam('apellidos');
        $columnas["documento"] = getParam('documento');
        $columnas["direccion"] = getParam('direccion');
        $columnas["telefono"] = getParam('telefono');
        $columnas["correo"] = getParam('correo');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (update($table, $data) > 0) {
            header('Location: /inventarios/proveedores');
        }else {
            header('Location: /inventarios/proveedores');
        }
    }

    //Eliminar datos
    if (isGet() && getParam("action") == "delete") {   

        if (delete($table, getParam("id")) > 0) {
            echo json_encode(array('token_delete'=>true));
        }else {
            echo json_encode(array('token_delete'=>false));
        }
    }
?>