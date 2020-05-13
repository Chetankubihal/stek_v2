<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../resources/seller.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare seller object
$seller = new Seller($db);
 
// set email property of record to read



$seller->email= '"'. $_POST['email'] .'"';
$seller->password= '"'. md5($_POST['password']) .'"';


$stmt=$seller->login();
$num = $stmt->rowCount();

if($num > 0){

    $seller->updateLoginTime();
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode(array("message" => "True", "sellerName" => $seller->sellerName,"status" => $seller->status,"image_path"=>$seller->image_path));
}
 
else{
    // set response code - 404 Not found 
    // tell the user seller does not exist
    echo json_encode(array("message" => "False"));
}


?>