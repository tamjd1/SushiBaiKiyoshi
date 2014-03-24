<?php
$file = "edit_menu_items.php";
$title = "Sushi Bai Kiyoshi - Edit Menu Items";
$banner = "Sushi Bai Kiyoshi - Edit Menu Items";
$description = "This page is where tde administrator will be able to add/delete items currently on tde menu";
$date = "20/03/2014";

require 'header.php';


$test =0;
echo '<table class="tableLayout">';
            echo '<tr>';
                echo '<td>ID</td>';
                echo '<td>Description</td>';
                echo '<td>Price</td>';
                echo '<td>Type</td>';
                echo '<td>Edit</td>';
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