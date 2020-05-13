<?php
class OTP{

private $table='otp';
public $email;
public $otp;

public function __construct($con)
{
    $this->conn = $con;
}

// Function to generate OTP
function generateNumericOTP() {

$n=6;
// Take a OTPgenerator string which consist of
// all numeric digits
$OTPgenerator = "1357902468";
$linkGenerator = "abcd13579fghijklmnop02468eqrstuvwxyz";

// Iterate for n-times and pick a single character
// from OTPgenerator and append it to $result

// Login for generating a random character from OTPgenerator
// ---generate a random number
// ---take modulus of same with length of OTPgenerator (say i)
// ---append the character at place (i) from OTPgenerator to result

$result = "";

for ($i = 1; $i <= $n; $i++) {
$result .= substr($OTPgenerator, (rand()%(strlen($OTPgenerator))), 1);
}

// Return result
return $result;
}


    
function saveOTP()

    {
        $query="INSERT INTO " . $this->table  ."

        SET 

        email = :email,
        otp = :otp";

        $stmt= $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->otp = htmlspecialchars(strip_tags($this->otp));

       
        $stmt->bindParam(':email',$this->email);
        $stmt->bindParam(':otp',$this->otp);
        
        if($stmt->execute())
        {
            return true;
        }

        return false;
       
    }
//     function resendOTP()

//     {
//     $query = "UPDATE
//     " . $this->table . "
//       SET
        
//          otp = :otp
//       WHERE
//          email = :email";

// // prepare query statement
//         $stmt = $this->conn->prepare($query);

// // sanitize
      
//         $this->email=htmlspecialchars(strip_tags($this->email));
//        $this->otp=htmlspecialchars(strip_tags($this->otp));

// // bind new values
        
//         $stmt->bindParam(':email', $this->email);
//         $stmt->bindParam(':otp', $this->otp);

// // execute the query
//     if($stmt->execute()){
//         return true;
//         }

//     return false;
// }
       

}

?> 