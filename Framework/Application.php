<?php

namespace Framework;

class Application
{
    public static function run()
    {
        $arUri = Request::parse();

        $controllerName = 'Application\\Controllers\\' . ucfirst($arUri['controller']);
        $actionName = 'action' . ucfirst($arUri['action']);
        unset($arUri['controller']);
        unset($arUri['action']);

        Tools::log('Application. Call method ' . $controllerName . '->' . $actionName . '()');
        $obj = new $controllerName();
        echo View::render('page.tmpl.php', [
            'content' => $obj->$actionName($arUri),
            'title' => $obj->title,
            'alert' => Session::get('alert'),
            'alertType' => Session::get('alertType'),
        ]);
        Session::deleteVariable('alert');
        Session::deleteVariable('alertType');
    }

}