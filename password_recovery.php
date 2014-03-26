<?php
$file = "password_recovery.php";
$title = "Sushi Bai Kiyoshi - Password Recovery";
$banner = "Sushi Bai Kiyoshi - Password Recovery";
$description = "This page is where users will go to when they forget their password and need to reset it";
$date = "20/03/2014";

require 'header.php';



if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$userName="";
	$emailAddress="";
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$userName = trim($_POST["userName"]);
	$emailAddress = trim($_POST["emailAddress"]);
	
    
    $sql = "SELECT UserID, UserEmail, UserPassword 
				FROM tblUsers
				WHERE UserID ='$userName' AND emailAddress = '$emailAddress'";
    
    
	$conn = db_connect();
	$result = pg_query($conn, $sql);			
	$records = pg_num_rows($result);
	
	//$password = pg_fetch_result($result, 'password');
		
    // If there are results send the email
	if ($records > 0)
	{		
		
	
		echo "email: " . pg_fetch_result($result, 0, 'emailAddress')."</br>";
		echo "password: " . pg_fetch_result($result, 0, 'password')."</br>";
		
		
		$to = '$emailAddress';
		$subject = 'Forgotten Password';
		$message = 'Your password is: '.pg_fetch_result($result, 0, 'password');
		$headers = 'From: admin@sushi.ca' . "\r\n" .
			'Cc: admin@sushi.ca\r\n';
			'Reply-To: admin@sushi.ca' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		if( mail($to,$subject,$message,$headers))  
		{
		  echo "Email has been sent with your forgotten password.";
		}
		else
		{
		  echo "Message could not be sent.";
		}		

		
	}
	else // No results
	{	
		echo "<h2>Username / Email Invalid</h2>";
		$userName="";
		$emailAddress="";	
	}
}
else
{				
	echo "Error: ".$error;
	echo "old pass: " .$old_pass="";
	echo "new pass: " .$new_pass="";
	echo "Confirmation: " .$confirm_pass="";
}

?>

<section class="center">            
 <br/>
    <form action="" method="post">
        <table id="recovery">  
        <th class="t_c" colspan="2">Password Recovery</th>
        <tr>
            <td>User-name</td> 
            <td> <input type="text" name="userName" value="<?php $userName;?>" size="25"/> </td>
        </tr>	
        <tr>
            <td>Email Address</td> 
            <td> <input type="text" name="emailAddress" value="<?php $emailAddress;?>" size="25"/></td>
        </tr>		
        <tr>
            <td colspan="3" align="center"><input type="submit" name="submit1" value="Submit"/></td>
        </tr>
        </table>
    </form>
    <br/>
    
</section>
            
<?php include 'footer.php'; ?>