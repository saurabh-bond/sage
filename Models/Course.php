<?php

class Course extends DBClass
{
        public static function fetchAll()
        {
                $query = "SELECT * FROM course WHERE active = 1";
                $students = DBClass::getInstance()->selectQuery($query);
                return $students['data'];
                
        }
}


?>
