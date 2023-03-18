<?php 
    require_once "../../../layouts/layout.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Crear Proveedores');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <form action="/inventarios/proveedores/save" method="post">
        
        <input class="form-control" type="hidden" name="action" value="save">

        <div class="card mt-4">
            <div class="card-header">
                <i class="fa fa-edit"></i>
                Crear Proveedor
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="nombres">
                                Nombres
                            </label>
                            <input type="text" class="form-control" name="nombres" maxlength="75"
                            placeholder="Ingresa el nombre del proveedor" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="apellidos">
                                Apellidos
                            </label>
                            <input type="text" class="form-control" name="apellidos" maxlength="75"
                            placeholder="Ingresa el apellido del proveedor" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="documento">
                                DUI
                            </label>
                            <input type="text" class="form-control" name="documento" maxlength="10"
                            placeholder="Ingresa el numero de documento 00000000-0" pattern="[0-9]{8}-[0-9]{1}" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="telefono">
                                Teléfono
                            </label>
                            <input type="text" class="form-control" name="telefono" maxlength="9"
                            placeholder="Ingresa el numero de telefono 0000-0000" pattern="[0-9]{4}-[0-9]{4}" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="correo">
                                Email
                            </label>
                            <input type="email" class="form-control" name="correo"
                            placeholder="Ingresa el email del proveedor"  required>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-3">
                            <label for="direccion" class="form-label fw-bold">Dirección</label>
                            <textarea class="form-control" name="direccion" rows="4" 
                            placeholder="Dirección del proveedor"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-edit"></i>
                    Guadar
                </button>

                <a href="/inventarios/proveedores" class="btn btn-secondary">
                    <i class="fa fa-arrow-circle-left"></i>
                    Regresar
                </a>
            </div>
        </div>
    </form>
</div>

<?php
    pageContentEnd();
    endHtml();
?>