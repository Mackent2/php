<?php 
	include('../includes/header.php');
	include('../includes/mysql_connect.php');
	include('../includes/sidebar-a.php');
?>
<section>
	<?php
		if (isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['y']) == 32)) {
			$e = mysqli_real_escape_string($conn, $_GET['x']);
			$a = mysqli_real_escape_string($conn, $_GET['y']);
			$q = "SELECT user_id FROM users WHERE email = '{$e}' and active ='{$a}'";
			$r = mysqli_query($conn, $q) or die ("Query: {$q} \n<br/> MSQLI :".mysqli_error($conn));
			if (mysqli_num_rows($r) == 1) {
				$q1 = "UPDATE users SET active = NULL WHERE email = '{$e}' and active = '{$a}'";
				$r1 = mysqli_query($conn, $q1) or die ("Query: {$q1} \n<br/> MSQLI :".mysqli_error($conn));
				if (mysqli_affected_rows($conn) == 1) {
					echo "<p class='success'>Kích hoạt tài khoản email: {$e} thành công !</p>";
				}else{
					echo "<p class='error'>Email {$e} không thể kích hoạt do một số lỗi system!</p>";
				}
			}else{
				header("location:".url."index.php");
			}

		}else{
			header("location:".url."index.php");
		}
	?>
</section>
<?php include('../includes/footer.php');?>