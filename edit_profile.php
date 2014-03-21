<?php
$file = "edit_profile.php";
$title = "Sushi Bai Kiyoshi - Edit Profile";
$banner = "Sushi Bai Kiyoshi - Edit Profile";
$description = "This page is where a login in customer can edit their profile information";
$date = "20/03/2014";

require 'header.php';



?>



        <section id="MainContent">            
         <p>Make Changes to your profile here</p>
         
          <table id="customerinfo">
            <th colspan="2" class="t_c">
                Personal Information
            </th>
            <tr>
                <td>
                    Name
                </td>
                <td>
                    <input type="textbox"/ name="name" value="<? echo $name; ?>">
                </td> 

            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                    <input type="email" name="email" value="<? echo $email; ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Phone Number
                </td>
                <td>
                    <input type="textbox" name="phoneNumber" value="<? echo $phoneNumber; ?>"/>
                </td>
            </tr>            
        </table>
        
        <br/>
        
      <!-- There should be the option to just delete the credit card not change it-->
        
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
                    <input type="textbox" name="address" value="<? echo $address; ?>"/>
                </td> 

            </tr>
            <tr>
                <td>
                    City
                </td>
                <td>
                    <input type="textbox" name="city" value="<? echo $city; ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    Province
                </td>
                <td>
                    <input type="textbox" name="province" value="<? echo $province; ?>"/>
                </td>
            </tr>            
            <tr>
                <td>
                    Postal Code
                </td>
                <td>
                    <input type="textbox" name="postalCode" value="<? echo $postalCode; ?>"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <br/>
                    <input type="button" value="Save Changes"/>
                    
                </td>
            </tr>
        </table>   
            
            
        </section>
            
<?php include 'footer.php'; ?>