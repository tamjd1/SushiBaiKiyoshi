<?php

/**
	validate_Id
	
	This function checks a users ID to ensure it is valid
	
	@author: group sushi
	@param: $id - User login id entered
	@return: $error - Returns proper error message or an empty string
*/
function validate_UserName($userName)
{
	$error = "";
	if (!isset ($userName) || $userName == "")
	{
		$error .= "You did not enter a user id <br/>";
		echo $userName = "";
	}
	else if (strlen($id) < 1)
	{
		$error .= "A username must be at least " . 3 . " characters. <em>$userName</em> is not enough<br/>";
		echo $userName = "";
	}
	else if (strlen($userName) > 5)
	{
		$error .= "A username must not be longer than " . 5 . " characters. <em>$userName</em> is too long<br/>";
		echo $userName = "";
	}
	return $error;
}

function validate_Pass($pass1, $pass2)
{
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
	return $error;
}


	/*This function checks a users E-mail to ensure it is valid

	@param: $email - User email entered
	@return: $error - Returns proper error message or an empty string
*/
function validate_Email($email)
{
	$error = "";
	if (!isset($email) || $email == "")//if user did not entered anything
	{
		//return $error .= "You did not enter an email address <br/>";//display error message
		$error = "You did not enter an email address <br/>";//display error message
		echo $email = "";//don't display the entered data
	}
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))//check if it is a valid email
	{
		//return $error .= "The email address <em>$email</em> is not valid <br/>";
		$error = "The email address <em>$email</em> is not valid <br/>";
		echo $email = "";
	}	
	return $error;
}


	
	/*This function checks a users first name to ensure it is valid

	@param: $first_name - Users first name entered
	@return: $error - Returns proper error message or an empty string */

function validate_First_Name($fname)
{
	$error = "";
	if (!isset($fname) || $fname == "")//if user did not entered anything
	{
		$error = "You did not enter your first name <br/>";//display error message
		echo $fname = "";//don't display the entered data
	}	
	else if(is_numeric($fname))//if user entered numeric value
	{
		$error = "Your first name cannot be a number, you entered: <em>$firstname</em> <br/>";	//display error message
		echo $fname = "";//display nothing in the firstname textbox	
	}
	else if (strlen($fname) > 35)//if the length of firstname is more than 20 characters
	{
		$error = "Your first name needs to be less than " . 35 . " characters. <em>$firstname</em> is too long <br/>";//display error
		echo $fname = "";//display nothing in the firstname textbox
	}
	
	return $error;
}

/*
	This function checks a users last name to ensure it is valid

	@param: $last_name - User last name entered
	@return: $error - Returns proper error message or an empty string
    */

function validate_Last_Name($lname)
{
	$error = "";
	if (!isset($lname) || $lname == "")//if user did not entered anything
	{
		$error =  "You did not enter your last name <br/>";//display error message
		echo $lname = "";//don't display the entered data
	}
	
	else if(is_numeric($lname))//if user entered numeric value
	{
		$error = "Your last name cannot be a number, you entered: <em>$lastname</em> <br/>";
		echo $lname = "";
	}
	else if (strlen($lname) > 35)//if lastname is more than the maximum value of 30 characters
	{
		$error = "Your last name needs to be less than " . 35 . " characters. <em>$lastname</em> is too long <br/>";
		echo $lname = "";
	}	
	return $error;
}

/*
	This function checks a users phone number to ensure it is valid
	
	@param: $phone - User phone number entered
	@return: $error - Returns proper error message or an empty string
*/

function validate_Phone($phoneNumber)
{
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
	return $error;
}

function validate_CardType($cardType)

	/*This function checks a user's card type to ensure it is valid
    */
{
	$error = "";
	if (!isset($cardType) || $cardType == "")//if user did not entered anything
	{
		$error = "You did not enter the type of card <br/>";//display error message
		echo $cardType = "";//don't display the entered data
	}

	return $error;
}

	/*This function checks the name of card to ensure it is valid */

function validate_NameOfCard($nameOfCard)
{
	$error = "";
	if (!isset($nameOfCard) || $nameOfCard == "")//if user did not entered anything
	{
		$error = "You did not enter your name of card <br/>";//display error message
		echo $nameOfCard = "";//don't display the entered data
	}
	else if(strlen($nameOfCard) > 50)//if name of card is more than the maximum value of 30 characters
	{
		$error = "Your name of card needs to be less than " . 50 . " characters. <em>$address</em> is too long <br/>";
		echo $nameOfCard = "";
	}
	return $error;
}

	/*This function checks a users card number to ensure it is valid */
