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
    $table = "productos"; //nombre tabla
    
    //columnas
    $columnas = [
        'id' => 'NULL',
        'id_categoria' => 'NULL',
        'id_concepto' => 'NULL',
        'nombre' => 'NULL',
        'stock' => 'NULL',
        'codigo' => 'NULL',
        'descripcion' => 'NULL',
        'consumible' => 'NULL'
    ];

    //validaciones
    $filter = [
        "id" => FILTER_SANITIZE_ENCODED,
        "id_categoria" => FILTER_VALIDATE_INT,
        "id_concepto" => FILTER_VALIDATE_INT,
        "nombre" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "stock" => FILTER_VALIDATE_INT,
        "codigo" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "descripcion" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "consumible" => FILTER_VALIDATE_INT
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        //cargado datos a modelo
        $columnas["id_categoria"] = getParam('categorias');
        $columnas["id_concepto"] = getParam('conceptos');
        $columnas["nombre"] = getParam('nombre');
        $columnas["stock"] = getParam('stock');
        $columnas["codigo"] = getParam('codigo');
        $columnas["descripcion"] = getParam('descripcion');
        $columnas["consumible"] = getParam('consumible');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (insert($table, $data) > 0) {
            header('Location: /inventarios/productos');
        }else {
            header('Location: /inventarios/productos');
        }
    }

    //Actualizar datos
    if (isPost() and getParam("action") == "update") {
        //cargado datos a modelo
        $columnas["id"] = getParam("id");
        $columnas["id_categoria"] = getParam('categorias');
        $columnas["id_concepto"] = getParam('conceptos');
        $columnas["nombre"] = getParam('nombre');
        $columnas["stock"] = getParam('stock');
        $columnas["codigo"] = getParam('codigo');
        $columnas["descripcion"] = getParam('descripcion');
        $columnas["consumible"] = getParam('consumible');

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (update($table, $data) > 0) {
            header('Location: /inventarios/productos');
        }else {
            header('Location: /inventarios/productos');
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