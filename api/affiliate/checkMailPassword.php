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
include_once '../config/email.php'
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare affiliate object
$affiliate = new Affiliate($db);
$email = new Mail();

 
// set email property of record to read
$affiliate->email = isset($_GET['email']) ? $_GET['email'] : die();
// read the details of affiliate to be edited

$stmt=$affiliate->checkEmail();



$num = $stmt->rowCount();

if($num > 0){

    $email->sendmail($_POST["email"]);


    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode(array("message" => "True"));
}
 
else{
    // set response code - 404 Not found 
    // tell the user affiliate does not exist
    echo json_encode(array("message" => "False"));
}
?>