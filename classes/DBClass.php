<?php


class DBClass
{
        use ConfigTraits;
        
        /* Class for handling db queries operation -- Saurabh Kumar */
        
        // database configurations
        protected $_host;
        protected $_dbName;
        protected $_userName;
        protected $_password;
        
        protected $_command;
        public static $_instance = null;
        
        public function __construct()
        {
                $this->_host = ConfigTraits::getConfig('host');
                $this->_dbName = ConfigTraits::getConfig('dbName');
                $this->_userName = ConfigTraits::getConfig('userName');
                $this->_password = ConfigTraits::getConfig('password');
                $this->_command = $this->connect();
        }
        
        public static function getInstance()
        {
                if (!is_object(self::$_instance))
                        self::$_instance = new DBClass();
                return self::$_instance;
        }
        
        
        private function connect()
        {
                $pdo = new PDO("mysql:host=" . $this->_host . ";dbname=" . $this->_dbName . ";charset=utf8", $this->_userName, $this->_password);
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }
        
        public function selectQuery($query, $params = array())
        {
                try {
                        $pdo = $this->_command->prepare($query);
                        $pdo->execute($params);
                        $data = $pdo->fetchAll();
                        return $this->sendResponse(200, null, 'Data fetched successfully.', $data);
                } catch (Exception $e) {
                        return $this->sendResponse(400, $e->getMessage(), 'Error in fetching data.');
                }
        }
        
        public function insertData($query, $params = [])
        {
                try {
                        $this->_command->beginTransaction();
                        $pdo = $this->_command->prepare($query);
                        $pdo->execute($params);
                        $this->_command->commit();
                        return $this->sendResponse(200, null, 'Record inserted successfully.');
                } catch (Exception $e) {
                        $this->_command->rollBack();
                        return $this->sendResponse(400, $e->getMessage(), 'Error in fetching data.');
                }
        }
        
        public function getRowsCount($query, $params = array())
        {
                $pdo = $this->_command->prepare($query);
                $pdo->execute($params);
                $row_count = $pdo->rowCount();
                return $row_count;
        }
        
        public function sendResponse($status, $err = null, $msg = "", $data = [])
        {
                return ['status' => $status, 'error' => $err, 'message' => $msg, 'data' => $data];
        }
        
}
