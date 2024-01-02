<?php

require_once __DIR__ . '/vendor/autoload.php';

use app\api\create;
use app\config\DbConnect;

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
    exit;
}

if($method == "POST")
{
    $data = json_decode(file_get_contents('php://input'));
    $response = create::createProduct($data);
    header('Content-Type: application/json');
    echo json_encode(["message" => $response]);
}
