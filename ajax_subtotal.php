<?php
$sub = ($_POST['subtotal']);

		// start session
		session_start();
		
        $_SESSION['subtotal'] = $sub;
        
		// close session
		session_write_close();


?>