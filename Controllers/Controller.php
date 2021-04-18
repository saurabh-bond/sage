<?php

class Controller extends Database
{
        public static function renderView($viewName, $data = [])
        {
                if (file_exists("./Views/{$viewName}.php")) {
                        require_once("./Views/{$viewName}.php");
                } else {
                        die("View does not exist");
                }
        }
}

?>
