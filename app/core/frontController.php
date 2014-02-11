<?php
class frontController
{
    public $application = null;

    function __construct($application)
    {
        $this->application = $application;
    }

    public function route()
    {

        // контроллер и действие по умолчанию
        $controller_name = 'index';
        $action_name = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        // получаем имя контроллера
        if ( !empty($routes[1]) )
        {
            $controller_name = strtolower($routes[1]);
        }

        // получаем имя экшена
        if ( !empty($routes[2]) )
        {
            $action_name = strtolower($routes[2]);
        }

        // добавляем префиксы
        $model_name = $controller_name . 'Model';
        $controller_name = $controller_name . 'Controller';
        $action_name = $action_name . 'Action';



        // подцепляем файл с классом модели (файла модели может и не быть)
        $model_file = $model_name . '.php';
        $model_path = "app/models/".$model_file;
        if(file_exists($model_path))
        {
            require_once("app/models/" . $model_file);
        }

        // подцепляем файл с классом контроллера
        $controller_file = $controller_name . '.php';
        $controller_path = "app/controllers/" . $controller_file;
        if(file_exists($controller_path))
        {
            require_once("app/controllers/" . $controller_file);
        }
        else
        {
            /*
            правильно было бы кинуть здесь исключение,
            но для упрощения сразу сделаем редирект на страницу 404
            */
            die('Unknown action');
        }

        // создаем контроллер
        $controller = new $controller_name;
        $action = $action_name;

        if(method_exists($controller, $action))
        {
            // вызываем действие контроллера
            $controller->$action();
        }
        else
        {
            // здесь также разумнее было бы кинуть исключение
            die('Unknown action');
        }
    }

    /*
     *
     * Execute controller
     */
    public function run()
    {
        $this->route();
    }
}