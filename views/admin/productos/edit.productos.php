<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Editar Producto');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <?php 
        foreach (find("productos", getParam("id")) as $producto) {
    ?>

    <form action="/inventarios/productos/<?php echo $producto["id"]; ?>/update" method="post">
        <input type="hidden" value="<?php echo $producto["id"]; ?>" name="id">
        <input class="form-control" type="hidden" name="action" value="update">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Editar Producto: <?php echo $producto["nombre"]; ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombre">
                                Producto
                            </label>
                            <input type="text" class="form-control" name="nombre" maxlength="75"
                            placeholder="Ingresa el nombre del producto" 
                            value="<?php echo $producto["nombre"]; ?>" required>
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
                                        if ($producto["id_categoria"] == $categoria["id"]) {
                                            echo "<option value='".$categoria["id"]."' selected>".$categoria["nombre"]."</option>";
                                        }else {
                                            echo "<option value='".$categoria["id"]."'>".$categoria["nombre"]."</option>";
                                        }
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
                                        if ($producto["id_concepto"] == $concepto["id"]) {
                                            echo "<option value='".$concepto["id"]."' selected>".$concepto["concepto"]."</option>";
                                        }else {
                                            echo "<option value='".$concepto["id"]."'>".$concepto["concepto"]."</option>";
                                        }
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
                            placeholder="Ingresa el stock del producto" 
                            value="<?php echo $producto["stock"]; ?>" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="codigo">
                                Còdigo
                            </label>
                            <input type="text" class="form-control" name="codigo" maxlength="50"
                            placeholder="Ingresa el código del producto" 
                            value ="<?php echo $producto["codigo"]; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="consumible">
                                Consumible
                            </label>
                            <div>
                                <?php 
                                    //controlar si que campo se marca
                                    $si = ($producto["consumible"] == true) ? "checked" : "";
                                    $no = ($producto["consumible"] == false) ? "checked" : "";
                                ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="consumible" value="1"
                                    <?php echo $si; ?>>
                                    <label class="form-check-label" for="inlineRadio1">Si</label>
                                </div>
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="consumible" value="0"
                                    <?php echo $no; ?>>
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-bold">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4" 
                            placeholder="Descripción del producto"><?php echo $producto["descripcion"]; ?></textarea>
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

    <?php 
        }
    ?>
</div>

<?php
    pageContentEnd();
    endHtml();
?>