<?php
$file = "password_recovery.php";
$title = "Sushi Bai Kiyoshi - Password Recovery";
$banner = "Sushi Bai Kiyoshi - Password Recovery";
$description = "This page is where users will go to when they forget their password and need to reset it";
$date = "20/03/2014";

require 'header.php';



?>



        <section class="center">            
         <br/>
            <form action="" method="post">
                <table id="recovery">  
                <th class="t_c">Password Recovery</th>
                <tr>
                    <td>
                    Email Address:
                    </td>
                    <td>
                     <input type="text"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;">
                    <input type="submit" value="Reset Password"/>
                    </td>                </tr>
                </table>
            </form>
            <br/>
            
        </section>
            
<?php include 'footer.php'; ?>