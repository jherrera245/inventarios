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
    $table = "categorias"; //nombre tabla
    
    //columnas
    $columnas = [
        'id' => 'NULL',
        'nombre' => 'NULL',
        'descripcion' => 'NULL'
    ];

    //validaciones
    $filter = [
        "id" => FILTER_SANITIZE_ENCODED,
        "nombre" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "descripcion" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ]
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        //cargado datos a modelo
        $columnas["nombre"] = getParam('nombre');
        $columnas["descripcion"] = getParam('descripcion');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (insert($table, $data) > 0) {
            header('Location: /inventarios/categorias');
        }else {
            header('Location: /inventarios/categorias');
        }
    }

    //Actualizar datos
    if (isPost() and getParam("action") == "update") {
        //cargado datos a modelo
        $columnas["id"] = getParam("id");
        $columnas["nombre"] = getParam('nombre');
        $columnas["descripcion"] = getParam('descripcion');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (update($table, $data) > 0) {
            header('Location: /inventarios/categorias');
        }else {
            header('Location: /inventarios/categorias');
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