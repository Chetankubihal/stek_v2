<?php

class Product{

private $conn;
private $table = 'products';

public $product_id;
public $product_SKU;   
public $product_HSN; 
public $product_name;
public $product_category;
public $product_sub_category;
public $product_description;
public $product_MRP;
public $product_selling_price;
public $merchant_id;
public $seller_email;
public $status;
public $package_length;
public $package_width;
public $package_breadth;
public $package_weight;


public function __construct($con)
{
    $this->conn = $con;
}

function addProduct()
{
    $query="INSERT INTO products(product_SKU,product_HSN,product_name,product_description,product_category,product_sub_category,seller_email,product_MRP,product_selling_price,package_length,package_width,package_breadth,package_weight) values (".$this->product_SKU.','.$this->product_HSN.','.$this->product_name.','.$this->product_description.','.$this->product_category.','.$this->product_sub_category.','.$this->seller_email.','.$this->product_MRP.','.$this->product_selling_price.','.$this->package_length.','.$this->package_width.','.$this->package_breadth.','.$this->package_weight.")";

  
    $stmt= $this->conn->prepare($query);

   if($stmt->execute())
   {
       //query to get last product id and increment by one
       $query1="SELECT MAX(product_id) as id from products where seller_email=".$this->seller_email;

       $stmt1=$this->conn->prepare($query1);

       if($stmt1->execute())
            {
                $row = $stmt1->fetch(PDO::FETCH_ASSOC);
                $this->product_id=$row['id'];
                $this->product_id=$row['product_SKU'];

                return true;
            }
        else 
            {
             return false;
            } 
   }

   else
   {
       return false;
   }

}

function getCategory()
{
    $query="SELECT * From category";

    $stmt= $this->conn->prepare($query);

   $stmt->execute();

   return $stmt;

}
function getSubCategory($category_id)
{
    $query="SELECT * From sub_category WHERE category_id=".$category_id;

    $stmt= $this->conn->prepare($query);

   $stmt->execute();

   return $stmt;

}

function readOne(){
 
    // query to read single record
     $query = "SELECT *
            FROM
                " . $this->table . "
            WHERE
                product_id = " . $this->product_id . "
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // execute query
    if ($stmt->execute())
 {
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    // $this->product_name = $row['product_name'];
    // $this->product_description = $row['product_description'];
    // $this->product_category = $row['product_category'];
    // $this->product_sub_category = $row['product_sub_category'];
    $this->product_MRP = $row['product_MRP'];
    $this->product_selling_price = $row['product_selling_price'];

    // $this->product_SKU = $row['product_SKU'];
    // $this->product_HSN = $row['product_HSN'];
    // $this->status = $row['status'];

    return true;
 }
 else
 {
     return false;
 }
    
  
}

function updateProduct()
{
    $query="Update products SET product_MRP=".$this->product_MRP.",product_selling_price=".$this->product_selling_price.",package_length=".$this->package_length.",package_width=".$this->package_width.",package_breadth=".$this->package_breadth.",package_weight=".$this->package_weight."WHERE  product_id=".$this->product_id."AND seller_email=".$this->seller_email;

  
    $stmt= $this->conn->prepare($query);

   if($stmt->execute())
   {
        return true;   
   }

   else
   {
       return false;
   }

}

function excelUpload($sheet_data,$seller_email)
{
   $flag=0;

    foreach ($sheet_data as $row)
    {
        if(!empty($row['C']) && $row['C']!='Name' )
        {

                $query='INSERT INTO products (product_SKU,product_HSN,product_name,product_description,product_category,product_sub_category,seller_email,product_MRP,product_selling_price,package_length,package_width,package_breadth,package_weight) values ("'.$row['A'].'","'.$row['B'].'","'.$row['C'].'","'.$row['D'].'","'.$row['E'].'","'.$row['F'].'","'.$seller_email.'","'.$row['G'].'","'.$row['H'].'","'.$row['I'].'","'.$row['J'].'","'.$row['K'].'","'.$row['L'].'") ';
                $stmt= $this->conn->prepare($query);

                if(!$stmt->execute())
                {
                     $flag++;   
                }

        }

    }

    return $flag;

}

}

?>