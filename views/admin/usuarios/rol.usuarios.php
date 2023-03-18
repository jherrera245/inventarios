<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Rol de Usuario');
    pageContentStart();
    sidebar();
    topMenu();
?>

<?php

    $query = "SELECT * FROM roles_usuarios WHERE id_usuario = ".getParam('id');

    $dataRol = [
        'id' => 'NULL',
        'id_user' => 'NULL',
        'id_rol' => 'NULL',
    ];

    $result = 0;

    foreach (selectCustom($query) as $permisos)
    {
        $dataRol['id'] = $permisos['id'];
        $dataRol['id_user'] = $permisos['id_usuario'];
        $dataRol['id_rol'] = $permisos['id_rol'];
        $result++;
    }
?>

<!-- Page content-->
<div class="container-fluid">
    <form action="/inventarios/rol/change" method="post">
        <?php
            $mensaje = "";
            if ($result == 0) {
                $mensaje = "
                <div class='row mt-4'>
                    <div class='col-12'>
                        <div class='alert alert-danger'>
                            <strong>Mensaje</strong>
                            <p>Actualmente no tiene asignado ningún rol</p>
                        </div>
                    </div>
                </div>
                ";
        ?>
            <input class="form-control" type="hidden" name="action" value="save">
        <?php
            }
            else {
        ?>
            <input class="form-control" type="hidden" name="action" value="update">
            <input class="form-control" type="hidden" name="id" value="<?php echo $dataRol["id"]; ?>" >
        <?php 
            }
        ?>

        <!--ID del usuario que se selecciono-->
        <input class="form-control" type="hidden" name="usuario" value="<?php echo getParam("id"); ?>" >

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Administrar Roles
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="rol">
                                Roles
                            </label>
                            <select name="rol" class="form-control">
                                <?php 
                                    foreach (selectAll("roles") as $rol) {
                                        if ($dataRol["id_rol"] == $rol["id"]) {
                                            echo "<option value='".$rol["id"]."' selected>".$rol["rol"]."</option>";
                                        }else {
                                            echo "<option value='".$rol["id"]."'>".$rol["rol"]."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/usuarios" class="btn btn-secondary">
                    <i class="fa fa-arrow-circle-left"></i>
                    Regresar
                </a>
            </div>
        </div>
    </form>

    <?php echo $mensaje; ?>

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