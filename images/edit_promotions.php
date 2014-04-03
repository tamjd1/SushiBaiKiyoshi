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

// Tables created every time the page loads
    $currentTable = "";
    $sql = "SELECT *
                FROM \"tblPromotions\"
                WHERE \"EndDate\" > current_date
                ORDER BY \"StartDate\"";    
    // connect to the database
    //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {               
        $currentTable .= '<table class="tableLayout">';
   
        $currentTable .=   // Create the currentTable titles
        '<tr>
            <td>ID</td>
            <td>Description</td>
            <td>Value</td>
            <td>Start Date</td>
            <td>End Date</td>
           
            <td>Edit</td>
         </tr>';  
                 
        // Generate the currentTable from the results
        for($i = 0; $i < $records; $i++)
        {
             $currentTable .=  // Generate the currentTable rows
            '<tr align="center">
                <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>';
                
                $currentTable .=  '<td>';
                if(pg_fetch_result($result, $i, 2) <= 1) // hard coded check for if a percent cause database messed up
                {
                    $currentTable .=  (pg_fetch_result($result, $i, 2) * 100).'%</td>';
                }
                else
                {
                    $currentTable .=  pg_fetch_result($result, $i, 2).'$</td>';
                }
                $currentTable .=  '</td>';                
            
               // show dates
                 $currentTable .=  '<td>'.pg_fetch_result($result, $i, 4).'</td>
                <td>'.pg_fetch_result($result, $i, 5).'</td>';
   
                $currentTable .=  "<td><a href=
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
        
         $currentTable .=  "</table>"; // Closing currentTable tag
    }
    // If no query results
    else 
    {
        echo "<br/>No search results";    
    }   
    
    
    $previousTable = "";
    $sql = "SELECT *
            FROM \"tblPromotions\"
            WHERE \"EndDate\" <= current_date
            ORDER BY \"StartDate\"";    
        
    // connect to the database
    //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if ($records > 0) // If there are results from the query
    {               
        $previousTable .= '<table class="tableLayout">';
   
        $previousTable .=   // Create the previousTable titles
        '<tr>
            <td>ID</td>
            <td>Description</td>
            <td>Value</td>
            <td>Start Date</td>
            <td>End Date</td>
           
            <td>Edit</td>
         </tr>';  
                 
        // Generate the previousTable from the results
        for($i = 0; $i < $records; $i++)
        {
             $previousTable .=  // Generate the previousTable rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>';
                
                 $previousTable .=  '<td>';
                if(pg_fetch_result($result, $i, 2) <= 1) // hard coded check for if a percent cause database messed up
                {
                     $previousTable .=  (pg_fetch_result($result, $i, 2) * 100).'%</td>';
                }
                else
                {
                     $previousTable .=  pg_fetch_result($result, $i, 2).'$</td>';
                }
               $previousTable .=  '</td>';
                
            
               // show dates
                 $previousTable .=  '<td>'.pg_fetch_result($result, $i, 4).'</td>
                <td>'.pg_fetch_result($result, $i, 5).'</td>';
             
                
             
                  
   
                   $previousTable .=  "<td><a href=
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
        
         $previousTable .=  "</table>"; // Closing previousTable tag
    }
    // If no query results
    else 
    {
        echo "<br/>No search results";    
    }   
if($_SERVER["REQUEST_METHOD"] == "GET") 
{
$errorMessage=  "";
 $description = "";
    $value = "";
}
if($_SERVER["REQUEST_METHOD"] == "POST") 
{
$errorMessage=  "";
    //Trim the inputs
    $description = trim ($_POST["description"]);
    $value = trim ($_POST["value"]);
    $isPercent =trim ( $_POST["isPercent"]);
    $startDate =trim ( $_POST["startDate"]);
    $endDate =trim ( $_POST["endDate"]);
    
   if (!isset($description) || $description == "")//if user did not entered anything
	{
		
		 $errorMessage .= "You must enter a description<br/>";
	}
    
     if (!isset($value) || $value == "")
	{
		
		$errorMessage .=  "You must enter a value<br/>";
	}
    else if(!is_numeric($value))//if user entered numeric value
	{
		$errorMessage .=  "Value must be numeric<br/>";
	}
    
    
    
    // Set the SQL statement

if($errorMessage== "")
    {

    $sql = "INSERT INTO \"tblPromotions\"(
             \"PromotionDescription\", \"PromotionValue\", \"IsPercent\", 
            \"StartDate\", \"EndDate\")
    VALUES ('$description','$value', $isPercent,'$startDate','$endDate');";

 
      // connect to the database
    //$conn = db_connect();
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
    // set records variable to number of found results
    $records = pg_num_rows($result);    
    
    if (!$result)
    {
       $errorMessage = "Error occurred"; 
    }
    else
    {
       $errorMessage = "'$description' has been added!";
        
     
    }
     $description = "";
    $value = "";
    }
}
?>

<section id="MainContent">         


<a href="./admin.php">Back</a>
<p class="t_c"><?php echo $errorMessage ;?><p> 
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
            <input type="textbox"/ name="description" id="description" value="<?php echo $description;?>">
            </td> 
        </tr>
        <tr>
            <td>
            Value
            </td>
            <td>
            <input type="number" name="value" value="<?php echo $value;?>" min="0" max="1000">
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
            <input type="date"/ name="startDate" value="<?php echo date('Y-m-d'); ?>">
            </td> 
        </tr>
        <tr>
            <td>
            End Date
            </td>
            <td>
            <input type="date"/ name="endDate" value="<?php echo date('Y-m-d'); ?>">
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

    <p class="t_c">Currently Active Promotions</p>    
    <?php echo $currentTable?>
    
    <br/>
    
    <p class="t_c">Inactive Promotions</p>
    <?php echo $previousTable?>
    
<br/>
</section>            
<?php include 'footer.php'; ?>