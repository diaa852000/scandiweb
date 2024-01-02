<?php namespace app\modules;

use app\config\DbConnect;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;

    protected DbConnect $db;

    public function __construct($sku, $name, $price, $productType)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->productType = $productType;
        $this->db = new DbConnect();

    }

    public function create($data)
    {
        $sql = "INSERT INTO products (SKU, Name, Price, Product_Type) VALUES (?,?,?,?);";
        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindValue(1, $this->sku);
        $stmt->bindValue(2, $this->name);
        $stmt->bindValue(3, $this->price);
        $stmt->bindValue(4, $this->productType);

        if ($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created'];
            print_r($response);
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record'];
            print_r($response);
        }
    }

}

