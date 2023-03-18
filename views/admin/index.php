<?php 
    require_once "../../layouts/layout.php";

    session_start();
    if ($_SESSION["rol"] != "Admin") {
        header("Location: /inventarios/login");
    }
    
    startHtml();
    head('Inicio Admin');
    pageContentStart();
    sidebar();
    topMenu();
?>
<!-- Page content-->
<div class="container-fluid">
    <h3 class="mt-4">Dashboard</h3>

    <div class="row mb-3">
        <!--tarjeta total materiales-->
        <div class="col-lg-3 col-sm-12">
           <div class="row p-2">
                <div class="col-12 shadow bg-primary rounded-3">
                    <div class="row align-items-center">
                        <div class="col-3 p-3 text-white">
                            <i class="fa-solid fa-screwdriver-wrench fs-1 opacity-75"></i>
                        </div>

                        <div class="col-9 p-3 text-white fs-4"> 
                            <div class="text-xs fw-bold text-uppercase mb-1">
                                Materiales
                            </div>
                            
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="totalMateriales"></span>
                            </div>                            
                        </div> 
                    </div>
                </div>
           </div>
        </div>

        <!--tarjeta total Practicantes-->
        <div class="col-lg-3 col-sm-12">
           <div class="row p-2">
                <div class="col-12 shadow bg-success rounded-3">
                    <div class="row align-items-center">
                        <div class="col-3 p-3 text-white">
                            <i class="fa-solid fa-chalkboard-user fs-1 opacity-75"></i>
                        </div>

                        <div class="col-9 p-3 text-white fs-4"> 
                            <div class="text-xs fw-bold text-uppercase mb-1">
                                Practicantes
                            </div>
                            
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="totalPracticantes"></span>
                            </div>                            
                        </div>      
                    </div>
                </div>
           </div>
        </div>

        <!--tarjeta total prestamos -->
        <div class="col-lg-3 col-sm-12">
           <div class="row p-2">
                <div class="col-12 shadow bg-danger rounded-3">
                    <div class="row align-items-center">
                        <div class="col-3 p-3 text-white">
                            <i class="fa-solid fa-ticket fs-1 opacity-75"></i>
                        </div>
                        <div class="col-9 p-3 text-white fs-4"> 
                            <div class="text-xs fw-bold text-uppercase mb-1">
                                Prestamos
                            </div>
                            
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="totalPrestamos"></span>
                            </div>                            
                        </div>
                    </div>
                </div>
           </div>
        </div>

        <!--tarjeta total usuarios-->
        <div class="col-lg-3 col-sm-12">
           <div class="row p-2">
                <div class="col-12 shadow bg-secondary rounded-3">
                    <div class="row align-items-center">
                        <div class="col-3 p-3 text-white">
                            <i class="fa-solid fa-users fs-1 opacity-75"></i>
                        </div>

                        <div class="col-9 p-3 text-white fs-4"> 
                            <div class="text-xs fw-bold text-uppercase mb-1">
                                Usuarios
                            </div>
                            
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span id="totalUsuarios"></span>
                            </div>                            
                        </div>
                    </div>
                </div>
           </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col-lg-6 col-xs-12">
             <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Materiales por Categoria</h6>
                </div>
                <div class="card-body">
                    <canvas width="100" height="100" id="graficaMateriales"></canvas>
                </div>
            </div>
        </div>
    
        <div class="col-lg-6 col-xs-12">
            <!-- Area Chart -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-primary">Top 10 Prestamos</h6>
                </div>
                <div class="card-body">
                    <canvas width="100" height="100" id="graficaPrestamos"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>


