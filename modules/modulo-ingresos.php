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
    $tableIngresos = "ingresos"; //nombre tabla
    
    //columnas
    $columnasIngreso = [
        'id' => 'NULL',
        'id_proveedor' => 'NULL',
        'fecha' => 'NULL',
    ];

    //validaciones ingreso
    $filterIngreso = [
        "id" => FILTER_SANITIZE_ENCODED,
        "id_proveedor" => FILTER_VALIDATE_INT,
        "fecha" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
    ];

    //configuracion de tabla
    $tableDetalle = "detalle_ingresos"; //nombre tabla

    //columnas
    $columnasDetalles = [
        'id' => 'NULL',
        'id_ingreso' => 'NULL',
        'id_producto' => 'NULL',
        'cantidad' => 'NULL',
        'precio_compra' => 'NULL',
    ];
    
    $filterDetalle = [
        "id" => FILTER_SANITIZE_ENCODED,
        "id_ingreso" => FILTER_VALIDATE_INT,
        "id_producto" => FILTER_VALIDATE_INT,
        "cantidad" => FILTER_VALIDATE_INT,
        "precio_compra" => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags'  => FILTER_FLAG_STRIP_LOW,
        ],
    ]; 

    //guardar datos
    if (isPost() and getParam("action") == "save") {
        try {
            //cargado datos a modelo
            $columnasIngreso["id_proveedor"] = getParam("proveedor");
            $columnasIngreso["fecha"] = date("Y-m-d");

            //creamos un nuevo array con las entradas filtradas
            $dataIngreso = filter_var_array($columnasIngreso, $filterIngreso);
            $idIngreso = insert($tableIngresos, $dataIngreso);

            //agreglo de datos desde el formulario
            $productos = getParam('producto');
            $cantidad = getParam('cantidad');
            $precio_compra = getParam('precio_compra');

            $count = 0;

            while ($count < count($productos)) {
                $columnasDetalles["id_ingreso"] = $idIngreso;
                $columnasDetalles["id_producto"] = $productos[$count];
                $columnasDetalles["cantidad"] = $cantidad[$count];
                $columnasDetalles["precio_compra"] = $precio_compra[$count];

                $dataDetalles = filter_var_array($columnasDetalles, $filterDetalle);
                insert($tableDetalle, $dataDetalles);
                $count++;
            }

            if ($count > 0) {
                header('Location: /inventarios/ingresos');
            }else {
                header('Location: /inventarios/ingresos');
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    //Eliminar datos
    if (isGet() && getParam("action") == "delete") {   

        if (delete($tableIngresos, getParam("id")) > 0) {
            echo json_encode(array('token_delete'=>true));
        }else {
            echo json_encode(array('token_delete'=>false));
        }
    }
?>