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
$itemID = $_GET["itemID"];
$description = $_GET["description"];
$price = $_GET["price"];
$type = $_GET["type"];
$promotionID = $_GET["promotionID"];


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
    $description = trim ($_POST["description"]);
    $price = trim ($_POST["price"]);
    $type =trim ( $_POST["type"]);
    $promotion =trim ( $_POST["promotion"]);

    
    // Set the SQL statement
    // Check if there is just one search field


    $sql = "UPDATE \"tblMenuItems\"
        SET \"ItemDescription\"='$description', \ItemPrice\"='$price', \"ItemType\"='$type', \"PromotionID\"='$promotion'
        WHERE ItemID='$itemID'";

    
   
    echo $sql;

    // connect to the database
    //$conn = db_connect();
    //issue the query       
    //$result = pg_query($conn, $sql);
    // set records variable to number of found results
    //$records = pg_num_rows($result);    
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
        Edit Information
        </th>
        <tr>
            <td>
            Description
            </td>
            <td>
            <input type="textbox"/ name="description" value="<?php echo $description ?>">
            </td> 
        </tr>
         <tr>
            <td>
            Price
            </td>
            <td>
            <input type="textbox"/ name="price" value="<?php echo $price ?>">
            </td> 
        </tr>
         <tr>
            <td>
            Type
            </td>
            <td>
            <input type="textbox"/ name="type" value="<?php echo $type ?>">
            </td> 
        </tr>
         <tr>
            <td>
            Promotion
            </td>
            <td>
            <select name="promotion">
              <option value="none">None</option>
              <option value="saab">Saab</option>
              <option value="mercedes">Mercedes</option>
              <option value="audi">Audi</option>
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
    
    
    

    
    <br>

</section>
<?php include 'footer.php'; ?>
