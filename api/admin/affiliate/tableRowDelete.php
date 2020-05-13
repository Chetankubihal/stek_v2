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
		$sql = "DELETE FROM affiliates ";
		$sql.=" WHERE email = '".$id."'";
		$query=mysqli_query($conn, $sql) or die("employee-delete.php: delete employees");
	}
}
?>