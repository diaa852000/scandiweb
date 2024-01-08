<?php namespace app\modules;

use app\config\DbConnect;
use app\modules\Product;

class BookProduct extends Product
{
    protected $weight;

    public function __construct($sku, $name, $price, $productType, DbConnect $db, $weight)
    {
        parent::__construct($sku, $name, $price, $productType, $db);
        $this->weight = $weight;
    }

    
    protected function handleAdditionalProperties($data)
    {
        $this->insertProductDetails($data);
        $this->updateProductValue();
    }

    private function insertProductDetails($data)
    {
        $sql = "INSERT INTO product_details (SKU, Weight) VALUES (?,?);";

        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindValue(1, $data->SKU);
        $stmt->bindValue(2, $data->Weight);


        if (!$stmt->execute()) {
            throw new \Exception('Failed to insert into product_details table');
        }
    }

    private function updateProductValue()
    {
        $sql = "UPDATE products
            SET Product_Value = (
                SELECT CONCAT(
                    COALESCE(Weight, 0) + COALESCE(Height, 0) + COALESCE(Width, 0) + COALESCE(Length, 0) + COALESCE(Size, 0)
                )
                FROM product_details
                WHERE product_details.SKU = products.SKU
            );";

        $stmt = $this->db->getConnection()->prepare($sql);

        if (!$stmt->execute()) {
            throw new \Exception('Failed to update Product_Value in products table');
        }
    }
}
