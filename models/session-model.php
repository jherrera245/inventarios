<?php 
    #importando libreria de base de datos para
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(DATABASE."conexion.php");

    /**
     *Buscar el usuario al iniciar session
     *@param $table string nombre de la tabla
     *@param $email correo electrónico
     *@param $password correo electrónico
     *@return $user array fila encontrada
     */
    function findUser($email, $password) {
        $query = "
            SELECT usuarios.id AS userId, username, rol FROM roles_usuarios 
            INNER JOIN usuarios ON usuarios.id = roles_usuarios.id_usuario
            INNER JOIN roles ON roles.id = roles_usuarios.id_rol
            WHERE (email = '$email' AND password = '$password') 
            AND (usuarios.status = 1 AND roles.status = 1)
        ";
        
        $conexion = getConexion();
        $result = mysqli_query($conexion, $query);
        $conexion->close();

        return $result;
    }
?>