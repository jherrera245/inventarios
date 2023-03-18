<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Practicante") {
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
                    AND practicantes.id_usuario = '".$_SESSION["logged_id"]."'
                    GROUP BY id, practicantes.nombres, practicantes.apellidos, prestamos.fecha
                ";
            
                foreach (selectCustom($selectPrestamo) as $prestamo) {
            ?>

            <form action="/inventarios/prestamos/practicante/<?php echo getParam('id'); ?>/return" method="post" >
                <input class="form-control" type="hidden" name="action" value="return">
                <input class="form-control" type="hidden" name="prestamo" value="<?php echo getParam('id'); ?>">

                <div class="card p-3 mb-3 mt-3">
                    <!-- title row -->
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
                    </div>

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="col-4">Material</th>
                                        <th>Cantidad Prestamo</th>
                                        <th>Cantidad Devuelta</th>
                                        <th>Devolver</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                        $query = "
                                            SELECT productos.id AS productoId, productos.nombre AS producto, productos.consumible,
                                            detalle_prestamos.cantidad_prestamo, detalle_prestamos.cantidad_devuelto 
                                            FROM detalle_prestamos
                                            INNER JOIN productos ON detalle_prestamos.id_producto = productos.id
                                            WHERE productos.consumible = 0 AND detalle_prestamos.id_prestamo = '".getParam("id")."'
                                        ";
                                        $rows = 0;

                                        foreach (selectCustom($query) as $detalle) {

                                            $max = 0;
                                            $min = 0;
    
                                            if ($detalle["cantidad_devuelto"] == 0) {
                                                $max = $detalle["cantidad_prestamo"];
                                                $min = $detalle["cantidad_devuelto"];
                                            }else {
                                                $max = $detalle["cantidad_prestamo"] - $detalle["cantidad_devuelto"];
                                                $min = 0;
                                            }

                                            if (($max-$min) > 0) {
                                                $rows++;
                                                echo "
                                                <tr>
                                                    <td>".$detalle["producto"]."</td>
                                                    <td>".$detalle["cantidad_prestamo"]."</td>
                                                    <td>".$detalle["cantidad_devuelto"]."</td>
                                                    <td class='col-4'>
                                                        <input class='form-control' type='hidden' name='producto[]' value='".$detalle["productoId"]."'>
                                                        <input class='form-control retorno' type='number' name='retorno[]' min='$min'
                                                        max='$max' placeholder='Ingresa la cantidad a devolver' value='0'>
                                                    </td>  
                                                </tr>
                                                ";
                                            }
                                        }

                                        if ($rows == 0) {
                                            echo "
                                                <tr>
                                                    <td colspan='4' class='text-center'>
                                                        El material ha sido de vuelto o es consumible
                                                    </td>
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
                            <?php 
                                if ($rows > 0) {
                            ?>
                                <button type="submit" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fa-solid fa-right-left"></i> Regresar Materiales
                                </button>
                            <?php
                                }
                            ?>
                            
                            <a href="/inventarios/prestamos/practicante" class="btn btn-secondary float-right" style="margin-right: 5px;">
                                <i class="fas fa-angle-left"></i> Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <?php 
                }
            ?>
        </div>
    </div>

</div>

<?php 
    $script  = "
    <script>
        $('.retorno').each(() => {
            $(this).on('change', (e) => {
                changenValue(e.target)
            })

            $(this).on('keyup', (e) => {
                changenValue(e.target)
            })
        })

        const changenValue = (input) => {
            let value = parseInt(input.value)
            let max = parseInt(input.max)
            let min = parseInt(input.min)

            if (value > max) {
                input.value = max
            }else if (value < min) {
                input.value = min
            }
        }
    </script>
    ";
?>

<?php
    pageContentEnd();
    endHtml($script);
?>