<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
?>
        <section id="MainContent">            

        <p class="t_c">
            Enter the following information and create an account that can be used to place orders for pick-up online.
        </p>
        <hr/>
        
        <table id="customerinfo">
            <th colspan="2" class="t_c">
                Personal Information
            </th>
            <tr>
                <td>
                    Name
                </td>
                <td>
                    <input type="textbox"/>
                </td> 

            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                    <input type="textbox"/>
                </td>
            </tr>
            <tr>
                <td>
                    Phone Number
                </td>
                <td>
                    <input type="textbox"/>
                </td>
            </tr>            
        </table>
        
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
                    <select>
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
                    <input type="textbox"/>
                </td>
            </tr>    
            <tr>
                <td>
                    Card Number
                </td>
                <td>
                    <input type="textbox"/>
                </td> 
            </tr>
            <tr>
                <td>
                    Expiration Date
                </td>
                <td>
                    <input type="textbox"/>
                </td>
            </tr>
            <tr>
                <td>
                    Security Code
                </td>
                <td>
                    <input type="textbox"/>
                </td>
            </tr>            
        
        </table>        
        
        <br/>
        
        <table id="billinginfo">
            <th colspan="2" class="t_c">
                Billing Information
            </th>
            <tr>
                <td>
                    Address
                </td>
                <td>
                    <input type="textbox"/>
                </td> 

            </tr>
            <tr>
                <td>
                    City
                </td>
                <td>
                    <input type="textbox"/>
                </td>
            </tr>
            <tr>
                <td>
                    Province
                </td>
                <td>
                    <input type="textbox"/>
                </td>
            </tr>            
            <tr>
                <td>
                    Postal Code
                </td>
                <td>
                    <input type="textbox"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <br/>
                    <input type="button" value="Register"/>
                    
                </td>
            </tr>
        </table>        
        
        <br/>

        </section>
            
<?php include 'footer.php'; ?>