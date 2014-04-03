<?php
$file = "edit_menu_items.php";
$title = "Sushi Bai Kiyoshi - Edit Menu Items";
$banner = "Sushi Bai Kiyoshi - Edit Menu Items";
$description = "This page is where the administrator will be able to add/delete items currently on the menu";
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

$promotionID = trim ($_GET["promotionID"]);
 $description = trim ($_GET["description"]);
    $value = trim ($_GET["value"]);
    $isPercent =trim ( $_GET["isPercent"]);
    $startDate =trim ( $_GET["startDate"]);
    $endDate =trim ( $_GET["endDate"]);
}
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    //Trim the inputs
    $promotionID = trim ($_GET["promotionID"]);
    $description = trim ($_POST["description"]);
    $value = trim ($_POST["value"]);
        $isPercent =trim ( $_POST["isPercent"]);
    $startDate =trim ( $_POST["startDate"]);
    $endDate =trim ( $_POST["endDate"]);
   

    
    // Set the SQL statement
    // Check if there is just one search field

 $sql =  "UPDATE \"tblPromotions\"
   SET \"PromotionDescription\"='$description', \"PromotionValue\"='$value', 
       \"IsPercent\"=$isPercent, \"StartDate\"='$startDate', \"EndDate\"='$endDate'
 WHERE \"PromotionID\"=$promotionID";
echo $sql;

 
      // connect to the database
    $conn = db_connect();
   
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if (!$result)
    {
        echo "Error occurred"; 
    }
    else
    {
        $_SESSION['message'] = "Change Made to '".$description."'!";
        header("Location: ./edit_promotions.php");
        
    }
}
   
?>



<section id="MainContent">         

<p class="t_c">Make changes to the promotion "<?php echo $description ?>"</p>
<hr/>
<form action="" method="post">
<a href="./admin.php">Back</a>
    <table id="customerinfo">
        <th colspan="2" class="t_c">
        Edit Promotion
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
            Value
            </td>
            <td>
            <input type="text" name="value" value="<?php echo $value ?>" min="0" max="1000">
            </td> 
        </tr>
         <tr>
            <td>
            Value Percent or Dollar
            </td>
            <td>
              <select name="isPercent">
              <option value=TRUE >Percent</option>
             <option value=FALSE >Dollar</option>
            </select>
            </td> 
        </tr>
        <tr>
            <td>
            Start Date
            </td>
            <td>
            <input type="date"/ name="startDate" value="<?php echo $startDate ?>">
            </td> 
        </tr>
        <tr>
            <td>
            End Date
            </td>
            <td>
            <input type="date"/ name="endDate" value="<?php echo $endDate ?>">
            </td> 
        </tr>
           <tr>
                <td colspan="2" style="text-align:center;">
                 
                    <input type="submit" name="submit" value="Save Changes"/>
                    
                </td>
            </tr>
       
    </table>
    </form>
<br/>

<br/>
</section>
            
<?php include 'footer.php'; ?>