<?php

namespace Framework;

class View
{
    public static function render($templateName, $vars=[])
    {
        extract($vars);

        ob_start();
        include DIRECTORY_APP . 'Views/' . $templateName;
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
}