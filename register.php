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

//$conn = pg_connect("host=localhost port:5432 dbname:sushi user=postgres password=mercymott");  

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
    
    if (!isset ($userName) || $userName == "")
	{
		$error .= "You did not enter a user id <br/>";
		echo $userName = "";
	}
	else if (strlen($userName) < 1)
	{
		$error .= "A username must be at least " . 3 . " characters. <em>$userName</em> is not enough<br/>";
		echo $userName = "";
	}
	else if (strlen($userName) > 5)
	{
		$error .= "A username must not be longer than " . 5 . " characters. <em>$userName</em> is too long<br/>";
		echo $userName = "";
	}
	
	else
	{
		//$sql = "Select id FROM users WHERE id='".$userName."'";
		//$result = pg_query($conn,$sql);
		//$records = pg_num_rows($result);
			
		//if ($records != 0)//if there's record
		//{
		//	$error .= "Username <em>$userName</em> already exists. Enter another username <br/>";
		//	echo $login = "";
		//	$requiredIsInvalid = true;
    }
	

	//PASSWORD VALIDATION
	$error = "";
	if ((!isset($pass1) || $pass1 == "") && (!isset($pass2) || $pass2 == "")) //if user did not entered anything
	{
		$error .= "You did not enter a password <br/>";//display error message
	}
	else 
	{
		$match = strcmp($pass1, $pass2);	//compare if both variable $pass1 & $pass2 are the same	
		
		if (($match < 0) || ($match > 0))
		{
			$error .= "The password and confirm password were not the same <br/>";//error message if not the same
			 
		}
		else if (strlen($pass1) < 6)//if the password is less than 6 characters
		{
			$error .= "Your password must be at least " . 6 . " characters <br/>";	 
		}
		else if (strlen($pass1) > 8)//if password is more than 8 characters
		{
			$error .= "Your password must be less than " . 8 . " characters <br/>"; 
		}
	}
    
    
    
	//EMAIL VALIDATION
	
	$error = "";
	if (!isset($email) || $email == "")//if user did not entered anything
	{
		//return $error .= "You did not enter an email address <br/>";//display error message
		$error .= "You did not enter an email address <br/>";//display error message
		echo $email = "";//don't display the entered data
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))//check if it is a valid email
	{
		//return $error .= "The email address <em>$email</em> is not valid <br/>";
		$error .= "The email address <em>$email</em> is not valid <br/>";
		echo $email = "";
	}	
		
	//FIRSTNAME VALIDATION	
	
	$error = "";
	if (!isset($fname) || $fname == "")//if user did not entered anything
	{
		$error .= "You did not enter your first name <br/>";//display error message
		echo $fname = "";//don't display the entered data
	}	
	else if(is_numeric($fname))//if user entered numeric value
	{
		$error .= "Your first name cannot be a number, you entered: <em>$firstname</em> <br/>";	//display error message
		echo $fname = "";//display nothing in the firstname textbox	
	}
	else if (strlen($fname) > 35)//if the length of firstname is more than 20 characters
	{
		$error .= "Your first name needs to be less than " . 35 . " characters. <em>$firstname</em> is too long <br/>";//display error
		echo $fname = "";//display nothing in the firstname textbox
	}
	

	//LASTNAME VALIDATION
	$error = "";
	if (!isset($lname) || $lname == "")//if user did not entered anything
	{
		$error .=  "You did not enter your last name <br/>";//display error message
		echo $lname = "";//don't display the entered data
	}
	
	else if(is_numeric($lname))//if user entered numeric value
	{
		$error .= "Your last name cannot be a number, you entered: <em>$lastname</em> <br/>";
		echo $lname = "";
	}
	else if (strlen($lname) > 35)//if lastname is more than the maximum value of 30 characters
	{
		$error .= "Your last name needs to be less than " . 35 . " characters. <em>$lastname</em> is too long <br/>";
		echo $lname = "";
	}	
    
    
	//PHONE NUMBER VALIDATION
	
	$error = "";
	$phoneNumber = preg_replace ('/\D/', '', $phoneNumber);//removes spaces and characters in phone numbers
	if (!isset($phoneNumber) || $phoneNumber == "")//if user did not entered anything
	{
		$error .= "You did not enter your phone number <br/>";//display error message
		echo $phoneNumber = "";//don't display the entered data
	}
	else if (strlen($phoneNumber) != 10)//if phone number is more than the maximum value 
	{
		$error .= "Your phone number needs to be less than " . 10 . " characters & numbers. <em>$phone</em> is too long <br/>";
		echo $phoneNumber= "";
	}



	//USER TYPE
	//set user type to "u" by default;
	$user_type = "u";

	if($error == "")
	{
		$requiredIsInvalid = false;
	}
	
	//INSERT VALID DATA TO THE USERS AND AGENTS DATABASE 
	if ($error == "" && $requiredIsInvalid == false)		
	{
		
		//sql statement to insert the valid data to the credit card database 
		
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
		$error .= "Please try again";
	}	
		

}   

?>



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
                    <?php echo $error;?>
                </td>
                <td>
                </td>
            </tr>
            
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
  
            <tr>
                <td style="text-align:center;">

                    <input type="button" value="Register"/>
                    <input type="reset" value="Clear"/></td>
                </td>
            </tr>
        </table>        
        
        <br/>

        </section>
 </form>
            
<?php include 'footer.php'; ?>