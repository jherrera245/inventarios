<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Crear Ingreso ');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <form action="/inventarios/ingresos/save" method="post">

        <input class="form-control" type="hidden" name="action" value="save">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Crear Ingreso
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group mb-3">
                            <label for="proveedor" class="form-label fw-bold">Proveedores</label>
                            <select class="form-control" name="proveedor" id="proveedor">
                                <?php 
                                    foreach(selectAll("proveedores") as $proveedor){
                                        echo "<option value='".$proveedor['id']."'>".$proveedor["nombres"]." ".$proveedor["apellidos"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Card regitro de ingresos -->
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <i class="fas fa-shopping-cart"></i>
                                Registro de Ingresos
                            </div>

                            <!-- Formulario de registro de ingresos -->
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-lg-3 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label fw-bold" for="producto">Productos</label>
                                            <select class="form-control select2bs4" id="producto">
                                            <?php 
                                                foreach(selectAll("productos") as $producto){
                                                    echo "<option value='".$producto['id']."'>".$producto["nombre"]."</option>";
                                                }
                                            ?>
                                            </select>
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
                                            <label class="form-label fw-bold" for="precio_compra">Precio Compra</label>
                                            <input type="number" class="form-control" id="precio_compra" 
                                            placeholder="Ingresa el precio de compra" min="0" step="0.05">
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
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Precio Compra</th>
                                                <th>SubTotal</th>
                                            </thead>

                                            <tbody id="detalle-compra">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="btn-guardar" disabled>
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/ingresos" class="btn btn-secondary">
                    <i class="fa fa-arrow-circle-left"></i>
                    Regresar
                </a>
            </div>
        </div>
    </form>
</div>

<!-- template detalle productos -->
<template id="template-detalle-compra">
    <tr>
        <td class="col-1 text-center">
            <button type="button" class="btn btn-danger btn-remove" data-id="1">
                <i class="fas fa-times"></i>
            </button>
        </td>
        <td class="col-3">
            <input type="hidden" class="form-control detalle-producto-id" name="producto[]">
            <input type="text" class="form-control detalle-producto-nombre" disabled>
        </td>

        <td>
            <input type="number" class="form-control detalle-cantidad" name="cantidad[]"
            placeholder="Ingresa cantidad de producto" min="0" step="1">
        </td>

        <td>
            <input type="number" class="form-control detalle-precio-compra" name="precio_compra[]"
            placeholder="Ingresa el precio de compra" min="0" step="0.05">
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
            });
        </script>
        
        <script>
            let rows = 0; //nuemro de filas
            //botones
            const btnAgregar = document.querySelector('#agregar');
            const btnGuardar = document.querySelector('#btn-guardar');
            
            //entradas
            const selectProducto = document.querySelector('#producto');
            const inputCantidad = document.querySelector('#cantidad');
            const inputPrecioCompra = document.querySelector('#precio_compra');
            //contenedores
            const contentCompras = document.querySelector('#detalle-compra');
            const templeteCompras = document.querySelector('#template-detalle-compra');
            const fragment = document.createDocumentFragment(); //fragmento

            let listaCompras = [];

            //eventos
            btnAgregar.addEventListener('click', (e) => {
                agregarCompra();
            })

            //evento remover compra
            const agregarEventoRemoverCompra = () => {
                const btnEditar = document.querySelectorAll('.btn-remove');

                btnEditar.forEach(button => {
                    button.addEventListener('click', (e) => {
                        let idFila = button.dataset.id;
                        removerCompra(idFila);
                        mostrarListaCompra();
                    })
                });
            }

            //agragar compra a objeto
            const agregarCompra = () =>{
                let getIdProducto = parseInt(selectProducto.value);
                let getNombreProducto = selectProducto.options[selectProducto.selectedIndex].text;
                let getCantidad = parseInt(inputCantidad.value);
                let getPrecioCompra = parseFloat(inputPrecioCompra.value);

                if (!isNaN(getCantidad) && !isNaN(getPrecioCompra)) {
                    rows++;
                    const compra = {
                        id: rows,
                        idProducto: getIdProducto,
                        nombreProducto: getNombreProducto,
                        cantidad: getCantidad,
                        precioCompra: getPrecioCompra,
                    };

                    listaCompras.push(compra);
                    clearInput();
                    mostrarListaCompra();
                }else {
                    alert('Completa las entradas')
                }
            }

            //mostrar listado de compras en filas de una tabla
            const mostrarListaCompra = () =>{
                //limpiar la lista de compras
                contentCompras.textContent = '';

                //agregar a campos
                listaCompras.forEach(item => {
                    const clone = templeteCompras.content.cloneNode(true)
                    clone.querySelector('.btn-remove').dataset.id = item.id;
                    clone.querySelector('.detalle-producto-id').value = item.idProducto;
                    clone.querySelector('.detalle-producto-nombre').value = item.nombreProducto;
                    clone.querySelector('.detalle-cantidad').value = item.cantidad;
                    clone.querySelector('.detalle-precio-compra').value = item.precioCompra;
                    fragment.appendChild(clone);
                })

                contentCompras.appendChild(fragment);
                agregarEventoRemoverCompra();
                enabledButtonGuardar();
            }

            //remover compra
            const removerCompra = (id) => {
                listaCompras = listaCompras.filter(item => item.id !== parseInt(id));
            }

            //limpiar entradas
            const clearInput = () => {
                inputCantidad.value = '';
                inputPrecioCompra.value = '';
            }

            //habilitar o deshabilitar boton guardar
            const enabledButtonGuardar = () => {
                if (listaCompras.length > 0) {
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