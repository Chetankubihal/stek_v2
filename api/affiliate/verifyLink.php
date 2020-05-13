<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


include_once '../config/database.php';
include_once '../resources/affiliate.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare affiliate object
$affiliate = new Affiliate($db);
 
// set email property of record to read



$email= base64_decode(urldecode($_GET['email'])) ;
    
$affiliate->flag='True';
$affiliate->email=$email;


  if( $affiliate->verify())
 {   
    // set response code - 200 OK
    http_response_code(200);
 

    header("Location:http://localhost/stek1/stackadmin-30/stack-admin-3.0/html/ltr/horizontal-menu-template/user-profile.php");
}
 else 
 {
    http_response_code(404);
 
    // make it json format
    echo json_encode(array("message" => "False"));
 }

?>