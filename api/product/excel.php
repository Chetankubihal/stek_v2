<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'phpexcel/PHPExcel/IOFactory.php';

include_once '../config/database.php';
 
// instantiate ag$products object
include_once '../resources/product.php';
 
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);


    
    if(isset($_POST['upload_excel']))
    {
        $seller_email="'". $_POST['seller_email'] ."'";

        $file_directory = "uploads/bulk_upload_excel/".$_POST['seller_email']."/";
        if(!is_dir($file_directory)){
            //Directory does not exist, so lets create it.
            mkdir($file_directory);
        }
        
        $file_info = $_FILES["result_file"]["name"];
        $new_file_name = date("dmY")."_".time().".xlsx" ;
        move_uploaded_file($_FILES["result_file"]["tmp_name"], $file_directory . $new_file_name);
         
        $file_type	= PHPExcel_IOFactory::identify($file_directory . $new_file_name);
        $objReader	= PHPExcel_IOFactory::createReader($file_type);
        $objPHPExcel = $objReader->load($file_directory . $new_file_name);
        $sheet_data	= $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

        $count=$product->excelUpload($sheet_data,$seller_email);

        if($count==0)
        {
            http_response_code(200);
            echo json_encode(array("message"=>"True"));
        }
        else{
            http_response_code(200);
            echo json_encode(array("message"=>"False","count"=>$count));
        }
        


    }
?>