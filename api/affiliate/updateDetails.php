<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../resources/affiliate.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare affiliate object
$affiliate = new Affiliate($db);

 
// set ID property of affiliate to be edited
    $affiliate->firstName = $_POST["first_name"];
    $affiliate->lastName = $_POST["last_name"];
    $affiliate->email = $_POST["email"];
    $affiliate->contact = $_POST["tel"];
    //$affiliate->image = $_POST["image"];

// update the affiliate
if($affiliate->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "True"));
}
 
// if unable to update the affiliate, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Failed"));
}
?>