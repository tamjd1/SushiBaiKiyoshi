<?php
$file = "edit_fish_prices.php";
$title = "Sushi Bai Kiyoshi - Edit Fish Prices";
$banner = "Sushi Bai Kiyoshi - Edit Fish Prices";
$description = "This page is where the administrator is able to add fish price information";
$date = "20/03/2014";

require 'header.php';



?>



        <section id="MainContent">            
             <table id="addFishPrice">
                <th colspan="2" class="t_c">
                Add Fish Price Information
                </th>
                <tr>
                    <td>
                    Type:
                    </td>
                    <td>
                    <input type="textbox"/ name="type">
                    </td> 
                </tr>
                <tr>
                    <td>
                    Date:
                    </td>
                    <td>
                    <input type="textbox"/ name="date">
                    </td> 
                </tr>
                <tr>
                    <td>
                    Location:
                    </td>
                    <td>
                    <input type="textbox"/ name="location">
                    </td> 
                </tr>
                <tr>
                    <td>
                    Supply Status:
                    </td>
                    <td>
                    <input type="textbox"/ name="supplyStatus">
                    </td> 
                </tr>
                  <tr>
                <td colspan="2" style="text-align:center;">
                    <br/>
                    <input type="button" value="Enter Pricing"/>
                    
                </td>
            </tr>
            </table>
            
            
        </section>
            
<?php include 'footer.php'; ?>