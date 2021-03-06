<?php
$file = "edit_profile.php";
$title = "Sushi Bai Kiyoshi - Edit Profile";
$banner = "Sushi Bai Kiyoshi - Edit Profile";
$description = "This page is where a login in customer can edit their profile information";
$date = "20/03/2014";

require 'header.php';


if (!isset($_SESSION['UserID'])) // Non login in users to be sent back to index
{
    $_SESSION['message'] = "You must logged in to access this page.";
    header('Location:./index.php');
}


if($_SERVER["REQUEST_METHOD"] == "GET") // If it the first time the page is loaded
{


$userName =  $_SESSION['UserID'];
$firstName =  $_SESSION['UserFirst'];
$lastName =  $_SESSION['UserLast'];
$email =  $_SESSION['UserEmail'];
$phoneNumber =  $_SESSION['UserPhone'];
$emailAddress = $_SESSION['UserEmail'];


    $sql = "SELECT \"UserID\", \"CreditCardNumber\", \"CreditCardExpiryDate\", 
       \"CreditCardType\", \"CardHolder\", \"BillingAddress\", \"BillingCity\", 
       \"BillingProvince\", \"BillingPostalCode\"
  FROM \"tblCreditCards\"
  WHERE \"UserID\" = '$userName'";    
       /*
        $billingAddress
        $CardHolder
        $CreditCardNumber
        $CreditCardExpiryDate
        $CreditCardSecurityCode
*/
    // connect to the database
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    $creditTable ="";
    
    if ($records > 0) // If there are results from the query
    {       
        
        
        $creditTable .= '<table class="tableLayout">';
   
         $creditTable .=   // Create the table titles
        '<tr>
        <td>Card Holder Name</td>
            <td>Billing Address</td>
            
            <td>Credit Card Number</td>
            <td>Expiry Date</td>
            <td>Security Code</td>
           
            <td>Delete</td>
         </tr>';  
                 
        // Generate the table from the results
        for($i = 0; $i < $records; $i++)
        {
        $CreditCardNumber = substr(pg_fetch_result($result, $i, 1), -4);
             $creditTable .=  // Generate the table rows
            '<tr align="center">
            <td>'.pg_fetch_result($result, $i, 4).'</td>
                  <td>'.pg_fetch_result($result, $i, 5).'</td>
                  
                  <td>**** **** **** '.$CreditCardNumber.'</td>
                  <td>'.pg_fetch_result($result, $i, 2).'</td>
                  <td>***</td>
                  <td><input id=\'delete_submit\' name=\'delete_submit\' type=\'submit\' value=\'delete\'></td>
                
                 </tr>';  
        }
        
         $creditTable .=  "</table>"; // Closing table tag
    }
    // If no query results
    else 
    {
        $creditTable = " <p class=\"t_c\">No credit cards</p>";    
    }   
    
    
}

if (!empty($_POST['delete_submit'])) {

echo "asasasasas";  
}


if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
    // Clear out the forms
    $userName =  $_POST['userName'];
    $firstName =  $_POST['firstName'];
    $lastName =  $_POST['lastName'];
    $email =  $_POST['email'];
    $phoneNumber =  $_POST['phoneNumber'];
 
    
    $user_id = $_SESSION['UserID']; 
    
    // Set the SQL statement
    // Check if there is just one search field
        
    $sql = "UPDATE \"tblUsers\"
   SET \"UserFirst\"='$firstName', \"UserLast\"='$lastName', \"UserEmail\"='$email', 
       \"UserPhone\"='$phoneNumber'
 WHERE\"UserID\" = '$user_id'";

       
    
echo $sql;
    // connect to the database
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);   
    
    if ($result)
    {
        
        $userName =  $_POST['userName'];
        $firstName =  $_POST['firstName'];
        $lastName =  $_POST['lastName'];
        $email =  $_POST['email'];
        $phoneNumber =  $_POST['phoneNumber'];

        $_SESSION['UserID'] =  $userName;
        $_SESSION['UserFirst'] = $firstName;
        $_SESSION['UserLast'] = $lastName;
        $_SESSION['UserEmail'] = $email;
        $_SESSION['UserPhone'] = $phoneNumber;    
        $_SESSION['message'] = "Changes saved";
        header("Location: ./edit_profile.php");    
}
}#end of post
?>



    <section id="MainContent">            
    <p class="t_c">
    Make Changes to your profile here.
    </p>
    <hr/>
<form action="" method="post">

    <table id="customerinfo">
        <th colspan="2" class="t_c">
        Personal Information
        </th>
        <tr>
            <td>
            Username
            </td>
            <td>
            <input type="textbox"/ name="userName" value="<?php echo $userName; ?>">
            </td> 
        </tr>
        <tr>
            <td>
            First Name
            </td>
            <td>
            <input type="textbox"/ name="firstName" value="<?php echo $firstName; ?>">
            </td> 
        </tr>
        <tr>
            <td>
            Last Name
            </td>
            <td>
            <input type="textbox"/ name="lastName" value="<?php echo $lastName; ?>">
            </td> 
        </tr>
        <tr>
            <td>
            Email
            </td>
            <td>
            <input type="email" name="email" value="<?php echo $email; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
            Phone Number
            </td>
            <td>
            <input type="textbox" name="phoneNumber" value="<?php echo $phoneNumber; ?>"/>
            </td>
        </tr>    
   <tr>
        <td colspan="2" style="text-align:center;">
      
        <input type="submit" value="Submit Changes"/>
        </td>        
    </table>
    </form>
    <br/>
    <br/>
    
    
    
    <!--
        <table id="billinginfo">
        <th colspan="2" class="t_c">
        Billing Information
        </th>
        <tr>
        <td>
        Address
        </td>
        <td>
        <input type="textbox" name="address" value="<? echo $address; ?>"/>
        </td> 

        </tr>
        <tr>
        <td>
        City
        </td>
        <td>
        <input type="textbox" name="city" value="<? echo $city; ?>"/>
        </td>
        </tr>
        <tr>
        <td>
        Province
        </td>
        <td>
        <input type="textbox" name="province" value="<? echo $province; ?>"/>
        </td>
        </tr>            
        <tr>
        <td>
        Postal Code
        </td>
        <td>
        <input type="textbox" name="postalCode" value="<? echo $postalCode; ?>"/>
        </td>
        </tr>

        </table>   
-->
        <!-- There should be the option to just delete the credit card not change it-->
       <?php echo $creditTable; ?>

    
    <br>

</section>
<?php include 'footer.php'; ?>
