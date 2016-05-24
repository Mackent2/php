<?php 
	include('header-admin.php');
	include('../includes/mysql_connect.php');
	include('sidebar-admin.php');
?>
<div class="container">
	<?php 
		if (isset($_SESSION['uid'])) {
			echo "<h2>Xin chào : ".$_SESSION['ln']."</h2>";
			echo "<p>Đây là trang quản lí dành cho admin, bạn có thể thêm sửa xóa mọi chức năng, với quyền cao nhất !</p>";
		}else{
			header("location:".url."index.php");
		}
	?>
	<p><a href="<?php echo url."index.php";?>" style = "color:blue;">Đi đến trang mua hàng !</a></p>
</div>
<?php include('../includes/footer.php');?>
