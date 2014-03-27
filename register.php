<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
require 'functions.php';
?>
        <section id="MainContent">            

<?php

$error = ""; //initialize error variable to nothing.
$outputError = "";

//when the website/webpage first loaded, initialize all the variable except $user_type to nothing. 
//Initialize $user_type to "u" meaning unregistered.
if($_SERVER["REQUEST_METHOD"] == "GET")
{

	$userName = "";
	$pass1 = "";
	$pass2 = "";
	$fname = "";  
	$lname = "";    
	$email = "";
	$phoneNumber = "";
    
    $cardType = ""; 
    $nameOnCard = "";  
    $cardNumber = "";   
    $month = "";
    $year = "";
    $expirationDate = "";   
    $securityCode = "";  
    
	$address = "";
	$city = "";
	$province = "";
	$postalCode = "";

    $user_type = "";
	$requiredIsInvalid = false;
} 

//once form is submitted, remove all whitespaces before and after each variable, 
//and do the validation before saving it to the database.
else if($_SERVER["REQUEST_METHOD"] == "POST"){

	$userName = trim ($_POST ["userName"]);
	$pass1 = trim ($_POST ["pass1"]);
	$pass2 = trim ($_POST ["pass2"]);   
	$fname = trim ($_POST ["fname"]);
	$lname = trim ($_POST ["lname"]);
    $email = trim ($_POST ["email"]);
	$phoneNumber = trim ($_POST ["phoneNumber"]);  
    
    $cardType = trim ($_POST ["cardType"]);   
    $nameOnCard = trim ($_POST ["nameOnCard"]);   
    $cardNumber = trim ($_POST ["cardNumber"]);   
    $expirationDate = trim ($_POST ["expirationDate"]);    
    $securityCode = trim ($_POST ["email"]);  

	$address = trim ($_POST ["address"]);
	$city = ($_POST ["cities"]);
	$province = ($_POST ["provinces"]);
	$postal_code = trim ($_POST ["postal_code"]);

	$requiredIsInvalid = false;

	//USERNAME VALIDATION
	//function for id validation. this will return the value of $error.
	$error = validate_Username($userName);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $username = "";
		$requiredIsInvalid = true;
	}	
	else
	{
		$sql = "Select id FROM users WHERE id='".$userName."'";
		$result = pg_query($conn,$sql);
		$records = pg_num_rows($result);
			
		if ($records != 0)//if there's record
		{
			$outputError .= "Username <em>$id</em> already exists. Enter another username <br/>";
			echo $login = "";
			$requiredIsInvalid = true;
		}
	}

	//PASSWORD VALIDATION
	$error = validate_Pass($pass1, $pass2);
	if (!$error == "")
	{
		$outputError .= $error;
		$requiredIsInvalid = true;
	}

	//EMAIL VALIDATION
	
	$error = validate_Email($email);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $email = "";
		$requiredIsInvalid = true;
	}
		
	//FIRSTNAME VALIDATION	
	
	$error = validate_First_Name($fname);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $fname = "";
		$requiredIsInvalid = true;
	}

	//LASTNAME VALIDATION
	$error = validate_Last_Name($lname);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $lname = "";
		$requiredIsInvalid = true;
	}
	
	//PHONE NUMBER VALIDATION
	
	$error = validate_Phone($phoneNumber);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $phoneNumber = "";
		$requiredIsInvalid = true;
	}	

	$error = validate_CardType($cardType);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $cardType = "";
		$requiredIsInvalid = true;
	}		
    
	//NAME ON CARD HOLDER VALIDATION
    if ($nameOnCard != ""){
        $error = validate_NameOnCard($nameOnCard);
        if (!$error == "")
        {
            $outputError .= $error;
            echo $nameOnCard = "";
            $requiredIsInvalid = true;
        }  
    }
    
	//CARD NUMBER VALIDATION
    
    if($cardNumber != ""){
        $error = validate_CardNumber($cardNumber);
        if (!$error == "")
        {
            $outputError .= $error;
            echo $nameOnCard = "";
            $requiredIsInvalid = true;
        }     
    }
    
 	//Expiration Date VALIDATION
    
    if ($month != "")
    {
        if (($month < 0) || ($month > 12)){
            $error = "month must be between 1 - 12 <br/>";
            $output .= $error;
            echo $month = "";
            $requiredIsInvalid = true;
            }
    }
    
    if ($year != "")
    {
        if (($year < 14) ){
            $error = "year must not be less than 2014 <br/>";
            $output .= $error;
            echo $year = "";
            $requiredIsInvalid = true;
        }
    } 
    
    $expirationDate = $month ."/". $year;
    
 	$error = validate_ExpirationDate($expirationDate);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $nameOnCard = "";
		$requiredIsInvalid = true;
	}  
 
	//CARD NUMBER VALIDATION
 	$error = validate_CardNumber($cardNumber);
	if (!$error == "")
	{
		$outputError .= $error;
		echo $nameOnCard = "";
		$requiredIsInvalid = true;
	}  
        
	//ADDRESS VALIDATION
	
	if ($address != "")
	{
		$error = validate_Address($address);
		if (!$error == "")
		{
			$outputError .= $error;
			echo $address = "";	
		}	
	}
    	//CITY VALIDATION
	
	if ($city != "")
	{
		$error = validate_City($city);
		if (!$error == "")
		{
			$outputError .= $error;
			echo $city = "";
		}	
	}
        //PROVINCE VALIDATION
	
	if ($province != "")
	{
		$error = validate_Province($province);
		if (!$error == "")
		{
			$outputError .= $error;
			echo $province = "";
		}	
	}
    
	
	//POSTAL CODE VALIDATION
	if ($postalCode != "")
	{
		$error = validate_PostalCode($postalCode);
		if (!$error == "")
		{
			$outputError .= $error;
			echo $postalCode = "";	
		}	
	}

	//USER TYPE
	//set user type to "u" by default;
	$user_type = "u";

	if($outputError == "")
	{
		$requiredIsInvalid = false;
	}
	
	//INSERT VALID DATA TO THE USERS AND AGENTS DATABASE 
	if ($error == "" && $requiredIsInvalid == false)		
	{
		$conn = pg_connect("host=localhost port:5432 dbname:sushi user=postgres password=mercymott");  
		//sql statement to insert the valid data to the credit card database 
		
        $sql = "INSERT INTO tblCreditCards(UserID, CreditCardNumber, CreditCardExpiryDate, CreditCardSecurityCode, CreditCardType, CardHolder, 
        BillingAddress, BillingCity,BillingProvince, BillingPostalCode)
        VALUES(
            '".$userName."',
            '".$cardType."',
            '".$nameOnCard."',
            '".$cardNumber."',
            '".$expirationDate."',
            '".$securityCode."', 
            '".$address."',
            '".$city."',
            '".$province."',
            '".$postalCode."')";
        
		pg_query($conn,$sql);//connect to the credit card database and execute the sql statement
		
		//sql statement to insert the valid data to the users database 
		$sql = "INSERT INTO tblUsers(UserID, UserFirst, UserLast, UserEmail, UserPhone, UserType)
		VALUES(
        	'".$userName."',
            '".$pass1."',
            '".$fname."',
            '".$lname."',  
            '".$email."',
            '".$phoneNumber."')";
		pg_query($conn,$sql);//connect to the username database and execute the sql statement
		header ("location: login.php");//redirects to login.php which is the login process		
	}
	else
	{
		$outputError .= "Please try again";
	}	
		
   //echo $error; 
}   
#end of post
?>

