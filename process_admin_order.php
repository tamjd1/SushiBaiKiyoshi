<?php
include './includes/functions.php';
$id = $_GET['id'];
$letter = $_GET['letter'];



$sql= "UPDATE \"tblInvoices\"
            SET \"InvoiceStatus\"= '".$letter.
            "' WHERE \"InvoiceID\"= '".$id."'";
            echo $sql;
$conn = db_connect();
   
//issue the query       
$result = pg_query($conn, $sql);

header( 'Location: ./admin_order.php' ) ;
?>