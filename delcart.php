<?php
	if (isset($_GET['bid'])) {
		$bid = $_GET['bid'];
		if ($_GET['bid'] == 0) {
			unset($_SESSION['cart']);

		}else{
			unset($_SESSION['cart'][$bid]);
		}

	}header("location:cart.php");
		exit();
?>