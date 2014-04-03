<?php
$file = "payment.php";
$title = "Sushi Bai Kiyoshi - Order Payment";
$banner = "Sushi Bai Kiyoshi - Order Payment";
$description = "This page displays order payment options and data";
$date = "05/03/2014";

require 'header.php'; ?>

<section id="MainContent">
 
 <?php
 //hard coded user id and user type for now.
$_SESSION['id'] = "turning_japanese";
$_SESSION['usertype'] = "c";

 
 ?>
 

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p style="text-align:center; font-size:30px;">Order Payment</p>
        
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
        
        <br/>
        
        <table id="creditcardinfo">
            <tr>
                <td style="text-align:center;">                    
                    <input type="submit" value="Pay Now" onclick=""/>         
                </td>
                <td style="text-align:center;">                    
                    <input type="submit" value="Cancel Order" onclick=""/>                    
                </td>
            </tr>
        </table>        
        
        <br/>
        
    </section>
    
</form>
        
<?php include 'footer.php'; ?>