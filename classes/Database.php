<?php

class Database
{
        public static $host = "127.0.0.1";
        public static $dbName = "sage";
        public static $userName = "root";
        public static $password = "abcd432";
        
        private static function connect()
        {
                $pdo = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName . ";charset=utf8", self::$userName, self::$password);
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }
        
        public static function query($query, $params = array())
        {
                $stmt = self::connect()->prepare($query);
                $stmt->execute($params);
                $data = $stmt->fetchAll();
                return $data;
        }
        
        public static function connection()
        {
                $connection = self::connect();
                return $connection;
        }
        
        public static function insertData() {
                $result_set = self::connect()->prepare("INSERT INTO `student` (`firstname`, `lastname`, `dob`, `contact`, `created`, `updated`) VALUES (:firstname, :lastname, :dob, :contact, :created, :updated)");
                $result_set->execute(array(
                        ':firstname' => 'Saurabh',
                        ':lastname' => 'Kumar1',
                        ':dob' => '1618674703',
                        ':contact' => '8123946324',
                        ':created' => '1618674703',
                        ':updated' => '1618674703',
                ));
                print_r($result_set);
                die('stop here');
        }
        
}

?>
