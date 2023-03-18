<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Editar Categoria');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <?php 
        foreach (find("categorias", getParam("id")) as $categoria) {
    ?>

    <form action="/inventarios/categorias/<?php echo $categoria["id"]; ?>/update" method="post">
        <input type="hidden" value="<?php echo $categoria["id"]; ?>" name="id">
        <input class="form-control" type="hidden" name="action" value="update">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Editar categoría: <?php echo $categoria["nombre"]; ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombre">
                                Nombre Categoria
                            </label>
                            <input type="text" class="form-control" name="nombre" 
                            placeholder="Nombre de la categoría" value="<?php echo $categoria["nombre"]; ?>"required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="descripcion">
                                Descripción Categoria
                            </label>
                            <textarea name="descripcion" rows="4" class="form-control" placeholder="Descripción Categoria" 
                            required><?php echo $categoria["descripcion"]; ?></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/categorias" class="btn btn-secondary">
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