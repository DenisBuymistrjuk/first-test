<?php
function __autoload($class_name)
{
    $filename = $class_name . '.php';
    require_once($filename);
}
class classload
{
    public static function start()
    {
        require_once('Application.php');
        require_once('core/frontController.php');
        require_once('core/controller.php');
        require_once('core/model.php');
        require_once('core/view.php');
        require_once('core/registry.php');

    }
}
