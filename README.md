# How to use it

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
            
            
            



