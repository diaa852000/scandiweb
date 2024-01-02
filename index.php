<?php

require_once __DIR__ . '/vendor/autoload.php';

use app\api\Read;
use app\config\DbConnect;
use app\api\Delete;

require_once('src/includes/cors.php');


try {
    $dbConnect = new DbConnect();
    $connection = $dbConnect->getConnection();
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
        $read = new Read($dbConnect);
        $products = $read->get();
        print_r(json_encode($products));
        break;
    
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        
        if (isset($data['product_ids']) && is_array($data['product_ids'])) {
        
            $deleteProducts = new Delete($dbConnect);
            $result = $deleteProducts->deleteAll($data['product_ids']);
        
            echo json_encode($result);
        } 
        else 
        {
            echo json_encode(['success' => false, 'message' => 'Invalid data provided for deletion']);
        }
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Method Not Allowed']);
        
    
}

