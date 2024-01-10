<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once('src/includes/cors.php');

use app\config\DbConnect;
use app\api\Delete;

// require_once('')

try {
    $dbConnect = new DbConnect();
    $connection = $dbConnect->getConnection();
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data)) {
            return "Choose products to be deleted, You chose no product";
        } elseif (isset($data['product_ids']) && is_array($data['product_ids'])) {
            $deleteProducts = new Delete($dbConnect);
            $result = $deleteProducts->deleteAll($data['product_ids']);

            header('Content-Type: application/json');
            echo json_encode($result);
            echo json_encode(['success' => 'true', 'message' => 'Successfully Deleted product(s)']);
        } else {
            echo json_encode(['success' => 'false', 'message' => 'Invalid data provided for deletion']);
        }
        break;
}
