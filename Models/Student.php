<?php

class Student extends DBClass
{
        public static function fetchAll()
        {
                $query = "SELECT * FROM student WHERE active = 1";
                $students = DBClass::getInstance()->selectQuery($query);
                return $students['data'];
                
        }
}


?>
