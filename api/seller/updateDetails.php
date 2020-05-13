<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../resources/seller.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare seller object
$seller = new Seller($db);
 
// get id of seller to be edited
 
// set ID property of seller to be edited
$seller->email = $_POST["email"];
$seller->sellerName = $_POST["sellerName"];
$seller->storeName = $_POST["storeName"];
$seller->type = $_POST["type"];
$seller->contact = $_POST["contact"];

 
// update the seller
if($seller->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "True"));
}
 
// if unable to update the seller, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Failed"));
}
?>