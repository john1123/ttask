<?php

namespace Framework;

abstract class Controller
{
    public $title = '';

    public function redirect($controller, $action="index", $args=[])
    {
        $location = '?controller=' . $controller . '&action=' . $action;
        foreach ($args as $name => $value) {
            if (!is_int($name)) {
                $location .= '&' . $name . '=' . urlencode($value);
            }
        }
        Tools::log('Location: ' . $location);
        header("Location: " . $location);
        exit;
    }
    public function alert($text, $type='success')
    {
        Session::set('alert', $text);
        Session::set('alertType', $type);
    }
}