<?php
$file = "credit_card_create.php";
$title = "Sushi Bai Kiyoshi - Add Credit Card";
$banner = "Sushi Bai Kiyoshi - Add Credit Card";
$description = "This page is creating a customer's credit card";
$date = "05/03/2014";



require 'header.php'; ?>

    <section id="MainContent">
 
 <?php
 //hard coded user id and user type for now.
$_SESSION['id'] = "turning_japanese";
$_SESSION['usertype'] = "c";

//variable declaration
$error = ""; //variable for errors
$expiryDate = ""; //variable for expiration date
$orderDate = ""; //variable for current date

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $error = "";
    $cardType = "";
	$nameOnCard = "";
	$cardNumber = "";
	$month = "";
	$year = "";  
	$securityCode = "";    
	$address = "";
	$city = "";
    $province = "";
	$postalCode = "";
    $expiryDate = "";
    
    $sql= "SELECT * FROM \"tblInvoices\" ORDER BY \"OrderDateTime\" limit 1";
    $result = pg_query($conn,$sql);//connect to the database and execute the sql statement
    $records = pg_num_rows($result); 
    if ($records != 0){
        $invoiceNumber = pg_fetch_result($result, 0, 'InvoiceID');    
    }
    else
    {
        $error .= "Invoice number not found </br>";
        $invoiceNumber = "";
    }
} 

