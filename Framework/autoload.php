<?php

spl_autoload_register(function($classname) {
    $fileName = str_replace("\\", '/', $classname) . ".php";
    if (file_exists(DIRECTORY_ROOT . $fileName)) {
        require_once(DIRECTORY_ROOT . $fileName);
        return;
    }
    throw new Exception('Unable to autoload class ' . $classname);
} );