<?php

namespace app\dbGateway;

use app\dbGateway\BookProduct;
use app\dbGateway\DVDProduct;
use app\dbGateway\FurnitureProduct;
use app\config\DbConnect;
use app\helpers\HandleErrors;

class ProductFactory
{
    public static function createProduct($productType, DbConnect $db, $data)
    {
        $handleErrors = new HandleErrors($db);
        switch ($productType) {
            case 'Book':
                return new BookProduct($data->SKU, $data->Name, $data->Price, $productType,  $db, $handleErrors, $data->Weight);
            case 'DVD':
                return new DVDProduct($data->SKU, $data->Name, $data->Price, $productType,  $db, $handleErrors, $data->Size);
            case 'Furniture':
                return new FurnitureProduct($data->SKU, $data->Name, $data->Price, $productType,  $db, $handleErrors, $data->Height, $data->Width, $data->Length);
            default:
                throw new \InvalidArgumentException('Invalid product type');
        }
    }
}
