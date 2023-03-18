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
    

    //total material
    if (isPost() and getParam("action") == "totalMaterial") {
        //sumarizar el material

        $materiales = "SELECT SUM(stock) AS total FROM productos WHERE status = 1";

        $json = array();

        foreach (selectCustom($materiales) as $material) {
            $json[] = $material;
        }
        
        echo json_encode($json);
    }

    //total practicantes
    if (isPost() and getParam("action") == "totalPracticante") {
        //contar los practicantes

        $practicantes = "SELECT COUNT(id) AS total FROM practicantes WHERE status = 1";

        $json = array();

        foreach (selectCustom($practicantes) as $practicante) {
            $json[] = $practicante;
        }
        
        echo json_encode($json);
    }

    //total prestamos
    if (isPost() and getParam("action") == "totalPrestamo") {
        //contar los prestamos

        $prestamos = "SELECT COUNT(id) AS total FROM prestamos WHERE status = 1";

        $json = array();

        foreach (selectCustom($prestamos) as $prestamo) {
            $json[] = $prestamo;
        }
        
        echo json_encode($json);
    }


    //total usuarios
    if (isPost() and getParam("action") == "totalUsuario") {
        //contar los usuarios

        $usuarios = "SELECT COUNT(id) AS total FROM usuarios WHERE status = 1";

        $json = array();

        foreach (selectCustom($usuarios) as $usuario) {
            $json[] = $usuario;
        }
        
        echo json_encode($json);
    }


    //grafica materiales
    if (isPost() and getParam("action") == "graficaMateriales") {
        //contar los usuarios
        $materiales = "
            SELECT CONVERT(categorias.nombre USING utf8) AS nombre, SUM(productos.stock) AS total
            FROM productos
            INNER JOIN categorias ON productos.id_categoria = categorias.id
            WHERE categorias.status = 1 AND productos.status = 1
            GROUP BY categorias.nombre
        ";

        $json = array();

        foreach (selectCustom($materiales) as $material) {
            $json[] = $material;
        }
        
        echo json_encode($json);
    }

    //grafica prestamos
    if (isPost() and getParam("action") == "graficaPrestamos") {
        //contar los usuarios
        $prestamos = "
            SELECT prestamos.fecha, SUM(detalle_prestamos.cantidad_prestamo) AS total
            FROM detalle_prestamos
            INNER JOIN prestamos ON detalle_prestamos.id_prestamo = prestamos.id
            WHERE prestamos.status = 1
            GROUP BY prestamos.id ORDER BY total DESC LIMIT 10
        ";

        $json = array();

        foreach (selectCustom($prestamos) as $prestamo) {
            $json[] = $prestamo;
        }
        
        echo json_encode($json);
    }
?>