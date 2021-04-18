<?php

trait ConfigTraits
{
        public static function dbConfig()
        {
                $dbConfigArr = [];
                if (file_exists("./config/database.php")) {
                        $dbConfigArr = include("./config/database.php");
                }
                return $dbConfigArr;
        }
        
        public static function getConfig($key)
        {
                $configArr = self::dbConfig();
                if (!empty($configArr) && isset($configArr[$key])) {
                        return $configArr[$key];
                }
                return "";
        }
}

?>
