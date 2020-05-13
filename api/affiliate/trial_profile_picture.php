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
$target_dir = "uploads/";

//get file extension
$imageFileType = strtolower(pathinfo(basename($_FILES["image"]["name"]),PATHINFO_EXTENSION));// refer for explaination https://www.geeksforgeeks.org/php-pathinfo-function/

//tokenize email to use it as image name and concatenate file extension
$image_name=strtok($affiliate->email,'@').".".$imageFileType;


//wonderful line here FOCUS HERE


 print_r($_FILES) ; //this will give contents of FILE .i.e Array as name at the beginning.....see output for clear..it is MULTI DIMENSIONAL ARRAY


print_r ($_FILES['image']); //previous will give whole array posted from $_FILES... out of that we take only from input field with name as image..

print_r($_FILES['image2']);// from image2

print_r($_FILES['image']['name']);//from image array we take name array

print_r($_FILES['image']['name'][0]);// will print name of file of FIRST IMAGE from name sub array which is element of image array

print_r($_FILES['image']['type'][0]);//will print type of the  first image in IMAGE ARRAY from input field with name as image[]

print_r(array_keys($_FILES)); // will give keys as image and image2 

print_r(array_keys($_FILES['image']));//will give keys again inside image ARRAY

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