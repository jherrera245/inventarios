<?php 

    /**
     * Verifcar si el metodo de envio es POST
     * @return boolean
     */
    function isPost() {
        return ($_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
    }

    /**
     * Verificar si el metodo de envio es GET
     * @return boolean
     */
    function isGet() {
        return ($_SERVER['REQUEST_METHOD'] == 'GET' ? true : false);
    }

    /**
     * Obtener el valor enviado por un formulario
     * @param $key clave post o get
     * @param $default valor predeterminado
     * @return valor de post o get, predeterminado null
     */
    function getParam($key, $default = null)
    {
        //retornamos el valor de tipo post
        if (isPost()) {
            if (isset($_POST[$key])) {
                return $_POST[$key];
            }
        }

        //retornamos valor de tipo get
        else if (isGet()) {
            if (isset($_GET[$key])) {
                return $_GET[$key];
            }
        }

        return $default;
    }

    /**
     * Obtener todos los elementos enviados por un formulario
     * @return array de entradas post o get 
     */
    function getAllParams()
	{
		if (isPost()) {
			return $_POST;
		}
		else if (isGet()) {
			return $_GET;
		}
	}
?>