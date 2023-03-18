<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Crear Productos');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <form action="/inventarios/productos/save" method="post">
        
        <input class="form-control" type="hidden" name="action" value="save">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Crear Productos
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombre">
                                Producto
                            </label>
                            <input type="text" class="form-control" name="nombre" maxlength="75"
                            placeholder="Ingresa el nombre del producto" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="categorias">
                                Categorias
                            </label>
                            <select name="categorias" class="form-control">
                                <?php 
                                    foreach (selectAll("categorias") as $categoria) {
                                        echo "<option value='".$categoria["id"]."'>".$categoria["nombre"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="conceptos">
                                Concepto
                            </label>
                            <select name="conceptos" class="form-control">
                                <?php 
                                    foreach (selectAll("conceptos") as $concepto) {
                                        echo "<option value='".$concepto["id"]."'>".$concepto["concepto"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="stock">
                                Stock
                            </label>
                            <input type="number" class="form-control" name="stock"
                            placeholder="Ingresa el stock del producto" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="codigo">
                                Còdigo
                            </label>
                            <input type="text" class="form-control" name="codigo" maxlength="50"
                            placeholder="Ingresa el código del producto" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="consumible">
                                Consumible
                            </label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="consumible" value="1">
                                    <label class="form-check-label" for="inlineRadio1">Si</label>
                                </div>
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="consumible" value="0">
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4" 
                            placeholder="Descripción del producto"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/productos" class="btn btn-secondary">
                    <i class="fa fa-arrow-circle-left"></i>
                    Regresar
                </a>
            </div>
        </div>
    </form>
</div>

<!--Agregando funcion select2 a select-->
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
    ";
?>

<?php
    pageContentEnd();
    endHtml($script);
?>