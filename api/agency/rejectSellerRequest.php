<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 

include_once '../config/database.php';
include_once '../resources/agency.php';
$database=new Database();

$conn=$database->getConnection();

$agency=new Agency($conn);

$agencyEmail =  $_GET['agencyEmail'] ;
$sellerEmail =  $_GET['sellerEmail'] ;


if($agency->rejectSellerRequest($sellerEmail,$agencyEmail))

{
    http_response_code(200);
 
    // show products data in json format
    echo json_encode(array("message" => "True"));
}

else
{
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(array("message" => "False")
    );
}
?>
