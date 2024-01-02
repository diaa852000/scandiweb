<?php namespace app\config;

use PDO;
use PDOException;

class DbConnect 
{
    private $server = 'localhost';
    private $dbname = 'scandiweb';
    private $user = 'root';
    private $pwd = 'password123';
    private $error = null;
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


    
    public function getError(){
        return $this->error;
    }

    public function setError($error){
        return $this->error = $error;
    }
}

