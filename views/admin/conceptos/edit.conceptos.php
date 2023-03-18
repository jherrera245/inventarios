<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Editar Concepto');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <?php 
        foreach (find("conceptos", getParam("id")) as $concepto) {
    ?>

    <form action="/inventarios/conceptos/<?php echo $concepto["id"]; ?>/update" method="post">
        
        <input type="hidden" value="<?php echo $concepto["id"]; ?>" name="id">
        <input class="form-control" type="hidden" name="action" value="update">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Editar categoría: <?php echo $concepto["concepto"]; ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombre">
                                Descripción de concepto
                            </label>
                            <input type="text" class="form-control" name="nombre" 
                            placeholder="Ingresa el concepto" value="<?php echo $concepto["concepto"]; ?>"required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/conceptos" class="btn btn-secondary">
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