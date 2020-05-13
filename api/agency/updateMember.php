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
 
$database = new Database();
$db = $database->getConnection();
 
$agency = new Agency($db);



    $agency->employeeEmail=$_POST["employee_email"];
    $agency->password = md5($_POST["employee_password"]);
    $agency->flag = 'True';
    
    // create the ag$agency
    if($agency->updateMember()){
 
        
        // set response code - 201 password
        http_response_code(201);
 
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