	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-a.php');?>
<section>
	<?php
		if(isset($_GET['x'], $_GET['y']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['y']) == 32)){
			$email = mysqli_real_escape_string($conn, $_GET['x']);
			$activate = mysqli_real_escape_string($conn, $_GET['y']);
			$q = "UPDATE users SET active = NULL WHERE email = '{$email}' && active = '{$activate}'";
			$r = mysqli_query($conn, $q); confirm_query($r, $q);
			if(mysqli_affected_rows($conn) == 1){
				echo "Kích hoạt thành công ! <br/>";
				echo "Click <a href = 'login.php'>login</a>";
			}else{
				echo "Lỗi kích hoạt thất bại ! Mời kiểm tra lại email";
			}
		}else{
			redirect_to();
		}
	?>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>