function validate_CardNumber($cardNumber)
{
	$error = "";
	if (!isset($cardNumber) || $cardNumber == "")//if user did not entered anything
	{
		$error = "You did not enter your name number <br/>";//display error message
		echo $cardNumber = "";//don't display the entered data
	}
	else if(strlen($cardNumber) > 16)//if name number is more than the maximum value of 16 characters
	{
		$error = "Your name number needs to be less than " . 16 . " characters. <em>$address</em> is too long <br/>";
		echo $cardNumber = "";
	}
	return $error;
}

	/*This function checks a users card security numbers to ensure it is valid */
function validate_SecurityCode($securityCode)
{
	$error = "";
	if (!isset($securityCode) || $securityCode == "")//if user did not entered anything
	{
		$error = "You did not enter your name number <br/>";//display error message
		echo $securityCode = "";//don't display the entered data
	}
	else if(strlen($securityCode) > 3)//if name number is more than the maximum value of 16 characters
	{
		$error = "Your name number needs to be less than " . 3 . " characters. <em>$address</em> is too long <br/>";
		echo $securityCode = "";
	}
	return $error;
}

	/*This function checks the credit card's expiration date to ensure it is valid*/

function validate_ExpirationDate($expirationDate)
{

    
	$error = "";
	if (!isset($expirationDate) || $expirationDate == "")//if user did not entered anything
	{
		$error = "You did not enter your name number <br/>";//display error message
		echo $expirationDate = "";//don't display the entered data
	}
	else if(strlen($expirationDate) > 5)//if name number is more than the maximum value of 5 characters
	{
		$error = "Your name number needs to be more than " . 5 . " characters. <em>$address</em> is too long <br/>";
		echo $expirationDate = "";
	}
	return $error;
}

/*
	This function checks a users address to ensure it is valid
	
	@param: $address - Users adress entered
	@return: $error - Returns proper error message or an empty string
*/
function validate_Address($address)
{
	$error = "";
	if (!isset($address) || $address == "")//if user did not entered anything
	{
		$error = "You did not enter your address <br/>";//display error message
		echo $address = "";//don't display the entered data
	}
	else if(strlen($address) > 50)//if address is more than the maximum value of 50 characters
	{
		$error = "Your address needs to be more than " . 50 . " characters. <em>$address</em> is too long <br/>";
		echo $address = "";
	}
	return $error;
}

function validate_City($city)
{
	$error = "";
	if (!isset($city) || $city == "")//if user did not entered anything
	{
		$error = "You did not enter your city <br/>";//display error message
		echo $city = "";//don't display the entered data
	}
	else if(strlen($city) > 30)//if city is more than the maximum value of 30 characters
	{
		$error = "Your city needs to be more than " . 30 . " characters. <em>$address</em> is too long <br/>";
		echo $city = "";
	}
	return $error;
}

function validate_Province($province)
{
	$error = "";
	if (!isset($province) || $province == "")//if user did not entered anything
	{
		$error = "You did not enter your province <br/>";//display error message
		echo $province = "";//don't display the entered data
	}
	else if(strlen($province) > 2)//if province is more than the maximum value of 2 characters
	{
		$error = "Your province needs to be more than " . 2 . " characters. <em>$address</em> is too long <br/>";
		echo $province = "";
	}
	return $error;
}
	

/*
	This function checks a users postal code to ensure it is valid
	
	@author: Mercy
	@param: $postal_code - Users postal code entered
	@return: $error - Returns proper error message or an empty string
*/
function validate_Postal_Code($postal_code)
{
	$error = "";
	//$postal_code = preg_replace('/\s+/', '', $postal_code);
	if (!isset($postal_code) || $postal_code == "")//if user did not entered anything
	{
		$error = "You did not enter your postal code <br/>";//display error message
	}
	else if (strlen($postal_code) != MAX_POSTAL_LENGTH || strlen($postal_code) < MAX_POSTAL_LENGTH)//if postal code must contain 6 characters.
	{
		$error = "Your postal code needs to be at least ".MAX_POSTAL_LENGTH." characters. <br/>";
	}	
	else if(!(preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i",$postal_code)))
	{
		$error = "Postal code is invalid<br/>";
	}
	
	return $error;
}



	
?>


