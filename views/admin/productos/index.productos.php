<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }

    startHtml();
    head('Lista Productos');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">

    <h4 class="mt-4">
        Productos 
        <a class="btn btn-primary" href="/inventarios/productos/create">
            <i class="fa fa-add"></i> Nuevo
        </a>
    </h4>
    
    <table id="productos" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class="col-2">ID</th>
                <th>Producto</th>
                <th>Categoria</th>
                <th>Concepto</th>
                <th>Stock</th>
                <th>Código</th>
                <th>Consumible</th>
                <th class="col-1">Opciones</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
                //cuando se trabaja con varias tablas o queremos hacer una selaccion diferente selectAll 
                //usamos la funcion selectCustom y elaboramos nuestro select de manera personalizada
                $query = "
                    SELECT productos.id, productos.nombre AS producto, categorias.nombre as categoria, 
                    conceptos.concepto, stock, codigo, consumible FROM productos
                    INNER JOIN categorias ON categorias.id = productos.id_categoria
                    INNER JOIN conceptos ON conceptos.id = productos.id_concepto
                    WHERE productos.status = 1;
                ";
            
                foreach (selectCustom($query) as $column) {
                    $id = $column['id'];
                    echo "<tr>";
                    echo "<td>".$column["id"]."</td>";
                    echo "<td>".$column["producto"]."</td>";
                    echo "<td>".$column["categoria"]."</td>";
                    echo "<td>".$column["concepto"]."</td>";
                    echo "<td>".$column["stock"]."</td>";
                    echo "<td>".$column["codigo"]."</td>";
                    if ($column["consumible"] == true) {
                        echo "<td><span class='badge bg-danger'>Si</span></td>";
                    } else {
                        echo "<td><span class='badge bg-success'>No</span></td>";
                    }
                    echo "<td class='text-center'>";
                    echo "
                    <a class='btn btn-primary' href='/inventarios/productos/$id/edit'>
                        <i class='fa fa-edit'></i>
                    </a>";
                    echo "
                    <button type='button' class='btn btn-danger btn-delete' onclick='deleteProducto($id);' data-id='".$column["id"]."'>
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
                <th>Producto</th>
                <th>Categoria</th>
                <th>Concepto</th>
                <th>Stock</th>
                <th>Código</th>
                <th>Consumible</th>
                <th class="col-1">Opciones</th>
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
            $('#productos').DataTable();
        });

        const deleteProducto = (id) => {

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
                        url: '/inventarios/productos/'+id+'/delete',
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