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
$seller->email = isset($_GET['email']) ? $_GET['email'] : die();
// read the details of seller to be edited

$stmt=$seller->checkEmail();

$num = $stmt->rowCount();

if($num > 0){

 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode(array("message" => "True"));
}
 
else{
    // set response code - 404 Not found 
    // tell the user seller does not exist
    echo json_encode(array("message" => "False"));
}
?>