<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";

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
    <form action="/inventarios/practicantes/save" method="post">

        <input class="form-control" type="hidden" name="action" value="save">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Crear Practicante
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="usuario">
                                Usuario
                            </label>
                            <select class="form-control" name="usuario">
                                <?php
                                    //Selecionamos los usuarios que no tienen un practicante asociado 
                                    //y son de tipo practicante 
                                    $query = "
                                        SELECT usuarios.id, usuarios.username 
                                        FROM usuarios
                                        INNER JOIN roles_usuarios ON roles_usuarios.id_usuario = usuarios.id
                                        INNER JOIN roles ON roles.id = roles_usuarios.id_rol
                                        WHERE usuarios.id NOT IN (SELECT practicantes.id_usuario FROM practicantes)
                                        AND roles.rol NOT IN('Admin') AND usuarios.status = 1;
                                    ";

                                    foreach(selectCustom($query) as $usuario) {
                                        echo "<option value='".$usuario["id"]."'>".$usuario["username"]."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombres">
                                Nombres
                            </label>
                            <input type="text" class="form-control" name="nombres" maxlength="75"
                                placeholder="Ingresa el nombre del practicante" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="apellidos">
                                Apellidos
                            </label>
                            <input type="text" class="form-control" name="apellidos" maxlength="75"
                                placeholder="Ingresa el apellido del practicante" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="carnet">
                                Carnet
                            </label>
                            <input type="text" class="form-control" name="carnet" maxlength="10"
                                placeholder="Ingresa el numero de carnet" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="dui">
                                DUI
                            </label>
                            <input type="text" class="form-control" name="dui" maxlength="10"
                                placeholder="Ingresa el numero de dui 00000000-0" pattern="[0-9]{8}-[0-9]{1}" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="telefono">
                                Teléfono
                            </label>
                            <input type="text" class="form-control" name="telefono" maxlength="9"
                                placeholder="Ingresa el numero de telefono 0000-0000" pattern="[0-9]{4}-[0-9]{4}"
                                required>
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