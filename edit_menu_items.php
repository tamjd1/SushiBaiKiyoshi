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

if($_SERVER["REQUEST_METHOD"] == "GET") // If it the first time the page is loaded
{
    $description = "";
    $type = "";
}

else if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
    // Clear out the forms
    $description = "";
    $type = "";
    
    // Trim the inputs
    $description = trim ($_POST ["description"]); 
    $type = trim ($_POST ["type"]);          
    
    // Set the SQL statement
    // Check if there is just one search field
    if($description == "" | $type == "")
        {
        
            $sql = "SELECT tblMenuItems.ItemID, tblMenuItems.ItemDescription, tblMenuItems.ItemPrice ,tblMenuItems.ItemType 
                    FROM tblMenuItems
                    WHERE LOWER(tblMenuItems.ItemDescription) LIKE LOWER('$description') OR LOWER(tblMenuItems.ItemType) LIKE LOWER('$type') )
                    ORDER BY tblMenuItems.ItemDescription ASC";    
        }
        else // Search using both fields
        {
           $sql = "SELECT tblMenuItems.ItemID, tblMenuItems.ItemDescription, tblMenuItems.ItemPrice ,tblMenuItems.ItemType 
                    FROM tblMenuItems
                    WHERE LOWER(tblMenuItems.ItemDescription) LIKE LOWER('$description') AND LOWER(tblMenuItems.ItemType) LIKE LOWER('$type') )
                    ORDER BY tblMenuItems.ItemDescription ASC";    
        }
    
    //$sql = "";

    // connect to the database
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       
        echo
        "<h1>
            ".$message."
        </h1>";
        
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
                  <td>'.pg_fetch_result($result, $i, "ItemID").'</td>
                <td>'.pg_fetch_result($result, $i, "ItemDescription").'</td>
                <td>'.pg_fetch_result($result, $i, "ItemPrice").'</td>
                <td>'.pg_fetch_result($result, $i, "ItemType").'</td>
                <td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
            </tr>';       
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
        <td colspan="2" style="text-align:center;">
      
        <input type="submit" value="Search"/>
        </td>
    </tr>
    </table>
    	</form>
            
            
            
</section>
            
<?php include 'footer.php'; ?>