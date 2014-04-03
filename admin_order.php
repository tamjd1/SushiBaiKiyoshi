<?php
$file = "index.php";
$title = "Sushi Bai Kiyoshi - Home Page";
$banner = "Sushi Bai Kiyoshi - Home Page";
$description = "This page displays the promotions and general information about the business Sushi Bai Kiyoshi";
$date = "05/03/2014";

require 'header.php';
?>
<?php

if (!isset($_SESSION['UserID'])) // Non login in users to be sent back to index
{
    $_SESSION['message'] = "You must login into access this page.";
    header('Location:./index.php');
}

if ($_SESSION['UserType'] != 'a') // If not an administrator redirect to main page
{
    $_SESSION['message'] = "You are not authorized to access the admin page.";
    header('Location:./index.php');
}

$sql= "SELECT \"tblInvoices\".\"InvoiceID\", \"tblInvoices\".\"OrderDateTime\", \"tblInvoices\".\"Comments\", \"tblInvoices\".\"Subtotal\"
            FROM \"tblInvoices\"
            WHERE \"tblInvoices\".\"InvoiceStatus\" = 'a'";
            //echo $sql;
$conn = db_connect();
   
//issue the query       
$result1 = pg_query($conn, $sql);
// set records variable to number of found results
$records1 = pg_num_rows($result1);    

if ($records1 > 0) // If there are results from the query
{       
	
    // Generate the table from the results
        for($i = 0; $i < $records1; $i++)
        {
		echo "<table class=\"tableLayout\" border=\"1\" style=\"margin-top:10px; margin-left:auto; margin-right:auto; width:500px !important;\">";
		$invoiceid = pg_fetch_result($result1, $i, 0);
		$invoicedatetime = pg_fetch_result($result1, $i, 1);
		$invoicecomments = pg_fetch_result($result1, $i, 2);
		$invoicesub = pg_fetch_result($result1, $i, 3);
	    
            echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong>Invoice ID: </strong>".$invoiceid."</td></tr>";
		echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong>Time Stamp: </strong>".$invoicedatetime."</td></tr>";		
            
	    
            echo "</tr>";
		
	
		$sql= "SELECT \"tblMenuItems\".\"ItemDescription\", \"tblInvoiceItems\".\"ItemQuantity\"
            	FROM \"tblInvoices\", \"tblInvoiceItems\", \"tblMenuItems\"
            	WHERE \"tblInvoices\".\"InvoiceID\" = ".$invoiceid.
		" AND \"tblInvoices\".\"InvoiceID\" = \"tblInvoiceItems\".\"InvoiceID\"
		AND \"tblInvoiceItems\".\"ItemID\" = \"tblMenuItems\".\"ItemID\"";
            	//echo $sql;
		//issue the query       
		$result2 = pg_query($conn, $sql);
		// set records variable to number of found results
		$records2 = pg_num_rows($result2); 
		if ($records2 > 0) // If there are results from the query
		{
			echo "<td style=\"text-align:left !important; font-size:120%;\"><strong>Item</strong></td>";
			echo "<td style=\"text-align:left !important; font-size:120%;\"><strong>Quantity</strong></td>";
		 for($j = 0; $j < $records2; $j++)
        	 {
			$itemdesc = pg_fetch_result($result2, $j, 0);
		$itemqty = pg_fetch_result($result2, $j, 1);
		
		echo "<tr>";
            	echo "<td style=\"text-align:left !important;\">".$itemdesc."</td>";
	    	echo "<td colspan=\"2\" style=\"text-align:left !important;\">".$itemqty."</td>";
            	
            	echo "</tr>";
		}
		echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong>Subtotal: $</strong>".$invoicesub."</td></tr>";
		echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong>Comments: </strong>".$invoicecomments."</td></tr>";
		}
		
		?>
		<tr>
            			<td><form action="./process_admin_order.php?id=<?php echo $invoiceid; ?>&letter=c" method="post"><input type="submit" value="Complete" /></form></td>
				<td><form action="./process_admin_order.php?id=<?php echo $invoiceid; ?>&letter=x" method="post"><input type="submit" value="Cancel" /></form></td>                                      
        		</tr>

		
	   </table><hr/> 
		
		
		
		                   
		 
<?php

        }
	
}
else
		{
		echo "<h3 style=\"text-align:center\">There are currently no active orders to display.</h3>";
		}
?>
<?php include 'footer.php'; ?>