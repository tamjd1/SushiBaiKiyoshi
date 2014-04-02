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


<?php
$errorMessage=  "";
    $table ="";
    $description = "";
    $type = "";
    $sql =  "SELECT * FROM \"tblUsers\"
    ORDER BY \"UserType\" ASC";
                        
     
     //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       

        $table .= '<br/> <table class="tableLayout">';
        
        $table .=  // Create the table titles
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
            $table .= // Generate the table rows
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
                   $table .= '<td>Administrator</td>';
                 }
                 else if(pg_fetch_result($result, $i, 6) == 'c')
                 {
                   $table .= '<td>Customer</td>';
                 }
                 else if(pg_fetch_result($result, $i, 6) == 'd')
                 {
                   $table .= '<td>Disabled</td>';
                 }
                $table .= "<td><a href=
                \"./edit_a_customer.php?
                userID=".pg_fetch_result($result, $i, 0).
                "&first=".pg_fetch_result($result, $i, 2).
                "&last=".pg_fetch_result($result, $i, 3).
                "&email=".pg_fetch_result($result, $i, 4).
                 "&phone=".pg_fetch_result($result, $i, 5).
                  "&type=".pg_fetch_result($result, $i, 6).
                "\">Edit</a></td>";
                
                
                
                 $table .= "</tr>";  
               // $table .= '<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
                
        }
        
        $table .= "</table>"; // Closing table tag
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
    $table ="";
    $description = "";
  $errorMessage=  "";
    
    // Trim the inputs
    $description = trim ($_POST ["description"]); 
        
    
    // Set the SQL statement
    // Check if there is just one search field
    
            $sql = "SELECT \"UserID\", \"Password\", \"UserFirst\", \"UserLast\", \"UserEmail\", \"UserPhone\", 
                            \"UserType\"
                    FROM \"tblUsers\"
                    WHERE 
                    LOWER(\"UserID\") LIKE LOWER('%$description%')OR 
                    LOWER(\"UserEmail\") LIKE LOWER('%$description%')  
                    OR 
                    LOWER(\"UserPhone\") LIKE LOWER('%$description%')                       
                    ORDER BY \"UserID\" ASC";  ;
        
      
  
     
   

    // connect to the database
    //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       

        $table .= '<br/> <table class="tableLayout">';
        
        $table .=  // Create the table titles
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
            $table .= // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 2).'</td>
                <td>'.pg_fetch_result($result, $i, 3).'</td>
                 <td>'.pg_fetch_result($result, $i, 4).'</td>
                <td>'.pg_fetch_result($result, $i, 5).'</td>';
                  // Check item status
                 if(pg_fetch_result($result, $i, 6) == 'a')
                 {
                   $table .= '<td>Administrator</td>';
                 }
                 else if(pg_fetch_result($result, $i, 6) == 'c')
                 {
                   $table .= '<td>Customer</td>';
                 }
                 else if(pg_fetch_result($result, $i, 6) == 'd')
                 {
                   $table .= '<td>Disabled</td>';
                 }
                
                
                $table .= "<td><a href=
                \"./edit_a_customer.php?
                userID=".pg_fetch_result($result, $i, 0).
                "&first=".pg_fetch_result($result, $i, 2).
                "&last=".pg_fetch_result($result, $i, 3).
                "&email=".pg_fetch_result($result, $i, 4).
                 "&phone=".pg_fetch_result($result, $i, 5).
                  "&type=".pg_fetch_result($result, $i, 6).
                "\">Edit</a></td>";
                
                 $table .= "</tr>";  
               // $table .= '<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
                
        }
        
        $table .= "</table>"; // Closing table tag
         $errorMessage= "Search results for '$description'"; 
    }
    // If no query results
    else 
    {
        $errorMessage= "No search results for '$description'";    
    }   
}#end of post


?>

<section id="MainContent">      
<a href="./admin.php">Back</a>

<p class="t_c"><?php echo $errorMessage ;?><p> 


<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <table class="center">
        <th colspan="2" class="t_c">
        User Search
        </th>
    <tr>
       
        <td>
        <input type="textbox"/ name="description" value="<?php echo $description;?>">
        </td> 
         <td colspan="2" style="text-align:center;">
      
        <input type="submit" value="Search"/>
        </td>
    </tr>
   
  
  
    </table>
    	</form>
            
            <?php echo $table ?>
            
</section>
            
<?php include 'footer.php'; ?>