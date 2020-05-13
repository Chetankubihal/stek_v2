<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php'; 
include_once '../resources/agency.php';
 
$database = new Database();
$db = $database->getConnection();
 
$agency = new Agency($db);


$idEmail= $_POST['add_email'];
$agencyMail=$_POST['email'];
 $to=$idEmail;
 $subject="Accept the invitation ";
 $headers="From:kubihalchetan@gmail.com@gmail.com" . "\r\n";
 $headers .= "Reply-To: ". "VERIFICATION" . "\r\n";
 $headers .= "MIME-Version: 1.0\r\n";
 $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


 $message  = '<h1>Click here to Accept the invitation</h1><br><br>';
 $message .= 'http://localhost/stackadmin-30/stackadmin-30/stack-admin-3.0/html/ltr/horizontal-menu-template/add_member_password.php?email=';
 $message .= $idEmail; 
 $message .= '&agencyMail=';
 $message .= $agencyMail ;   

 mail($to,$subject,$message,$headers);
 // get database connection




$agency->email = $_POST["email"];
$agency->employeeEmail = $_POST["add_email"];
$agency->role='employee';
$agency->addMember();

?>
