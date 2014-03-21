<?php
$file = "edit_menu_items.php";
$title = "Sushi Bai Kiyoshi - Edit Menu Items";
$banner = "Sushi Bai Kiyoshi - Edit Menu Items";
$description = "This page is where the administrator will be able to add/delete items currently on the menu";
$date = "20/03/2014";

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