<?php

namespace Framework;

class Session {
    public static function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    public static function get($name, $defaultValue = '')
    {
        return array_key_exists($name, $_SESSION) ? $_SESSION[$name] : $defaultValue;
    }
    
    public static function deleteVariable($name)
    {
        unset($_SESSION[$name]);
    }
    
    public static function issetVariable($name)
    {
        return array_key_exists($name, $_SESSION)? true: false;
    }
}
