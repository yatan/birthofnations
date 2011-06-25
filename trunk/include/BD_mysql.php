<?php
/**
 * Clase para conectar con una BBDD de MySQL
 *
 * 
 */

class BD {
    private $conexion;
    private $resultSet;

    private $arrayAux;

    // Conecta con un servidor de la base de datos
    public function conectar($host,$usuario,$contraseña)
    {
        try
        {

            if(func_num_args() == 4)
            {
                $this->conexion = new mysqli($host,$usuario,$contraseña);
                $this->conexion->select_db(func_get_arg(3));
            }
            else if(func_num_args() == 3)
             {
                 $this->conexion = new mysqli($host,$usuario,$contraseña);
             }
             else
             {
                 throw new Exception("Número de argumentos incorrecto");
             }
        }
        catch (Exception $e)
        {
            return $e->getMessage();

        }


        if(str_word_count($this->conexion->connect_error) != 0)
        {
            return $this->conexion->connect_error;
        }
        else
         {
            return 0;
         }
    }

    // Establece la base de datos/esquema sobre el que se va a trabajar
    public function setEsquema($esquema)
    {
        try
        {
            if(strlen($esquema) != 0)
             $this->conexion->select_db($esquema);
            else
                throw  new Exception("No se ha introducido el esquema");
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
        }

    }

    //Ejecuta una instrucción SQL
    public function ejecutar($sentencia)
    {
     
        try
        {
            if(strlen($sentencia) != 0)
            {
              $this->resultSet = $this->conexion->query($sentencia);

              return 0;
            }
            else
            {
                throw new Exception("No se ha introducido una sentencia SQL");
                return 1;
            }
        }
        catch (Exception $e)
        {
                echo $e->getMessage();
                return 1;
        }


    }

    /**
     * Realiza un SELECT en la base de datos
     * 
     * @param <string> Campo a filtrar OPCIONAL
     * @param <string> Tabla
     * @param <string> Valor del campo que se desea evaluar
     * @param <string> Valor a verificar
     *
     * 
     */
    public function select()
    {
        if (func_num_args () == 4)
        {
            $cadena = "SELECT ".func_get_arg(0)." FROM ".func_get_arg(1)." WHERE ".func_get_arg(2)."='".func_get_arg(3)."'";
           
        }
        else if (func_num_args () == 3)
        {
            $cadena = "SELECT * FROM ".func_get_arg(0)." WHERE ".func_get_arg(1)."=".func_get_arg(2);         
           
        }
        else if (func_num_args () == 2){
            $cadena = "SELECT ".func_get_arg(0)." FROM ".func_get_arg(1);
        }
        else {
            throw new Exception("Son necesarios entre 2 y 4 parámetros");
        }

       
       return $this->ejecutar($cadena);

    }

    /* Obtiene un valor en una fila y columna especifica
     * @param fila, entero
     * @param columna, entero
     */
    public function getValor($fila, $columna)
    {
        /*Se posiciona en la fila*/

        $this->resultSet->data_seek($fila);
        $fila_r = $this->resultSet->fetch_array();

        return $fila_r[$columna];
    }

    /* Obtiene un valor en una fila y columna especificada por su nombre
     * @param fila, entero con el número de fila
     * @param columna, cadena de caracteres con el nombre de la columna
     */
    public function getValorPorNombreColumna()
    {
        if(func_num_args() == 1)
        {

            $nombre = func_get_arg(0);
            $numFila = 0;
        }
        else
        {
            $numFila = func_get_arg(0);
            $nombre = func_get_arg(1);

        }

        $this->resultSet->data_seek($numFila);
        $fila = $this->resultSet->fetch_assoc();
    
        
        return $fila[$nombre];
    }

    // Se posiciona en la fila especificada partiendo desde el inicio del resultset
    public function absolute($fila)
    {
        $this->resultSet->data_seek($fila);
    }


    // Ejecuta una instrucción INSERT
     public function setValor($table, $values) {


        $consulta = "insert into {$table} ("
                        .implode(', ', array_keys($values))
                        .') values(';

        foreach ($values as $key => $value) {
            if(is_numeric($value)) {
               $consulta .= ', ' . $value;
            } else {
                 $consulta .= ", '". $value . "'";
            }
        }

        $consulta = str_replace('(,', '(',  $consulta);
        $consulta .=  ')';
       
        $this->conexion->query($consulta);
  
        if(strlen($this->conexion->error) == 0)
            return $this->conexion->insert_id;
        else
            {
                $cadenaError = $this->conexion->error;
                $cadenaError .=',';
                $cadenaError .= $this->conexion->errno;
            return $cadenaError;
            }
     }

     // Ejecuta una instrucción UPDATE
     public function updateValor($tabla,$columnaClave, $id, $columna, $valor)
     {
           $consulta = "UPDATE {$tabla} SET {$columna} = '{$valor}' WHERE {$columnaClave} = {$id};";
        
          return $this->conexion->query($consulta);

     }

     // Ejecuta una instrucción DELETE
     public function deleteValor($tabla, $idNombre, $id)
     {
         $consulta = "DELETE FROM {$tabla} WHERE {$idNombre} = {$id}";
         $this->conexion->query($consulta);

     }

     // Obtiene el número de filas del resultset
     public function getNumFilas()
     {   
        return $this->resultSet->num_rows;
       
     }

     // Obtiene el número de columnas del resultset
     public function getNumColumnas()
     {

         return $this->resultSet->field_count;
     }

     // Libera el buffer de operaciones
     public function liberar(){
         $this->conexion->store_result();
     }

     // Obtiene el último código de error obtenido
     public function getError()
     {
         return $this->conexion->error;
     }

     // Se desconecta de la BBDD
     public function desconectar()
     {
         if(isset ($this->resultSet))
            $this->resultSet->close();
         if(isset ($this->conexion))
            $this->conexion->close();
     }




}
?>