<?php 
    require_once "../../../layouts/layout.php";
    require_once "../../../models/model.php";
    require_once "../../../requests/request.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Editar Usuario');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <?php 
        foreach (find("usuarios", getParam("id")) as $usuario) {
    ?>

    <form action="/inventarios/usuarios/<?php echo $usuario["id"]; ?>/update" method="post">
        <input type="hidden" value="<?php echo $usuario["id"]; ?>" name="id">
        <input class="form-control" type="hidden" name="action" value="update">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Editar Usuario: <?php echo $usuario["username"]; ?>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombre">
                                Username
                            </label>
                            <input type="text" class="form-control" name="nombre" 
                            value="<?php echo $usuario["username"]; ?>"
                            placeholder="Nombre de usuario" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="correo">
                                Email
                            </label>
                            <input type="email" class="form-control" name="correo" 
                            value="<?php echo $usuario["email"]; ?>"
                            placeholder="Correo del usuario" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="password">
                                Contraseña
                            </label>
                            <input type="password" class="form-control" name="password" 
                            id="password" placeholder="Ingresa tu contraseña">
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="password">
                                Confirmar Contraseña
                            </label>
                            <input type="password" class="form-control" name="repassword" 
                            id="repassword" placeholder="Ingresa tu contraseña">
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary" id="btn-guardar">
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

    <?php 
        }
    ?>
</div>

<?php 
    $script="
    <script>
        $('input').focus(function() {
            let password = $('input[name=password]').val();
            let repassword = $('input[name=repassword]').val();
            if(($('input[name=password]').val().length == 0) || ($('input[name=repassword]').val().length == 0)){
                $('#password').addClass('is-invalid');
            }
            else if (password != repassword) {
                $('#password').addClass('is-invalid');
                $('#repassword').addClass('is-invalid');
                $('#btn-guardar').attr('disabled', true);
            }
            else {
                $('#password').removeClass('is-invalid');
                $('#repassword').removeClass('is-invalid');
                $('#password').addClass('is-valid');
                $('#repassword').addClass('is-valid');
                $('#btn-guardar').attr('disabled', false);
            }
        });
    </script>
    ";
?>

<?php
    pageContentEnd();
    endHtml($script);
?>