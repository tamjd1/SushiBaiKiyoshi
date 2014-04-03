<?php
$file = "edit_fish_prices.php";
$title = "Sushi Bai Kiyoshi - Edit Fish Prices";
$banner = "Sushi Bai Kiyoshi - Edit Fish Prices";
$description = "This page is where the administrator is able to add fish price information";
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

if($_SERVER["REQUEST_METHOD"] == "GET") // If the page has been submitted
{   
 $type = "";
    $date = "";
    $location = "";
    $supplyStatus = "";
    $price = "";
    $errorMessage=  "";
}
if($_SERVER["REQUEST_METHOD"] == "POST") // If the page has been submitted
{      
    // Clear out the vars
    $type = "";
    $date = "";
    $location = "";
    $supplyStatus = "";
    $price = "";
    $errorMessage=  "";
    // Trim the inputs
    $type = trim ($_POST ["type"]); 
    $date = trim ($_POST ["date"]); 
    $location = trim ($_POST ["location"]); 
    $supplyStatus = trim ($_POST ["supplyStatus"]); 
     $price = trim ($_POST ["price"]); 
  
    if (!isset($type) || $type == "")//if user did not entered anything
	{
		
		 $errorMessage .= "You must enter a type<br/>";
	}
    
     if (!isset($price) || $price == "")
	{
		
		$errorMessage .=  "You must enter a price<br/>";
	}
    else if(!is_numeric($price))//if user entered numeric value
	{
		$errorMessage .=  "Price must be numeric<br/>";
	}
     if (!isset($location) || $location == "")//if user did not entered anything
	{
		
		$errorMessage .=  "You must enter a location<br/>";//don't display the entered data
	}
	
	if($errorMessage== "")
    {
    $sql = "INSERT INTO \"tblFishMarket\"(\"Type\", \"Date\", \"Price\", \"Location\", \"SupplyStatus\")
            VALUES ('$type', '$date', '$price', '$location' , '$supplyStatus')";

    // connect to the database
    //$conn = db_connect();
    
   
    $conn = db_connect();
    //issue the query       
    $result = pg_query($conn, $sql);
      
   
    if (!$result)
    {
        $errorMessage .= "Pricing not added"; 
    }
    else
    {
        $errorMessage .= "Pricing added!";
             $type = "";
        $date = "";
        $location = "";
        $supplyStatus = "";
        $price = "";
       
    }
    }
   }
?>
        <section id="MainContent">   
 <a href="./admin.php">Back</a>   
<p class="t_c">
<?php echo $errorMessage ;?>
<p> 
       
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
             <table class="center">
                <th colspan="2" class="t_c">
                Add Fish Price Information
                </th>
                <tr>
                    <td>
                    Type
                    </td>
                    <td>
                    <input type="textbox"/ name="type" value="<?php echo $type;?>" >
                    </td> 
                </tr>
                <tr>
                    <td>
                    Date
                    </td>
                    <td>
                    <input type="date"/ name="date" value="<?php echo date('Y-m-d'); ?>">
                    </td> 
                </tr>
                 <tr>
                    <td>
                    Price
                    </td>
                    <td>
                    <input type="number"/ name="price" value="<?php echo $price;?>">
                    </td> 
                </tr>
                <tr>
                    <td>
                    Location
                    </td>
                    <td>
                    <input type="textbox"/ name="location" value="<?php echo $location;?>">
                    </td> 
                </tr>
                <tr>
                  <td>
                    Supply Status
                    </td>
                    <td>
                    <select name="supplyStatus">
                        <option value="l" >Low</option>
                        <option value="m" >Medium</option>
                        <option value="h">High</option>                        
                    </select>
                    </td> 
                </tr>
                  <tr>
                <td colspan="2" style="text-align:center;">
                    <br/>
                    <input type="submit" name="submit" value="Enter Pricing"/>
                    
                </td>
            </tr>
            </table>
            
            </form>
        </section>
            
<?php include 'footer.php'; ?>