<?php 
	include('includes/header.php');
	include('includes/mysql_connect.php');
	include('includes/sidebar-b.php');
?>
<section>
	<?php
	if (isset($_GET['bid'])) {
		$uid = $_GET['bid'];
		if (isset($_SESSION['cart'][$uid])) {
			$so_luong = $_SESSION['cart'][$uid] +1;
		}else{
			$so_luong = 1;
		}
		$_SESSION['cart'][$uid] = $so_luong;
		header('location:cart.php');
	}
?>	
</section>
<?php include('includes/footer.php');?>