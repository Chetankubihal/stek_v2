<?php 

class Affiliate{

    private $conn;
    private $table = 'affiliates';

 
    public $firstName;
    public $lastName;
    public $email;
    public $contact;
    public $password;
    public $image_path;
    public $flag;
    public $status;
    public $code;
    public function __construct($con)
    {
        $this->conn = $con;
    }


    function getAllAffiliates(){
 
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

        firstName = :firstName,
        lastName = :lastName,
        email = :email,
        contact = :contact,
        password = :password,
        code = :code ";

        $stmt= $this->conn->prepare($query);

        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->contact = htmlspecialchars(strip_tags($this->contact));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':firstName',$this->firstName);
        $stmt->bindParam(':lastName',$this->lastName);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':contact',$this->contact);
        $stmt->bindParam(':password',$this->password);
        $stmt->bindParam(':code',$this->code);
       // $stmt->bindParam(':image',$this->image);

        
       

        if($stmt->execute())
        {
            return true;
        }

        return false;
       
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
    $this->firstName = $row['firstName'];
    $this->lastName = $row['lastName'];
    $this->email = $row['email'];
    $this->contact = $row['contact'];
    $this->code = $row['code'];
    $this->image = $row['image'];
    $this->date = $row['date'];
    $this->loginTime = $row['loginTime'];

    
}

function readImage(){
 
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
    // $this->firstName = $row['firstName'];
    // $this->lastName = $row['lastName'];
     $this->email = $row['email'];
    // $this->contact = $row['contact'];
    // $this->password = $row['password'];
     $this->image = $row['image'];

    
}
function update()
    {
        $query = "UPDATE
        " . $this->table . "
          SET
             firstName = :firstName,
             lastName = :lastName,
             contact = :contact,
             email = :email
          WHERE
             email = :email";

// prepare query statement
            $stmt = $this->conn->prepare($query);
           
// sanitize
            $this->firstName=htmlspecialchars(strip_tags($this->firstName));
            $this->lastName=htmlspecialchars(strip_tags($this->lastName));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->contact=htmlspecialchars(strip_tags($this->contact));


// bind new values
            $stmt->bindParam(':firstName', $this->firstName);
            $stmt->bindParam(':lastName', $this->lastName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':contact', $this->contact);
           

// execute the query
        if($stmt->execute()){
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
    


 
    function checkVerified(){
 
         
            
        $query = "SELECT *  FROM " .$this->table. " WHERE status = 'Active' AND email=" . $this->email; 
        
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
       $this->code = $row['code'];
       $this->status=$row['status'];
       $this->image_path=$row['image_path'];
     
      // echo($code);
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
function generateAffiliateCode() {

    $n=8;
    // Take a OTPgenerator string which consist of
    // all numeric digits
    
    $linkGenerator = "ABCDEF790246GHIJKLMNOPQRSTUVWXYZ1358";
    
    // Iterate for n-times and pick a single character
    // from OTPgenerator and append it to $result
    
    // Login for generating a random character from OTPgenerator
    // ---generate a random number
    // ---take modulus of same with length of OTPgenerator (say i)
    // ---append the character at place (i) from OTPgenerator to result
    
    $result = "";
    
    for ($i = 1; $i <= $n; $i++) {
    $result .= substr($linkGenerator, (rand()%(strlen($linkGenerator))), 1);
    }
    
    // Return result
    return $result;
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

    



