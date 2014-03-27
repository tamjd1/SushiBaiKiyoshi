<?php
$file = "payment.php";
$title = "Sushi Bai Kiyoshi - Order Payment";
$banner = "Sushi Bai Kiyoshi - Order Payment";
$description = "This page displays order payment options and data";
$date = "05/03/2014";

require 'header.php'; ?>

    <section id="MainContent">

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
            <th colspan="2" class="t_c">
                Credit Card Information
            </th>
            <tr>
                <td>
                    Card Type
                </td>
                <td>
                    <select name="cardType">
                        <option value="Visa">Visa</option>
                        <option value="Mastercard">Mastercard</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    Name on Card
                </td>
                <td>
                    <input type="text" name="nameOnCard"/>
                </td>
            </tr>    
            <tr>
                <td>
                    Card Number
                </td>
                <td>
                    <input type="text" name="cardNumber"/>
                </td> 
            </tr>
            <tr>
                <td>
                    Expiration Date
                </td>
                <td>
                    <table>
                        <tr>
                            <td>Month
                            </td>
                            <td>
                            <select name="month">
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            </td>
                            <td>Year
                            </td>
                            <td>
                            <select name="year">
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                            </select>
                            </td>
                        </tr>
                    </table>
                  
                </td>
            </tr>
            <tr>
                <td>
                    Security Code
                </td>
                <td>
                    <input type="text" name="securityCode"/>
                </td>
            </tr>            
        </table>
        <table style="margin:0 auto 0 auto">        
            <th colspan="2" class="t_c">
                Billing Information
            </th>
            <tr>
                <td>
                    Address
                </td>
                <td>
                    <input type="text" name="address"/>
                </td> 

            </tr>
            <tr>
                <td>
                    City
                </td>
                <td>
                    <input type="text" name="city"/>
                </td>
            </tr>
            <tr>
                <td>
                    Province
                </td>
                <td>
                    <input type="text" name="province"/>
                </td>
            </tr>            
            <tr>
                <td>
                    Postal Code
                </td>
                <td>
                    <input type="text" name="postalCode"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <br/>
                    <input type="button" value="Confirm Order"/>
                    
                </td>
            </tr>
        </table>        
        
        <br/>
        
    </section>
        
<?php include 'footer.php'; ?>