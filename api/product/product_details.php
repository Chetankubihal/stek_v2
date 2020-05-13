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

$seller_email='"'.$_GET['seller_email'].'"';

$columns = array( 
// datatable column index  => database column name
	0 =>'product_id',
	1 =>'product_name', 
	2 => 'product_SKU',	
	3=> 'product_category',
    4=> 'product_sub_category'	
);

// getting total number records without any search
$sql = "SELECT product_id ";
$sql.=" FROM products";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT product_id,product_name,product_SKU,product_category,product_sub_category,status ";
$sql.=" FROM products WHERE seller_email=";
$sql.=$seller_email;

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( product_SKU LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR product_category LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR product_name LIKE '".$requestData['search']['value']."%' )";
	$sql.=" OR product_sub_category LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
//$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
$i=1+$requestData['start'];
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = "<input type='checkbox'  class='deleteRow' value='".$row['product_id']."'  /> #".$i ;
	$nestedData[] = $row["product_name"];
	$nestedData[] = $row["product_sku"];
	$nestedData[] = $row["product_category"];
    $nestedData[] = $row["product_sub_category"];
   
	
	

	if($row['status']=='Active')     
    $nestedData[] = "<span class='badge badge-success'>" . $row['status'] ."</span>";
	else if($row['status']=='Deactivated')
	$nestedData[] = "<span class='badge badge-danger'>" . $row['status'] ."</span>";
	else 
	$nestedData[] = "<span class='badge badge-warning'>" . $row['status'] ."</span>";

	$nestedData[]= "<button name='view' class=' btn' value='view' data-toggle='tooltip' title='View' onclick=loadmodal(" .'"' . $row['product_id'] .'"'. ") ><i class='icon-eye'></i></button>";

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
