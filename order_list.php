<?php
$file = "order_list.php";
$title = "Sushi Bai Kiyoshi - Order List";
$banner = "Sushi Bai Kiyoshi - Order List";
$description = "This page will display orders that are currently open";
$date = "24/03/2014";

require 'header.php';


$test =0;
echo '<table id="menuItems">';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Description</th>';
            echo '<th>Price</th>';
            echo '<th>Type</th>';
            echo '<th>Edit</th>';

            echo '</tr>';


            while ($test < 30){

            echo '<tr align="center">

            <td>ID here</td>
            <td>Description Here</td>
            <td>Type Here</td>
            <td></td>';
     

            echo "<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>";

            echo '</tr>';
$test +=1;

                }#end of while


         



echo '</table>';

?>



        <section id="MainContent">            
         
            
            
            
        </section>
            
<?php include 'footer.php'; ?>