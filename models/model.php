<?php 
    #importando libreria de base de datos para
    include_once(dirname(__DIR__)."/config/config.php");
    require_once(DATABASE."conexion.php");

    /**
     *Funcion buscar un registros segun su id.
     *@param $table string nombre de la tabla
     *@param $id int del registro
     *@return $row array fila encontrada
     */
    function find($table, $id) {
        $query = "SELECT * FROM $table WHERE $table.id = $id AND $table.status = 1";
        $conexion = getConexion();
        $result = mysqli_query($conexion, $query);
        $conexion->close();

        return $result;
    }

    /**
     * Consulta seleccion personalizada
     * @param $query consulta personalizada
     */

    function selectCustom($queryCustom)
    {
        $query = $queryCustom;
        $conexion = getConexion();
        $result = mysqli_query($conexion, $query);
        $conexion->close();

        return $result;
    }
    
    /**
     * Funcion para selecionar todo
     * @param $table nombre de la tabla
     * @return array datos de la tabla
     */
    function selectAll($table)
    {
        $query = "SELECT * FROM $table WHERE $table.status=1";
        $conexion = getConexion();
        $result = mysqli_query($conexion, $query);
        $conexion->close();

        return $result;
    }
    
    /**
     *Funcion predeteminado para insertar registros.
     *@param $table string nombre de la tabla
     *@param $data array datos a insertar key columna, values valores a almacenar
     *@return ultimo id insertado, caso ontrario falso
     */
    function insert($table, $data){
        //extraemos el nombre de las llaves el cual representa el nombre de columna
        $columnsName = array_keys($data);
        //esta variable almacena la consulta sql
        $query = "INSERT INTO $table (";
        $query .= implode(",", $columnsName);
        $query .= ") VALUES (";

        $columnsValue = array_values($data); //valor de cada campos o columna
        $firstColumn = true;
        //concatenamos valores de tal manera que se construya la consulta
        foreach ($columnsValue as $value) {
            $query .= ($firstColumn === true) ? "$value" : ", '$value'";
            $firstColumn = false;
        }
        $query .= ")";

        $conexion = getConexion();
        $insert = mysqli_query($conexion, $query);
       
        //retornamos el id ultimo registro ingresado
        if ($insert) {
            return mysqli_insert_id($conexion);
        }

        $conexion->close();

        return false;
    }

    /**
     *Funcion predeterminada para actualizar registros.
     *@param $table string nombre de la tabla
     *@param $data array datos a insertar key columna, values valores a almacenar
     *@return boolean
     */
    function update($table, $data){

        //esta variable almacena la consulta sql
        $query = "UPDATE $table SET ";
        $firstColumn = true;

        //concatenamos valores de tal manera que se construya la consulta
        foreach ($data as $column => $value) {
            if ($column != 'id') {
                $query .= ($firstColumn === true) ? "" : ", ";
                $query .= $column."='$value'";
                $firstColumn = false;
            }
        }
        
        $id = $data['id'];
        $query .= " WHERE id = $id";

        $conexion = getConexion();
        $update = mysqli_query($conexion, $query);
       
        //retornamos verdadero si se guarda el registro en la base de datos
        if (mysqli_affected_rows($conexion)>0) {
            return true;
        }

        $conexion->close();
        return false;
    }

    /**
     *Funcion eliminar un registro.
     *@param $table string nombre de la tabla
     *@param $id int del registro
     *@return boolean
     */
    function delete($table, $id) {
        //No eliminamos el registro si no cambiabiamos el estado para ocultarlo
        $query = "UPDATE $table SET $table.status = 0 WHERE $table.id = $id";
        $conexion = getConexion();
        $delete = mysqli_query($conexion, $query);

        if (mysqli_affected_rows($conexion)>0) {
            $conexion->close();
            return true;
        }

        return false;
    }

    /**
     *funcion para retornar producto
     *@param $table string nombre de la tabla
     *@param $cantidad int
     *@param $prestamoId int
     *@param $productoId int
     *@return boolean
     */
    function returnProduct($table, $cantidad, $prestamoId, $productoId){
        $query = "
            UPDATE $table SET $table.cantidad_devuelto = $table.cantidad_devuelto + $cantidad 
            WHERE $table.id_prestamo = $prestamoId AND $table.id_producto = $productoId
        ";
        
        $conexion = getConexion();
        $delete = mysqli_query($conexion, $query);

        if (mysqli_affected_rows($conexion)>0) {
            $conexion->close();
            return true;
        }

        return false;
    }
?>