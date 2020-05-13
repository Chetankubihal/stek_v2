<?php 

class Seller{

    private $conn;
    private $table = 'seller';

 
    public $email;
    public $sellerName;
    public $storeName;
    public $type;
    public $contact;
    public $password;
    public $image_path;
    public $affiliateCode;
    public $status;
    public $flag;

    public function __construct($con)
    {
        $this->conn = $con;
    }


    function getAllSeller(){
 
        // select all query
        $query="SELECT * FROM " . $this->table ;

        $stmt= $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function register()
    {
        $query="INSERT INTO " . $this->table  ."

        SET 

        email = :email,
        sellerName = :sellerName,
        storeName = :storeName,
        type = :type,
        password = :password,
        contact = :contact,
        affiliateCode = :affiliateCode";

        $stmt= $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->sellerName = htmlspecialchars(strip_tags($this->sellerName));
        $this->storeName = htmlspecialchars(strip_tags($this->storeName));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->password = htmlspecialchars(strip_tags($this->password));


        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':sellerName',$this->sellerName);
        $stmt->bindParam(':storeName',$this->storeName);
        $stmt->bindParam(':type',$this->type);
        $stmt->bindParam(':contact',$this->contact);
        $stmt->bindParam(':password',$this->password);
        $stmt->bindParam(':affiliateCode',$this->affiliateCode);
        
        if($stmt->execute())
        {
            return true;
        }

        return false;
       
    }

    
    function checkEmail(){
     
        // query to read single record
         $query = "SELECT *
                FROM
                    " . $this->table . "
                WHERE
                    email = " . $this->email ;
     
        // prepare query statement

        $stmt = $this->conn->prepare($query);
     
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    

function update()
    {
        $query = "UPDATE
        " . $this->table . "
          SET
             sellerName = :sellerName,
             storeName = :storeName,
             contact = :contact,
             type = :type,
             email = :email
          WHERE
             email = :email";

// prepare query statement
            $stmt = $this->conn->prepare($query);

// sanitize
            $this->storeName=htmlspecialchars(strip_tags($this->storeName));
            $this->sellerName=htmlspecialchars(strip_tags($this->sellerName));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->contact=htmlspecialchars(strip_tags($this->contact));
            $this->type=htmlspecialchars(strip_tags($this->type));


// bind new values
            $stmt->bindParam(':storeName', $this->storeName);
            $stmt->bindParam(':sellerName', $this->sellerName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':contact', $this->contact);


// execute the query
        if($stmt->execute()){
            return true;
            }

        return false;
}

    

function updateLoginTime()
    {   
        date_default_timezone_set("Asia/Kolkata"); 
        $date = new DateTime("NOW");
        $loginTime= '"' . $date->format('Y-m-d H:i:s') .'"';

        $query = "UPDATE
        " . $this->table . "
          SET
            loginTime = " . $loginTime. "
            WHERE
            email =".$this->email;

// prepare query statement
            $stmt = $this->conn->prepare($query);
   

// execute the query
        if($stmt->execute()){
            return true;
            }

        return false;
}
    function login(){
 
         
        $query = "SELECT *
               FROM
                   " . $this->table . "
               WHERE password = " . $this->password . " AND  email= " . $this->email ;
    
       // prepare query statement
    
       $stmt = $this->conn->prepare($query);
    
    
       // execute query
       $stmt->execute();
    
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
       // set values to object properties
       $this->sellerName = $row['sellerName'];
       $this->status =$row['status'];
       $this->image_path=$row['image_path'];
       
       return $stmt;

    }

    function register_insert_verified()
    {

        $query="INSERT INTO  verified

        SET 
        email = :email";
           

        $stmt= $this->conn->prepare($query);

     
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':email',$this->email);
      

        
        $stmt->execute();
    
       
    }
    function checkVerified(){
 
         
        $query = "SELECT *
               FROM
                   verified 
               WHERE flag = 'True' AND  email= " . $this->email ;
    
       // prepare query statement
    
       $stmt = $this->conn->prepare($query);
    
    
       // execute query
       $stmt->execute();
    
       return $stmt;
    
    }
    function verifyAccount($email,$otp){
 
         
        $query = "SELECT *
               FROM
                   otp 
               WHERE email = " . $email . " AND  otp= " . $otp ;
    
       // prepare query statement
    
       $stmt = $this->conn->prepare($query);
    
    
       // execute query
       $stmt->execute();
    
       return $stmt;
    
    }

    function verify()
    {
        
    
       
    $query = "UPDATE ".$this->table." 
    SET
       status = 'Active'
    WHERE
       email = :email";

// prepare query statement
      $stmt = $this->conn->prepare($query);
     
// sanitize
      
      $this->email=htmlspecialchars(strip_tags($this->email));

// bind new values
      $stmt->bindParam(':email', $this->email);
    
// execute the query
$stmt->execute();

return $stmt;   
    }
    function checkPassword()
{
   
 
         
        $query = "SELECT *
               FROM
                   " . $this->table . "
               WHERE password = " . $this->password . " AND  email= " . $this->email ;
    
       // prepare query statement
    
       $stmt = $this->conn->prepare($query);
    
    
       // execute query
       $stmt->execute();
    
       return $stmt;


}
function updatePassword()
{

   

    $query = "UPDATE
    " . $this->table . "
      SET     
         password = :password
          WHERE
         email = :email";

// prepare query statement
        $stmt = $this->conn->prepare($query);
       
// sanitize
       
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));

// bind new values
       
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

// execute the query
    if($stmt->execute()){
        return true;
        }

    return false;
}
function readOne(){
 
    // query to read single record
     $query = "SELECT *
            FROM
                " . $this->table . "
            WHERE
                email = " . $this->email . "
            LIMIT
                0,1";
 
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
 
    // bind id of product to be updated
    $stmt->bindParam(1, $this->email);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->storeName = $row['storeName'];
    $this->sellerName = $row['sellerName'];
    $this->type = $row['type'];
    $this->email = $row['email'];
    $this->contact = $row['contact'];
    $this->password = $row['password'];
}

function addAgency($agencyEmail)
{

    $query="INSERT INTO add_seller_agency (sellerEmail,agencyEmail) values ($agencyEmail,$this->email)";  
    $stmt = $this->conn->prepare( $query );

if($stmt->execute())
{
    return true;
}

return false;

}

function change_profile_picture($image_name)
{

    $query = "UPDATE ".$this->table." SET image_path = "."'".$image_name."'"." WHERE email = "."'".$this->email."'";



    $stmt = $this->conn->prepare($query);

    if($stmt->execute()){

        return true;
        
        }
    return false;

}
}

?>

    



