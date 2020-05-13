<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../resources/affiliate.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare affiliate object
$affiliate = new Affiliate($db);
 
// set email property of record to read
$affiliate->email = '"'. $_GET['email'] .'"';
// read the details of affiliate to be edited

$affiliate->readOne();
 
if($affiliate->email!=null){
    // create array
    $affiliate_arr = array(
        "email" =>  $affiliate->email,
        "firstName" => $affiliate->firstName,
        "lastName" => $affiliate->lastName,
        "contact" => $affiliate->contact,
        "code" => $affiliate->code,
        "date" =>$affiliate->date,
        "loginTime"=>$affiliate->loginTime,
        //"image" => $affiliate->image
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($affiliate_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user affiliate does not exist
    echo json_encode(array("message" => "affiliate does not exist."));
}
?>