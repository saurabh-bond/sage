<?php

class CourseSubscription extends DBClass
{
        protected $table = 'course_subscription';
        
        public static function fetchAll()
        {
                $query = "SELECT * FROM " . self::$table;
                $students = DBClass::getInstance()->selectQuery($query);
                return $students['data'];
        }
        
}


?>
