<?php 
    //incluyendo librerias
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(MODELS."model.php");
    require_once(REQUESTS."request.php");

    //Definimos la codificación de caracteres en la cabecera.
    header('Content-Type: text/html; charset=utf-8');

    //Obtener datos del producto
    if (isGet()) {
        $data = array();
        //cuando se trabaja con varias tablas o queremos hacer una selaccion diferente selectAll 
        //usamos la funcion selectCustom y elaboramos nuestro select de manera personalizada
        $query = "
            SELECT productos.id, productos.nombre AS producto, categorias.nombre as categoria, 
            conceptos.concepto, stock, codigo, consumible FROM productos
            INNER JOIN categorias ON categorias.id = productos.id_categoria
            INNER JOIN conceptos ON conceptos.id = productos.id_concepto
            WHERE productos.status = 1;
        ";

        foreach (selectCustom($query) as $producto) {
            $row = array();
            $data[] = $producto;
        }
        
        echo json_encode($data);
    }
?>