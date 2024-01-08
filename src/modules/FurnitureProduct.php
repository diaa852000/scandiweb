<?php namespace app\modules;

use app\config\DbConnect;

class FurnitureProduct extends Product
{
    protected $height;
    protected $width;
    protected $length;

    public function __construct($sku, $name, $price, $productType,DbConnect $db ,$height, $width, $length)
    {
        parent::__construct($sku, $name, $price, $productType, $db);

        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    
    protected function handleAdditionalProperties($data)
    {
        $this->insertProductDetails($data);
        $this->updateProductValue();
    }


    private function insertProductDetails($data)
    {
        $sql = "INSERT INTO product_details (SKU, Height, Width, Length) VALUES (?,?,?,?);";

        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindValue(1, $data->SKU);
        $stmt->bindValue(2, $data->Height);
        $stmt->bindValue(3, $data->Width);
        $stmt->bindValue(4, $data->Length);

        if (!$stmt->execute()) {
            throw new \Exception('Failed to insert into product_details table');
        }
    }

    private function updateProductValue()
    {
        $sql = "UPDATE products
            SET Product_Value = (
                SELECT CONCAT(
                    COALESCE(Height, 0), 'x', COALESCE(Width, 0) , 'x', COALESCE(Length, 0) 
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