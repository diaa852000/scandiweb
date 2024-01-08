<?php namespace app\api;

use app\config\DbConnect;
use Error;

class Read 
{
    protected DbConnect $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    public function get()
    {
        try
        {
            $sql = "SELECT * FROM products;";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $products;
        }
        catch (\PDOException $e)
        {
            throw new Error("Error Fetching Data" . $e);
        }
    }
}

