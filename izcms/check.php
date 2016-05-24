<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php
	if (isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string($conn, $_GET['email']);
		// truy van vao data voi email vua nhan
		$q = "SELECT user_id FROM users WHERE email = '{$e}'";
		$r = mysqli_query($conn, $q); confirm_query($r, $q);
		if(mysqli_num_rows($r) == 1){
			echo "NO"; // NO da ton tai email nen khong the lay email nay dang ky duoc
		}else{
			echo "YES"; // Ok ten email co the dang ky
		}
	}
?>