<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../resources/seller.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare seller object
$seller = new Seller($db);
 
// set email property of record to read
$seller->email =  $_GET['email'] ;
// read the details of seller to be edited

$seller->readOne();
 
if($seller->email!=null){
    // create array
    $seller_arr = array(

        "sellerName" => $seller->sellerName,
        "storeName" => $seller->storeName,
        "type" => $seller->type,
        "email" => $seller->email,
        "contact" => $seller->contact,
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($seller_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user seller does not exist
    echo json_encode(array("message" => "seller does not exist."));
}
?>