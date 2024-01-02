<?php namespace app\api;


use app\modules\BookProduct;
use app\modules\DVDProduct;
use app\modules\FurnitureProduct;


class create 
{

    public static function createProduct($data)
    {
        if(empty($data)){
            return "Error: Invalid or empty data received.";
        }

        $productType = $data->Product_Type;
        
        switch ($productType) {
            case "DVD":
                $product = new DVDProduct(
                    $data->SKU,
                    $data->Name,
                    $data->Price,
                    $data->Product_Type,
                    $data->Size
                );
                break;

            case "Book":
                $product = new BookProduct(
                    $data->SKU,
                    $data->Name,
                    $data->Price,
                    $data->Product_Type,
                    $data->Weight
                );
                break;

            case "Furniture":
                $product = new FurnitureProduct(
                    $data->SKU,
                    $data->Name,
                    $data->Price,
                    $data->Product_Type,
                    $data->Height,
                    $data->Width,
                    $data->Length
                );
                break;

            default:
                return "Error: Invalid Product type";
        }

        $product->create($data);
        
        return "Product created successfully.";
    }
}
