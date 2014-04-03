<?php
$file = "edit_menu_items.php";
$title = "Sushi Bai Kiyoshi - Edit Menu Items";
$banner = "Sushi Bai Kiyoshi - Edit Menu Items";
$description = "This page is where the administrator will be able to add/delete items currently on the menu";
$date = "20/03/2014";

require 'header.php';



if (!isset($_SESSION['UserID'])) // Non login in users to be sent back to index
{
    $errorMessage= "You must login into access this page.";
    header('Location:./index.php');
}

if ($_SESSION['UserType'] != 'a') // If not an administrator redirect to main page
{
    $errorMessage= "You are not authorized to access the admin page.";
    header('Location:./index.php');
}
    
// Clear form fields on first load
if($_SERVER["REQUEST_METHOD"] == "GET") // If it the first time the page is loaded
{
    
   
//$_SESSION['message'] = "";
$searchField = "";
$errorMessage=  "";
    $description = "";
    $type= "";
    $price = "";
    $table = "";
    $sql= "SELECT \"tblMenuItems\".\"ItemID\", \"tblMenuItems\".\"ItemDescription\", \"tblMenuItems\".\"ItemPrice\", \"tblMenuItems\".\"ItemType\", \"tblMenuItems\".\"ItemStatus\", \"tblMenuItems\".\"PromotionID\", \"tblPromotions\".\"PromotionDescription\", \"tblPromotions\".\"PromotionValue\", \"tblPromotions\".\"IsPercent\", \"tblPromotions\".\"StartDate\", \"tblPromotions\".\"EndDate\" 
            FROM \"tblMenuItems\" 
            left JOIN \"tblPromotions\"
            ON \"tblMenuItems\".\"PromotionID\" = \"tblPromotions\".\"PromotionID\"
            ORDER BY \"ItemDescription\" ASC";
              
              


    /*
    $sql =  "SELECT \"ItemID\", \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"PromotionID\"
                        FROM \"tblMenuItems\" 
                        
                        ORDER BY \"ItemDescription\" ASC"; */
                        
     $conn = db_connect();
   
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       
       
        
        $table .= '<br/><table class="tableLayout">';
        
         $table .=   // Create the table titles
        '<tr>
            <td>ID</td>
            <td>Description</td>
            <td>Price</td>
            <td>Type</td>
            <td>Promotion</td>
            <td>Enabled</td>
            <td>Edit</td>
         </tr>';  
                 
        // Generate the table from the results
        for($i = 0; $i < $records; $i++)
        {
             $table .=  // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>
                <td>'.pg_fetch_result($result, $i, 2).'$</td>';
                
                
                // display the real names of the type
                if(pg_fetch_result($result, $i, 3) == 'r')
                {
                     $table .=  '<td>Roll</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 's')
                {
                     $table .=  '<td>Sashima</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'sr')
                {
                     $table .=  '<td>Special Roll</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'a')
                {
                     $table .=  '<td>Appetizer</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'c')
                {
                     $table .=  '<td>Combo</td>';
                }
                else
                {
                     $table .=  '<td></td>';
                }
                
                
                 
                 
                 // Checks if there is a promotion
                 if(pg_fetch_result($result, $i, 7) != null)
                 {
                     $table .=  '<td>'.pg_fetch_result($result, $i, 6).' = ';
                    if(pg_fetch_result($result, $i, 7) <= 1)
                    {
                         $table .=  (pg_fetch_result($result, $i, 7) * 100).'%</td>';
                    }
                    else
                    {
                         $table .=  pg_fetch_result($result, $i, 7).'$</td>';
                    }
                 }
                 else
                 {
                 
                     $table .=  '<td></td>';
                 }
                 
                 // Check item status
                 if(pg_fetch_result($result, $i, 4) == 'e')
                 {
                    $table .=  '<td><input type="checkbox" name="enabled" checked disabled></td>';
                 }
                 else
                 {
                      $table .=  '<td><input type="checkbox" name="enabled" disabled></td>';
                 }
                 
                 
              
                
                 $table .=  "<td><a href=
                \"./edit_item.php?
                itemID=".pg_fetch_result($result, $i, 0).
                "&description=".pg_fetch_result($result, $i, 1).
                "&price=".pg_fetch_result($result, $i, 2).
                 "&itemStatus=".pg_fetch_result($result, $i, 4).
                 "&promotionID=".pg_fetch_result($result, $i, 5).
                "&type=".pg_fetch_result($result, $i, 3).
                "\">Edit</a></td>
                
                 </tr>";  
               // echo '<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
              
        }
        
         $table .=  "</table>"; // Closing table tag
    }
    // If no query results
    else 
    {
        $errorMessage= "<br/>No search results";    
    }   

            
}

// Creates the search table
if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
$errorMessage=  "";
    $table = "";
     $description = "";
    $type= "";
    $price = "";
  
    $searchField = "";
    // Trim the inputs
    //$searchField = trim ($_POST ["searchField"]); 
            
    $errorMessage= "Results for '".$searchField."'";
    // Set the SQL statement
    // Check if there is just one search field
  
        
   $sql = "SELECT \"tblMenuItems\".\"ItemID\", \"tblMenuItems\".\"ItemDescription\", \"tblMenuItems\".\"ItemPrice\", \"tblMenuItems\".\"ItemType\", \"tblMenuItems\".\"ItemStatus\", \"tblMenuItems\".\"PromotionID\", \"tblPromotions\".\"PromotionDescription\", \"tblPromotions\".\"PromotionValue\", \"tblPromotions\".\"IsPercent\", \"tblPromotions\".\"StartDate\", \"tblPromotions\".\"EndDate\" 
            FROM \"tblMenuItems\" 
            left JOIN \"tblPromotions\"
            ON \"tblMenuItems\".\"PromotionID\" = \"tblPromotions\".\"PromotionID\"
            
                WHERE 
                LOWER(\"ItemDescription\") LIKE LOWER('%$searchField%')OR 
               
                LOWER(\"ItemType\") LIKE LOWER('%$searchField%')
                             
                ORDER BY \"ItemDescription\" ASC";  
           

    // connect to the database
    //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
   if ($records > 0) // If there are results from the query
    {       
       
        
        $table .= '<br/><table class="tableLayout">';
        
         $table .=   // Create the table titles
        '<tr>
            <td>ID</td>
            <td>Description</td>
            <td>Price</td>
            <td>Type</td>
            <td>Promotion</td>
            <td>Enabled</td>
            <td>Edit</td>
         </tr>';  
                 
        // Generate the table from the results
        for($i = 0; $i < $records; $i++)
        {
             $table .=  // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>
                <td>'.pg_fetch_result($result, $i, 2).'$</td>';
                
                
                // display the real names of the type
                if(pg_fetch_result($result, $i, 3) == 'r')
                {
                     $table .=  '<td>Roll</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 's')
                {
                     $table .=  '<td>Sashima</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'sr')
                {
                     $table .=  '<td>Special Roll</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'a')
                {
                     $table .=  '<td>Appetizer</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'c')
                {
                     $table .=  '<td>Combo</td>';
                }
                else
                {
                     $table .=  '<td></td>';
                }
                
                
                 
                 
                 // Checks if there is a promotion
                 if(pg_fetch_result($result, $i, 7) != null)
                 {
                     $table .=  '<td>'.pg_fetch_result($result, $i, 6).' = ';
                    if(pg_fetch_result($result, $i, 7) <= 1)
                    {
                         $table .=  (pg_fetch_result($result, $i, 7) * 100).'%</td>';
                    }
                    else
                    {
                         $table .=  pg_fetch_result($result, $i, 7).'$</td>';
                    }
                 }
                 else
                 {
                 
                     $table .=  '<td></td>';
                 }
                 
                 // Check item status
                 if(pg_fetch_result($result, $i, 4) == 'e')
                 {
                    $table .=  '<td><input type="checkbox" name="enabled" checked disabled></td>';
                 }
                 else
                 {
                      $table .=  '<td><input type="checkbox" name="enabled" disabled></td>';
                 }
                 
                 
              
                
                 $table .=  "<td><a href=
                \"./edit_item.php?
                itemID=".pg_fetch_result($result, $i, 0).
                "&description=".pg_fetch_result($result, $i, 1).
                "&price=".pg_fetch_result($result, $i, 2).
                 "&itemStatus=".pg_fetch_result($result, $i, 4).
                 "&promotionID=".pg_fetch_result($result, $i, 5).
                "&type=".pg_fetch_result($result, $i, 3).
                "\">Edit</a></td>
                
                 </tr>";  
               // echo '<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
              
        }
        
         $table .=  "</table>"; // Closing table tag
    }
    // If no query results
    else 
    {
        $errorMessage= "<br/>No search results";    
    }   
}#end of post

if (!empty($_POST['add_menu_item'])) 
{
$errorMessage=  "";
   $description = trim($_POST["description"]);
    $price= trim($_POST["price"]);
    $type = trim($_POST["type"]);
     $promotion = trim($_POST["tblPromotions"]);
      $enabled = trim($_POST["enabled"]);
      
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
      if($errorMessage== "")
    {
      if($promotion == 0){
    $promotion='null';}
      $sql = "INSERT INTO \"tblMenuItems\"(
            \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"ItemStatus\", 
            \"PromotionID\")
    VALUES ('$description', $price, '$type', '$enabled', $promotion)";


    
      // connect to the database
    //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if (!$result)
    {
        $errorMessage=  "Error occurred"; 
    }
    else
    {
        $errorMessage= "'$description' Added!";
        
    }
    $description = "";
    $type= "";
    $price = "";
     }
}
?>

<section id="MainContent">         
<a href="./admin.php">Back</a>

<p class="t_c"><?php echo $errorMessage ;?><p> 

<form method="post" action="">
    <table class="center">
        <th colspan="2" class="t_c">
        Add a Menu Item
        </th>
 <tr>
       
        <td>
        Description:
        </td> 
        <td>
        <input type="textbox"/ name="description" value="<?php echo $description;?>">
        </td> 
    </tr>
     <tr>
       
        <td>
        Price:
        </td> 
        <td>
        <input type="textbox"/ name="price" value="<?php echo $price;?>">
        </td> 
    </tr>
     <tr>
       
        <td>
        Type:
        </td> 
        <td>
            <select name="type">
                <option value="" <?php if($type == ''){echo "selected=\"selected\"";}?> >
                </option>
                <option value="r" <?php if($type == 'r'){echo "selected=\"selected\"";}?> >Roll</option>
                <option value="s" <?php if($type == 's'){echo "selected=\"selected\"";}?> >Sashimi</option>
                <option value="sr" <?php if($type == 'sr'){echo "selected=\"selected\"";}?> >Special Roll</option>   
                <option value="a" <?php if($type == 'a'){echo "selected=\"selected\"";}?> >Appetizer</option>   
                <option value="c" <?php if($type == 'c'){echo "selected=\"selected\"";}?> >Combo</option>                   
            </select>
        </td> 
    </tr>
     <tr>
       
        <td>
        Promotion:
        </td> 
        <td>
         <?php create_sticky_dropdown("tblPromotions",'',"None")?>
        </td> 
    </tr>
     <tr>
       
        <td>
        Enabled:
        </td> 
        <td>
         <select name="enabled">
                <option value="e" >Enabled</option>
                <option value="d" >Removed</option>                
            </select>
        </td> 
    </tr>
        <td colspan="2" style="text-align:center;">
      
        <input type="submit" name="add_menu_item"value="Add Item"/>
        </td>
    </tr>
    </table>
</form>
<hr/>
<br/>



<form method="post" action="">
    <table class="center">
        <th colspan="2" class="t_c">
        Menu Item Search
        </th>
    <tr>
       
        <td>
        <input type="textbox"/ name="searchField" value="<?php echo $searchField;?>">
        </td> 
    
        <td colspan="2" style="text-align:center;">
      
        <input type="submit" value="Search"/>
        </td>
    </tr>
    </table>
</form>


        
        
    <?php  echo $table; ?>     
            
</section>
            
<?php include 'footer.php'; ?>