<?php echo $outputError;?>



<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <p class="t_c">
            Enter the following information and create an account that can be used to place orders for pick-up online.
        </p>
        <hr/>
        
        <table id="customerinfo">
            <th colspan="2" class="t_c">
                Personal Information
            </th>
            <tr>
                <td>
                    Username
                </td>
                <td>
                    <input type="text" name="<?php echo $userName;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Password
                </td>
                <td>
                    <input type="Password1" name="<?php echo $pass1;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Confirm Password
                </td>
                <td>
                    <input type="Password2" name="<?php echo $pass2;?>"/>
                </td>
            </tr>
            <tr>
            <td>
                    First Name
                </td>
                <td>
                    <input type="text" name="<?php echo $fname;?>"/>
                </td> 
            </tr>
            <td>
                    Last Name
                </td>
                <td>
                    <input type="text" name="<?php echo $lname;?>"/>
                </td> 
            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                    <input type="email" name="<?php echo $email;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Phone Number
                </td>
                <td>
                    <input type="text" name="<?php echo $phoneNumber;?>"/>
                </td>
            </tr>            
        </table>
        
        <br/>
        
        <table id="creditcardinfo">
            <th colspan="2" class="t_c">
                Credit Card Information
            </th>
            <tr>
                <td>
                    Card Type
                </td>
                <td>
                    <select name="<?php echo $cardType;?>">
                        <option value="Visa">Visa</option>
                        <option value="Mastercard">Mastercard</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Name on Card
                </td>
                <td>
                    <input type="text" name="<?php echo $nameOnCard;?>"/>
                </td>
            </tr>    
            <tr>
                <td>
                    Card Number
                </td>
                <td>
                    <input type="text" name="<?php echo $cardNumber;?>"/>
                </td> 
            </tr>
            <tr>
                <td>
                    Expiration Date
                </td>
                <td>
                    <table>
                        <tr>
                            <td>Month
                            </td>
                            <td>
                            <select name="<?php echo $month;?>">
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            </td>
                            <td>Year
                            </td>
                            <td>
                            <select name="<?php echo $year;?>">
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                            </select>
                            </td>
                        </tr>
                    </table>
                  
                </td>
            </tr>
            <tr>
                <td>
                    Security Code
                </td>
                <td>
                    <input type="text" name="<?php echo $securityCode;?>"/>
                </td>
            </tr>            
            <tr>
                <td>
                    Address
                </td>
                <td>
                    <input type="text" name="<?php echo $address;?>"/>
                </td> 

            </tr>
            <tr>
                <td>
                    City
                </td>
                <td>
                    <input type="text" name="<?php echo $city;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Province
                </td>
                <td>
                    <input type="text" name="<?php echo $province;?>"/>
                </td>
            </tr>            
            <tr>
                <td>
                    Postal Code
                </td>
                <td>
                    <input type="text" name="<?php echo $postalCode;?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <br/>
                    <input type="button" value="Register"/>
                    
                </td>
            </tr>
        </table>        
        
        <br/>

        </section>
 </form>
            
<?php include 'footer.php'; ?>