<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/includes/cors.php';

use app\config\DbConnect;
use app\dbGateway\ProductFactory;

try {
    $dbConnect = new DbConnect();
    $connection = $dbConnect->getConnection();
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "OPTIONS") {
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: *");
    exit();
}

if ($method == "POST") {

    $data = json_decode(file_get_contents('php://input'));

    if (empty($data)) 
    {
        $response = ['status' => 0, 'message' => 'Error: Invalid or empty data received.'];
    } 
    else 
    {
        try {
            $productType = $data->Product_Type;
            $product = ProductFactory::createProduct($productType, $dbConnect, $data);
            
            $product->create($data);

            $response = ['status' => 1, 'message' => 'Record created'];
        } 
        catch (\Throwable $e)
        {
            $response = ['status' => 0, 'message' => 'Failed to create record: ' . $e->getMessage()];
            throw $e;
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    exit();
}
