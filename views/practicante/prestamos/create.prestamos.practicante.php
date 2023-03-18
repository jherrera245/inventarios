<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

    session_start();
    if ($_SESSION["rol"] != "Practicante") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Crear Prestamo');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <form action="/inventarios/prestamos/practicante/save" method="post">

        <?php 
            $query = "SELECT id FROM practicantes WHERE id_usuario = '".$_SESSION["logged_id"]."'";
            $id = 0;

            foreach (selectCustom($query) as $practicante) {
                $id = $practicante["id"];
            }
        ?>

        <input class="form-control" type="hidden" name="action" value="save">
        <input class="form-control" type="hidden" name="practicante" value="<?php echo $id; ?>">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Solicitar Prestamo
            </div>

            <!-- Formulario de registro de ingresos -->
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold" for="producto">Material o Herramienta</label>
                            <select class="form-control select2bs4" id="producto">
                            <?php 
                                foreach(selectAll("productos") as $producto){
                                    echo "<option value='".$producto["id"]."'>".$producto["nombre"]."</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold" for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" 
                            placeholder="Disponibles" min="0" step="1" disabled>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold" for="cantidad">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" 
                            placeholder="Ingresa cantidad de producto" min="0" step="1">
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold" for="opciones">Opciones</label>
                            <button type="button"class="btn btn-primary form-control" id="agregar">
                                <i class="fa fa-plus-square"></i>&nbsp;Agregar
                            </button>
                        </div>
                    </div>

                </div>

                <!-- tabla de detalles -->
                <div class="row">
                    <div class="col-12">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <th>Opciones</th>
                                <th>Material o Herramienta</th>
                                <th>Cantidad</th>
                            </thead>

                            <tbody id="detalle-prestamo">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="btn-guardar" disabled>
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/prestamos/practicante" class="btn btn-secondary">
                    <i class="fa fa-arrow-circle-left"></i>
                    Regresar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- template detalle productos -->
<template id="template-detalle-prestamo">
    <tr>
        <td class="col-1 text-center">
            <button type="button" class="btn btn-danger btn-remove" data-id="1">
                <i class="fas fa-times"></i>
            </button>
        </td>
        <td class="col-6">
            <input type="hidden" class="form-control detalle-producto-id" name="producto[]">
            <input type="text" class="form-control detalle-producto-nombre" disabled>
        </td>

        <td class="col-5">
            <input type="number" class="form-control detalle-cantidad" name="cantidad[]"
            placeholder="Ingresa cantidad de producto" min="0" step="1">
        </td>

        <td></td>
    </tr>
</template>

<?php 
    $script = "
        <script>
            $(document).ready(function() {
                $('select').each(function () {
                    $(this).select2({
                    theme: 'bootstrap4',
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                    placeholder: $(this).data('placeholder'),
                    allowClear: Boolean($(this).data('allow-clear')),
                    closeOnSelect: !$(this).attr('multiple'),
                    });
                });

                onLoadStockProducto();
            });

            $('#producto').on('change', () => {
                onLoadStockProducto();
            });

            onLoadStockProducto = () => {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '/inventarios/onload/productos',
                    data: {
                        action : 'onload',
                        id: $('#producto').val(),
                    },
                    success: function (response) {
                        const producto = response;
                        $('#cantidad').val('0');

                        if (listaPrestamos.length > 0) {
                            let quitar = 0;

                            listaPrestamos.forEach(prestamo=> {
                                if (parseInt(prestamo.idProducto) === parseInt(producto.id)) {
                                    quitar += prestamo.cantidad;
                                }
                            });

                            let stock = (producto.stock > quitar) ? producto.stock - quitar : 0;

                            $('#stock').val(stock);
                            $('#cantidad').attr('max', stock);
                        }else {
                            $('#stock').val(producto.stock);
                            $('#cantidad').attr('max', producto.stock);
                        }
                    }
                });
            }

            //generacion de tabal dinamica para registro de pedidos
            let rows = 0; //nuemro de filas
            //botones
            const btnAgregar = document.querySelector('#agregar');
            const btnGuardar = document.querySelector('#btn-guardar');
            
            //entradas
            const selectProducto = document.querySelector('#producto');
            const inputCantidad = document.querySelector('#cantidad');
            
            //contenedores
            const contentIngresos = document.querySelector('#detalle-prestamo');
            const templateIngresos = document.querySelector('#template-detalle-prestamo');
            const fragment = document.createDocumentFragment(); //fragmento

            let listaPrestamos = [];

            //eventos
            btnAgregar.addEventListener('click', (e) => {
                let cantidad = parseInt($('#cantidad').val());
                let stock = parseInt($('#stock').val());

                if (cantidad > 0 && stock > 0) {

                    if (cantidad > stock) {
                        let nuevaCantidad = $('#stock').val();
                        $('#cantidad').val(nuevaCantidad);
                    }
                    agregarCompra();
                    onLoadStockProducto();
                }else {
                    alert('Completa las entradas o stock del material es 0');
                    onLoadStockProducto();
                }
            })

            //evento remover compra
            const agregarEventoRemoverCompra = () => {
                const btnEditar = document.querySelectorAll('.btn-remove');

                btnEditar.forEach(button => {
                    button.addEventListener('click', (e) => {
                        let idFila = button.dataset.id;
                        removerCompra(idFila);
                        mostrarListaCompra();
                        onLoadStockProducto();
                    })
                });
            }

            //agragar compra a objeto
            const agregarCompra = () =>{
                let getIdProducto = parseInt(selectProducto.value);
                let getNombreProducto = selectProducto.options[selectProducto.selectedIndex].text;
                let getCantidad = parseInt(inputCantidad.value);

                if (!isNaN(getCantidad)) {
                    rows++;
                    const compra = {
                        id: rows,
                        idProducto: getIdProducto,
                        nombreProducto: getNombreProducto,
                        cantidad: getCantidad,
                    };

                    listaPrestamos.push(compra);
                    clearInput();
                    mostrarListaCompra();
                }else {
                    alert('Completa las entradas')
                }
            }

            //mostrar listado de compras en filas de una tabla
            const mostrarListaCompra = () =>{
                //limpiar la lista de compras
                contentIngresos.textContent = '';

                //agregar a campos
                listaPrestamos.forEach(item => {
                    const clone = templateIngresos.content.cloneNode(true)
                    clone.querySelector('.btn-remove').dataset.id = item.id;
                    clone.querySelector('.detalle-producto-id').value = item.idProducto;
                    clone.querySelector('.detalle-producto-nombre').value = item.nombreProducto;
                    clone.querySelector('.detalle-cantidad').value = item.cantidad;
                    fragment.appendChild(clone);
                })

                contentIngresos.appendChild(fragment);
                agregarEventoRemoverCompra();
                enabledButtonGuardar();
            }

            //remover compra
            const removerCompra = (id) => {
                listaPrestamos = listaPrestamos.filter(item => item.id !== parseInt(id));
            }

            //limpiar entradas
            const clearInput = () => {
                inputCantidad.value = '';
            }

            //habilitar o deshabilitar boton guardar
            const enabledButtonGuardar = () => {
                if (listaPrestamos.length > 0) {
                    btnGuardar.disabled = false;
                }else {
                    btnGuardar.disabled = true;
                }
            }
        </script>
    ";
?>

<?php
    pageContentEnd();
    endHtml($script);
?>