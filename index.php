<?php

require_once __DIR__ . '/vendor/autoload.php';

use app\api\Read;
use app\config\DbConnect;

require_once('src/includes/cors.php');


try {
    $dbConnect = new DbConnect();
    $connection = $dbConnect->getConnection();
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "GET":
        $read = new Read($dbConnect);
        $products = $read->get();
        print_r(json_encode($products));
        break;    
}

