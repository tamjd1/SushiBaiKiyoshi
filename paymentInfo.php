<?php
$file = "paymentInfo.php";
$title = "Sushi Bai Kiyoshi - Payment Information";
$banner = "Sushi Bai Kiyoshi - Payment Information";
$description = "This page will display the list of customer's credit card";
$date = "05/03/2014";



require 'header.php'; ?>

    <section id="MainContent">
 
 <?php
 //hard coded user id and user type for now.
$_SESSION['id'] = "turning_japanese";
$_SESSION['usertype'] = "c";

if (!isset($_SESSION['id']) || ($_SESSION['id']) == "")
{
	$_SESSION['message'] = "You must login to do payment transaction.";
	header('Location:./index.php');
}

else if ($_SESSION['usertype'] != 'c')
{
	$_SESSION['message'] = "You are not authorized to access this page.";
	//header('Location:./index.php');
}

$error = "";
$expiryDate = "";
//check if customer is in the database
$conn = db_connect();
 
 ?>
 

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p style="text-align:center; font-size:30px;">Payment Confirmation</p>
        
        <div>
            
            <?php
            
                if (isset($_SESSION['id']) || ($_SESSION['id']) != "")
               
                {
                    $conn = db_connect();

                    $sql = "SELECT \"UserID\",\"CreditCardNumber\",\"CreditCardType\" FROM \"tblCreditCards\" WHERE \"UserID\" = '".$_SESSION['id']."'";
                    $result = pg_query($conn,$sql);
                    $records = pg_num_rows($result);
                            
                    if($records > 0)
                    {
                        
                         $table .= "<p>Select payment card:</p>";
                         $table .= '<table class="tableLayout">';
                        $table .=  // Create the table titles
                        '
                       
                        <tr>
                            <td>Credit Card Type</td>
                            <td>Credit Card Number</td>         
                         </tr>';  
                         
                        for($i = 0; $i < $records; $i++)
                        {
                        $table .=   
                        '<tr>
                            <td>'.pg_fetch_result($result, $i, 'CreditCardType').'</td>
                            <td>'.pg_fetch_result($result, $i, 'CreditCardNumber').'</td>         
                        </tr>';  
                        $table .= "</table><br/>";
                        }
                    } 
                }                    
                else 
                {
                    header("Location: ./credit_card_create.php");
                }
                
            
            ?>
        </div>

        
       
        
    </section>
    
</form>
        
<?php include 'footer.php'; ?>