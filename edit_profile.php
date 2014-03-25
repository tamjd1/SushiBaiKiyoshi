<?php
$file = "edit_profile.php";
$title = "Sushi Bai Kiyoshi - Edit Profile";
$banner = "Sushi Bai Kiyoshi - Edit Profile";
$description = "This page is where a login in customer can edit their profile information";
$date = "20/03/2014";

require 'header.php';


/*
if (!isset($_SESSION['id'])) // Non login in users to be sent back to index
{
    $_SESSION['message'] = "You must login into access this page.";
    header('Location:./index.php');
}

*/ 


if($_SERVER["REQUEST_METHOD"] == "GET") // If it the first time the page is loaded
{

$userName = "Tom";
$emailAddress = "tomDaison12@hotmail.com";

/*
    $sql = "SELECT users.id, users.usertype, agents.first_name, agents.last_name
            FROM users, agents 
            WHERE users.id=agents.user_id AND ( LOWER(agents.first_name) LIKE LOWER('$firstname') OR LOWER(agents.last_name) LIKE LOWER('$lastname') )
            ORDER BY users.enroll_date ASC";    
       
    

    // connect to the database
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    */
}

if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
    // Clear out the forms
   
    
    // Trim the inputs
    $user_id = trim ($_POST ["user_id"]);      
    
    // Set the SQL statement
    // Check if there is just one search field
        
    $sql = "SELECT users.id, users.usertype, agents.first_name, agents.last_name
            FROM users, agents 
            WHERE users.id=agents.user_id AND ( LOWER(agents.first_name) LIKE LOWER('$firstname') OR LOWER(agents.last_name) LIKE LOWER('$lastname') )
            ORDER BY users.enroll_date ASC";    
       
    

    // connect to the database
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
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
            <input type="textbox"/ name="name" value="<? echo $userName; ?>">
            </td> 
        </tr>
        <tr>
            <td>
            First Name
            </td>
            <td>
            <input type="textbox"/ name="name" value="<? echo $firstName; ?>">
            </td> 
        </tr>
        <tr>
            <td>
            Last Name
            </td>
            <td>
            <input type="textbox"/ name="name" value="<? echo $lastName; ?>">
            </td> 
        </tr>
        <tr>
            <td>
            Email
            </td>
            <td>
            <input type="email" name="email" value="<? echo $email; ?>"/>
            </td>
        </tr>
        <tr>
            <td>
            Phone Number
            </td>
            <td>
            <input type="textbox" name="phoneNumber" value="<? echo $phoneNumber; ?>"/>
            </td>
        </tr>            
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
        <table id="creditcardinfo">
        <th colspan="2" class="t_c">
        Credit Card(s)
        </th>
        <tr>
        <th>
        Address
        </th>
        <th>
        Name on Card
        </th>
        <th>
        Card number
        </th>
        <th>
        Expiration Date
        </th>
        <th>
        Security Code
        </th>
        <th>
        Delete
        </th>
        </tr>

        <tr>
        <td>
        1303 Country RD 2
        </td>
        <td>
        Thom Davison
        </td>
        <td>
        ************4474
        </td>
        <td>
        09/14
        </td>
        <td>
        913
        </td>               
        <td>
        <a href="edit_profile.php" <input type=\"submit\" value=\"Edit\" />Delete</a>
        </td>
        </tr>
        <tr>
        <td colspan="5" style="text-align:right;">
        <input type="button" value="Add Another Card"/>
        </td>
        </tr>
        </tr>
        <tr>
        <td colspan="5" style="text-align:center;">
        <br>
        <br>
        <br>
        <br>
        <input type="submit" value="Submit Changes"/>

        </td>
        </tr>
        </table>  

    
    <br>

</section>
<?php include 'footer.php'; ?>
