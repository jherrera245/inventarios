<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }

    startHtml();
    head('Lista Ingresos');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">

    <h4 class="mt-4">
        Ingresos 
        <a class="btn btn-primary" href="/inventarios/ingresos/create">
            <i class="fa fa-add"></i> Nuevo
        </a>
    </h4>
    
    <table id="ingresos" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-2">ID</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Total</th>
                <th class="col-2">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php

                $query = "
                    SELECT ingresos.id, CONCAT(proveedores.nombres, ' ', proveedores.apellidos) AS proveedor,
                    ingresos.fecha,
                    SUM(detalle_ingresos.cantidad * detalle_ingresos.precio_compra) AS total
                    FROM ingresos
                    INNER JOIN detalle_ingresos ON detalle_ingresos.id_ingreso = ingresos.id
                    INNER JOIN proveedores ON proveedores.id = ingresos.id_proveedor
                    WHERE ingresos.status = 1
                    GROUP BY id, proveedores.nombres, proveedores.apellidos, ingresos.fecha
                    ORDER BY ingresos.fecha ASC
                ";

                foreach (selectCustom($query) as $column) {
                    $id = $column['id'];
                    echo "<tr>";
                    echo "<td>".$column["id"]."</td>";
                    echo "<td>".$column["proveedor"]."</td>";
                    echo "<td>".$column["fecha"]."</td>";
                    echo "<td>".$column["total"]."</td>";
                    echo "<td class='text-center'>";
                    echo "
                    <a class='btn btn-primary' href='/inventarios/ingresos/$id/show'>
                        <i class='fa fa-eye'></i>
                    </a>";
                    echo "
                    <button type='button' class='btn btn-danger btn-delete' onclick='deleteIngreso($id);' data-id='".$column["id"]."'>
                        <i class='fa fa-trash'></i>
                    </button>";
                    echo"</td>";
                    echo "</tr>";
                }
            ?>    
        </tbody>
        
        <tfoot>
            <tr>
                <th class="col-2">ID</th>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Total</th>
                <th class="col-2">Opciones</th>
            </tr>
        </tfoot>
    </table>

    <div class="mb-3"></div>
</div>

<!--creando varible con el script a anexar a la plantilla -->
<?php 
    $script = "
    <script>
        $(document).ready(function () {
            $('#ingresos').DataTable();
        });

        const deleteIngreso = (id) => {

            Swal.fire({
                title: 'Estas seguro?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar ahora!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '/inventarios/ingresos/'+id+'/delete',
                        success: function (data) {
                            if (data.token_delete === true) {
                                Swal.fire(
                                    'Eliminado!',
                                    'Tu registro fue eleminado correctamente.',
                                    'success'
                                )

                            }else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'El registro de pudo ser eliminado',
                                    footer: '<a>Ingresa aqui para obtener más información?</a>'
                                })
                            }
                            
                            //espera para recargar la pagina
                            setTimeout(() =>{
                                location.reload();
                            }, 500);
                        }
                    });
                }
            });
        };
    </script>
    ";
?>

<?php
    pageContentEnd();
    endHtml($script);
?>