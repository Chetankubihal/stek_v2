<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../resources/affiliate.php';


 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$affiliate = new Affiliate($db);

$stmt = $affiliate->getAllAffiliates();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $affiliate_arr=array();
    $affiliate_arr["data"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $affiliate_item=array(
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "contact" => $contact,
            "password" => $password
        );
 
        array_push($affiliate_arr["data"], $affiliate_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($affiliate_arr);
}
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No records found.")
    );
}

 