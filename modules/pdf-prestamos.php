<?php 
    //incluyendo librerias
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(MODELS."model.php");
    require_once(REQUESTS."request.php");
    require_once(PDF."PDF.php");

    //para hacer uso del modulo debe tener rol admin
    session_start();
    if (!isset($_SESSION["logged_ok"])) {
        header("Location: /inventarios/login");
    }

    if (getParam("id")) {
        $selectPrestamo = "
            SELECT prestamos.id, CONCAT(practicantes.nombres, ' ', practicantes.apellidos) AS practicante,
            prestamos.fecha,
            SUM(detalle_prestamos.cantidad_prestamo) AS total
            FROM prestamos
            INNER JOIN detalle_prestamos ON detalle_prestamos.id_prestamo = prestamos.id
            INNER JOIN practicantes ON practicantes.id = prestamos.id_practicante
            WHERE prestamos.status = 1 AND prestamos.id = '".getParam("id")."'
            GROUP BY id, practicantes.nombres, practicantes.apellidos, prestamos.fecha
        ";

        $selectDetalle = "
            SELECT productos.nombre AS producto, productos.consumible,
            detalle_prestamos.cantidad_prestamo
            FROM detalle_prestamos
            INNER JOIN productos ON detalle_prestamos.id_producto = productos.id
            WHERE detalle_prestamos.id_prestamo = '".getParam("id")."'
        ";

        $pdf = new PDF('P', 'mm', 'A4');
        
        $pdf::$title = "Reporte Prestamos de Materiales";

        foreach (selectCustom($selectPrestamo) as $prestamo) {
            $pdf::$date = "Fecha de Prestamo: ".$prestamo["fecha"];
            $pdf::$practicante = "Practicante: ".$prestamo["practicante"];
            $pdf::$total = "Total de materiales: ".$prestamo["total"];
        }

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFillColor(200, 232, 232);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80,5, "Material", 1, 0, 'C', 1);
        $pdf->Cell(55,5, "Unidades", 1, 0, 'C', 1);
        $pdf->Cell(55,5, "Consumible", 1, 1, 'C', 1);

        foreach (selectCustom($selectDetalle) as $detalle) {
            $consumible = ($detalle["consumible"]) ? "Si" : "No";

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(80,5, $detalle["producto"], 1, 0, 'C', 1);
            $pdf->Cell(55,5, $detalle["cantidad_prestamo"], 1, 0, 'C', 1);
            $pdf->Cell(55,5, $consumible, 1, 1, 'C', 1);
        }

        $pdf->Output();
    }

?>