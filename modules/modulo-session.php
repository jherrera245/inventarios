<?php 
    //incluyendo librerias
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(MODELS."session-model.php");
    require_once(REQUESTS."request.php");

    //Definimos la codificación de caracteres en la cabecera.
    header('Content-Type: text/html; charset=utf-8');


    //iniciar sesion
    if (isPost()) {
        $email = getParam("email");
        $password = md5(getParam("password"));
        $user = array();

        foreach (findUser($email, $password) as $userlogin) {
            $user["userId"] = $userlogin['userId'];
            $user["username"] = $userlogin["username"];
            $user["rol"] = $userlogin["rol"];
        }

        if (count($user) > 0) {
            session_id($user["rol"]);
            session_start();
            
            $_SESSION["logged_ok"] = true;
            $_SESSION["logged_id"] = $user["userId"]; 
            $_SESSION['username'] = $user["username"];
            $_SESSION['rol'] = $user["rol"];

            if ($_SESSION['rol'] == "Admin") {
                header("Location: /inventarios/admin");
            } else if ($_SESSION['rol'] == "Practicante") {
                header("Location: /inventarios/practicante");
            } else {
                header("Location: /inventarios/login");
            }
        }else {
            header("Location: /inventarios/login");
        }
    }

    //Cerrar sesion
    if (isGet()) {
        session_start();
        unset($_REQUEST["logout"]);
        session_destroy();
        header("Location: /inventarios/login");
    }
?>