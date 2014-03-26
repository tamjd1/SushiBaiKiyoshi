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
{
    // Set the SQL statement
    // Check if there is just one search field
   
   







// old stuff///////////////////////////////////////////////////
// $test =0;
// echo '<br/><table class="tableLayout">';
            // echo '<tr>';
                // echo '<td>ID</td>';
                // echo '<td>Description</td>';
                // echo '<td>Price</td>';
                // echo '<td>Type</td>';
                // echo '<td>Edit</td>';
            // echo '</tr>';


            // while ($test < 30){

            // echo '<tr align="center">
                    // <td>ID here</td>
                    // <td>Description Here</td>
                    // <td>Type Here</td>
                    // <td></td>';
                
     

            // echo "<td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>";

            // echo '</tr>';
// $test +=1;

                // }#end of while


         



// echo '</table>';

?>



<section id="MainContent">         
<br/>   
<p class="t_c">Promotions listed from newest to oldest</p>

<?php
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
        
        
        echo '<table class="tableLayout">';
        
        echo  // Create the table titles
        '<tr>
            <td>ID</td>
            <td>Description</td>
            <td>Value</td>
            <td>IsPercent</td>
            <td>Start Date</td>
            <td>End Date</td>
            <td>Edit</td>
         </tr>';  
                 
        // Generate the table from the results
        for($i = 0; $i < $records; $i++)
        {
            echo // Generate the table rows
            '<tr align="center">
                  <td>'.pg_fetch_result($result, $i, 0).'</td>
                <td>'.pg_fetch_result($result, $i, 1).'</td>
                <td>'.pg_fetch_result($result, $i, 2).'</td>
                <td>'.pg_fetch_result($result, $i, 3).'</td>
                <td>'.pg_fetch_result($result, $i, 4).'</td>
                <td>'.pg_fetch_result($result, $i, 5).'</td>              
                <td><a href=\"\" <input type=\"submit\" value=\"Edit\" />Edit</a></td>               
            </tr>';       
        }
        
        echo "</table>"; // Closing table tag
    }
    // If no query results
    else 
    {
        echo "<br/>No search results";    
    }   
}

?>
<br/>
</section>
            
<?php include 'footer.php'; ?>