//once form is submitted, remove all whitespaces before and after each variable, 
//and do the validation before saving it to the database.
else if($_SERVER["REQUEST_METHOD"] == "POST"){

	$cardType = trim ($_POST ["cardType"]);
	$nameOnCard = trim ($_POST ["nameOnCard"]);
	$cardNumber = trim ($_POST ["cardNumber"]);   
	$month = trim ($_POST ["month"]);
	$year = trim ($_POST ["year"]);
    $securityCode = trim ($_POST ["securityCode"]);
	$address = trim ($_POST ["address"]); 
    $city = trim ($_POST ["city"]);  
    $province = trim ($_POST ["province"]);  
    $postalCode = trim ($_POST ["postalCode"]);   
    
    define("MAX_NAME_LENGTH", 70);
    define("MAX_NUMBER_LENGTH", 16);
    define("MAX_SECURITY_LENGTH", 3);
    define("MIN_ADDRESS_LENGTH", 5);
    define("MAX_ADDRESS_LENGTH", 50);
    define("MIN_CITY_LENGTH", 2);
    define("MAX_CITY_LENGTH", 30);
    define("MAX_POSTAL_LENGTH", 6);

    
//VALIDATION

//validate card type
	if (!isset($cardType) || $cardType == "")//if user did not entered anything
	{
		$error .= "You did not select a card type. Please try again<br/>";//display error message
		echo $cardType = "";//don't display the entered data
	}	


//validate name of card
	if (!isset($nameOnCard) || $nameOnCard == "")//if user did not entered anything
	{
		$error .= "You did not enter your name on card.<br/>";//display error message
		echo $nameOnCard = "";//don't display the entered data
	}	
	else if(is_numeric($nameOnCard))//if user entered numeric value
	{
		$error .= "Your first name cannot be a number, you entered: <em>$nameOnCard</em> <br/>";	//display error message
		echo $nameOnCard = "";//display nothing in the nameOnCard textbox	
	}
	else if (strlen($nameOnCard) > MAX_NAME_LENGTH)//if the length of nameOnCard is more than 70 characters
	{
		$error .= "Your first name needs to be less than " . MAX_NAME_LENGTH . " characters. <em>$nameOnCard</em> is too long <br/>";//display error
		echo $nameOnCard = "";//display nothing in the nameOnCard textbox
	}
   
//validate card number
	if (!isset($cardNumber) || $cardNumber == "")//if user did not entered anything
	{
		$error .= "You did not enter your card number.  <br/>";//display error message
		echo $cardNumber = "";//don't display the entered data
	}	
	else if(!is_numeric($cardNumber))//if user entered numeric value
	{
		$error .= "Your card number must be a number, you entered: <em>$cardNumber</em> <br/>";	//display error message
		echo $cardNumber = "";//display nothing in the cardNumber textbox	
	}
	else if (strlen($cardNumber) != MAX_NUMBER_LENGTH)//if the length of cardNumber is not equals to 16 characters
	{
		$error .= "Your card number must be " . MAX_NUMBER_LENGTH . " digits. you entered: <em>$cardNumber</em>  <br/>";//display error
		echo $cardNumber = "";//display nothing in the cardNumber textbox
	}

//validate month
	if (!isset($month) || $month == "")//if user did not entered anything
	{
		$error .= "You did not select expiry month. Please try again<br/>";//display error message
		echo $month = "";//don't display the entered data
	}
    else
    {
        $expiryDate .= $month;
    }

//validate year
	if (!isset($year) || $year == "")//if user did not entered anything
	{
		$error .= "You did not select expiry year. <br/>";//display error message
		echo $year = "";//don't display the entered data
	}
    else
    {
        $expiryDate .= "/";
        $expiryDate .= $year;
    }
    
    

//validate security code

	if (!isset($securityCode) || $securityCode == "")//if user did not entered anything
	{
		$error .= "You did not enter the security code of your credit card.  <br/>";//display error message
		echo $securityCode = "";//don't display the entered data
	}	
	else if(!is_numeric($securityCode))//if user entered numeric value
	{
		$error .= "Your security code must be a number, you entered: <em>$securityCode</em> <br/>";	//display error message
		echo $securityCode = "";//display nothing in the securityCode textbox	
	}
	else if (strlen($securityCode) != MAX_SECURITY_LENGTH)//if the length of securityCode is not equals to 16 characters
	{
		$error .= "Your security must be " . MAX_SECURITY_LENGTH . " digits. you entered: <em>$securityCode</em>  <br/>";//display error
		echo $securityCode = "";//display nothing in the securityCode textbox
	}	
    
//validate address
	if (!isset($address) || $address == "")//if user did not entered anything
	{
		$error .= "You did not enter your address.  <br/>";//display error message
		echo $address = "";//don't display the entered data
	}	
	else if(is_numeric($address))//if user entered numeric value
	{
		$error .= "Your address cannot be a number, you entered: <em>$address</em> <br/>";	//display error message
		echo $address = "";//display nothing in the nameOnCard textbox	
	}
	else if (strlen($address) < MIN_ADDRESS_LENGTH)//if the length of address is more than 70 characters
	{
		$error .= "Your address must be more than " . MIN_ADDRESS_LENGTH . " characters. <em>$address</em> is not <br/>";//display error
		echo $address = "";//display nothing in the address textbox
	}
    else if (strlen($address) > MAX_ADDRESS_LENGTH)//if the length of address is more than 70 characters
	{
		$error .= "Your address  needs to be less than " . MAX_ADDRESS_LENGTH . " characters. <em>$address</em> is too long <br/>";//display error
		echo $address = "";//display nothing in the address textbox
	}

 //validate city
	if (!isset($city) || $city == "")//if user did not entered anything
	{
		$error .= "You did not enter your city.  <br/>";//display error message
		echo $city = "";//don't display the entered data
	}	
	else if(is_numeric($city))//if user entered numeric value
	{
		$error .= "Your city cannot be a number, you entered: <em>$city</em> <br/>";	//display error message
		echo $city = "";//display nothing in the nameOnCard textbox	
	}
	else if (strlen($city) < MIN_CITY_LENGTH)//if the length of city is more than 70 characters
	{
		$error .= "Your city must be more than " . MIN_CITY_LENGTH . " characters. <em>$city</em> is too long <br/>";//display error
		echo $city = "";//display nothing in the city textbox
	}
    else if (strlen($city) > MAX_CITY_LENGTH)//if the length of city is more than 70 characters
	{
		$error .= "Your city  needs to be less than " . MAX_CITY_LENGTH . " characters. <em>$city</em> is too long <br/>";//display error
		echo $city = "";//display nothing in the city textbox
	}  
    
  //validate province
	if (!isset($province) || $province == "")//if user did not entered anything
	{
		$error .= "You did not enter your province. <br/>";//display error message
		echo $city = "";//don't display the entered data
	}	

//postal code
	if (!isset($postalCode) || $postalCode == "")//if user did not entered anything
	{
		$error .= "You did not enter your postal code.<br/>";//display error message
        echo $postalCode = "";//don't display the entered data
	}
	else if (strlen($postalCode) != MAX_POSTAL_LENGTH || strlen($postalCode) < MAX_POSTAL_LENGTH)//if postal code must contain 6 characters.
	{
		$error .= "Your postal code needs to be at least ".MAX_POSTAL_LENGTH." characters. <br/>";
        echo $postalCode = "";//don't display the entered data
	}	
	else if(!(preg_match("/^([a-ceghj-npr-tv-z]){1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}[a-ceghj-npr-tv-z]{1}[0-9]{1}$/i",$postalCode)))
	{
		$error .= "Postal code format must be X9X9X9<br/>";
        echo $postalCode = "";//don't display the entered data
	}
    
    if ($error == "")    
	{
		$sql = "INSERT INTO \"tblInvoices\" 
		VALUES(
        	'".$_SESSION['id']."',
            '".$cardNumber."',
            '".$expiryDate."',
            '".$securityCode."',
            '".$cardType."',  
            '".$nameOnCard."',
            '".$address."',
            '".$city."',
            '".$province."',
            '".$postalCode."')";
            
         pg_query($conn,$sql);//connect to the id database and execute the sql statement
            
         $orderDate = date();
         
         /*
         $sql = "UPDATE \"tblInvoices\"
        SET \"InvoiceID\"='$invoicesNumber', \"OrderDateTime\"='$orderDate', \"Subtotal\"='$_SESSION['Subtotal']',	
        , \"Tax\"='$_SESSION['Tax']'
        WHERE \"ItemID\"='$invoiceNumber'";
          
		pg_query($conn,$sql);//connect to the id database and execute the sql statement
        */
        
        
        //Destroy the current session before recreating the session id variable
		session_destroy();
        
        // when session starts, update the session id variable
		session_start();
		
		$_SESSION['id'] = $id;	
        $_SESSION['IinvoiceID'] = $invoiceNumber;	
        $_SESSION['message'] .= "Your invoice number is <em> $invoiceNumber</em> <br/>"
        $_SESSION['message'] .= "Items are ready for pick-up in 30 mins!";
        
        //redirects to the confirmation page
	
		header ("location: payment_confirm.php");
        }
	else
	{
		$error .= "Please try again";
	}   
}


 
 ?>
 

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        
        <table id="creditcardinfo">
            <th colspan="2" class="t_c">
                Enter Credit Card Information
            </th>
            <tr>
                <td colspan = "2" class="errmsg">
                    <?php echo $error ?>
            </tr>
            <tr>
                <td>
                    Card Type
                </td>
                <td>
                    <select name="cardType" value="<?php echo $cardType ?>">
                        <option value="visa">Visa</option>
                        <option value="mastercard">Mastercard</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Name on Card  
                </td>
                <td>
                    <input type="text" name="nameOnCard" value="<?php echo $nameOnCard ?>"/>
                </td>
            </tr>    
            <tr>
                <td>
                    Card Number
                </td>
                <td>
                    <input type="text" name="cardNumber" value="<?php echo $cardNumber ?>"/>
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
                            <select name="month" value="<?php echo $month ?>">
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            </td>
                            <td>Year
                            </td>
                            <td>
                            <select name="year" value="<?php echo $year ?>">
                                <option value="14">2014</option>
                                <option value="15">2015</option>
                                <option value="16">2016</option>
                                <option value="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20">2020</option>
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
                    <input type="text" name="securityCode" value="<?php echo $securityCode ?>"/>
                    
                    
                </td>
            </tr>            
        </table>
        <table style="margin:0 auto 0 auto">        
            <th colspan="2" class="t_c">
                Billing Information
            </th>
            <tr>
                <td>
                    Address
                </td>
                <td>
                    <input type="text" name="address" value="<?php echo $address ?>"/>
                </td> 

            </tr>
            <tr>
                <td>
                    City
                </td>
                <td>
                    <input type="text" name="city" value="<?php echo $city ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Province
                </td>
                <td>
                    <select name="province" value="<?php echo $province ?>">
                                <option value="AB">AB</option>
                                <option value="BC">BC</option>
                                <option value="MB">MB</option>
                                <option value="NB">NB</option>
                                <option value="NB">NL</option>
                                <option value="NS">NS</option>
                                <option value="NT">NT</option>
                                <option value="NU">NU</option>
                                <option value="ON">ON</option>
                                <option value="PE">PE</option>
                                <option value="QC">QC</option>
                                <option value="SK">SK</option>
                                <option value="YT">YT</option>
                            </select>
                </td>
            </tr>            
            <tr>
                <td>
                    Postal Code
                </td>
                <td>
                    <input type="text" name="postalCode" value="<?php echo $postalCode ?>"/>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">                    
                    <input type="submit" value="Submit"/>                    
                </td>
                <td style="text-align:center;">                    
                    <input type="submit" value="Reset"/>                    
                </td>
            </tr>
        </table>        
        
        <br/>
        
    </section>
    
</form>
        
<?php include 'footer.php'; ?>