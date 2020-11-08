<?php // https://yadro.top/1824-pishem-svoy-pervyy-freymvork-na-php.htm

namespace Framework;

abstract class Model
{
    private $_connection;
    protected $_options = array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");
    public function __construct()
    {
        $this->_initConnection();
    }

    private function _initConnection()
    {
        if (!$this->_connection instanceof \PDO) {
            $dsn = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);
            try {
                $this->_connection = new \PDO($dsn, DB_USER, DB_PASS, $this->_options);
            } catch (PDOException $e) {
                throw new Exception('Connection failed: ' . $e->getMessage());
            }
        }
    }

    public function getConnection()
    {
        return $this->_connection;
    }
 
}