<?php
$file = "edit_profile.php";
$title = "Sushi Bai Kiyoshi - Edit Profile";
$banner = "Sushi Bai Kiyoshi - Edit Profile";
$description = "This page is where a login in customer can edit their profile information";
$date = "20/03/2014";

require 'header.php';



?>



        <section id="MainContent">            
           <p class="t_c">
            Make Changes to your profile here.
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
        

        
        <br/>
        <form action="" method="post">
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
           
        </table>   
            
                  <!-- There should be the option to just delete the credit card not change it-->
    <table id="creditcardinfo">
    <th colspan="2" class="t_c">
    Credit Card(s)
    </th>
    <tr>
        <th>
            Address
        </th>
        <th>
            Name on Card
        </th>
        <th>
            Card number
        </th>
        <th>
            Expiration Date
        </th>
        <th>
            Security Code
        </th>
        <th>
            Delete
        </th>
    </tr>

    <tr>
        <td>
            1303 Country RD 2
        </td>
        <td>
            Thom Davison
        </td>
        <td>
            ************4474
        </td>
        <td>
            09/14
        </td>
        <td>
            913
        </td>               
        <td>
            <a href="edit_profile.php" <input type=\"submit\" value=\"Edit\" />Delete</a>
        </td>
    </tr>
    <tr>
        <td colspan="5" style="text-align:right;">
            <input type="button" value="Add Another Card"/>
        </td>
    </tr>
    </tr>
        <tr>
        <td colspan="5" style="text-align:center;">
        <br>
        <br>
        <br>
        <br>
        <input type="submit" value="Save Changes"/>

        </td>
    </tr>
    </table>  
    
    </form>
    <br>
    
        </section>
            
<?php include 'footer.php'; ?>