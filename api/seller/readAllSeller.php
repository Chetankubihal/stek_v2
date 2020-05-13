<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../resources/seller.php';


 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$seller = new Seller($db);

$stmt = $seller->getAllSeller();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
   
    $seller_arr=array();
    $seller_arr["records"]=array();
    $seller_arr['count']=$num;
    // retrieve our table contents
    // fetch() is faster than fetchAll()

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
      

        $seller_item=array(
            "storename" => $storeName,
            "sellername" => $sellerName,
            "type" => $type,
            "email" => $email,
            "contact" => $contact,
            "password" => $password
        );
 
        array_push($seller_arr["records"], $seller_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($seller_arr);
}
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No records found.")
    );
}

 