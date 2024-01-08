<?php

namespace app\modules;

use app\config\DbConnect;

class DuplicateSkuException extends \Exception
{
}

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;
    protected DbConnect $db;


    public function __construct($sku, $name, $price, $productType, DbConnect $db)
    {

        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->productType = $productType;
        $this->db = $db;
    }

    public function create($data)
    {
        try {
            $this->db->getConnection()->beginTransaction();

            $this->insertProductRecord();
            $this->handleAdditionalProperties($data);

            $this->db->getConnection()->commit();

            $response = ['status' => 1, 'message' => 'Record created'];
            print_r($response);

        } catch (\PDOException $e) {

            $this->db->getConnection()->rollBack();

            if ($this->isDuplicateSkuError($e)) 
            {
                $this->handleDuplicateSkuError($e);
            } 
            else 
            {
                $response = ['status' => 0, 'message' => 'Failed to create record: ' . $e->getMessage()];
                print_r($response);
            }

        }
    }

    protected function insertProductRecord()
    {
        try {

            $sql = "INSERT INTO products (SKU, Name, Price, Product_Type) VALUES (?,?,?,?);";
            $stmt = $this->db->getConnection()->prepare($sql);

            $stmt->bindValue(1, $this->sku);
            $stmt->bindValue(2, $this->name);
            $stmt->bindValue(3, $this->price);
            $stmt->bindValue(4, $this->productType);

            $stmt->execute();

        } 
        catch (\PDOException $e) 
        {
            if ($this->isDuplicateSkuError($e)) 
            {
                $this->handleDuplicateSkuError($e);
            } 
            else 
            {
                throw $e; 
            }
        }
    }
    
    protected function isDuplicateSkuError(\PDOException $e)
    {
        // Check if the error code indicates a unique constraint violation
        return $e->getCode() == '23000'; 
    }
    
    protected function handleDuplicateSkuError(\PDOException $e)
    {
        $response = ['status' => 0, 'message' => 'Duplicate SKU: ' . $this->sku];
        $jsonRes = json_encode($response);
        
        header('Content-Type: application/json');
        
        echo $jsonRes;
        
        exit();
    }

    abstract protected function handleAdditionalProperties($data);
}
