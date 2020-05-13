<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


$data_ids = $_REQUEST['data_ids'];
$data_id_array = explode(",", $data_ids); 
if(!empty($data_id_array)) {
	foreach($data_id_array as $id) {
		$sql = "UPDATE affiliates ";
		$sql.=" SET  status = 'Active' ";
		$sql.=" WHERE email = '".$id."'";
		$query=mysqli_query($conn, $sql) or die("employee-delete.php: delete employees");
	
	}
	foreach($data_id_array as $id)
	{
		$to=$id;
		$subject="Account has Been Activated";
		$headers="From:kubihalchetan@gmail.com@gmail.com" . "\r\n";
		$headers .= "Reply-To: ". "VERIFICATION" . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	   
	   
		$message  = '<h1>Account has been Activated</h1><br><br>';
		$message .= 'Write to us @ V-bridge.co.in or Contact 1111-2222-3333';
	
	   
		mail($to,$subject,$message,$headers);
	}
}

?>