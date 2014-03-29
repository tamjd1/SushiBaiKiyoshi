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
    
// Clear form fields on first load
if($_SERVER["REQUEST_METHOD"] == "GET") // If it the first time the page is loaded
{
    
   
//$_SESSION['message'] = "";
    $description = "";
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
        $_SESSION['message'] = "<br/>No search results";    
    }   

            
}

// Creates the search table
if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
    $table = "";
    
    // Trim the inputs
    $description = trim ($_POST ["description"]); 
            
    
    // Set the SQL statement
    // Check if there is just one search field
  
        
   $sql = "SELECT \"tblMenuItems\".\"ItemID\", \"tblMenuItems\".\"ItemDescription\", \"tblMenuItems\".\"ItemPrice\", \"tblMenuItems\".\"ItemType\", \"tblMenuItems\".\"ItemStatus\", \"tblMenuItems\".\"PromotionID\", \"tblPromotions\".\"PromotionDescription\", \"tblPromotions\".\"PromotionValue\", \"tblPromotions\".\"IsPercent\", \"tblPromotions\".\"StartDate\", \"tblPromotions\".\"EndDate\" 
            FROM \"tblMenuItems\" 
            left JOIN \"tblPromotions\"
            ON \"tblMenuItems\".\"PromotionID\" = \"tblPromotions\".\"PromotionID\"
            
                WHERE 
                LOWER(\"ItemDescription\") LIKE LOWER('%$description%')OR 
               
                LOWER(\"ItemType\") LIKE LOWER('%$description%')
                             
                ORDER BY \"ItemDescription\" ASC";  
        
    
     
   

    // connect to the database
    //$conn = db_connect();
    $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
   if ($records > 0) // If there are results from the query
    {       
       
        $_SESSION['message'] = "Results for '".$description."'";
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
        $_SESSION['message'] = "<br/>No search results";    
    }   
}#end of post

?>



<section id="MainContent">         
<br/>   
<a href="./admin.php">Back</a>
<p class="message">
<?php echo  $_SESSION['message']; ?></p>


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table class="center">
        <th colspan="2" class="t_c">
        Search for a Menu Item
        </th>
    <tr>
        <td>
        Item Description:
        </td>
        <td>
        <input type="textbox"/ name="description" value="<?php echo $description;?>">
        </td> 
    </tr>
   
    <tr>
        <td colspan="2" style="text-align:center;">
      
        <input type="submit" value="Search"/>
        </td>
    </tr>
    </table>
</form>
        
        
    <?php  echo $table; ?>     
            
</section>
            
<?php include 'footer.php'; ?>