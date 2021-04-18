<?php

class Route
{
        public static $validRoutes = [];
        
        public static function call($url, $function)
        {
                self::$validRoutes[] = $url;
                
                if ($_GET['url'] == $url) {
                        $function->__invoke();
                }
        }
}

?>
