<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../resources/agency.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare agency object
$agency = new Agency($db);
 
// set email property of record to read
$agency->email = '"'. $_GET['email'] .'"';
// read the details of agency to be edited

$agency->readOne();
 
if($agency->email!=null){
    // create array
    $agency_arr = array(

        "agencyName" => $agency->agencyName,
        "type" => $agency->type,
        "email" => $agency->email,
        "phone" => $agency->phone,
        "password" => $agency->password
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($agency_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user agency does not exist
    echo json_encode(array("message" => "agency does not exist."));
}
?>