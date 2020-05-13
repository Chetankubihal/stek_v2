<?php
// required headers
header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';

include_once 'email.php';



 
// instantiate affiliate object
include_once '../resources/affiliate.php';
 
$database = new Database();
$db = $database->getConnection();
 
$email = new Mail();

$affiliate = new Affiliate($db);
 

// get posted data
//$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty

 
    // set affiliate property values
    /*$affiliate->firstName = $data->firstName;
    $affiliate->lastName = $data->lastName;
    $affiliate->email = $data->email;
    $affiliate->contact = $data->contact;
    $affiliate->password = $data->password;*/

    $affiliate->firstName = $_POST["first_name"];
    $affiliate->lastName = $_POST["last_name"];
    $affiliate->email = $_POST["email"];
    $affiliate->contact = $_POST["tel"];
    $affiliate->password = md5($_POST["password"]);
    $affiliate->code = $affiliate->generateAffiliateCode();

   // $affiliate->image = $_POST["image"];
   
    
    

    // create the affiliate
    if($affiliate->register()){
        
        $email->sendmail($_POST["email"]);
        
       // $affiliate->;
        // set response code - 201 password
        http_response_code(201);
        
       
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