<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';


$_SESSION['message'] = "";
?>



        <section id="MainContent">            
          <p>This is where the administrator can make changes to customers registered on the site.</p>
            <div class="center">
            <ul>
                 <li><a href="./edit_menu_items.php">Edit Menu Items</a></li>
                  <li><a href="./edit_fish_Prices.php">Add Fish Prices</a></li>
                  <li><a href="./customer_status.php">Edit User Profiles</a></li>
                  <li><a href="./edit_promotions.php">Edit Promotions</a></li>
            </ul>
            </div>
        </section>
            
<?php include 'footer.php'; ?>