<!--creando varible con el script a anexar a la plantilla -->
<?php 
    $script = "
    <script>
        $(document).ready(function () {
            totalMateriales();
            totalPracticantes();
            totalPrestamos();
            totalUsuarios();
            graficaMateriales();
            graficaPrestamos();
        });

        const totalMateriales = () => {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/inventarios/home/admin/totales',
                data: {
                    action: 'totalMaterial'
                },
                success: function (response) {
                   const totalMaterial = response[0].total;
                   $('#totalMateriales').text(totalMaterial);
                }
            });
        }

        const totalPracticantes = () => {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/inventarios/home/admin/totales',
                data: {
                    action: 'totalPracticante'
                },
                success: function (response) {
                   const totalPracticante = response[0].total;
                   $('#totalPracticantes').text(totalPracticante);
                }
            });
        }

        const totalPrestamos = () => {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/inventarios/home/admin/totales',
                data: {
                    action: 'totalPrestamo'
                },
                success: function (response) {
                   const totalPrestamo = response[0].total;
                   $('#totalPrestamos').text(totalPrestamo);
                }
            });
        }

        const totalUsuarios = () => {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '/inventarios/home/admin/totales',
                data: {
                    action: 'totalUsuario'
                },
                success: function (response) {
                   const totalUsuario = response[0].total;
                   $('#totalUsuarios').text(totalUsuario);
                }
            });
        }

        const graficaMateriales = () => {
            $.ajax({
                url:'/inventarios/home/admin/totales',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'graficaMateriales'
                },
                success: function (data) {
                    const LienzoGraficaMateriales = document.getElementById('graficaMateriales');
                    
                    const dataMaterial = data;
                    let graficaLabel = [];
                    let totalMateriales = [];
                    let colorPastel = []
                    let colorBordePastel = [];

                    dataMaterial.forEach(material => {
                        let color1 = Math.floor(Math.random() * 54) + 1; 
                        let color2 = Math.floor(Math.random() * 162) + 1;
                        let color3 = Math.floor(Math.random() * 255) + 1;

                        graficaLabel.push(material.nombre);
                        totalMateriales.push(material.total);
                        colorPastel.push('rgba('+color1+', '+color2+', '+color3+', 0.2)');
                        colorBordePastel.push('rgba('+color1+', '+color2+', '+color3+', 1)');
                    });

                    const graficaCapacitacion = {
                        label: 'Materiales por categoria',
                        data: totalMateriales,
                        backgroundColor: colorPastel,
                        borderColor: colorBordePastel,
                        borderWidth: 1,
                    };

                    new Chart(LienzoGraficaMateriales, {
                        type: 'doughnut',// Tipo de gráfica
                        data: {
                            labels: graficaLabel,
                            datasets: [
                                graficaCapacitacion,
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    display: false,
                                },
                                x:{
                                    display: false,
                                },
                            },
                        }
                    });
                },
                error:function() {
                    console.log('Error al recibir los datos')
                }
            });
        }

        const graficaPrestamos = () => {
            $.ajax({
                url:'/inventarios/home/admin/totales',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'graficaPrestamos'
                },
                success: function (data) {
                    const LienzoGraficaPrestamo = document.getElementById('graficaPrestamos');
                    
                    const dataPrestamo = data;
                    let graficaLabel = [];
                    let totalPrestamos = [];
                    let colorPastel = []
                    let colorBordePastel = [];

                    dataPrestamo.forEach(prestamo => {
                        let color1 = Math.floor(Math.random() * 54) + 1; 
                        let color2 = Math.floor(Math.random() * 162) + 1;
                        let color3 = Math.floor(Math.random() * 255) + 1;

                        graficaLabel.push(prestamo.fecha);
                        totalPrestamos.push(prestamo.total);
                        colorPastel.push('rgba('+color1+', '+color2+', '+color3+', 0.2)');
                        colorBordePastel.push('rgba('+color1+', '+color2+', '+color3+', 1)');
                    });

                    const GraficaPrestamo = {
                        label: 'Top 10 Prestamos',
                        data: totalPrestamos,
                        backgroundColor: colorPastel,
                        borderColor: colorBordePastel,
                        borderWidth: 1,
                    };


                    new Chart(LienzoGraficaPrestamo, {
                        type: 'bar',// Tipo de gráfica
                        data: {
                            labels: graficaLabel,
                            datasets: [
                                GraficaPrestamo,
                            ]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                },
                            },
                        }
                    });
                },
                error:function() {
                    console.log('Error al recibir los datos')
                }
            });
        }

    </script>
    ";
?>


<?php
    pageContentEnd();
    endHtml($script);
?>