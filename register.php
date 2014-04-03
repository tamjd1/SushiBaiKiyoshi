<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Customer Registration Page";
$banner = "Sushi Bai Kiyoshi - Customer Registration Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
//require 'functions.php';
?>
<section id="MainContent">            

<?php

$error = ""; //initialize error variable to nothing.
$outputError = "";

//when the website/webpage first loaded, initialize all the variable except $user_type to nothing. 
//Initialize $user_type to "u" meaning unregistered.
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $error = "";
	$id = "";
	$password = "";
	$conf_password = "";
	$first_name = "";  
	$last_name = "";    
	$email_address = "";
	$phoneNumber = "";
    //$user_type = "";
	//$requiredIsInvalid = false;
} 

//once form is submitted, remove all whitespaces before and after each variable, 
//and do the validation before saving it to the database.
else if($_SERVER["REQUEST_METHOD"] == "POST"){

	$id = trim ($_POST ["id"]);
	$password = trim ($_POST ["password"]);
	$conf_password = trim ($_POST ["conf_password"]);   
	$first_name = trim ($_POST ["first_name"]);
	$last_name = trim ($_POST ["last_name"]);
    $email_address = trim ($_POST ["email_address"]);
	$phoneNumber = trim ($_POST ["phoneNumber"]);  
    
    define("MAX_PHONE_NUMBER_LENGTH", 10);
    define("MIN_ID_LENGTH", 3);
    define("MAX_ID_LENGTH", 20);
    define("MIN_PASSWORD_LENGTH", 6);
    define("MAX_PASSWORD_LENGTH", 15);
    define("MIN_NAME_LENGTH", 2);
    define("MAX_NAME_LENGTH", 35);


	$requiredIsInvalid = false;

	//id VALIDATION
	//function for id validation. this will return the value of $error.
    
    if (!isset ($id) || $id == "")
	{
		$error .= "You did not enter a user id <br/>";
		echo $id = "";
	}
	else if (strlen($id) < MIN_ID_LENGTH)
	{
		$error .= "A id must be at least " . MIN_ID_LENGTH . " characters. <em>$id</em> is not enough<br/>";
		echo $id = "";
	}
	else if (strlen($id) > MAX_ID_LENGTH)
	{
		$error .= "A id must not be longer than " . MAX_ID_LENGTH . " characters. <em>$id</em> is too long<br/>";
		echo $id = "";
	}
	
	else
	{
    
        $conn = db_connect();
        $sql = "SELECT \"UserID\" FROM \"tblUsers\" WHERE \"UserID\" = '".$id."'";
		$result = pg_query($conn,$sql);
		$records = pg_num_rows($result);
     			
		if ($records != 0)//if there's record
		{
			$error .= "UserID <em>$id</em> already exists. Enter another User ID <br/>";
			echo $id = "";
			//$requiredIsInvalid = false;
        }
    }
	

	//PASSWORD VALIDATION

    if($password != $conf_password)
    {
        $error .= "Your password and confirm password MUST be the same<br/>";
        $password = "";
    }else if($password == "" || !isset($password))
    {
        $error .= "You must provide password and confirm password.<br/>";//error message if not the same
         
    }
    else if (strlen($password) < MIN_PASSWORD_LENGTH)//if the password is less than 6 characters
    {
        $error .= "Your password must be at least " . MIN_PASSWORD_LENGTH . " characters <br/>";	 
        $password = "";
    }
    else if (strlen($password) > MAX_PASSWORD_LENGTH)//if password is more than 8 characters
    {
        $error .= "Your password must be less than " . MAX_PASSWORD_LENGTH . " characters <br/>"; 
        $password = "";
    }
	
    
    
    
	//EMAIL VALIDATION
	
	if (!isset($email_address) || $email_address == "")//if user did not entered anything
	{
		
		$error .= "You did not enter an email address <br/>";//display error message
		echo $email_address = "";//don't display the entered data
	}
	else if (!filter_var($email_address, FILTER_VALIDATE_EMAIL))//check if it is a valid email
	{
		$error .= "The email address <em>$email_address</em> is not valid <br/>";
		echo $email_address = "";
	}	
		
	//FIRSTNAME VALIDATION	
	
	if (!isset($first_name) || $first_name == "")//if user did not entered anything
	{
		$error .= "You did not enter your first name <br/>";//display error message
		echo $first_name = "";//don't display the entered data
	}	
	else if(is_numeric($first_name))//if user entered numeric value
	{
		$error .= "Your first name cannot be a number, you entered: <em>$firstname</em> <br/>";	//display error message
		echo $first_name = "";//display nothing in the firstname textbox	
	}
	else if (strlen($first_name) < MIN_NAME_LENGTH)//if the length of firstname is less than 2 characters
	{
		$error .= "Your first name must be fore than " . MIN_NAME_LENGTH . " characters. <em>$firstname</em> is not enough <br/>";//display error
		echo $first_name = "";//display nothing in the firstname textbox
	}
    else if (strlen($first_name) > MAX_NAME_LENGTH)//if the length of firstname is more than 20 characters
	{
		$error .= "Your first name needs to be less than " . MAXA_NAME_LENGTH . " characters. <em>$firstname</em> is too long <br/>";//display error
		echo $first_name = "";//display nothing in the firstname textbox
	}
	

	//LASTNAME VALIDATION
	if (!isset($last_name) || $last_name == "")//if user did not entered anything
	{
		$error .=  "You did not enter your last name <br/>";//display error message
		echo $last_name = "";//don't display the entered data
	}
	
	else if(is_numeric($last_name))//if user entered numeric value
	{
		$error .= "Your last name cannot be a number, you entered: <em>$lastname</em> <br/>";
		echo $last_name = "";
	}
	else if (strlen($last_name) < MIN_NAME_LENGTH)//if the length of last_name is less than 2 characters
	{
		$error .= "Your first name must be fore than " . MIN_NAME_LENGTH . " characters. <em>$last_name</em> is not enough <br/>";//display error
		echo $last_name = "";//display nothing in the last_name textbox
	}
    else if (strlen($last_name) > MAX_NAME_LENGTH)//if the length of lastname is more than 20 characters
	{
		$error .= "Your first name needs to be less than " . MAXA_NAME_LENGTH . " characters. <em>$last_name</em> is too long <br/>";//display error
		echo $last_name = "";//display nothing in the lastname textbox
	}
    
    
	//PHONE NUMBER VALIDATION
	
	$phoneNumber = preg_replace ('/\D/', '', $phoneNumber);//removes spaces and characters in phone numbers
	if (!isset($phoneNumber) || $phoneNumber == "")//if user did not entered anything
	{
		$error .= "You did not enter your phone number <br/>";//display error message
		echo $phoneNumber = "";//don't display the entered data
	}
	else if (strlen($phoneNumber) != MAX_PHONE_NUMBER_LENGTH)//if phone number must be 10 digit long
	{
		$error .= "Your phone number needs to be less than " . MAX_PHONE_NUMBER_LENGTH . " characters & numbers. <em>$phoneNumber</em> is too long <br/>";
		echo $phoneNumber= "";
	}



	//USER TYPE
	//set user type to "c" by default;
	$user_type = "c";

	//if($error == "")
	//{
	//	$requiredIsInvalid = false;
	//}
	
	//INSERT VALID DATA TO THE USERS AND AGENTS DATABASE 
	//if ($error == "" && $requiredIsInvalid == false)
    if ($error == "")    
	{
		

		$sql = "INSERT INTO \"tblUsers\" 
		VALUES(
        	'".$id."',
            '".$password."',
            '".$first_name."',
            '".$last_name."',  
            '".$email_address."',
            '".$phoneNumber."',
            '".$user_type."')";
          
		pg_query($conn,$sql);//connect to the id database and execute the sql statement
		header ("location: welcome.php");//redirects to the welcome page
        $_SESSION['message'] = "You Are Now REGISTERED!<br/> Login To Order!";
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
                <td colspan="2" class="errmsg">
                    <?php echo $error;?>
                </td>
            </tr>
            
            <tr>
                <td>
                    User ID
                </td>
                <td>
                    <input type="text" name="id" value="<?php echo $id;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Password
                </td>
                <td>
                    <input type="password" name="password" value="<?php echo $password;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Confirm Password
                </td>
                <td>
                    <input type="password" name="conf_password" value="<?php echo $password;?>"/>
                </td>
            </tr>
            <tr>
            <td>
                    First Name
                </td>
                <td>
                    <input type="text" name="first_name" value="<?php echo $first_name;?>"/>
                </td> 
            </tr>
            <td>
                    Last Name
                </td>
                <td>
                    <input type="text" name="last_name" value="<?php echo $last_name;?>"/>
                </td> 
            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                    <input type="email" name="email_address" value="<?php echo $email_address;?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Phone Number
                </td>
                <td>
                    <input type="text" name="phoneNumber" value="<?php echo $phoneNumber;?>"/>
                </td>
            </tr>            
  
            <tr>
                <td style="text-align:right;">

                    <input type="submit" value="Register"/></td>
                <td>
                    <input type="reset" value="Clear"/>
                </td>
            </tr>
        </table>        
        
        <br/>

        </section>
 </form>
            
<?php include 'footer.php'; ?>