<?php

namespace app\api;

use app\config\DbConnect;

class Delete
{
    protected DbConnect $db;

    public function __construct(DbConnect $db)
    {
        $this->db = $db;
    }

    public function deleteAll($product_ids)
    {
        try {
            $this->db->getConnection()->beginTransaction();

            // $this->deleteDetails($product_ids);
            $this->deleteProduct($product_ids);

            $this->db->getConnection()->commit();

            return json_encode(['success' => true, 'message' => 'Products deleted successfully']);
        } 
        catch (\PDOException $e) 
        {
            $this->db->getConnection()->rollBack();

            return json_encode(['success' => false, 'message' => 'Error deleting products: ' . $e->getMessage()]);
        }
    }

    // private function deleteDetails($product_ids)
    // {
    //     $sqlDeleteDetails = "DELETE FROM product_details WHERE SKU IN (" . implode(',', array_fill(0, count($product_ids), '?')) . ")";
    //     $stmtDeleteDetails = $this->db->getConnection()->prepare($sqlDeleteDetails);

    //     foreach ($product_ids as $key => $productID) 
    //     {
    //         $stmtDeleteDetails->bindValue(($key + 1), $productID, \PDO::PARAM_STR);
    //     }

    //     $stmtDeleteDetails->execute();
    // }

    private function deleteProduct($product_ids)
    {
        $sqlDeleteProducts = "DELETE FROM products WHERE SKU IN (" . implode(',', array_fill(0, count($product_ids), '?')) . ")";
        $stmtDeleteProducts = $this->db->getConnection()->prepare($sqlDeleteProducts);

        foreach ($product_ids as $key => $productID) 
        {
            $stmtDeleteProducts->bindValue(($key + 1), $productID, \PDO::PARAM_STR);
        }

        $stmtDeleteProducts->execute();
    }
}
