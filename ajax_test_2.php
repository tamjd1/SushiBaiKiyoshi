<?php
$data = json_decode($_POST['data'], true);

		// start session
		session_start();
		$_SESSION['cart_data'] = $data;
		// close session
		session_write_close();


?>

<script> 
console.log("///////////////////////////////////");
var data = "//////////////////////////////////////////////" + "<?php json_encode($data); ?>";
console.log(data);

</script>