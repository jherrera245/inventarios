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
    $table = "practicantes"; //nombre tabla
    
    //columnas
    $columnas = [
        'id' => 'NULL',
        'id_usuario' => 'NULL',
        'nombres' => 'NULL',
        'apellidos' => 'NULL',
        'dui' => 'NULL',
        'carnet' => 'NULL',
        'telefono' => 'NULL',
    ];

    //validaciones
    $filter = [
        "id" => FILTER_SANITIZE_ENCODED,
        "id_usuario" => FILTER_VALIDATE_INT,
        "nombres" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "apellidos" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "dui" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "carnet" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "telefono" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        //cargado datos a modelo
        $columnas["id_usuario"] = getParam("usuario");
        $columnas["nombres"] = getParam('nombres');
        $columnas["apellidos"] = getParam('apellidos');
        $columnas["dui"] = getParam('dui');
        $columnas["carnet"] = getParam('carnet');
        $columnas["telefono"] = getParam('telefono');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (insert($table, $data) > 0) {
            header('Location: /inventarios/practicantes');
        }else {
            header('Location: /inventarios/practicantes');
        }
    }


    //Actualizar datos
    if (isPost() and getParam("action") == "update") {
        //cargado datos a modelo
        $columnas["id"] = getParam("id");
        $columnas["id_usuario"] = getParam("usuario");
        $columnas["nombres"] = getParam('nombres');
        $columnas["apellidos"] = getParam('apellidos');
        $columnas["dui"] = getParam('dui');
        $columnas["carnet"] = getParam('carnet');
        $columnas["telefono"] = getParam('telefono');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (update($table, $data) > 0) {
            header('Location: /inventarios/practicantes');
        }else {
            header('Location: /inventarios/practicantes');
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