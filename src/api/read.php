<?php namespace app\api;

use app\config\DbConnect;

class Read 
{
    protected DbConnect $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    public function get()
    {
        $sql = "SELECT * FROM products;";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $products;
    }
}

