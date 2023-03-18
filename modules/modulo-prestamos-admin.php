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
    $tablePrestamos = "prestamos"; //nombre tabla
    
    //columnas
    $columnasPrestamo = [
        'id' => 'NULL',
        'id_practicante' => 'NULL',
        'fecha' => 'NULL',
    ];

    //validaciones Prestamo
    $filterPrestamo = [
        "id" => FILTER_SANITIZE_ENCODED,
        "id_practicante" => FILTER_VALIDATE_INT,
        "fecha" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
    ];

    //configuracion de tabla
    $tableDetalle = "detalle_prestamos"; //nombre tabla

    //columnas
    $columnasDetalles = [
        'id' => 'NULL',
        'id_prestamo' => 'NULL',
        'id_producto' => 'NULL',
        'cantidad_prestamo' => 'NULL',
        'cantidad_devuelto' => 'NULL',
    ];
    
    $filterDetalle = [
        "id" => FILTER_SANITIZE_ENCODED,
        "id_prestamo" => FILTER_VALIDATE_INT,
        "id_producto" => FILTER_VALIDATE_INT,
        "cantidad_prestamo" => FILTER_VALIDATE_INT,
        "cantidad_devuelto" => FILTER_VALIDATE_INT,
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        try {
            //cargado datos a modelo
            $columnasPrestamo["id_practicante"] = getParam("practicante");
            $columnasPrestamo["fecha"] = date("Y-m-d");

            //creamos un nuevo array con las entradas filtradas
            $dataPrestamo = filter_var_array($columnasPrestamo, $filterPrestamo);
            $idPrestamo = insert($tablePrestamos, $dataPrestamo);

            //agreglo de datos desde el formulario
            $productos = getParam('producto');
            $cantidad = getParam('cantidad');

            $count = 0;

            while ($count < count($productos)) {
                $columnasDetalles["id_prestamo"] = $idPrestamo;
                $columnasDetalles["id_producto"] = $productos[$count];
                $columnasDetalles["cantidad_prestamo"] = $cantidad[$count];
                $columnasDetalles["cantidad_devuelto"] = 0;

                $dataDetalles = filter_var_array($columnasDetalles, $filterDetalle);
                insert($tableDetalle, $dataDetalles);
                $count++;
            }

            if ($count > 0) {
                header('Location: /inventarios/prestamos/admin');
            }else {
                header('Location: /inventarios/prestamos/admin');
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    //regresar materiales
     //guardar datos
     if (isPost() and getParam("action") == "return") {
        try {
            //id del prestamo 
            $prestamoId = getParam('prestamo');

            //agreglo de datos desde el formulario
            $retorno = getParam('retorno');
            $producto = getParam('producto');

            $count = 0;

            while ($count < count($producto)) {
                $productoId = $producto[$count];
                $cantidad = $retorno[$count];

                echo $prestamoId."<br>";
                echo $cantidad."<br>";
                echo $prestamoId."<br>";
    
                returnProduct($tableDetalle, $cantidad, $prestamoId, $productoId);            
                $count++;
            }

            if ($count > 0) {
                header('Location: /inventarios/prestamos/admin');
            }else {
                header('Location: /inventarios/prestamos/admin');
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    //Eliminar datos
    if (isGet() && getParam("action") == "delete") {   

        if (delete($tablePrestamos, getParam("id")) > 0) {
            echo json_encode(array('token_delete'=>true));
        }else {
            echo json_encode(array('token_delete'=>false));
        }
    }
?>