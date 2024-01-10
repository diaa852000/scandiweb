<?php namespace app\helpers;

use app\config\DbConnect;

class HandleErrors extends \Exception
{
    protected DbConnect $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    public function isProductExists($sku)
    {
        $sql = "SELECT COUNT(*) FROM products WHERE SKU = ?";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(1, $sku);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function isDuplicateSkuError(\PDOException $e)
    {
        return $e->getCode() == '23000';
    }



    public function handleDuplicateSkuError(\PDOException $e, $sku)
    {
        $response = ['status' => 0, 'message' => 'Duplicate SKU: ' . $sku];
        $jsonRes = json_encode($response);

        header('Content-Type: application/json');

        echo $jsonRes;
        
        exit();
    }

    public function handleDuplicateSkuInsertion($sku)
    {
        $response = ['status' => 0, 'message' => 'Product with SKU already exisit'];
        $jsonRes = json_encode($response);
        
        header('Content-Type: application/json');

        echo $jsonRes;

        exit();
    }
}