<?php

namespace Framework;

class Tools
{
    public static function log($message)
    {
        $str = date('d.m.Y H:i:s: ') . $message . PHP_EOL;
        file_put_contents(DIRECTORY_ROOT . 'data' . DIRECTORY_SEPARATOR . 'log.txt', $str, FILE_APPEND | LOCK_EX);
    }
}