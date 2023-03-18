<?php 
    require_once "../../layouts/layout.php";
    require_once "../../models/model.php";

    session_start();
    if (!isset($_SESSION["logged_ok"])) {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Perfil');
    pageContentStart();
    sidebar();
    topMenu();
?>

<!-- Page content-->
<div class="container-fluid">
    <h3 class="mt-4">Perfil</h3>
    
    <?php 
        foreach (find("usuarios", $_SESSION["logged_id"]) as $usuario) {
    ?>

    <form action="/inventarios/perfil/<?php echo $usuario["id"]; ?>/update" method="post">
        <input type="hidden" value="<?php echo $usuario["id"]; ?>" name="id">

        <input class="form-control" type="hidden" name="action" value="update">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Perfil Usuario: <?php echo $usuario["username"]; ?>
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
                    Actualizar Perfil
                </button>
            </div>
        </div>
    </form>

    <?php 
        }
    ?>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="alert alert-primary">
                Una vez actualizados los datos del perfil se cerrara la Sessión.
            </div>
        </div>
    </div>
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