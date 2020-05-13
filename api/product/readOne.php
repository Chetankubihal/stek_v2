<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

 
// include database and object files
include_once '../config/database.php';
include_once '../resources/product.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare affiliate object
$product = new Product($db);
 
// set email property of record to read
$product->product_id= '"'. $_POST['product_id'] .'"';
// read the details of affiliate to be edited


 
if($product->readOne()){
    // create array
    $product_details = array(
        "name" =>  $product->product_name,
        "description" => $product->product_description,
        "category" => $product->product_category,
        "sub_category" => $product->product_sub_category,
        "SKU" => $product->product_SKU,
        "HSN" => $product->product_HSN,
        "selling_price"=> $product->product_selling_price,
        "MRP"=> $product->product_MRP,
        "status"=> $product->status 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode(array("message"=>"True","data"=>$product_details));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user affiliate does not exist
    echo json_encode(array("message" => "False"));
}
?>