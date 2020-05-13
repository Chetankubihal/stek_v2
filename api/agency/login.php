<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../resources/agency.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare agency object
$agency = new Agency($db);
 
// set email property of record to read



$agency->employeeEmail= '"'. $_POST['email'] .'"';
$agency->password= '"'. md5($_POST['password']) .'"';

$stmt1=$agency->checkVerified();
if(($stmt1->rowCount())>0)
{

$stmt=$agency->login();
$num = $stmt->rowCount();

if($num > 0){

    $agency->updateLoginTime();
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode(array("message" => "True","username" =>$_POST['email'],"role" => $agency->role,"image_path"=>$agency->image_path));
}   
 
else{
    // set response code - 404 Not found 
    // tell the user agency does not exist
    echo json_encode(array("message" => "False"));
}
}
else
{
    echo json_encode(array("message" => "Not Verified"));
}


?>