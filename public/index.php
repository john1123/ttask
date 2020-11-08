<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

// Основные пути со слешем на конце
define('DIRECTORY_ROOT', preg_replace('%[^\\\\/]+.[^\\\\/]+$%m', '', __FILE__));
define('DIRECTORY_APP', DIRECTORY_ROOT . 'Application' . DIRECTORY_SEPARATOR);

require_once DIRECTORY_ROOT . 'Framework' . '/' . 'autoload.php';
require_once DIRECTORY_APP . 'config.php';
Framework\Tools::log('Start application. ' . $_SERVER['REQUEST_URI']);
Framework\Application::run();
