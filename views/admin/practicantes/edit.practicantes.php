<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Crear Practicantes');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <?php 
        foreach (find("practicantes", getParam("id")) as $practicante) {
    ?>
    <form action="/inventarios/practicantes/<?php echo $practicante["id"]; ?>/update" method="post">

        <input class="form-control" type="hidden" name="id" value="<?php echo $practicante["id"]; ?>">
        <input class="form-control" type="hidden" name="usuario" value="<?php echo $practicante["id_usuario"]; ?>">
        <input class="form-control" type="hidden" name="action" value="update">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Editar Practicante: <?php echo $practicante["nombres"]." ".$practicante["apellidos"] ; ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombres">
                                Nombres
                            </label>
                            <input type="text" class="form-control" name="nombres" maxlength="75"
                                placeholder="Ingresa el nombre del practicante" 
                                value = "<?php echo $practicante["nombres"]; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="apellidos">
                                Apellidos
                            </label>
                            <input type="text" class="form-control" name="apellidos" maxlength="75"
                                placeholder="Ingresa el apellido del practicante"
                                value = "<?php echo $practicante["apellidos"]; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="carnet">
                                Carnet
                            </label>
                            <input type="text" class="form-control" name="carnet" maxlength="10"
                                placeholder="Ingresa el numero de carnet" 
                                value = "<?php echo $practicante["carnet"]; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="dui">
                                DUI
                            </label>
                            <input type="text" class="form-control" name="dui" maxlength="10"
                                placeholder="Ingresa el numero de dui 00000000-0" pattern="[0-9]{8}-[0-9]{1}" 
                                value ="<?php echo $practicante["dui"]; ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="telefono">
                                Teléfono
                            </label>
                            <input type="text" class="form-control" name="telefono" maxlength="9"
                                placeholder="Ingresa el numero de telefono 0000-0000" pattern="[0-9]{4}-[0-9]{4}"
                                value = "<?php echo $practicante["telefono"]; ?>" required>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/practicantes" class="btn btn-secondary">
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