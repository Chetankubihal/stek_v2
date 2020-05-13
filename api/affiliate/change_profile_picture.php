<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../resources/affiliate.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare affiliate object
$affiliate = new Affiliate($db);
$affiliate->email= $_POST['email'] ;

//tokenize email to use it as image name
$image_name=strtok($affiliate->email,'@');

//set target directory
$target_dir = "profile pictures/";

//get file extension
$imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION));

//tokenize email to use it as image name and concatenate file extension
$image_name=strtok($affiliate->email,'@').".".$imageFileType;


if($affiliate->change_profile_picture($image_name))
{
   
    $uploadOk = 1;
    $error_flag;

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            
            $uploadOk = 1;
        } else {
           // echo "File is not an image.";
           $error_flag=1;
            $uploadOk = 0;
        }
    }
  
    // file size restricted to 10MB
    if ($_FILES["image"]["size"] > 10485760 ) {
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
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$image_name)) {

            echo json_encode(array("message" => "upload success"));
        } else {
            echo json_encode(array("message" => "upload failed"));// failed because of server directory
        }
    }
}
else{

    echo json_encode(array("message" => "upload failed"));// failed because of database or query error
    
}

?>