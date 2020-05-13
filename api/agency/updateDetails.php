<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../resources/agency.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare agency object
$agency = new Agency($db);
 
// get id of agency to be edited
 
// set ID property of agency to be edited
$agency->type =$_POST["type"];
$agency->agencyName = $_POST["agency"];
$agency->email = $_POST["email"];
$agency->phone =$_POST["phone"];
$agency->password = $_POST["password"];

 
// update the agency
if($agency->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "True"));
}
 
// if unable to update the agency, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Failed"));
}
?>