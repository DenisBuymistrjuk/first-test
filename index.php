<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL);

register_shutdown_function('session_write_close');

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (
    getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'
));

if( strpos($_SERVER['SERVER_NAME'], 'local') ){
    define('APPLICATION_ENV', 'development');
}

require_once('app/autoload.php');
classload::start();
//require_once('app/application.php');

$app = new Application();

$app->frontController()->run();