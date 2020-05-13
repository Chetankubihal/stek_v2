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

 
    $product->product_SKU = '"'. $_POST["product_sku"].'"';
    $product->product_HSN ='"'.$_POST["product_hsn"].'"';
    $product->product_name ='"'.  $_POST["product_name"].'"';
    $product->product_description ='"'. $_POST["product_description"].'"';
    $product->product_category = '"'. $_POST["product_category"].'"';
    $product->product_sub_category='"'.  $_POST["product_sub_category"].'"';
    $product->seller_email='"'.  $_POST["seller_email"].'"';
    // $product->product_MRP='"'.  $_POST["product_MRP"].'"';
    // $product->product_selling_price='"'.  $_POST["product_selling_price"].'"';

    

    if($product->addProduct())
    {

        

        $current_directory=getcwd();

        //concatenate current_directory with product_id
        $current_directory=$current_directory."\\product_images\\".$product->product_id;

        //making directory by product_id
        mkdir($current_directory);

        http_response_code(200);
        echo json_encode(array("message"=>"True","product_id"=>$product->product_id));
    }

    else
    {

        http_response_code(404);

        echo json_encode(array("message"=>"False"));
    }

?>