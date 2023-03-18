<?php 
    require_once "../../../layouts/layout.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Crear Usuario');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <form action="/inventarios/usuarios/save" method="post">

        <input class="form-control" type="hidden" name="action" value="save">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Crear Usuario
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombre">
                                Username
                            </label>
                            <input type="text" class="form-control" name="nombre" 
                            placeholder="Nombre de usuario" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="correo">
                                Email
                            </label>
                            <input type="email" class="form-control" name="correo" 
                            placeholder="Correo del usuario" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="password">
                                Contraseña
                            </label>
                            <input type="password" class="form-control" name="password" 
                            id="password" placeholder="Ingresa tu contraseña" required>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="password">
                                Confirmar Contraseña
                            </label>
                            <input type="password" class="form-control" name="repassword" 
                            id="repassword" placeholder="Ingresa tu contraseña" required>
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
</div>

<?php 
    $script="
    <script>
        $('#btn-guardar').attr('disabled', true);

        $('input').focus(function() {
            let password = $('input[name=password]').val();
            let repassword = $('input[name=repassword]').val();
            if(($('input[name=password]').val().length == 0) || ($('input[name=repassword]').val().length == 0)){
                $('#password').addClass('is-invalid');
            }
            else if (password != repassword) {
                $('#password').addClass('is-invalid');
                $('#repassword').addClass('is-invalid');
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