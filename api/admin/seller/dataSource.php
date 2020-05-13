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


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	
	0 =>'sellerName', 
	1 => 'sellerName',
	2=> 'storeName',
	3=> 'type',
	4=> 'status'
);

// getting total number records without any search
$sql = "SELECT email ";
$sql.=" FROM seller";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT sellerName, email,storeName, type,status ";
$sql.=" FROM seller WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( email LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR sellerName LIKE '".$requestData['search']['value']."%' ";

	$sql.=" OR storeName LIKE '".$requestData['search']['value']."%' )";
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

	$nestedData[] = "<input type='checkbox'  class='deleteRow' value='".$row['email']."'  /> #".$i ;
	$nestedData[] = $row["sellerName"];
	$nestedData[] = $row["storeName"];
	$nestedData[] = $row["type"];
	
	if($row['status']=='Active')     
    $nestedData[] = "<span class='badge badge-success'>" . $row['status'] ."</span>";
	else if($row['status']=='Deactivated')
	$nestedData[] = "<span class='badge badge-danger'>" . $row['status'] ."</span>";
	else
	$nestedData[] = "<span class='badge badge-warning'>" . $row['status'] ."</span>";
	
	$nestedData[]= "<input type='button' name='view' value='view' onclick=sellerDashboard(" .'"' . $row['email'] .'"'.','.'"'. $row['sellerName'] .'"'. ") >";

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
