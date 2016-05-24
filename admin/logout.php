<?php 
	include('../includes/header.php');
	include('../includes/mysql_connect.php');
	include('../includes/sidebar-a.php');
?>
<?php
	if(isset($_SESSION['e'])) {
		session_destroy();
		echo "<script>
		alert('Logout thành công !');
		location.href='http://localhost/hocphp/index.php';
		</script>";
		echo "<p class='logout'>Trở về -->> <a href='http://localhost/hocphp/index.php'>trang chủ !</a></p>";
	}else{
		header("location:".url."index.php");
	}
	
?>
<?php include('../includes/footer.php');?>
