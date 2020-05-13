<?php 

class Agency{

    private $conn;
    private $table = 'agency';

 

    public $type;
    public $agencyName;
    public $email;
    public $image_path;
    public $phone;
    public $password;
    public $flag;
    public $employeeEmail;
    public $role;

    public function __construct($con)
    {
        $this->conn = $con;
    }


    function getAllAgency(){
 
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

        agencyName = :agencyName,
        type = :type,
        email = :email,
        phone = :phone,
        password = :password";

        $stmt= $this->conn->prepare($query);

        $this->agencyName = htmlspecialchars(strip_tags($this->agencyName));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->password = htmlspecialchars(strip_tags($this->password));

        
        $stmt->bindParam(':agencyName',$this->agencyName);
        $stmt->bindParam(':type',$this->type);
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':phone',$this->phone);
        $stmt->bindParam(':password',$this->password);
        
        if($stmt->execute())
        {
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
        $this->agencyName = $row['agencyName'];
        $this->type = $row['type'];
        $this->email = $row['email'];
        $this->phone = $row['phone'];
        $this->password = $row['password'];
    }

    function getSellers($search)
    {
        
        $query = "SELECT sellerEmail FROM add_seller_agency WHERE agencyEmail= ".$this->email." AND status='Accepted'" ;
        

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        $seller_email_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['sellerEmail'];
            array_push($seller_email_arr, '"'.$row['sellerEmail'].'"');
        }
    
        $query1="SELECT * FROM  seller WHERE  email IN (".implode(',',$seller_email_arr).")";
        if( !empty($search) )
        {
        $query1.="AND sellerName = ".$search;
        $query1.="OR storeName =".$search;
        }

        
        $stmt1= $this->conn->prepare($query1);

        $stmt1->execute();

     return $stmt1;
     
    }
    
    function getSellerRequests($search)
    {
        $query = "SELECT sellerEmail FROM add_seller_agency WHERE agencyEmail= ".$this->email." AND status='Not Accepted'" ;
        

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        $seller_email_arr=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $row['sellerEmail'];
            array_push($seller_email_arr, '"'.$row['sellerEmail'].'"');
        }
    
        $query1="SELECT * FROM  seller WHERE  email IN (".implode(',',$seller_email_arr).")";
        $query1.="AND sellerName = ".$search;
        $query1.="OR storeName =".$search;


        $stmt1= $this->conn->prepare($query1);

        $stmt1->execute();

     return $stmt1;
     
    }

    function acceptSellerRequest($sellerEmail,$agencyEmail)
    {
        $query="UPDATE add_seller_agency SET status = 'Accepted' WHERE sellerEmail=".$sellerEmail."AND agencyEmail=".$agencyEmail;
        
        $stmt=$this->conn->prepare($query);

        if($stmt->execute())
        {
            return true;

        }

        else 
        {
            return false;
        }

    }
    
    function rejectSellerRequest($sellerEmail,$agencyEmail)
    {
        $query="DELETE FROM add_seller_agency WHERE sellerEmail=".$sellerEmail."AND agencyEmail=".$agencyEmail;
        
        $stmt=$this->conn->prepare($query);

        if($stmt->execute())
        {
            return true;

        }

        else 
        {
            return false;
        }

    }
    
    function deleteSeller($sellerEmail,$agencyEmail)
    {
        $query="DELETE FROM add_seller_agency WHERE sellerEmail=".$sellerEmail."AND agencyEmail=".$agencyEmail;
        
        $stmt=$this->conn->prepare($query);

        if($stmt->execute())
        {
            return true;

        }

        else 
        {
            return false;
        }

    }

    function update()
        {
            $query = "UPDATE
            " . $this->table . "
              SET
                 agencyName = :agencyName,
                 type = :type,
                 password = :password,
                 phone = :phone,
                 email = :email
              WHERE
                 email = :email";
    
    // prepare query statement
                $stmt = $this->conn->prepare($query);
    
    // sanitize
                $this->agencyName=htmlspecialchars(strip_tags($this->agencyName));
                $this->type=htmlspecialchars(strip_tags($this->type));
                $this->email=htmlspecialchars(strip_tags($this->email));
                $this->phone=htmlspecialchars(strip_tags($this->phone));
                $this->password=htmlspecialchars(strip_tags($this->password));
    
    // bind new values
                $stmt->bindParam(':agencyName', $this->agencyName);
                $stmt->bindParam(':type', $this->type);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':phone', $this->phone);
                $stmt->bindParam(':password', $this->password);
    
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
        
    
    function checkEmployeeEmail(){
     
        // query to read single record
         $query = "SELECT * FROM agency_employees
                WHERE
                    employeeEmail = " . $this->email ;
     
        // prepare query statement

        $stmt = $this->conn->prepare($query);
     
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
    function login(){
 
         
        $query = "SELECT * FROM agency_employees 
               WHERE password = " . $this->password . " AND  employeeEmail= " . $this->employeeEmail ;
    
       // prepare query statement
    
       $stmt = $this->conn->prepare($query);
    
    
       // execute query
       $stmt->execute();
        
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
       
       
       $this->role = $row['role'];
       $this->image_path=$row['image_path'];

       
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
            email =".$this->employeeEmail;

// prepare query statement
            $stmt = $this->conn->prepare($query);
   

// execute the query
        if($stmt->execute()){
            return true;
            }

        return false;
}

    function checkVerified(){
 
         
//        $query = "SELECT *  FROM " .$this->table. " WHERE status = 'Active' AND email IN (SELECT email FROM agency_employees WHERE employeeEmail= " . $this->employeeEmail . " AND password = ". $this->password .")";  
    
$query = "SELECT *  FROM " .$this->table. " WHERE status = 'Active' AND email IN (SELECT email FROM agency_employees WHERE employeeEmail= " . $this->employeeEmail . ")"; 

       $stmt = $this->conn->prepare($query);
    
    
       // execute query
       $stmt->execute();
    
       return $stmt;
    
    }
    
    function verify()
    {
        
    
        $query = "UPDATE " . $this->table ."
          SET
             status = 'Active'
          WHERE
             email = :email ";
    
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
    function updatePassword()
    {

       

        $query = "UPDATE agency_employees SET     
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
function updateMember()
    {


      
        $query="UPDATE agency_employees SET
         password = :password,
         flag = :flag
          WHERE
          employeeEmail = :employeeEmail";

        $stmt= $this->conn->prepare($query);

        
        
        $stmt->bindParam(':employeeEmail',$this->employeeEmail);
        $stmt->bindParam(':flag',$this->flag);
        $stmt->bindParam(':password',$this->password);
        
        if($stmt->execute())
        {
            return true;
        }

        return false;
       
    }
    function addMember()
    {
        $query="INSERT INTO " .'agency_employees'. "

        SET 

        
        email = :email,
        employeeEmail = :employeeEmail,
        role = :role";
       

        $stmt= $this->conn->prepare($query);

       

        
       
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':employeeEmail',$this->employeeEmail);
        $stmt->bindParam(':role',$this->role);


    
        
        if($stmt->execute())
        {
            return true;
        }

        return false;
       
    }

    function change_profile_picture($image_name)
    {
    
        $query = "UPDATE ".'agency_employees'." SET image_path = "."'".$image_name."'"." WHERE employeeEmail = "."'".$this->employeeEmail."'";
        
        $stmt = $this->conn->prepare($query);
    
        if($stmt->execute()){
    
            return true;
            
            }
        return false;
    
    }
   
    }

?>



