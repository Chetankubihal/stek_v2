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

$agency->email =  $_GET['email'] ;

if(isset($_GET['search']))
    $search=$_GET['search'];
else 
    $search="";

$stmt=$agency->getSellerRequests($search);

if($stmt->rowCount()>0)

{
    $seller_arr=array();
    $seller_arr["records"]=array();
    $seller_arr['count']=$stmt->rowCount();

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
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($seller_arr);
}

else
{
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No records found.")
    );
}
?>
