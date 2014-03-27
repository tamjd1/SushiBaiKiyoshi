<?php
$file = "edit_menu_items.php";
$title = "Sushi Bai Kiyoshi - Edit Menu Items";
$banner = "Sushi Bai Kiyoshi - Edit Menu Items";
$description = "This page is where the administrator will be able to add/delete items currently on the menu";
$date = "20/03/2014";

require 'header.php';

/*
if (!isset($_SESSION['id'])) // Non administrators to be sent back to index
{
    $_SESSION['message'] = "You must login into access the admin page.";
    header('Location:./index.php');
}

if ($_SESSION['usertype'] != 'a') // If not an administrator redirect to main page
{
    $_SESSION['message'] = "You are not authorized to access the admin page.";
    header('Location:./index.php');
}
    */
    
$message = $_SESSION['message'];
echo $_SESSION['message'];
if($_SERVER["REQUEST_METHOD"] == "GET") // If it the first time the page is loaded
{
if($message!="")
{
    echo $message;
}
    $description = "";
    $type = "";
    $sql= "SELECT \"tblMenuItems\".\"ItemID\", \"tblMenuItems\".\"ItemDescription\", \"tblMenuItems\".\"ItemPrice\", \"tblMenuItems\".\"ItemType\", \"tblMenuItems\".\"ItemStatus\", \"tblMenuItems\".\"PromotionID\", \"tblPromotions\".\"PromotionDescription\", \"tblPromotions\".\"PromotionValue\", \"tblPromotions\".\"IsPercent\", \"tblPromotions\".\"StartDate\", \"tblPromotions\".\"EndDate\" 
            FROM \"tblMenuItems\" 
            left JOIN \"tblPromotions\"
            ON \"tblMenuItems\".\"PromotionID\" = \"tblPromotions\".\"PromotionID\"
            ORDER BY \"ItemDescription\" ASC";
              
              


    /*
    $sql =  "SELECT \"ItemID\", \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"PromotionID\"
                        FROM \"tblMenuItems\" 
                        
                        ORDER BY \"ItemDescription\" ASC"; */
                        
     //$conn = db_connect();
    $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       
       
        
        echo '<br/><table class="tableLayout">';
        
        echo  // Create the table titles
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
            echo // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>
                <td>'.pg_fetch_result($result, $i, 2).'$</td>';
                
                
                // display the real names of the type
                if(pg_fetch_result($result, $i, 3) == 'r')
                {
                    echo '<td>Roll</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 's')
                {
                    echo '<td>Sashima</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'sr')
                {
                    echo '<td>Special Roll</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'a')
                {
                    echo '<td>Appetizer</td>';
                }
                else if(pg_fetch_result($result, $i, 3) == 'c')
                {
                    echo '<td>Combo</td>';
                }
                else
                {
                    echo '<td></td>';
                }
                
                
                 
                 
                 // Checks if there is a promotion
                 if(pg_fetch_result($result, $i, 7) != null)
                 {
                    echo '<td>'.pg_fetch_result($result, $i, 6).' = ';
                    if(pg_fetch_result($result, $i, 7) <= 1)
                    {
                        echo (pg_fetch_result($result, $i, 7) * 100).'%</td>';
                    }
                    else
                    {
                        echo pg_fetch_result($result, $i, 7).'$</td>';
                    }
                 }
                 else
                 {
                 
                    echo '<td></td>';
                 }
                 
                 // Check item status
                 if(pg_fetch_result($result, $i, 4) == 'e')
                 {
                   echo '<td><input type="checkbox" name="enabled" checked disabled></td>';
                 }
                 else
                 {
                     echo '<td><input type="checkbox" name="enabled" disabled></td>';
                 }
                 
                 
              
                
                echo "<td><a href=
                \"./edit_item.php?
                itemID=".pg_fetch_result($result, $i, 0).
                "&description=".pg_fetch_result($result, $i, 1).
                "&price=".pg_fetch_result($result, $i, 2).
                 "&itemStatus=".pg_fetch_result($result, $i, 4).
                 "&promotionID=".pg_fetch_result($result, $i, 6).
                "&type=".pg_fetch_result($result, $i, 3).
                "\">Edit</a></td>
                
                 </tr>";  
               // echo '<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
                
        }
        
        echo "</table>"; // Closing table tag
    }
    // If no query results
    else 
    {
        echo "<br/>No search results";    
    }   
}

else if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
    // Clear out the variables
    $description = "";
    $type = "";
    
    // Trim the inputs
    $description = trim ($_POST ["description"]); 
    $type = trim ($_POST ["type"]);          
    
    // Set the SQL statement
    // Check if there is just one search field
    if($description == "" | $type == "")
        {
        "SELECT \"ItemID\", \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"PromotionID\"
FROM \"tblMenuItems\" 
WHERE LOWER(\"ItemDescription\") LIKE LOWER('$description') OR 
	LOWER(\"ItemType\") LIKE LOWER('$type')
	ORDER BY \"ItemDescription\" ASC";
    
            $sql =  "SELECT \"ItemID\", \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"PromotionID\"
                        FROM \"tblMenuItems\" 
                        WHERE LOWER(\"ItemDescription\") LIKE LOWER('$description') OR 
                        LOWER(\"ItemType\") LIKE LOWER('$type')
                        ORDER BY \"ItemDescription\" ASC"; 
        }
        else // Search using both fields
        {
           $sql = "SELECT \"ItemID\", \"ItemDescription\", \"ItemPrice\", \"ItemType\", \"PromotionID\"
                        FROM \"tblMenuItems\" 
                        WHERE LOWER(\"ItemDescription\") LIKE LOWER('$description') AND 
                        LOWER(\"ItemType\") LIKE LOWER('$type')
                        ORDER BY \"ItemDescription\" ASC";  
        }
    
     
   

    // connect to the database
    //$conn = db_connect();
    $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       
       
        
        echo '<table class="tableLayout">';
        
        echo  // Create the table titles
        '<tr>
            <td>ID</td>
            <td>Description</td>
            <td>Price</td>
            <td>Type</td>
            <td>Edit</td>
         </tr>';  
                 
        // Generate the table from the results
        for($i = 0; $i < $records; $i++)
        {
            echo // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>
                <td>'.pg_fetch_result($result, $i, 2).'</td>
                <td>'.pg_fetch_result($result, $i, 3).'</td>';
                echo "<td><a href=
                \"./edit_item.php?
                id=".pg_fetch_result($result, $i, 0).
                "&description=".pg_fetch_result($result, $i, 1).
                "&price=".pg_fetch_result($result, $i, 2).
                "&type=".pg_fetch_result($result, $i, 3).
                "\">Edit</a></td>
                 </tr>";  
               // echo '<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
                
        }
        
        echo "</table>"; // Closing table tag
    }
    // If no query results
    else 
    {
        echo "<br/>No search results";    
    }   
}#end of post




// old stuff///////////////////////////////////////////////////
// $test =0;
// echo '<br/><table class="tableLayout">';
            // echo '<tr>';
                // echo '<td>ID</td>';
                // echo '<td>Description</td>';
                // echo '<td>Price</td>';
                // echo '<td>Type</td>';
                // echo '<td>Edit</td>';
            // echo '</tr>';


            // while ($test < 30){

            // echo '<tr align="center">
                    // <td>ID here</td>
                    // <td>Description Here</td>
                    // <td>Type Here</td>
                    // <td></td>';
                
     

            // echo "<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>";

            // echo '</tr>';
// $test +=1;

                // }#end of while


         



// echo '</table>';

?>



<section id="MainContent">         
<br/>   

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
     </tr>
        <td colspan="2" style="text-align:center;">
        or
        </td>
    </tr>
    <tr>
        <td>
        Item Type:
        </td>
        <td>
        <input type="textbox"/ name="type" value="<?php echo $type;?>"> 
        </td> 
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;">
      
        <input type="submit" value="Search"/>
        </td>
    </tr>
    </table>
    	</form>
            
            
            
</section>
            
<?php include 'footer.php'; ?>