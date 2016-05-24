	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();	 ?>
<?php
	if (isset($_GET['del']) && isset($_GET['cat_name']) && filter_var($_GET['del'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$del = $_GET['del'];
		$cat_name = $_GET['cat_name'];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['delete']) && $_POST['delete'] == 'yes') {
					$q = "DELETE FROM categories WHERE cat_id = {$del} AND cat_name = '{$cat_name}'";
					$r = mysqli_query($conn, $q);
					confirm_query($r, $q);
					if(mysqli_affected_rows($conn) == 1){
						$messages = "Del categories Success";
					}else{
						$messages = "Del categories NO Success";
					}
			}else{
				$messages = "Ban khong muon xoa categories";
			}
		}
	}
	else{
		redirect_to('admin/view-categories.php');
	}
?>
<section>
	<!-- ham htmlentities in ra toan bo nhung j nguoi dung nhap vao tranh truong hop xau -->
	<h3>Delete categories: <?php if (isset($cat_name)) echo htmlentities($cat_name, ENT_COMPAT, 'UTF-8');?></h3>
	<!-- Thong bao loi -->
	<?php if (isset($messages)) {
		echo $messages;
	}?>
	<form action="" method="POST">
		<fieldset>
			<legend>Delete category</legend>
			<label for="">Are you sure???</label>
			<div>
				<label for="">NO</label>
				<input type="radio" name="delete" value="no" checked="checked" />
				<label for="">YES</label>
				<input type="radio" name="delete" value="yes" />
			</div>
			<input type="submit" name="submit" value="Xóa categories" onclick = "return confirm('Are you sure ???')">
		</fieldset>
	</form>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

