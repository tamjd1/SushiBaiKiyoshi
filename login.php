<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';



if($_SERVER["REQUEST_METHOD"] == "GET")
{

}
if($_SERVER["REQUEST_METHOD"] == "POST")
    {       
        //the page got here from submitting the form, let's try to process
        $loginID = trim($_POST["login"]);
        $password = trim($_POST["pass"]);
        
       
            //no errors connent to db
            //Attempts to select a record where the entered information is matching
            $sql = "SELECT \"UserID\",\"UserType\"
                    FROM \"tblUsers\"

                    WHERE \"UserID\"='".$loginID."' AND \"Password\" = '".$password."'";
                    echo $sql;
            //Runs the select query
            $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
            $result = pg_query($conn, $sql);
            //Checks how many records result from the query
            $records = pg_num_rows($result);
            
            //If the information entered results in a resulting record (ie. the username&password are legit) then do this stuff
            if ($records > 0)
            {           
                //session_start();            
                $_SESSION['id'] = $loginID;             
                $_SESSION['user_type'] = pg_fetch_result($result, 0, 1);
              
            echo  $_SESSION['id'];
            echo  $_SESSION['user_type'];
            }
            else
            {
                
            }
        
    }
    else
    {
        //there were problems, concatentate the TRY AGAIN message
        $error .= "<br/>Please Try Again";      
    }
?>



        <section id="MainContent">            
          <p class="t_c">This is where the administrator can make changes to customers, menu items, promotions, and enter pricing pricing information.</p>
<hr/>          
         <form  method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>" >
<table style="margin-left:auto; margin-right:auto;background-color: #CCCCCC;" border="0" cellpadding="10" >
	<tr>
		<td><strong>Login ID</strong></td>
		<td><input type="text" name="login" value="" size="20" /></td>
	</tr>
	<tr>
		<td><strong>Password</strong></td>
		<td><input type="password" name="pass" value="" size="20" /></td>
	</tr>
</table>
<table style="margin-left:auto; margin-right:auto;" border="0" cellspacing="15" >
	<tr>
		<td><input type="submit" value = "Log In" /></td>
		
		<td><input type="reset" value = "Clear" /></td>
	</tr>
</table>
<h3 style="text-align: center"><a href="./password_recovery.php">Forgot Password?</a></h3>
</form>
        </section>
            
<?php include 'footer.php'; ?>