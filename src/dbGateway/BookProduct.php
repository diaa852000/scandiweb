<?php namespace app\dbGateway;

use app\config\DbConnect;
use app\helpers\HandleErrors;
use Exception;

class BookProduct extends Product
{
    protected $weight;

    public function __construct($sku, $name, $price, $productType, DbConnect $db, HandleErrors $handleErrors, $weight)
    {
        parent::__construct($sku, $name, $price, $productType, $db, $handleErrors);
        $this->weight = $weight;
    }
    public function create($data)
    {
        try
        {
            parent::create($data);

            $sql = "INSERT INTO products (SKU, Name, Price, Product_Type, Product_Details) VALUES (?,?,?,?,?)";

            $stmt = $this->db->getConnection()->prepare($sql);

            $productDetails = json_encode([
                'Weight' =>$this->weight
            ]);

            $stmt->bindValue(1, $this->sku);
            $stmt->bindValue(2, $this->name);
            $stmt->bindValue(3, $this->price);
            $stmt->bindValue(4, $this->productType);
            $stmt->bindValue(5, $productDetails);

            $stmt->execute();
        }
        catch (\PDOException $e)
        {
            throw new Exception($e);
        }
    }
}