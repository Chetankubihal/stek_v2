<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate affiliate object
include_once '../resources/seller.php';

include_once 'email.php';
 
$database = new Database();
$db = $database->getConnection();
 
$seller = new Seller($db);
$email = new Mail();


    $seller->email = $_POST["email"];
    $seller->sellerName = $_POST["sellerName"];
    $seller->storeName = $_POST["storeName"];
    $seller->type = $_POST["type"];
    $seller->contact = $_POST["contact"];
    $seller->password = md5($_POST["password"]);
    $seller->affiliateCode = $_POST["affiliateCode"];
    
 
    // create the affiliate
    if($seller->register()){
 
        $email->sendmail($_POST["email"]);

        $seller->register_insert_verified();
        // set response code - 200 password
        http_response_code(200);
 
        // tell the user
        echo json_encode(array("message" => "True"));
    }
 
    // if unable to create the affiliate, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Registration Failed."));
    }

 
// tell the user data is incomplete
?>