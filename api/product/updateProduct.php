<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
 
// instantiate ag$products object
include_once '../resources/product.php';
 
$database = new Database();
$db = $database->getConnection();
 
$product = new Product($db);

// get posted data

// make sure data is not empty

    $product->product_id = "'" . $_POST["product_id"] . "'";
    $product->seller_email='"'.  $_POST["seller_email"].'"';
    $product->product_MRP='"'.  $_POST["product_MRP"].'"';
    $product->product_selling_price='"'.  $_POST["product_selling_price"].'"';
    $product->package_length='"'.  $_POST["package_length"].'"';
    $product->package_width='"'.  $_POST["package_width"].'"';
    $product->package_breadth='"'.  $_POST["package_breadth"].'"';
    $product->package_weight='"'.  $_POST["package_weight"].'"';

    

    if($product->updateProduct())
    {
        http_response_code(200);
        echo json_encode(array("message"=>"True","product_id"=>$product->product_id));
    }

    else
    {

        http_response_code(404);

        echo json_encode(array("message"=>"False"));
    }

?>