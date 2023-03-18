<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

    session_start();
    if ($_SESSION["rol"] != "Practicante") {
        header("Location: /inventarios/login");
    }

    startHtml();
    head('Lista Prestamos');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">

    <h4 class="mt-4">
        Prestamos 
        <a class="btn btn-primary" href="/inventarios/prestamos/practicante/create">
            <i class="fa fa-add"></i> Nuevo
        </a>
    </h4>
    
    <table id="prestamos" class="table table-striped table-bordered table-hover" style="width:100%">
        <thead>
            <tr>
                <th class="col-2">ID</th>
                <th>Practicante</th>
                <th>Fecha</th>
                <th>Total</th>
                <th class="col-2">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php

                $query = "
                    SELECT prestamos.id, CONCAT(practicantes.nombres, ' ', practicantes.apellidos) AS practicante,
                    prestamos.fecha,
                    SUM(detalle_prestamos.cantidad_prestamo) AS total
                    FROM prestamos
                    INNER JOIN detalle_prestamos ON detalle_prestamos.id_prestamo = prestamos.id
                    INNER JOIN practicantes ON practicantes.id = prestamos.id_practicante
                    WHERE prestamos.status = 1 AND practicantes.id_usuario = '".$_SESSION["logged_id"]."'
                    GROUP BY id, practicantes.nombres, practicantes.apellidos, prestamos.fecha 
                    ORDER BY prestamos.fecha ASC;
                ";

                foreach (selectCustom($query) as $column) {
                    $id = $column['id'];
                    echo "<tr>";
                    echo "<td>".$column["id"]."</td>";
                    echo "<td>".$column["practicante"]."</td>";
                    echo "<td>".$column["fecha"]."</td>";
                    echo "<td>".$column["total"]."</td>";
                    echo "<td class='text-center'>";
                    echo "
                    <a class='btn btn-primary' href='/inventarios/prestamos/practicante/$id/show'>
                        <i class='fa fa-eye'></i>
                    </a>";
                    echo "
                    <a class='btn btn-success' href='/inventarios/prestamos/practicante/$id/retorno'>
                        <i class='fa-solid fa-right-left'></i>
                    </a>
                    ";
                    echo "
                    <button type='button' class='btn btn-danger btn-delete' onclick='deletePrestamo($id);' data-id='".$column["id"]."'>
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
            $('#prestamos').DataTable();
        });

        const deletePrestamo = (id) => {

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
                        url: '/inventarios/prestamos/practicante/'+id+'/delete',
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