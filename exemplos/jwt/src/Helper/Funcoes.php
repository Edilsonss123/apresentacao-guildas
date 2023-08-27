<?php
if (!function_exists("dd")) {
    function dd(...$v)  {
        echo "<pre>"; 
            var_dump($v);
        echo "</pre>";
        die;
    }
}

if (!function_exists("dump")) {
    function dump(...$v)  {
        echo "<pre>"; 
            var_dump($v);
        echo "</pre>";
    }
}