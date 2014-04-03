<?php
$file = "customer_orders.php";
$title = "Order List";
$banner = "Order List";
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
$userid = $_SESSION['UserID'];









echo "<h2 style=\"text-align:center\">Order List for ".$_SESSION['UserFirst']." ".$_SESSION['UserLast']."</h2>";



$sql= "SELECT \"tblInvoices\".\"InvoiceID\", \"tblInvoices\".\"OrderDateTime\", \"tblInvoices\".\"Comments\", \"tblInvoices\".\"Subtotal\", \"tblInvoices\".\"InvoiceStatus\"
            FROM \"tblInvoices\"
            WHERE \"tblInvoices\".\"UserID\" = '".$userid."'".
            "ORDER BY \"InvoiceStatus\", \"InvoiceID\" DESC";
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
	$invoicestat = pg_fetch_result($result1, $i, 4);
	    
            echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong>Invoice ID: </strong>".$invoiceid."</td></tr>";
		echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong></strong>".$invoicedatetime."</td></tr>";		
            
	    
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
			echo "<td style=\"text-align:center; font-size:120%;\"><strong>Quantity</strong></td>";
		 for($j = 0; $j < $records2; $j++)
        	 {
			$itemdesc = pg_fetch_result($result2, $j, 0);
		$itemqty = pg_fetch_result($result2, $j, 1);
		
		echo "<tr>";
            	echo "<td style=\"text-align:left !important;\">".$itemdesc."</td>";
	    	echo "<td style=\"text-align:left !important;\">".$itemqty."</td>";
            	
            	echo "</tr>";
		}
		echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong>Subtotal: $</strong>".$invoicesub."</td></tr>";
		echo "<tr><td colspan=\"2\" style=\"text-align:left !important;\"><strong>Comments: </strong>".$invoicecomments."</td></tr>";
		if ($invoicestat == 'a')
		{
		echo "<tr><td colspan=\"10\" style=\"text-align:right\"><form action=\"./process_cust_order.php?id=".$invoiceid."&letter=x\" method=\"post\"><input type=\"submit\" value=\"Cancel\" /></form></td></tr>";                                      
        	}
		}
		?>
		

		
	   </table><hr/> 
		
		
		
		                   
		 
<?php

        }
	
}
else
		{
		echo "<h3 style=\"text-align:center\">You haven't made any orders yet. Try us out for lunch!</h3>";
		}?>
<?php include 'footer.php'; ?>