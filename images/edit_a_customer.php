<?php
$file = "edit_profile.php";
$title = "Sushi Bai Kiyoshi - Edit Profile";
$banner = "Sushi Bai Kiyoshi - Edit Profile";
$description = "This page is where a login in customer can edit their profile information";
$date = "20/03/2014";

require 'header.php';



if (!isset($_SESSION['UserID'])) // Non login in users to be sent back to index
{
    $_SESSION['message'] = "You must login into access this page.";
    header('Location:./index.php');
}

if ($_SESSION['UserType'] != 'a') // If not an administrator redirect to main page
{
    $_SESSION['message'] = "You are not authorized to access the admin page.";
    header('Location:./index.php');
}


if($_SERVER["REQUEST_METHOD"] == "GET") // If it the first time the page is loaded
{

$userID = $_GET["userID"];
$first = $_GET["first"];
$last = $_GET["last"];
$email = $_GET["email"];
$phone = $_GET["phone"];
$type = $_GET["type"];




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
    //Trim the inputs
    $userID = trim ($_GET["userID"]);
$first = trim ($_POST["first"]);
$last = trim ($_POST["last"]);
$email = trim ($_POST["email"]);
$phone = trim ($_POST["phone"]);
$type = trim ($_POST["type"]);
  

    
    // Set the SQL statement
    // Check if there is just one search field


    $sql = "UPDATE \"tblUsers\"
        SET \"UserFirst\"='$first', \"UserLast\"='$last', \"UserEmail\"='$email' , \"UserPhone\"='$phone', \"UserType\"='$type'
        WHERE \"UserID\"='$userID'";

echo $sql;
      // connect to the database
    //$conn = db_connect();
    $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if (!$result)
    {
        $message = "An error occurred"; 
        
    }
    else
    {
        $_SESSION['message'] = "Change Made to '".$userID."'!";
        header("Location: ./customer_status.php");
    }
    
    
   
   
}#end of post
?>



    <section id="MainContent">            
    <p class="t_c">
    Make Changes to "<?php echo $userID ?>".
    </p>
    <hr/>
    
<form action="" method="post">
<a href="./customer_status.php">Back</a>
    <table id="customerinfo">
        <th colspan="2" class="t_c">
        Edit Customer Information
        </th>
        <tr>
            <td>
            ID
            </td>
            <td>
            <input type="textbox"/ name="userID" value="<?php echo $userID ?>" disabled>
            </td> 
        </tr>
         <tr>
            <td>
            First Name
            </td>
            <td>
            <input type="textbox"/ name="first" value="<?php echo $first ?>">
            </td> 
        </tr>
         <tr>
            <td>
            Last Name
            </td>
            <td>
             <input type="textbox"/ name="last" value="<?php echo $last ?>">
            </td> 
        </tr>
         <tr>
            <td>
            Email
            </td>
            <td>
            <input type="textbox"/ name="email" value="<?php echo $email ?>">
            </td> 
        </tr>
          <tr>
            <td>
            Phone
            </td>
            <td>
             <input type="textbox"/ name="phone" value="<?php echo $phone ?>">
            </td> 
        </tr>
         <tr>
            <td>
            Type
            </td>
            <td>
              <select name="type">
            <option value="c" >Enabled</option>
              <option value="d" >Disabled</option>
              <option value="a">Administrator</option>
             
            </select>
            </td> 
        </tr>
       
        
        <tr>
        <td colspan="2" style="text-align:center;">
      
        <input type="submit" value="Submit Changes"/>
        </td>
    </tr>
                
    </table>
    </form>
    <br/>
    <br/>
    
   

</section>
<?php include 'footer.php'; ?>
