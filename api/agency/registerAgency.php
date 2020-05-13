<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate ag$agency object
include_once '../resources/agency.php';
include_once 'email.php';
 
$database = new Database();
$db = $database->getConnection();
 
$agency = new Agency($db);

$email = new Mail();

// get posted data

// make sure data is not empty

 
    // set ag$agency property values
    $agency->type =$_POST["type"];
    $agency->agencyName = $_POST["agencyName"];
    $agency->email = $_POST["email"];
    $agency->phone =$_POST["phone"];
    $agency->password = md5($_POST["password"]);
    $agency->employeeEmail= $_POST["email"];
    
    
    // create the ag$agency
    if($agency->register()){
 
        $email->sendmail($_POST["email"]);

        
        // set response code - 201 password
        http_response_code(201);
        $agency->flag='True';
        $agency->role='admin';

        $agency->addMember();
        $agency->updateMember();
        // tell the user
        echo json_encode(array("message" => "True"));
    }
 
    // if unable to create the ag$agency, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Registration Failed."));
    }

 
// tell the user data is incomplete
?>