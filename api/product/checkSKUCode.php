<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../resources/product.php";

$database=new Database();
$con=$database->getConnection();

$product=new Product($con);

$product->product_SKU='"'. $_POST['product_SKU']. '"';
$product->seller_email='"'. $_POST['seller_email'].'"';
$stmt = $product->checkSKUcode();

$count=$stmt->rowCount();

if($count>0)
{

    http_response_code(200);
    echo json_encode(array("message"=>true));
}
else
{
    http_response_code(200);
    echo json_encode(array("message"=>false));
}

?>