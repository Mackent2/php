<?php include ('../includes/header.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<section>
	<?php if (is_admin()) {
		echo "
		<h3>Welcome to IzCMS Admin Panel </h3>
		<p>Chào mừng bạn đến với trang quản lý izCMS. Bạn có thể thêm sửa xóa bài viết !</p>
		";
	}else{
		redirect_to();
	}
	?>
	
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

