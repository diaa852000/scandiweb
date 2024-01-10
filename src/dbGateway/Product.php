<?php namespace app\dbGateway;

use app\config\DbConnect;
use app\helpers\HandleErrors;
use Exception;

abstract class Product
{
    protected $sku;
    protected $name;
    protected $price;
    protected $productType;
    // protected $productDetails;
    protected DbConnect $db;
    protected HandleErrors $handleErrors;

    public function __construct($sku, $name, $price, $productType, DbConnect $db, HandleErrors $handleErrors)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->productType = $productType;  
        // $this->productDetails = $productDetails;
        $this->db = $db;
        $this->handleErrors = $handleErrors;
    }


    public function create($data)
    {
        if($this->handleErrors->isProductExists($data->SKU)){
            $this->handleErrors->handleDuplicateSkuInsertion($data->sku);
            throw new Exception("SKU is already exist");
        }
    }
}