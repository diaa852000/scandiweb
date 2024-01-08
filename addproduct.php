<?php 

require_once __DIR__ . '/vendor/autoload.php';

use app\config\DbConnect;
use app\modules\BookProduct;
use app\modules\DVDProduct;
use app\modules\FurnitureProduct;

require_once('src/includes/cors.php');

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

if($method == "POST")
{
    $data = json_decode(file_get_contents('php://input'));
    if (empty($data)) {
        $response = ['status' => 0, 'message' => 'Error: Invalid or empty data received.'];
    } 
    else 
    {
        $productType = $data->Product_Type; 

        $productClasses = [
            'DVD' => DVDProduct::class,
            'Book' => BookProduct::class,
            'Furniture' => FurnitureProduct::class
        ];  

        if(isset($productClasses[$productType]))
        {
            $productClass = $productClasses[$productType];

            $product = new $productClass(
                $data->SKU,
                $data->Name,
                $data->Price,
                $data->Product_Type,
                $dbConnect,

                $data->Size ?? null, 
                
                $data->Weight ?? null,
                
                $data->Height ?? null,
                $data->Width ?? null,
                $data->Length ?? null,
            );

            $response = $product->create($data);
        }
        else
        {
            $response = ['status' => 0, 'message' => 'Error: Unknown Product type'];
        }
    }

    exit;

}
