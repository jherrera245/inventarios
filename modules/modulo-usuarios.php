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
    $table = "usuarios"; //nombre tabla
    
    //columnas
    $columnas = [
        'id' => 'NULL',
        'username' => 'NULL',
        'email' => 'NULL',
        'password' => 'NULL',
    ];

    //validaciones
    $filter = [
        "id" => FILTER_SANITIZE_ENCODED,
        "username" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
        "email" => FILTER_VALIDATE_EMAIL,
        "password" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        //cargado datos a modelo
        $columnas["username"] = getParam('nombre');
        $columnas["email"] = getParam('correo');
        $columnas["password"] = md5(getParam('password'));        

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
        $columnas["username"] = getParam('nombre');
        $columnas["email"] = getParam('correo');
        
        if (getParam('password') == "") {
            foreach (find("usuarios", getParam("id")) as $usuario) {
                $columnas["password"] = $usuario["password"];
            } 
        }else {
            $columnas["password"] = md5(getParam("password"));
        }

        //creamos un nuevo array con las entradas filtradas
        $data = filter_var_array($columnas, $filter);

        if (update($table, $data) > 0) {
            header('Location: /inventarios/usuarios');
        }else {
            header('Location: /inventarios/usuarios');
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