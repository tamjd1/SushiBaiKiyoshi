<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

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



?>



        <section id="MainContent">            
          <p class="t_c">This is where the administrator can make changes to customers, menu items, promotions, and enter pricing pricing information.</p>
<hr/>          
          <div class="t_c">
           
                <a href="./edit_menu_items.php">Edit Menu Items</a> <br/>
                <a href="./edit_promotions.php">Edit Promotions</a> <br/><br/>
                <a href="./customer_status.php">Edit User Profiles</a> <br/><br/>
                  <a href="./edit_fish_Prices.php">Add Fish Prices</a> <br/>
                  
                  
                  <br/>
            </ul>
            </div>
        </section>
            
<?php include 'footer.php'; ?>