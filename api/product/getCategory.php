<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../resources/product.php';

$database = new Database();
$con = $database->getConnection();
 

$product=new Product($con);

$stmt=$product->getCategory();
$num = $stmt->rowCount();

if($num>0)
{
    $category_array=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $category=array("category_id"=>$category_id,
        "category_name"=>$category_name);
    
    array_push($category_array, $category);

}

http_response_code(200);

echo json_encode(($category_array));

}

else
{
    http_response_code(200);

    echo json_encode(array("data"=>"No Data Found")); 
}

?>
