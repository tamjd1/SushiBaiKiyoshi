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

 $table = "";
 $sql = "SELECT *
            FROM \"tblPromotions\"
            ORDER BY \"StartDate\"";    
        
       
    
  

    // connect to the database
    //$conn = db_connect();
    $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {       
        
        
        $table .= '<table class="tableLayout">';
   
         $table .=   // Create the table titles
        '<tr>
            <td>ID</td>
            <td>Description</td>
            <td>Value</td>
            <td>Start Date</td>
            <td>End Date</td>
           
            <td>Edit</td>
         </tr>';  
                 
        // Generate the table from the results
        for($i = 0; $i < $records; $i++)
        {
             $table .=  // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>';
                
                 $table .=  '<td>';
                if(pg_fetch_result($result, $i, 2) <= 1) // hard coded check for if a percent cause database messed up
                {
                     $table .=  (pg_fetch_result($result, $i, 2) * 100).'%</td>';
                }
                else
                {
                     $table .=  pg_fetch_result($result, $i, 2).'$</td>';
                }
               $table .=  '</td>';
                
            
               // show dates
                 $table .=  '<td>'.pg_fetch_result($result, $i, 4).'</td>
                <td>'.pg_fetch_result($result, $i, 5).'</td>';
             
                
             
                  
   
                   $table .=  "<td><a href=
                \"./edit_a_promotion.php?
                promotionID=".pg_fetch_result($result, $i, 0).
                "&description=".pg_fetch_result($result, $i, 1).
                "&value=".pg_fetch_result($result, $i, 2).
                 "&isPercent=".pg_fetch_result($result, $i, 3).
                 "&startDate=".pg_fetch_result($result, $i, 4).
                "&endDate=".pg_fetch_result($result, $i, 5).
                "\">Edit</a></td>
                
                 </tr>";  
        }
        
         $table .=  "</table>"; // Closing table tag
    }
    // If no query results
    else 
    {
        echo "<br/>No search results";    
    }   
}
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
    //Trim the inputs
    $description = trim ($_POST["description"]);
    $value = trim ($_POST["value"]);
    $isPercent =trim ( $_POST["isPercent"]);
    $startDate =trim ( $_POST["startDate"]);
    $endDate =trim ( $_POST["endDate"]);
   

    
    // Set the SQL statement
    // Check if there is just one search field


    $sql = "INSERT INTO \"tblPromotions\"(
             \"PromotionDescription\", \"PromotionValue\", \"IsPercent\", 
            \"StartDate\", \"EndDate\")
    VALUES ('$description','$value', $isPercent,'$startDate','$endDate');";

 
      // connect to the database
    //$conn = db_connect();
    $conn = pg_connect("host=localhost port=5432 dbname=sb user=postgres password=vdragon");
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if (!$result)
    {
        $_SESSION['message'] = "Error occurred"; 
    }
    else
    {
        $_SESSION['message'] = "Promotion Added!";
        
     
    }
}
   
?>



<section id="MainContent">         

<p class="t_c">Promotions listed from newest to oldest</p>
<hr/>
<a href="./admin.php">Back</a>
<p class="message">
<?php echo  $_SESSION['message']; ?></p>
<form action="" method="post">

    <table id="customerinfo">
        <th colspan="2" class="t_c">
        Add Promotion
        </th>
        <tr>
            <td>
            Description
            </td>
            <td>
            <input type="textbox"/ name="description" value="">
            </td> 
        </tr>
        <tr>
            <td>
            Value
            </td>
            <td>
            <input type="number" name="value" value="" min="0" max="1000">
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
            <input type="date"/ name="startDate" value="">
            </td> 
        </tr>
        <tr>
            <td>
            End Date
            </td>
            <td>
            <input type="date"/ name="endDate" value="">
            </td> 
        </tr>
           <tr>
                <td colspan="2" style="text-align:center;">
                 
                    <input type="submit" name="submit" value="Enter Promotion"/>
                    
                </td>
            </tr>
       
    </table>
    </form>
<br/>
<?php echo $table?>
<br/>
</section>
            
<?php include 'footer.php'; ?>