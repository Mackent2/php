	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();?>
<?php
	if (isset($_GET['pid']) && isset($_GET['page_name']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$pid = $_GET['pid'];
		$page_name = $_GET['page_name'];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['delete']) && $_POST['delete'] == 'yes') {
					$q = "DELETE FROM pages WHERE page_id = {$pid} AND page_name = '{$page_name}'";
					$r = mysqli_query($conn, $q);
					confirm_query($r, $q);
					if(mysqli_affected_rows($conn) == 1){
						$messages = "Del Pages Success";
					}else{
						$messages = "Del Pages NO Success";
					}
			}else{
				$messages = "Ban khong muon xoa Pages";
			}
		}
	}
	else{
		redirect_to('admin/view-pages.php');
	}
?>
<section>
	<!-- ham htmlentities in ra toan bo nhung j nguoi dung nhap vao tranh truong hop xau -->
	<h3>Delete pages: <?php if (isset($page_name)) echo htmlentities($page_name, ENT_COMPAT, 'UTF-8');?></h3>
	<!-- Thong bao loi -->
	<?php if (isset($messages)) {
		echo $messages;
	}?>
	<form action="" method="POST">
		<fieldset>
			<legend>Delete Pages</legend>
			<label for="">Are you sure???</label>
			<div>
				<label for="">NO</label>
				<input type="radio" name="delete" value="no" checked="checked" />
				<label for="">YES</label>
				<input type="radio" name="delete" value="yes" />
			</div>
			<input type="submit" name="submit" value="Xóa Pages" onclick = "return confirm('Are you sure ???')">
		</fieldset>
	</form>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

