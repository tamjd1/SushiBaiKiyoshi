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

    $itemID = $_GET["itemID"];
    $description = $_GET["description"];
    $price = $_GET["price"];
    $type = $_GET["type"];
    $promotionID = $_GET["promotionID"];
    $itemStatus = $_GET["itemStatus"];
    $table="";
    $_SESSION['promotionEmails'] = "";
         $_SESSION['promotionEmailMessage'] ="";
        

}

if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
    //Trim the inputs
    $description = trim ($_POST["description"]);
    $price = trim ($_POST["price"]);
    $type =trim ( $_POST["type"]);
    $promotion =trim ( $_POST["tblPromotions"]);
    $errorMessage ="";
    
    $promotionID = trim($_POST["tblPromotions"]);
    $itemID = $_GET["itemID"];
    $itemStatus = $_POST["itemStatus"];
    $table="";
     
     if (!isset($description) || $description == "")//if user did not entered anything
	{
		
		 $errorMessage .= "You must enter a description<br/>";
	}
    
     if (!isset($price) || $price == "")
	{
		
		$errorMessage .=  "You must enter a price<br/>";
	}
    else if(!is_numeric($price))//if user entered numeric value
	{
		$errorMessage .=  "Price must be numeric<br/>";
	}
     if (!isset($type) || $type == "")//if user did not entered anything
	{
		
		$errorMessage .=  "You must enter a type<br/>";//don't display the entered data
	}
    // Set the SQL statement
    // Check if there is just one search field
if($promotion == 0){
    $promotion='null';}
    $emails = "";
    $emailMessage ="";
    
    if($errorMessage== "")
    {
    $sql = "UPDATE \"tblMenuItems\"
        SET \"ItemDescription\"='$description', \"ItemPrice\"='$price', \"ItemType\"='$type' , \"ItemStatus\"='$itemStatus', \"PromotionID\"=$promotion
        WHERE \"ItemID\"='$itemID'";


      // connect to the database
    //$conn = db_connect();
    $conn = db_connect();
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
        //header("Location: ./edit_menu_items.php");
        
        
        $sql="SELECT 
              \"tblUsers\".\"UserID\", 
              \"tblUsers\".\"UserEmail\"
              
            FROM \"tblUsers\"
            LEFT OUTER JOIN \"tblCustomerFavourites\"
                ON \"tblUsers\".\"UserID\"=\"tblCustomerFavourites\".\"UserID\"
            LEFT OUTER JOIN \"tblMenuItems\"
                ON \"tblCustomerFavourites\".\"ItemID\"=\"tblMenuItems\".\"ItemID\"
            LEFT OUTER JOIN \"tblPromotions\"
                ON \"tblMenuItems\".\"PromotionID\"=\"tblPromotions\".\"PromotionID\"
            WHERE \"tblMenuItems\".\"PromotionID\" = $promotion
            GROUP BY \"tblUsers\".\"UserID\", \"tblUsers\".\"UserEmail\"";

 //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    

    if($records > 0)
    {
        
         $table .= "<p class=\"t_c\">Customers who favourited  '".$description."'</p>";
             $table .= '<table class="tableLayout">';
        $table .=  // Create the table titles
        '
       
        <tr>
            <td>User ID</td>
            <td>Email Adress</td>         
         </tr>';  
         
        for($i = 0; $i < $records; $i++)
        {
            $table .=   
            '<tr>
                <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>         
            </tr>';  
            $emails .= pg_fetch_result($result, $i, 1).", ";
         }
        
        
         $sql="SELECT \"PromotionDescription\", \"PromotionValue\", \"IsPercent\", 
       \"StartDate\", \"EndDate\"
  FROM \"tblPromotions\"
  WHERE \"PromotionID\" = '$promotionID'";
  
   $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);  
  
        $emailMessage .= "Hello valued customer! There is a new \"".pg_fetch_result($result, 0, 0)."\" on the '$description'!!! Thats ";
        
        
        if(pg_fetch_result($result, 0, 1) <= 1) // hard coded check for if a percent cause database messed up
        {
            $emailMessage .= (pg_fetch_result($result, 0, 1) * 100).'%';
         }
        else
        {
            $emailMessage.= pg_fetch_result($result, 0, 1);
        }
        
        $emailMessage .= " off the '$description' starting ".pg_fetch_result($result, 0, 3)." until ".pg_fetch_result($result, 0, 4);
         $table .= "<tr><td>$emails</td><td>$emailMessage</td></tr>";
        $_SESSION['promotionEmails'] = $emails;
        $_SESSION['promotionEmailMessage'] = $emailMessage;
    }    
    else 
    {
        header("Location: ./edit_menu_items.php");
    }
    }
    $table .= "</table><br/>";
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
               
                
                <option value="Rolls" <?php if($type == 'Rolls'){echo "selected=\"selected\"";}?> >Rolls</option>
                <option value="Sashimi" <?php if($type == 'Sashimi'){echo "selected=\"selected\"";}?> >Sashimi</option>
                <option value="Special Rolls" <?php if($type == 'Special Rolls'){echo "selected=\"selected\"";}?> >Special Rolls</option>   
                <option value="Appetizers" <?php if($type == 'Appetizers'){echo "selected=\"selected\"";}?> >Appetizers</option>   
                <option value="Combos" <?php if($type == 'Combos'){echo "selected=\"selected\"";}?> >Combos</option>                   
            </select>
           
            </td> 
        </tr>
         <tr>
            <td>
            Promotion
            </td>
            <td>
             <?php create_sticky_dropdown("tblPromotions", $promotionID, "None" )?>
            
            </td> 
        </tr>
          <tr>
            <td>
            Item Status
            </td>
            <td>
            <select name="itemStatus">
                <option value="e" >Enabled</option>
                <option value="d"<?php if($itemStatus == 'd'){echo "selected=\"selected\"";}?> >Removed</option>                
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
  
 
    <?php echo $table;?>
    <br/>

 

    <br/>

</section>
<?php include 'footer.php'; ?>
