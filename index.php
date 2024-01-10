<?php

require_once __DIR__. '/vendor/autoload.php';
require_once('src/includes/cors.php');

use app\api\Read;
use app\config\DbConnect;

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

