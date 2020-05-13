<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vbridge";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$email = '"'. $_GET['email'] .'"';

$columns = array( 
// datatable column index  => database column name

    0 =>'employeeEmail', 
	1=> 'password'
);

// getting total number records without any search
$sql = "SELECT employeeEmail ";
$sql.=" FROM agency_employees";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT  employeeEmail, flag  ";
$sql.=" FROM agency_employees WHERE email = $email";	
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( employeeEmail LIKE '".$requestData['search']['value']."%') ";    

}
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = "<input type='checkbox'  class='deleteRow' value='".$row['employeeEmail']."'  /> #".$i ;
	$nestedData[] = $row["employeeEmail"];	
	if($row["flag"]=='True')
	$nestedData[] = "<span class='badge badge-success'>Accepted</span>";
	else
	$nestedData[] = "<span class='badge badge-danger'>Pending</span>";
    $data[] = $nestedData;
    
	$i++;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
