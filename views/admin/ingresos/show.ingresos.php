<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }

    startHtml();
    head('Detalles Ingresos');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <?php
                $selectIngreso = "
                    SELECT ingresos.id, CONCAT(proveedores.nombres, ' ', proveedores.apellidos) AS proveedor,
                    SUM(detalle_ingresos.cantidad * detalle_ingresos.precio_compra) AS total, fecha
                    FROM ingresos
                    INNER JOIN detalle_ingresos ON detalle_ingresos.id_ingreso = ingresos.id
                    INNER JOIN proveedores ON proveedores.id = ingresos.id_proveedor
                    WHERE ingresos.status = 1 AND ingresos.id = '".getParam("id")."'
                    GROUP BY id, proveedores.nombres, proveedores.apellidos;
                ";
            
                foreach (selectCustom($selectIngreso) as $ingreso) {
            ?>
            
            <div class="card p-3 mb-3 mt-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h5>
                            <i class="fas fa-user"></i>
                            Proveedor: <?php echo $ingreso["proveedor"]; ?>
                        </h5>

                        <p>
                            <small><span class="fw-bold">Fecha</span>: <?php echo $ingreso["fecha"]; ?></small>
                        </p>
                    </div>
                    <!-- /.col -->
                </div>

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Cantidad</th>
                                    <th>Producto</th>
                                    <th>Precio de Compra</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $query = "
                                        SELECT productos.nombre AS producto, detalle_ingresos.cantidad, detalle_ingresos.precio_compra
                                        FROM detalle_ingresos
                                        INNER JOIN productos ON detalle_ingresos.id_producto = productos.id
                                        WHERE detalle_ingresos.id_ingreso = '".getParam("id")."'
                                    ";

                                    foreach (selectCustom($query) as $detalle){
                                        echo "
                                        <tr>
                                            <td>".$detalle["producto"]."</td>
                                            <td>".$detalle["cantidad"]."</td>
                                            <td>".$detalle["precio_compra"]."</td>
                                        </tr>
                                        ";
                                    }
                                ?>
                                <tr>
                                    <th colspan="2">Total</th>
                                    <td>
                                        <span class="badge bg-primary">
                                           $ <?php echo $ingreso["total"]; ?>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button>
                        
                        <a href="/inventarios/ingresos" class="btn btn-secondary float-right" style="margin-right: 5px;">
                            <i class="fas fa-angle-left"></i> Regresar
                        </a>
                    </div>
                </div>
            </div>

            <?php 
                }
            ?>
        </div>
    </div>

</div>

<?php
    pageContentEnd();
    endHtml();
?>