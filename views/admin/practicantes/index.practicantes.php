<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }

    startHtml();
    head('Lista Practicantes');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">

    <h4 class="mt-4">
        Practicantes 
        <a class="btn btn-primary" href="/inventarios/practicantes/create">
            <i class="fa fa-add"></i> Nuevo
        </a>
    </h4>
    
    <table id="practicantes" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class="col-2">ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>DUI</th>
                <th>Carnet</th>
                <th>Telefono</th>
                <th class="col-2">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php 
                foreach (selectAll("practicantes") as $column) {
                    $id = $column['id'];
                    echo "<tr>";
                    echo "<td>".$column["id"]."</td>";
                    echo "<td>".$column["nombres"]."</td>";
                    echo "<td>".$column["apellidos"]."</td>";
                    echo "<td>".$column["dui"]."</td>";
                    echo "<td>".$column["carnet"]."</td>";
                    echo "<td>".$column["telefono"]."</td>";
                    echo "<td class='text-center'>";
                    echo "
                    <a class='btn btn-primary' href='/inventarios/practicantes/$id/edit'>
                        <i class='fa fa-edit'></i>
                    </a>";
                    echo "
                    <a class='btn btn-secondary' href='/inventarios/usuarios/".$column["id_usuario"]."/edit'>
                        <i class='fa fa-user'></i>
                    </a>";
                    echo "
                    <button type='button' class='btn btn-danger btn-delete' onclick='deletePracticante($id);' data-id='".$column["id"]."'>
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
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>DUI</th>
                <th>Carnet</th>
                <th>Telefono</th>
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
            $('#practicantes').DataTable();
        });

        const deletePracticante = (id) => {

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
                        url: '/inventarios/practicantes/'+id+'/delete',
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