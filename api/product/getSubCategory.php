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

$category_id=$_GET['category_id'];


$stmt=$product->getSubCategory($category_id);
$num = $stmt->rowCount();

if($num>0)
{
    $category_array=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $category=array("sub_category_id"=>$sub_category_id,
        "sub_category_name"=>$sub_category_name);
    
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
