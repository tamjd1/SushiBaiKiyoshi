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
$itemStatus = $_GET["itemStatus"];




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
   
$itemID = $_GET["itemID"];
$itemStatus = $_POST["itemStatus"];
    
    // Set the SQL statement
    // Check if there is just one search field


    $sql = "UPDATE \"tblMenuItems\"
        SET \"ItemDescription\"='$description', \"ItemPrice\"='$price', \"ItemType\"='$type' , \"ItemStatus\"='$itemStatus', \"PromotionID\"=$promotion
        WHERE \"ItemID\"='$itemID'";


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
        $_SESSION['message'] = "Change Made to ".$description."!";
        header("Location: ./edit_menu_items.php");
    }
    
    
   
   
}#end of post
?>



    <section id="MainContent">            
    <p class="t_c">
    Make Changes to "<?php echo $description ?>".
    </p>
    <hr/>
<form action="" method="post">
<a href="./edit_menu_items.php">Back</a>
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
            <select name="type">
              <option value="r" >Roll</option>
              <option value="s">Sashimi</option>
              <option value="sr">Special Roll</option>
              <option value="a">Appetizer</option>
                <option value="c">Combo</option>
            </select>
            </td> 
        </tr>
         <tr>
            <td>
            Promotion
            </td>
            <td>
            <select name="promotion">
            <option value=null >None</option>
              <option value="1" >Salmon Sale</option>
              <option value="2">Tuna Sale</option>
              <option value="3">Unagi Sale</option>
              <option value="4">Crab Sale</option>
                <option value="5">Red Snapper</option>
            </select>
            </td> 
        </tr>
          <tr>
            <td>
            Item Status
            </td>
            <td>
            <select name="itemStatus">
              <option value="e" >Enable</option>
              <option value="d">Disable</option>
              
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
