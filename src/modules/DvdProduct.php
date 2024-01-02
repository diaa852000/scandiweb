<?php namespace app\modules;

use app\config\DbConnect;
use app\modules\Product;

class DVDProduct extends Product
{
    protected $size;
    protected DbConnect $db;

    public function __construct($sku, $name, $price, $productType, $size)
    {
        parent::__construct($sku, $name, $price, $productType);
        $this->size = $size;
    }


    public function create($data)
    {
        try {
            $this->db->getConnection()->beginTransaction();

            parent::create($data);

            $this->insertProductDetails($data);

            $this->updateProductValue($data);

            $this->db->getConnection()->commit();

            $response = ['status' => 1, 'message' => 'Record created'];
            print_r($response);

        } catch (\PDOException $e) {
            $this->db->getConnection()->rollBack();

            $response = ['status' => 0, 'message' => 'Failed to create record: ' . $e->getMessage()];
            print_r($response);
        }
    }

    private function insertProductDetails($data)
    {
        $sql = "INSERT INTO product_details (SKU, Size) VALUES (?,?);";

        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindValue(1, $data->SKU);
        $stmt->bindValue(2, $data->Size);


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
