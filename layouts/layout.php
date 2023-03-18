<?php
    function startHtml() {
        echo '
        <!DOCTYPE html>
        <html lang="es">
        ';
    }

    function head($namepage) {
        $root_path = "/inventarios";
        echo '
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
            <meta name="description" content="" />
            <meta name="author" content="" />
            <title>'.$namepage.'</title>
            <!-- Favicon-->
            <link rel="icon" type="image/x-icon" href="'.$root_path.'/public/assets/favicon.ico" />
            <!-- Core theme CSS (includes Bootstrap)-->
            <link href="'.$root_path.'/public/css/bootstrap.min.css" rel="stylesheet" />
            <link href="'.$root_path.'/public/css/styles.css" rel="stylesheet" />
            <!--Iconos-->
            <link rel="stylesheet" href="'.$root_path.'/public/fonts/css/all.min.css">
            <!--Estilos para datatable-->
            <link href="'.$root_path.'/public/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
            <link href="'.$root_path.'/public/css/sweetalert2.min.css" rel="stylesheet" />
            <!--Select2-->
            <link href="'.$root_path.'/public/css/select2.min.css" rel="stylesheet" />
            <link href="'.$root_path.'/public/css/select2-bootstrap4.min.css" rel="stylesheet" />
        </head>
        <body>';
    }

    function pageContentStart() {
        echo '
            <div class="d-flex" id="wrapper">
        ';
    }

    function sidebar() {
        if ($_SESSION["rol"] == "Admin") {
            sidebarAdmin();
        }

        if ($_SESSION["rol"] == "Practicante") {
            siderbarPracticante();
        }
    }

    function sidebarAdmin() {
        echo '
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">
                <i class="fa-solid fa-business-time"></i>
                Inventarios
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/admin">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/categorias">
                    <i class="fa-solid fa-list"></i>
                    Categorias
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/conceptos">
                    <i class="fa-solid fa-lightbulb"></i>
                    Conceptos
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/productos">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    Productos o Materiales
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/proveedores">
                    <i class="fa-solid fa-user-group"></i>
                    Proveedores
                </a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/practicantes">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Practicantes
                </a>

                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/ingresos">
                    <i class="fa-solid fa-dollar"></i>
                    Ingresos
                </a>

                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/prestamos/admin">
                    <i class="fa-solid fa-ticket"></i>
                    Prestamos
                </a>
                
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/usuarios">
                    <i class="fa-solid fa-users"></i>
                    Usuarios
                </a>
            </div>
        </div>';
    }

    function siderbarPracticante() {
        echo '
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">
                <i class="fa-solid fa-business-time"></i>
                Inventarios
            </div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/practicante">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>

                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="/inventarios/prestamos/practicante">
                    <i class="fa-solid fa-ticket"></i>
                    Prestamos
                </a>
            </div>
        </div>';
    }

    function topMenu() {
        echo '
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">
                        <i class="fa fa-bars"></i>
                    </button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-user-tie"></i>
                                    '.$_SESSION['username'].'
                                    <span class="badge bg-success">'.$_SESSION['rol'].'</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/inventarios/perfil">
                                        <i class="fa-solid fa-user-plus"></i>
                                        Perfil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/inventarios/login/close">
                                        <i class="fa-solid fa-circle-left"></i>
                                        Cerrar Sesión
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        ';
    }

    function pageContentEnd() {
        echo '</div>';
    }

    function endHtml($scripts = null) {
        $root_path = "/inventarios";
        echo '
            </div>
            <!-- Bootstrap core JS-->
            <script src="'.$root_path.'/public/js/bootstrap.min.js"></script>
            <!-- Core theme JS-->
            <script src="'.$root_path.'/public/js/scripts.js"></script>
            <script src="'.$root_path.'/public/js/jquery-3.5.1.js"></script>
            <script src="'.$root_path.'/public/js/jquery.dataTables.min.js"></script>
            <script src="'.$root_path.'/public/js/dataTables.bootstrap5.min.js"></script>
            <script src="'.$root_path.'/public/js/sweetalert2.js"></script>
            <script src="'.$root_path.'/public/js/select2.min.js"></script>
            <script src="'.$root_path.'/public/js/select2.min.js"></script>
            <script src="'.$root_path.'/public/js/chart.min.js"></script>
            '.$scripts.'
        </body>
        </html>';
    }
?>