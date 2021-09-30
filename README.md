# How to use 

        use MUSTAFA\PDO_DATABASE\DataBase;
        $options = 
            [
                // required
                'db_name' => '',
                
                // optional
                'host' => 'localhost',
                'user_name' => 'root',
                'password' => '',
                'db_type' => 'mysql',
                'charset' => 'UTF-8',
                'port' => 3306
            ];
            
            $db_object = new DataBase($options);
            
            // SELECT
            $db_object->selectAll('user');
            $db_object->select_row('user', ['id' => 4]);
            
            // INSERT
            $db_object->insert('user', ['id' => 120, 'full_name' => 'MUSTAFA EL-HAMZAWY']);
            
            // UPDATE OR EDIT
            $db_object->update('user', [ 'full_name' => 'MUSTAFA'], ['id' => 120]);
            
            // DELETE
            $db_object->delete_row('user', ['id' => 120]);
            
            
            
            
            
            



