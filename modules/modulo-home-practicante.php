<?php
    //incluyendo librerias
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(MODELS."model.php");
    require_once(REQUESTS."request.php");

    //para hacer uso del modulo debe tener rol admin
    session_start();
    if ($_SESSION["rol"] != "Practicante") {
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

    //total materiales pendientes
    if (isPost() and getParam("action") == "totalPendiente") {
        $practicante = getParam("practicante");
        //contar los practicantes
        $pendientes = "
            SELECT SUM(detalle_prestamos.cantidad_prestamo) AS total 
            FROM detalle_prestamos
            INNER JOIN prestamos ON prestamos.id = detalle_prestamos.id_prestamo
            INNER JOIN practicantes ON practicantes.id = prestamos.id_practicante
            INNER JOIN productos ON productos.id = detalle_prestamos.id_producto
            WHERE 
            (detalle_prestamos.cantidad_prestamo - detalle_prestamos.cantidad_devuelto) > 0 AND productos.consumible = 0
            AND practicantes.id_usuario = '$practicante' AND prestamos.status = 1
        ";

        $json = array();

        foreach (selectCustom($pendientes) as $pendiente) {
            $json[] = $pendiente;
        }
        
        echo json_encode($json);
    }

    //total prestamos
    if (isPost() and getParam("action") == "totalPrestamo") {
        $practicante = getParam("practicante");
        //contar los prestamos
        $prestamos = "
            SELECT COUNT(prestamos.id) AS total 
            FROM prestamos 
            INNER JOIN practicantes ON practicantes.id = prestamos.id_practicante
            WHERE practicantes.id_usuario = '$practicante' AND prestamos.status = 1
        ";

        $json = array();

        foreach (selectCustom($prestamos) as $prestamo) {
            $json[] = $prestamo;
        }
        
        echo json_encode($json);
    }


    //total regresado
    if (isPost() and getParam("action") == "totalRegresado") {
        $practicante = getParam("practicante");
        //contar los regresado
        $regresados = "
            SELECT SUM(detalle_prestamos.cantidad_devuelto) AS total 
            FROM detalle_prestamos
            INNER JOIN prestamos ON prestamos.id = detalle_prestamos.id_prestamo
            INNER JOIN practicantes ON practicantes.id = prestamos.id_practicante
            INNER JOIN productos ON productos.id = detalle_prestamos.id_producto
            WHERE  productos.consumible = 0 AND practicantes.id_usuario = '$practicante' AND prestamos.status = 1
        ";

        $json = array();

        foreach (selectCustom($regresados) as $regresado) {
            $json[] = $regresado;
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
        $practicante = getParam("practicante");
        //contar los prestamos por practicante
        $prestamos = "
            SELECT prestamos.fecha, SUM(detalle_prestamos.cantidad_prestamo) AS total
            FROM detalle_prestamos
            INNER JOIN prestamos ON detalle_prestamos.id_prestamo = prestamos.id
            INNER JOIN practicantes ON practicantes.id = prestamos.id_practicante
            WHERE practicantes.id_usuario = '$practicante' AND prestamos.status = 1
            GROUP BY prestamos.id ORDER BY total DESC LIMIT 10
        ";

        $json = array();

        foreach (selectCustom($prestamos) as $prestamo) {
            $json[] = $prestamo;
        }
        
        echo json_encode($json);
    }
?>