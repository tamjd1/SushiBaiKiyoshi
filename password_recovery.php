<?php
$file = "password_recovery.php";
$title = "Sushi Bai Kiyoshi - Password Recovery";
$banner = "Sushi Bai Kiyoshi - Password Recovery";
$description = "This page is where users will go to when they forget their password and need to reset it";
$date = "20/03/2014";

require 'header.php';



if($_SERVER["REQUEST_METHOD"] == "GET")
{
	$user_id="";
	$email_address="";
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$user_id = trim($_POST["user_id"]);
	$email_address = trim($_POST["email_address"]);
	
	$sql = "SELECT id, email_address, password 
				FROM users, agents
				WHERE users.id=agents.user_id AND id ='$user_id' AND email_address = '$email_address'";
	$conn = db_connect();
	$result = pg_query($conn, $sql);			
	$records = pg_num_rows($result);
	
	//$password = pg_fetch_result($result, 'password');
		
	if ($records > 0)
	{		
		
	
		echo "email: " . pg_fetch_result($result, 0, 'email_address')."</br>";
		echo "password: " . pg_fetch_result($result, 0, 'password')."</br>";
		
		
		$to = pg_fetch_result($result, 0, 'email_address');
		$subject = 'Forgotten Password';
		$message = 'Your password is: '.pg_fetch_result($result, 0, 'password');
		$headers = 'From: admin@mkt2.ca' . "\r\n" .
			'Cc: admin@mtk2.ca\r\n';
			'Reply-To: admin@mtk2.ca' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();

		if( mail($to,$subject,$message,$headers))  
		{
		  echo "Message sent successfully.";
		}
		else
		{
		  echo "Message could not be sent.";
		}		

		
	}
	else
	{	
		echo "<h2>Username / Email Invalid</h2>";
		$user_id="";
		$email_address="";	
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
                <th class="t_c">Password Recovery</th>
               	<tr>
					<td>User Id</td> 
					<td> <input type="text" name="user_id" value="<?php $user_id;?>" size="25"/> </td>
				</tr>	
				<tr>
					<td>Email Address</td> 
					<td> <input type="text" name="email_address" value="<?php $email_address;?>" size="25"/></td>
				</tr>		
				<tr>
					<td colspan="3" align="center"><input type="submit" name="submit1" value="Submit"/></td>
				</tr>
                </table>
            </form>
            <br/>
            
        </section>
            
<?php include 'footer.php'; ?>