	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-a.php');?>
<?php
	if (!isset($_SESSION['first_name'])) {
		// Khong co sesion chuyen huong ve trang chu
		redirect_to();
	}else{
		$_SESSION = array(); //xoa het array sesion
		session_destroy(); // xoa tat ca session hien dang co
		setcookie(session_name(),'', time()-3600); // xoa cooki cua trinh duyet
	}
	echo "Logout thành công !"
?>
<section></section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>