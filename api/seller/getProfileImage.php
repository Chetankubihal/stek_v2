
<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

$connect = mysqli_connect("localhost", "root", "", "vbridge");  

            $query = "SELECT * FROM tbl_images ORDER BY id DESC LIMIT 1 ";  
            $result = mysqli_query($connect, $query); 
          ($row= mysqli_fetch_array($result));
            echo json_encode(array("message" => $row['name']));

        ?>