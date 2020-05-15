<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../resources/product.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$product = new Product($db);

$product->product_SKU= $_POST['product_SKU'] ;
$product->seller_email= $_POST['seller_email'] ;


//tokenize email to use it as image name
//$image_name=strtok($product->email,'@');

//set target directory

 $target_dir = getcwd().'\\product_images\\'.$product->seller_email.'\\'.$product->product_SKU.'\\';




//get file extension

//tokenize email to use it as image name and concatenate file extension
//$image_name=strtok($affiliate->email,'@').".".$imageFileType;

$count_of_images=count($_FILES['image']['name']);
$count_of_success=0;
for($i=0;$i<$count_of_images;$i++)
{

    $imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"][0]),PATHINFO_EXTENSION));

   
    {
       
        $uploadOk = 1;
        $error_flag;
    
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"][$i]);
            if($check !== false) {
                
                $uploadOk = 1;
            } else {
               // echo "File is not an image.";
               $error_flag=1;
                $uploadOk = 0;
            }
        }
      
        // file size restricted to 10MB
        if ($_FILES["image"]["size"][$i] > 10485760 ) {
           // echo "Sorry, your file is too large.";
           $error_flag=2;
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $error_flag=3;
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            if($error_flag==1)
            echo json_encode(array("message" => "error1"));// error1=>file not image
           else if($error_flag==2)
           echo json_encode(array("message" => "error2"));
           else if($error_flag==3)
           echo json_encode(array("message" => "error3"));
           
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"][$i],$target_dir.$_FILES["image"]["name"][$i]) ) {
    
                $count_of_success+=1;
                
            }
            //  else {
            //     echo json_encode(array("message" => "failed"));// failed because of server directory
            // }
        }
    }
 
}
echo json_encode(array("message" => "success","count"=>$count_of_success));



?>