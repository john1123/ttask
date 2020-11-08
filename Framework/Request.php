<?php

namespace Framework;

class Request
{
    public static $defaultController = 'tasks'; // контроллер если не задан
    public static $defaultAction = 'index'; // метод если не задан

    public static function parse()
    {
        $requestedUrl = $_SERVER["REQUEST_URI"];
        $parameters = strstr(urldecode($requestedUrl), '?');
        $parameters = substr($parameters, 1);
        $arParameters = explode('&', $parameters);
        $arUri = [];
        foreach ($arParameters as $part) {
            $arParts = explode('=', $part);
            if (array_key_exists(1, $arParts) && strlen($arParts[0]) > 0) {
                $arUri[$arParts[0]] = $arParts[1];
            }
        }
        $arUri['controller'] = array_key_exists('controller', $arUri) ? $arUri['controller'] : self::$defaultController;
        $arUri['action'] = array_key_exists('action', $arUri) ? $arUri['action'] : self::$defaultAction;

        return $arUri;
    }
}