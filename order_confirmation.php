<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
?>
 <section id="MainContent">  
            <p class="message">
        <?php echo  $_SESSION['message']; ?></p>
          

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p style="text-align:center; font-size:30px;">Order Confirmation</p>
        
        <div id="cartDiv" style="margin:0 auto 0 auto;">
            <table id="cart">
                <tr>
                    <th colspan="2" class="t_c">My Cart</th><hr/>
                </tr>
                
                <!-- temp -->
                <tr style="text-align:left">
                    <td>Spicy Tuna Combo</td>
                    <td style="text-align:right">$13.99</td>
                </tr>
                <tr style="text-align:left">
                    <td>Avocado Cucumber Combo</td>
                    <td style="text-align:right">$10.99</td>
                </tr>
                <!-- /temp -->
                
                <tr>
                    <td colspan="2"><hr/>Total: $24.98</td>
                </tr>
            </table>
        </div>        
                   
        
        </section>
        
</form>
            
<?php include 'footer.php'; ?>