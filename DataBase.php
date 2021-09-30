<?php


namespace MUSTAFA\PDO_DATABASE;


use PDO;

class DataBase
{
    private $_connect;

    public function __construct($options)
    {
        // optional
        $host     = ! empty($options['host'])      ? $options['host']      : 'localhost';
        $userName = ! empty($options['user_name']) ? $options['user_name'] : 'root';
        $password = ! empty($options['password'])  ? $options['password']  : '';
        $db_type  = ! empty($options['db_type'])   ? $options['db_type']   : "mysql";
        $charset  = ! empty($options['charset'])   ? $options['charset']   : "UTF-8";
        $port     = ! empty($options['port'])      ? $options['port']      : 3306;

        // required
        if (!empty($options['db_name'])){
            $db_name = $options['db_name'];
        }
        $dsn = "{$db_type}:host={$host};port={$port};dbname={$db_name}";

        // connect
        $this->_connect = new PDO($dsn, $userName, $password);
    }


    /*------------------------------------------------------------------------*
    *                                                                         *
    *            This function to get all data from a table                   *
    *                                                                         *
    *------------------------------------------------------------------------ */

    public function selectAll($talbeName)
    {
        $data = $this->_connect->query("SELECT * FROM $talbeName")->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    /*------------------------------------------------------------------------*
    *                                                                         *
    *            This function to get all data from a row in a table          *
    *                                                                         *
    *------------------------------------------------------------------------ */

    public function select_row($tableName, $primary_key)
    {
        $keys = array_keys($primary_key);
        $condition = "`$keys[0]` = {$primary_key[$keys[0]]}";

        $data = $this->_connect->query("SELECT * FROM $tableName WHERE $condition")->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    /*-----------------------------------------------------------------------*
     *                                                                       *
     *  This function to insert data into a table                            *
     *  $values --> must be sent as array ['attribute_name => 'value']       *
     *---------------------------------------------------------------------- */

    public function insert($tableName, $values)
    {
        $keys = array_keys($values);
        $count = count($keys);

        $attributes = "(";
        for ($i = 0; $i < $count; $i++)
        {
            $attributes .= "`$keys[$i]`";
            if ($i !== $count - 1)
                $attributes .= ', ';
        }
        $attributes .= ')';

        $data = "(";
        for ($i = 0; $i < $count; $i++)
        {
            $data .= "'{$values[$keys[$i]]}'";
            if ($i !== $count - 1)
                $data .= ', ';
        }
        $data .= ')';

        $query = "INSERT INTO $tableName $attributes VALUES $data";
        $this->_connect->query($query);
    }

    /*-----------------------------------------------------------------------*
     *                                                                       *
     *            This function to get the last inserted id in the db        *
     *                                                                       *
     *---------------------------------------------------------------------- */

    public function lastInsertedId()
    {
        return $this->_connect->lastInsertId();
    }

    /*-----------------------------------------------------------------------*
     *            This function to delete a row from a table                 *
     *                                                                       *
     * $primary_key --> example : ['id' => 5]                                *
     *---------------------------------------------------------------------- */

    public function delete_row($tableName, $primary_key)
    {
        $keys = array_keys($primary_key);
        $condition = "`$keys[0]` = {$primary_key[$keys[0]]}";

        $this->_connect->query("DELETE FROM $tableName WHERE $condition");

    }

    /*-----------------------------------------------------------------------*
     * This function to delete a row from a table                            *
     * $values --> must be sent as array ['attribute_name => 'value']        *
     * $primary_key --> example : ['id' => 5]                                *
     *------------------------------------------------------------------------ */

    public function update($tableName, $values, $primary_key)
    {
        $keys  = array_keys($values);
        $count = count($keys);
        $statement = '';
        for ($i = 0; $i < $count; $i++)
        {
            $statement .= "`{$keys[$i]}` = " . "'{$values[$keys[$i]]}'";

            if ($i !== $count - 1)
                $statement .= ', ';
        }
        $primaryKey = key($primary_key);
        $condition = "$primaryKey = $primary_key[$primaryKey]";
        $query = "UPDATE $tableName SET $statement WHERE $condition";
        echo $query;die;
        $this->_connect->query($query);

    }
    
}