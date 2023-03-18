<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }

    startHtml();
    head('Detalles Prestamo');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <?php
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
            ?>

            <div class="card p-3 mb-3 mt-3">
                <!-- title row -->
                <?php 
                    foreach (selectCustom($selectPrestamo) as $prestamo) {
                ?>
                <div class="row">
                    <div class="col-12">
                        <h5>
                            <i class="fas fa-user"></i>
                            Practicante: <?php echo $prestamo["practicante"]; ?>
                        </h5>

                        <p>
                            <span class="fw-bold">Fecha de Prestamo</span>: <?php echo $prestamo["fecha"]; ?>
                        </p>

                        <p>
                            <span class="fw-bold">Total de Material Sumnistrados: </span>
                            <span class="badge bg-primary">
                                <?php echo $prestamo["total"]; ?>
                            </span>
                        </p>
                    </div>
                    <!-- /.col -->
                    <?php 
                        }
                    ?>
                </div>

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Cantidad Prestamo</th>
                                    <th>Cantidad Devuelta</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $query = "
                                        SELECT productos.nombre AS producto, productos.consumible,
                                        detalle_prestamos.cantidad_prestamo, detalle_prestamos.cantidad_devuelto 
                                        FROM detalle_prestamos
                                        INNER JOIN productos ON detalle_prestamos.id_producto = productos.id
                                        WHERE detalle_prestamos.id_prestamo = '".getParam("id")."'
                                    ";

                                    foreach (selectCustom($query) as $detalle){          
                                        $materialDevuelto = ($detalle["consumible"]) ? 
                                        "<span class='badge bg-secondary'>No Aplica</span>" : $detalle["cantidad_devuelto"];

                                        echo "
                                        <tr>
                                            <td>".$detalle["producto"]."</td>
                                            <td>".$detalle["cantidad_prestamo"]."</td>
                                            <td>".$materialDevuelto."</td>
                                        </tr>
                                        ";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <a href="/inventarios/prestamos/reportes/<?php echo getParam("id"); ?>/pdf" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </a>
                        
                        <a href="/inventarios/prestamos/admin" class="btn btn-secondary float-right" style="margin-right: 5px;">
                            <i class="fas fa-angle-left"></i> Regresar
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?php
    pageContentEnd();
    endHtml();
?>