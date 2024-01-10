<?php namespace app\config;

use PDO;
use PDOException;

class DbConnect 
{
    private $server = 'localhost';
    private $dbname = 'api';
    private $user = 'root';
    private $pwd = 'password123';
    // private $user = 'id21765076_diaaeltaiby';
    //prot=3306
    // private $pwd = '';
    protected $connection;

    public function __construct()
    {
        $this->connect();
    }

    public function connect() {
        try {
            $this->connection = new PDO('mysql:host=' . $this->server . ';port=3300;dbname=' . $this->dbname, $this->user, $this->pwd);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

}

