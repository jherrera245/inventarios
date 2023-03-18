<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/fonts/css/all.min.css">
    <title>Login</title>
</head>
<body>
   <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-12 m-auto" style="margin-top: 12vw !important;">
                <form action="login/session" method="post">
                    <input type="hidden" name="session_start" class="form-control">

                    <div class="card">
                        <div class="card-header">
                            <i class="fa-solid fa-screwdriver-wrench"></i> Login
                        </div>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
    
                            <div class="input-group mb-1">
                                <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
    
                        <div class="card-footer">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-primary"><i class="fa-solid fa-gear"></i> Iniciar Sesión</button>
                                <button type="reset" class="btn btn-outline-danger"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
        </div>
   </div>
    <script src="public/js/bootstrap.min.js"></script>
    <script src="public/fonts/js/all.min.js"></script>
</body>
</html>