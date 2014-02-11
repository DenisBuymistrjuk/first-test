<?php
class Application {

    private $_config_file_path = '';
    private $_config = null;
    private $_db = null;
    private $_frontController = null;
    public $registry = null;

    function __construct()
    {
        $this->registry = new Registry();
        $this->_initConfig();
        $this->_initDB();
    }

    public function getConfig()
    {
        if( null == $this->_config ){
            $this->_initConfig();
        }


        return $this->_config[APPLICATION_ENV];
    }

    private function _initConfig()
    {
        $this->_config_file_path = dirname(__FILE__) . '/configs/config.ini';

        try {
            if( !file_exists($this->_config_file_path) )
                throw new Exception('Invalid config file path');

            $this->_config = parse_ini_file($this->_config_file_path, true);

            if( !$this->_config )
                throw new Exception('Can\'t load config file');

        } catch (Exception $e){
            $this->_error($e->getMessage());
        }

        $this->registry->config = $this->_config;
    }



    private function _setConfig()
    {

    }

    private function _initDB()
    {
        $conf = $this->getConfig();

        try {
            $dbh = new PDO(
                'mysql:host=' . $conf['db.params.host'] . ';dbname=' . $conf['db.params.dbname'],
                $conf['db.params.username'],
                $conf['db.params.password']
            );
        } catch(PDOException $e){
            $this->_error($e->getMessage());
        }

        $this->_db = $dbh;

        $this->registry->config = $this->_db;
    }

    public function getDbAdapter()
    {
        if( null === $this->_db )
            $this->_initDB();

        return $this->_db;
    }

    private function _error($errors)
    {
        $template = '<div>Error %s: <b>%s</b></div>';
        if( is_array($errors) ){
            $message = '';
            foreach($errors as $key => $error){
                $message .= vsprintf($template, array( $key, $error ));
            }
            die($message);
        }
        die(vsprintf($template, array( 0, $errors )));
    }

    public function frontController()
    {
        if( null === $this->_frontController ) {
            $this->_frontController = new frontController($this);
        }

        return $this->_frontController;
    }
}