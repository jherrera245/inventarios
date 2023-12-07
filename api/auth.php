<?php 
    //incluyendo librerias
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(MODELS."session-model.php");
    require_once(REQUESTS."request.php");

    //Definimos la codificación de caracteres en la cabecera.
    header('Content-Type: text/html; charset=utf-8');

    //iniciar sesion
    if (isPost()) {
        //recibiendo datos del formulario como json
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data["email"];
        $password = md5($data["password"]);

        $user = array();

        foreach (findUser($email, $password) as $userlogin) {
            $user["userId"] = $userlogin['userId'];
            $user["username"] = $userlogin["username"];
            $user["rol"] = $userlogin["rol"];
        }

        if (count($user) > 0) {
            $user["message"] = "Sesion iniciada correctamente!!!";
            echo json_encode($user);
        }else {
            $user["message"] = "Usuario no encontrado intenta de nuevo!!!";
            echo json_encode($user);
        }
    }

    //Cerrar sesion
    if (isGet()) {
        unset($_REQUEST["logout"]);
        echo json_encode(["message" => "Sesion finalizada correctamente!!!"]);
    }
?>