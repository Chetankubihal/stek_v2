<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


include_once '../config/database.php';
include_once '../resources/agency.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare affiliate object
$agency = new Agency($db);
 
// set email property of record to read



$email= base64_decode(urldecode($_GET['email'])) ;
    
$agency->flag='True';
$agency->email=$email;


  if( $agency->verify())
 {   
    // set response code - 200 OK
    http_response_code(200);
 

    header("Location:http://localhost/stackadmin-30/stackadmin-30/stack-admin-3.0/html/ltr/horizontal-menu-template/login-advanced.php");
}
 else 
 {
    http_response_code(404);
 
    // make it json format
    echo json_encode(array("message" => "False"));
 }

?>