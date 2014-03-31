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
{?>
<a href="./admin.php">Back</a>

<?php
    $description = "";
    $type = "";
    $sql =  "SELECT * FROM \"tblUsers\"
    ORDER BY \"UserType\" ASC";
                        
     
     //$conn = db_connect();
    $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       

        echo '<br/> <table class="tableLayout">';
        
        echo  // Create the table titles
        '<tr>
            <td>ID</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Phone</td>           
           
             <td>Type</td>
            <td>Edit</td>
            
         </tr>';  
                 
        // Generate the table from the results
        for($i = 0; $i < $records; $i++)
        {
            echo // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 2).'</td>
                <td>'.pg_fetch_result($result, $i, 3).'</td>
                 <td>'.pg_fetch_result($result, $i, 4).'</td>
                <td>'.pg_fetch_result($result, $i, 5).'</td>
           ';
                  // Check item status
                 if(pg_fetch_result($result, $i, 6) == 'a')
                 {
                   echo '<td>Administrator</td>';
                 }
                 else if(pg_fetch_result($result, $i, 6) == 'c')
                 {
                   echo '<td>Customer</td>';
                 }
                 else if(pg_fetch_result($result, $i, 6) == 'd')
                 {
                   echo '<td>Disabled</td>';
                 }
                echo "<td><a href=
                \"./edit_a_customer.php?
                userID=".pg_fetch_result($result, $i, 0).
                "&first=".pg_fetch_result($result, $i, 2).
                "&last=".pg_fetch_result($result, $i, 3).
                "&email=".pg_fetch_result($result, $i, 4).
                 "&phone=".pg_fetch_result($result, $i, 5).
                  "&type=".pg_fetch_result($result, $i, 6).
                "\">Edit</a></td>'";
                
                
                
                 echo "</tr>";  
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
                ">Edit</a></td>
                 </tr>";  
               // echo '<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
                
        }
        
        echo "</table><br/>"; // Closing table tag
        
      
        
    }
    // If no query results
    else 
    {
        echo "<br/>No search results";    
    }   
}#end of post


?>



<section id="MainContent">      


<br/>   
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table class="center">
        <th colspan="2" class="t_c">
        Search for User
        </th>
    <tr>
        <td>
        User Name
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
        Email Address
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