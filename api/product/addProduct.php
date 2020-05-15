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
    $product->product_MRP='"'.  $_POST["product_MRP"].'"';
    $product->product_selling_price='"'.  $_POST["product_selling_price"].'"';
    $product->package_length='"'.  $_POST["package_length"].'"';
    $product->package_width='"'.  $_POST["package_width"].'"';
    $product->package_breadth='"'.  $_POST["package_breadth"].'"';
    $product->package_weight='"'.  $_POST["package_weight"].'"';

    // $product->product_MRP='"'.  $_POST["product_MRP"].'"';
    // $product->product_selling_price='"'.  $_POST["product_selling_price"].'"';

    

    if($product->addProduct())
    {

        

        $current_directory=getcwd();
        //concatenate current_directory with product_id
        $current_directory=$current_directory."\\product_images\\".trim($product->seller_email,'"')."\\";

        //making directory by product_id
        if(!is_dir($current_directory))
        mkdir($current_directory,0777);

        $current_directory=$current_directory.$product->product_SKU."\\";

        if(!is_dir($current_directory))
        mkdir($current_directory,0777);

        http_response_code(200);
        echo json_encode(array("message"=>"True","product_id"=>$product->product_id,"product_sku"=>$product->product_SKU));
    }

    else
    {

        http_response_code(404);

        echo json_encode(array("message"=>"False"));
    }

?>