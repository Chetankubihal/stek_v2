<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 

$email=$_GET['email'];

$to=$email;
$subject="Password has Been changed";
$headers="From:kubihalchetan@gmail.com@gmail.com" . "\r\n";
$headers .= "Reply-To: ". "VERIFICATION" . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message .= '<h1>Password has Been changed</h1>';
$message  = '<h3>If it was Not you Please click the link Below to Deactivate your Account</h1><br><br>';
$message .= 'http://localhost/stek_v2/api/admin/affiliate/statusDeactive.php?data_ids=';
$message .= $email;
$message .= 'Write to us @ V-bridge.co.in or Contact 9481010728';


mail($to,$subject,$message,$headers);

?>
